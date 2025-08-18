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
      'info_material' => '情報提供資料',
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

?>