<?php

// アイキャッチ有効化
add_theme_support('post-thumbnails');

//固定ページで抜粋を使えるようにする
add_post_type_support( 'page', 'excerpt' );


// アイキャッチ画像取得
function get_thumb_img($size = 'full') {
  $thumb_id = get_post_thumbnail_id();                         // アイキャッチ画像のIDを取得
  $thumb_img = wp_get_attachment_image_src($thumb_id, $size);  // $sizeサイズの画像内容を取得
  $thumb_src = $thumb_img[0];    // 画像のurlだけ取得
  $thumb_alt = get_the_title();  //alt属性に入れるもの（記事のタイトルにしています）
  return '<img src="'.$thumb_src.'" alt="'.$thumb_alt.'">';
}


// 管理者バージョンアップ通知表示
function update_nag_admin_only() {
  if ( ! current_user_can( 'administrator' )) {
    remove_action( 'admin_notices', 'update_nag', 3 );
  }
}
add_action( 'admin_init', 'update_nag_admin_only' );

// タイトルタグ出力
add_theme_support( 'title-tag' );

// ページタイトル取得
function get_page_title() {
  $page_title = wp_get_document_title();
  return $page_title;
}

// サイトキャッチフレーズ非表示
function wp_document_title_parts( $title ) {
  if ( is_home() || is_front_page() ) {
    unset( $title['tagline'] );
  } 
  return $title;
}
add_filter( 'document_title_parts', 'wp_document_title_parts');

// description変更
function get_description() {
  if(is_single()) {
    $description = get_the_excerpt();
  }
  elseif(is_front_page()) {
    $description = "ためとこは、薬剤師の生涯学習を支援するための単位管理アプリです。最短5分から学習できるコンテンツのほか、研修認定薬剤師の取得済み単位シールや、単位
    証明書の登録による、便利な単位管理システムも備えています。";
  }
  elseif(is_page()) {
    $description = get_the_excerpt();
  }
  elseif(is_home()) {
    $description = "一覧ページ";
  }
  if(empty($description)) {
    $description = bloginfo('description');
  }
  return $description;
}

// デフォルトsitemapを無効化
add_filter( 'wp_sitemaps_enabled', '__return_false' );

$post_types = [
  'video_library' => '動画ライブラリ',
  'material'      => 'スライド資料',
];

// カスタム投稿登録（既存コードそのまま）
foreach ($post_types as $slug => $name) {
  register_post_type($slug, [
      'labels' => [
          'name'          => $name,
          'singular_name' => $name,
          'add_new'       => '新規追加',
          'add_new_item'  => "{$name}を追加",
          'edit_item'     => "{$name}を編集",
          'view_item'     => "{$name}を表示",
      ],
      'public'        => true,
      'has_archive'   => true,
      'menu_position' => 5,
      'supports'      => ['title', 'editor', 'thumbnail'],
      'show_in_rest'  => true,
  ]);
}

// 共通カテゴリー（階層あり）
register_taxonomy('common_category', array_keys($post_types), [
  'labels' => [
      'name'              => '共通カテゴリー',
      'singular_name'     => '共通カテゴリー',
      'search_items'      => 'カテゴリーを検索',
      'all_items'         => 'すべてのカテゴリー',
      'parent_item'       => '親カテゴリー',
      'parent_item_colon' => '親カテゴリー:',
      'edit_item'         => 'カテゴリーを編集',
      'update_item'       => 'カテゴリーを更新',
      'add_new_item'      => '新しいカテゴリーを追加',
      'new_item_name'     => '新しいカテゴリー名',
      'menu_name'         => 'カテゴリー',
  ],
  'hierarchical'  => true,
  'public'        => true,
  'show_in_rest'  => true,
]);

// タグ（階層なし・投稿タイプ共通）
add_action('init', 'register_common_tag_taxonomy');
function register_common_tag_taxonomy() {

  register_taxonomy('common_tag', ['video_library', 'material'], [
    'labels' => [
        'name'                       => 'タグ',
        'singular_name'              => 'タグ',
        'menu_name'                  => 'タグ',
        'all_items'                  => 'すべてのタグ',
        'edit_item'                  => 'タグを編集',
        'view_item'                  => 'タグを表示',
        'update_item'                => 'タグを更新',
        'add_new_item'               => '新しいタグを追加',
        'new_item_name'              => '新しいタグ名',
        'search_items'               => 'タグを検索',
        'popular_items'              => '人気のタグ',
        'separate_items_with_commas' => 'カンマで区切ってタグを入力',
        'add_or_remove_items'        => 'タグを追加または削除',
        'choose_from_most_used'      => 'よく使われているタグから選択',
        'not_found'                  => 'タグが見つかりません',
    ],
    'hierarchical' => true, // タグは階層なし
    'public'       => true,
    'show_ui'      => true,
    'show_in_rest' => true,
  ]);
}






