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
    echo '<p>投稿が見つかりませんでした</p>';
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


 // WPForms の送信データ保存を無効化
add_filter( 'wpforms_process_entry_save', '__return_false' );

add_action( 'wpforms_process_complete', 'my_custom_user_registration_request', 10, 4 );
function my_custom_user_registration_request( $fields, $entry, $form_data, $entry_id ) {

    if ( absint( $form_data['id'] ) !== 123 ) return; // フォームID

    // 入力情報を取得（WPには保存しない）
    $username   = sanitize_user( $fields[1]['value'] );
    $email      = sanitize_email( $fields[2]['value'] );
    $password   = $fields[3]['value'];
    $name       = sanitize_text_field( $fields[4]['value'] );
    $company    = sanitize_text_field( $fields[5]['value'] );
    $department = sanitize_text_field( $fields[6]['value'] );
    $phone      = sanitize_text_field( $fields[7]['value'] );
    $purpose    = sanitize_text_field( $fields[8]['value'] );

    // ユーザー承認用の一意IDを作成して保存（後で承認リンクで使用）
    $approval_key = wp_generate_password( 20, false );
    update_post_meta( $entry_id, '_approval_key', $approval_key );
    update_post_meta( $entry_id, '_user_data', compact('username','email','password','name','company','department','phone','purpose') );

    // 管理者メール送信
    $admin_email = get_option('admin_email');
    $approve_link = admin_url( "admin-post.php?action=approve_user&entry_id=$entry_id&key=$approval_key" );

    $subject = '新規会員登録申請';
    $message = "新規会員登録の申請があります。\n\n";
    $message .= "ユーザー名: $username\nメール: $email\n氏名: $name\n会社名: $company\n部署名: $department\n電話番号: $phone\n目的: $purpose\n\n";
    $message .= "承認する場合はこちらのリンクをクリックしてください:\n$approve_link";

    wp_mail( $admin_email, $subject, $message );
}

add_action( 'admin_post_approve_user', 'approve_user_registration' );
function approve_user_registration() {
    if ( ! current_user_can('administrator') ) {
        wp_die('権限がありません。');
    }

    $entry_id = intval( $_GET['entry_id'] ?? 0 );
    $key      = sanitize_text_field( $_GET['key'] ?? '' );

    $stored_key = get_post_meta( $entry_id, '_approval_key', true );
    if ( $key !== $stored_key ) {
        wp_die('無効な承認リンクです。');
    }

    $user_data = get_post_meta( $entry_id, '_user_data', true );
    if ( ! $user_data ) {
        wp_die('ユーザー情報が見つかりません。');
    }

    $userdata = array(
        'user_login' => $user_data['username'],
        'user_pass'  => $user_data['password'],
        'user_email' => $user_data['email'],
        'role'       => 'subscriber',
    );

    $user_id = wp_insert_user( $userdata );

    if ( is_wp_error( $user_id ) ) {
        wp_die('ユーザー登録に失敗しました: ' . $user_id->get_error_message() );
    }

    // 登録完了メール（任意）
    wp_mail( $user_data['email'], '会員登録完了', "ユーザー名: {$user_data['username']} でログインできます。" );

    echo 'ユーザー登録が完了しました。';
    exit;
}

add_action( 'admin_menu', function() {
  add_menu_page(
      '会員申請一覧',         // ページタイトル
      '会員申請一覧',         // メニュータイトル
      'administrator',       // 権限
      'pending_user_requests', // スラッグ
      'render_pending_user_requests', // 表示関数
      'dashicons-admin-users', // アイコン
      6
  );
});

function render_pending_user_requests() {
  echo '<div class="wrap"><h1>未承認の会員申請</h1>';

  // WPFormsのエントリー投稿タイプは "wpforms_entries"
  $entries = get_posts(array(
      'post_type'   => 'wpforms_entry',
      'numberposts' => -1,
      'meta_query'  => array(
          array(
              'key'     => '_approval_key',
              'compare' => 'EXISTS'
          )
      )
  ));

  if ( empty($entries) ) {
      echo '<p>現在、未承認の申請はありません。</p>';
      echo '</div>';
      return;
  }

  echo '<table class="widefat fixed" style="width:100%;"><thead><tr>';
  echo '<th>ユーザー名</th><th>メール</th><th>氏名</th><th>会社名</th><th>部署名</th><th>電話番号</th><th>目的</th><th>承認</th>';
  echo '</tr></thead><tbody>';

  foreach ( $entries as $entry ) {
      $data = get_post_meta( $entry->ID, '_user_data', true );
      $key  = get_post_meta( $entry->ID, '_approval_key', true );

      echo '<tr>';
      echo '<td>' . esc_html($data['username']) . '</td>';
      echo '<td>' . esc_html($data['email']) . '</td>';
      echo '<td>' . esc_html($data['name']) . '</td>';
      echo '<td>' . esc_html($data['company']) . '</td>';
      echo '<td>' . esc_html($data['department']) . '</td>';
      echo '<td>' . esc_html($data['phone']) . '</td>';
      echo '<td>' . esc_html($data['purpose']) . '</td>';
      echo '<td><a class="button button-primary" href="' . admin_url("admin-post.php?action=approve_user&entry_id={$entry->ID}&key={$key}") . '">承認</a></td>';
      echo '</tr>';
  }

  echo '</tbody></table></div>';
}





?>