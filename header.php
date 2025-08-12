<!doctype html>
<html class="no-js" lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_page_title(); ?></title>
	  <meta name="description" content="<?php echo get_description(); ?>">
	  <meta property="og:title" content="<?php echo get_page_title(); ?>">
	  <meta property="og:type" content="website">
	  <meta property="og:description" content="<?php echo get_description(); ?>">
		<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/ogimage.jpg" />
	  <link href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" rel="shortcut icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/styles.css">
	
		<?php wp_head(); ?>
  </head>
  
  <body <?php body_class(); ?>>
		
	  <header id="global-header">

      <div class="container">
        <div style="display:flex;align-items:center;gap:16px">
          <button class="mobile-toggle" aria-controls="main-navigation" aria-expanded="false" id="navToggle">☰</button>
          <a class="logo" href="/">
            <!-- 本番では画像ファイルを置き換えてください -->
            <img src="https://www.joshibi.ac.jp/common/img/logo_joshibi.svg" alt="女子美術大学">
          </a>
        </div>

        <nav id="main-navigation" class="main-nav" role="navigation" aria-label="メインナビゲーション">
          <ul>
            <li class="has-dropdown">
              <a href="#">JOSHIBI NEWS</a>
              <div class="dropdown" aria-hidden="true">
                <a href="#">お知らせ</a>
                <a href="#">プレスリリース</a>
                <a href="#">展覧会・イベント情報</a>
                <a href="#">広報誌</a>
                <a href="#">オープンキャンパス・進学相談会</a>
                <a href="#">受験生サイト</a>
              </div>
            </li>

            <li class="has-dropdown">
              <a href="#">女子美について</a>
              <div class="dropdown" aria-hidden="true">
                <a href="#">教育理念と方針</a>
                <a href="#">女子美の歴史と教育組織</a>
                <a href="#">情報の公開</a>
                <a href="#">キャンパス・施設</a>
              </div>
            </li>

            <li class="has-dropdown">
              <a href="#">大学・短大・大学院</a>
              <div class="dropdown" aria-hidden="true">
                <a href="#">学べる科目</a>
                <a href="#">学部・学科一覧</a>
                <a href="#">短期大学部</a>
              </div>
            </li>

            <li><a href="#">入試情報</a></li>
            <li><a href="#">学生生活</a></li>
            <li><a href="#">進路と就職</a></li>
            <li><a href="#">アクセス案内</a></li>
            <li><a href="#">お問い合わせ</a></li>
            <li><a href="https://joshibiglobal.jp" target="_blank" rel="noopener">Global Site</a></li>
          </ul>
        </nav>

        <div class="quick-links">
          <a class="btn" href="#">資料請求</a>
          <a class="btn" href="#">在学生の方へ</a>
        </div>
      </div>


	  </header>