// JSとAjax用
function enqueue_video_library_scripts() {
  wp_enqueue_script(
      'video-library-js',
      get_template_directory_uri() . '/js/scripts.js',
      ['jquery'],
      '1.0',
      true
  );

  wp_localize_script('video-library-js', 'videoLibrary', [
      'ajaxurl' => admin_url('admin-ajax.php')
  ]);
}
add_action('wp_enqueue_scripts', 'enqueue_video_library_scripts');

// Ajaxで投稿取得
function fetch_video_library_posts() {
  $parent = sanitize_text_field($_POST['parent'] ?? '');
  $term   = sanitize_text_field($_POST['term'] ?? '');

  $tax_query = [];

  if ($parent) {
      $parent_term = get_term_by('slug', $parent, 'common_category');

      if ($parent_term) {
          if ($term === 'all') {
              // 親＋子カテゴリーすべてを取得
              $child_terms = get_terms([
                  'taxonomy'   => 'common_category',
                  'hide_empty' => true,
                  'parent'     => $parent_term->term_id,
                  'fields'     => 'ids'
              ]);

              $terms = array_merge([$parent_term->term_id], $child_terms);

              $tax_query[] = [
                  'taxonomy' => 'common_category',
                  'field'    => 'term_id',
                  'terms'    => $terms,
                  'operator' => 'IN'
              ];
          } else {
              // 子カテゴリー単体
              $tax_query[] = [
                  'taxonomy' => 'common_category',
                  'field'    => 'slug',
                  'terms'    => $term,
              ];
          }
      }
  }

  $args = [
      'post_type'      => 'video_library',
      'posts_per_page' => -1,
      'tax_query'      => $tax_query
  ];

  $query = new WP_Query($args);

  if ($query->have_posts()) {
    // 検索結果タイトルを追加
    echo '<h3>検索結果</h3>';

    echo '<div class="video-items">';
while ($query->have_posts()) {
    $query->the_post();
    
    // 投稿URL
    $permalink = get_permalink();
    
    // 投稿カテゴリー
    $categories = get_the_terms(get_the_ID(), 'common_category');
    $category_names = [];
    $parent_class = '';

    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $cat) {
            $category_names[] = $cat->name;

            // 親カテゴリーがいる場合、親のスラッグを取得
            if ($cat->parent) {
                $parent = get_term($cat->parent, 'common_category');
                $parent_class = 'parent-cat-' . $parent->slug;
            } else {
                $parent_class = 'parent-cat-' . $cat->slug;
            }
        }
    }
    $category_names_str = implode(', ', $category_names);
    
    echo '<div class="post-contents">'; // aタグの外側を囲む
    
    echo '<a href="'.esc_url($permalink).'" class="video-item">';
    
    // サムネイル
    if (has_post_thumbnail()) {
        the_post_thumbnail('medium');
    }
    
    echo '<div class="text-box">';
    // タイトル
    echo '<h4>'.get_the_title().'</h4>';
    
    // 本文（抜粋）
    echo '<p>'.get_the_excerpt().'</p>';
    
    // カテゴリー名
    if ($category_names_str) {
      // 親カテゴリーごとのクラスを追加
      echo '<p class="video-categories ' . esc_attr($parent_class) . '">' . $category_names_str . '</p>';
    }
    echo '</div>'; // text-box閉じ
    
    echo '</a>'; // aタグ閉じ
    echo '</div>'; // post-contents閉じ
}
echo '</div>';
} else {
    echo '<p class="nopost">関連する投稿はまだありません。</p>';
}

  wp_reset_postdata();
  wp_die();
}
add_action('wp_ajax_fetch_video_library', 'fetch_video_library_posts');
add_action('wp_ajax_nopriv_fetch_video_library', 'fetch_video_library_posts');





// // Ajax: 子カテゴリー取得
// add_action('wp_ajax_get_child_terms', 'ajax_get_child_terms');
// add_action('wp_ajax_nopriv_get_child_terms', 'ajax_get_child_terms');
// function ajax_get_child_terms() {
//     $parent_slug = sanitize_text_field($_POST['parent'] ?? '');
//     $parent = get_term_by('slug', $parent_slug, 'video_library'); // ← 修正！

