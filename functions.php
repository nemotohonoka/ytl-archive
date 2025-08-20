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

// ===== カスタム投稿タイプの登録 =====
add_action('init', function() {

  // 投稿タイプ共通の設定
  $post_types = [
      'video_library' => '動画ライブラリ',
      'web_seminar'   => 'Web講演会',
      'material' => 'スライド資料',
  ];

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

  // ===== 共通カテゴリー（階層あり） =====
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
      'hierarchical'  => true, // 親子関係あり
      'public'        => true,
      'show_in_rest'  => true,
  ]);
});





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
      echo '<div class="video-items">';
      while ($query->have_posts()) {
          $query->the_post();
          echo '<div class="video-item">';
          if (has_post_thumbnail()) {
              the_post_thumbnail('thumbnail');
          }
          echo '<p>' . get_the_title() . '</p>';
          echo '</div>';
      }
      echo '</div>';
  } else {
      echo '<p>投稿が見つかりませんでした。</p>';
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








?>