//     if ($parent) {
//         $terms = get_terms([
//             'taxonomy'   => 'video_library', // ← 修正！
//             'hide_empty' => true,
//             'parent'     => $parent->term_id
//         ]);

//         echo '<div class="child-buttons" data-parent="'.$parent_slug.'">';
//         echo '<button class="child-button" data-term="'.$parent->slug.'">すべて</button>';
//         foreach ($terms as $term) {
//             echo '<button class="child-button" data-term="'.$term->slug.'">'.$term->name.'</button>';
//         }
//         echo '</div>';
//     }
//     wp_die();
// }

// // Ajax: 投稿取得
// add_action('wp_ajax_get_videos', 'ajax_get_videos');
// add_action('wp_ajax_nopriv_get_videos', 'ajax_get_videos');
// function ajax_get_videos() {
//     $term_slug = sanitize_text_field($_POST['term'] ?? '');

//     $args = [
//         'post_type'      => 'video_library', // ← 投稿タイプ
//         'posts_per_page' => -1,
//     ];

//     if ($term_slug) {
//         $args['tax_query'] = [[
//             'taxonomy' => 'video_library', // ← 修正！
//             'field'    => 'slug',
//             'terms'    => $term_slug,
//         ]];
//     }

//     $query = new WP_Query($args);

//     if ($query->have_posts()) {
//         while ($query->have_posts()) {
//             $query->the_post();
//             echo '<div class="video-item">';
//             if (has_post_thumbnail()) {
//                 the_post_thumbnail('medium');
//             }
//             echo '<h4>'.get_the_title().'</h4>';
//             echo '</div>';
//         }
//         wp_reset_postdata();
//     } else {
//         echo '<p>該当する動画はありません。</p>';
//     }

//     wp_die();
// }

// // JS に Ajax URL を渡す
// function enqueue_video_library_scripts() {
//   wp_enqueue_script(
//       'video-library-scripts',
//       get_template_directory_uri() . '/scripts.js',
//       ['jquery'],
//       null,
//       true
//   );

//   wp_localize_script('video-library-scripts', 'videoLibraryAjax', [
//       'ajaxurl' => admin_url('admin-ajax.php'),
//   ]);
// }
// add_action('wp_enqueue_scripts', 'enqueue_video_library_scripts');


// ====================================================
// 1. 会員管理者権限作成
// ====================================================
add_action('init', function() {
  if (!get_role('member_admin')) {
      add_role('member_admin', '会員管理者', [
          'read'         => true,
          'list_users'   => true,
          'edit_users'   => true,
          'promote_users'=> true,
          'delete_users' => true, // 削除権限を付与
      ]);
  }
});

// ====================================================
// 2. 新規登録ユーザーは subscriber のみ
// ====================================================
add_action('user_register', function($user_id){
  $user = new WP_User($user_id);
  $user->set_role('subscriber');
});

// // ====================================================
// // 2. 新規登録ユーザーは subscriber & pending
// // ====================================================
// add_action('user_register', function($user_id){
//   update_user_meta($user_id, 'wpmem_status', 'pending');
// });
// add_action('wpmem_post_register', function($user_id){
//   update_user_meta($user_id, 'wpmem_status', 'pending');
// });

// ====================================================
// 3. 会員管理者の管理画面メニューを制限（ユーザー一覧のみ）
// ====================================================
add_action('admin_menu', function() {
  $current_user = wp_get_current_user();
  if (in_array('member_admin', $current_user->roles)) {
      remove_menu_page('index.php');           
      remove_menu_page('edit.php');            
      remove_menu_page('edit.php?post_type=page'); 
      remove_menu_page('upload.php');          
      remove_menu_page('edit-comments.php');  
      remove_menu_page('themes.php');          
      remove_menu_page('plugins.php');         
      remove_menu_page('tools.php');           
      remove_menu_page('options-general.php'); 
  }
});

// // ====================================================
// // 4. ユーザー一覧に承認ステータス列を追加
// // ====================================================
// add_filter('manage_users_columns', function($columns){
//   $columns['wpmem_status'] = '承認ステータス';
//   return $columns;
// });

// // ====================================================
// // 5. 承認ステータス列に値を表示
// // ====================================================
// add_action('manage_users_custom_column', function($value, $column_name, $user_id){
//   if($column_name !== 'wpmem_status') return $value;

//   $status = get_user_meta($user_id, 'wpmem_status', true);

//   switch($status){
//       case 'pending':
//           return '<span style="color:orange;">承認待ち</span>';
//       case 'active':
//           return '<span style="color:green;">承認済み</span>';
//       case 'denied':
//           return '<span style="color:red;">非承認</span>';
//       default:
//           return '未設定';
//   }
// }, 10, 3);

// ====================================================
// 6. ユーザー一覧表示制御
// ====================================================
// add_action('pre_get_users', function($query){
//   if(!is_admin()) return;

//   $current_user = wp_get_current_user();

//   // 会員管理者は subscriber のみ表示
//   if(in_array('member_admin', $current_user->roles)){
//       $query->set('role', 'subscriber');
//   } 
//   // 管理者は subscriber を非表示、他のユーザーは表示
//   elseif(in_array('administrator', $current_user->roles)){
//       $query->set('role__not_in', ['subscriber']);
//   }
// });

// // ====================================================
// // 7. 承認／非承認処理
// // ====================================================
// // 承認処理
// add_action('admin_post_wpmem_approve', function(){
//   $user_id = intval($_GET['user']);
//   $current_user = wp_get_current_user();

//   // 権限チェック
//   if(!in_array('member_admin', $current_user->roles)) wp_die('権限がありません');
//   if(!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'wpmem_approve_'.$user_id)) wp_die('不正な操作です');

//   // WP-Members が読み込まれていなければ後で実行
//   if(!function_exists('wpmem_approve_user')){
//       add_action('plugins_loaded', function() use ($user_id){
//           if(function_exists('wpmem_approve_user')){
//               wpmem_approve_user($user_id); // 内部承認
//               update_user_meta($user_id, 'wpmem_status', 'active'); // 一覧表示用
//           }
//       });
//   } else {
//       wpmem_approve_user($user_id); // 内部承認
//       update_user_meta($user_id, 'wpmem_status', 'active'); // 一覧表示用
//   }

//   // 承認メール
//   $user = get_userdata($user_id);
//   wp_mail($user->user_email, '会員登録承認のお知らせ', 'あなたの会員登録が承認されました。ログイン可能です。');

//   wp_redirect(admin_url('users.php'));
//   exit;
// });

// // 非承認処理
// add_action('admin_post_wpmem_deny', function(){
//   $user_id = intval($_GET['user']);
//   $current_user = wp_get_current_user();

//   // 権限チェック
//   if(!in_array('member_admin', $current_user->roles)) wp_die('権限がありません');
//   if(!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'wpmem_deny_'.$user_id)) wp_die('不正な操作です');

//   // WP-Members が読み込まれていなければ後で実行
//   if(!function_exists('wpmem_deny_user')){
//       add_action('plugins_loaded', function() use ($user_id){
//           if(function_exists('wpmem_deny_user')){
//               wpmem_deny_user($user_id); // 内部非承認
//               update_user_meta($user_id, 'wpmem_status', 'denied'); // 一覧表示用
//           }
//       });
//   } else {
//       wpmem_deny_user($user_id); // 内部非承認
//       update_user_meta($user_id, 'wpmem_status', 'denied'); // 一覧表示用
//   }

//   // 非承認メール
//   $user = get_userdata($user_id);
//   wp_mail($user->user_email, '会員登録不承認のお知らせ', '申し訳ありません。あなたの会員登録は不承認となりました。');

//   wp_redirect(admin_url('users.php'));
//   exit;
// });

// // ====================================================
// // 8. 会員管理者が subscriber を削除可能にする
// // ====================================================
// add_filter('map_meta_cap', function($caps, $cap, $user_id, $args){
//   if($cap === 'delete_user'){
//       $target_user_id = $args[0] ?? 0;
//       if(!$target_user_id) return $caps;

//       $current_user = get_userdata($user_id);
//       $target_user  = get_userdata($target_user_id);
//       if(!$current_user || !$target_user) return $caps;

//       if(in_array('member_admin', $current_user->roles) && in_array('subscriber', $target_user->roles)){
//           return ['exist']; // subscriber を削除可能
//       }
//   }
//   return $caps;
// }, 10, 4);

// // ====================================================
// // 9. ユーザー一覧に承認／非承認ボタンを追加
// // ====================================================
// add_filter('manage_users_columns', function($columns){
//   $columns['wpmem_action'] = '操作';
//   return $columns;
// });

// add_action('manage_users_custom_column', function($value, $column_name, $user_id){
//   if($column_name !== 'wpmem_action') return $value;

//   $current_user = wp_get_current_user();
//   if(!in_array('member_admin', $current_user->roles)) return $value;

//   $status = get_user_meta($user_id, 'wpmem_status', true);

//   if($status === 'pending'){
//       $approve_url = wp_nonce_url(admin_url('admin-post.php?action=wpmem_approve&user=' . $user_id), 'wpmem_approve_'.$user_id);
//       $deny_url    = wp_nonce_url(admin_url('admin-post.php?action=wpmem_deny&user=' . $user_id), 'wpmem_deny_'.$user_id);

//       return '<a href="'.$approve_url.'" class="button button-primary">承認</a> '.
//              '<a href="'.$deny_url.'" class="button button-secondary">非承認</a>';
//   } elseif($status === 'active'){
//       return '承認済み';
//   } elseif($status === 'denied'){
//       return '非承認';
//   }
//   return '';
// }, 10, 3);


// // 1. DBに保存しない：登録前に不要フィールドを削除
// add_filter('wpmem_post_register_data', function($fields, $user_id = null){
//   // 保存したくないフィールド
//   $remove_fields = ['first_name','last_name','company','department','billing_phone','purpose'];
//   foreach($remove_fields as $key){
//       unset($fields[$key]);
//   }
//   return $fields;
// }, 10, 2);


// // 2. メール送信：登録後に必ず実行
// add_action('user_register', function($user_id){
//   $notify_email = 'h.nemoto@p-oh.jp'; // 管理者メール

//   $user = get_userdata($user_id);
//   if (!$user) return;

//   // $_POSTから追加情報を取得（DBには保存されない）
//   $extra_fields = [
//       'first_name'   => isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '',
//       'last_name'    => isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '',
//       'company'      => isset($_POST['company']) ? sanitize_text_field($_POST['company']) : '',
//       'department'   => isset($_POST['department']) ? sanitize_text_field($_POST['department']) : '',
//       'billing_phone'=> isset($_POST['billing_phone']) ? sanitize_text_field($_POST['billing_phone']) : '',
//       'purpose'      => isset($_POST['purpose']) ? sanitize_text_field($_POST['purpose']) : '',
//   ];

//   // ユーザー編集ページリンク
//   $user_edit_url = admin_url('user-edit.php?user_id=' . $user_id);

//   // メール件名・本文
//   $subject = sprintf('【新規会員申請】%s', $user->user_login);

//   $message_html = '<p>新しい会員申請がありました。</p><ul>';
//   $message_html .= '<li>ユーザー名: ' . esc_html($user->user_login) . '</li>';
//   $message_html .= '<li>メール: ' . esc_html($user->user_email) . '</li>';
//   foreach($extra_fields as $key => $value){
//       $message_html .= '<li>' . esc_html(ucfirst(str_replace('_',' ',$key))) . ': ' . esc_html($value) . '</li>';
//   }
//   $message_html .= '</ul><p>ユーザー詳細ページ:<br>';
//   $message_html .= '<a href="' . esc_url($user_edit_url) . '" target="_blank">ユーザー詳細を確認する</a></p>';

//   $headers = ["Content-Type: text/html; charset=UTF-8"];
//   wp_mail($notify_email, $subject, $message_html, $headers);
// });


// ----------------------------
// Ultimate Member: 任意のフィールドをDBに保存せずメール通知
// ----------------------------

add_action('um_registration_complete', function($user_id) {
  // POSTデータから各フィールドを取得
  $user_name        = isset($_POST['user_name']) ? sanitize_text_field($_POST['user_name']) : '';
  $company     = isset($_POST['company']) ? sanitize_text_field($_POST['company']) : '';
  $department  = isset($_POST['department']) ? sanitize_text_field($_POST['department']) : '';
  $phone       = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
  $purpose     = isset($_POST['purpose']) ? sanitize_text_field($_POST['purpose']) : '';

  // 念のためユーザーメタから削除
  delete_user_meta($user_id, 'user_name');
  delete_user_meta($user_id, 'company');
  delete_user_meta($user_id, 'department');
  delete_user_meta($user_id, 'phone');
  delete_user_meta($user_id, 'purpose');

  // ----------------------------
  // 任意のメールアドレスに通知
  // ----------------------------
  $admin_email = 'h.nemoto@p-oh.jp'; // 開発環境用
  $user_info   = get_userdata($user_id);

  $subject = '新規ユーザー登録通知';
  $message = "以下のユーザーが登録しました。\n\n";
  $message .= "ユーザー名: " . $user_info->user_login . "\n";
  $message .= "氏名: " . $user_name . "\n";
  $message .= "会社名: " . $company . "\n";
  $message .= "部署: " . $department . "\n";
  $message .= "電話番号: " . $phone . "\n";
  $message .= "ご利用目的: " . $purpose . "\n";

  wp_mail($admin_email, $subject, $message);

}, 10, 1);








?>
