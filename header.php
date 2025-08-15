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
  <div id="global-header">
    <div class="header--inner header-sp">
      <h1>
        <a href="<?php echo home_url(); ?>">
          <div class="logo">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="">
          </div>
        </a>
      </h1>

      <div class="right-box">
        <div class="sub-nav large-view">
          <div class="search-link">
            <a href="<?php echo home_url(); ?>/plan/">
              <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                <g transform="translate(-1201 -22)">
                  <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                  <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                </g>
              </svg>
              <span>動画ライブラリ</span>
            </a>
          </div>

          <div class="search-link">
            <a href="<?php echo home_url(); ?>/corporation/">
              <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                <g transform="translate(-1201 -22)">
                  <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                  <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                </g>
              </svg>
              <span>スライド資料</span>
            </a>
          </div>
        </div>

        <div class="contact-nav medium-view">
          <ul>
            <li class="inquiry"><a href="" target="_blank"><span>お問い合わせ</span></a></li>
            <li class="download"><a href="<?php echo home_url(); ?>/faq/"><span>ログイン・会員登録</span></a></li>
          </ul>
        </div>

        <div class="search-button">
          <a href="<?php echo home_url(); ?>/corporation/">
            <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
              <g transform="translate(-1201 -22)">
                <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
              </g>
            </svg>
          </a>
        </div>

        <div id="nav-toggle">
          <span></span>
          <span></span>
          <span></span>
        </div>

        <nav class="sp-nav">
          <h1>
            <a href="<?php echo home_url(); ?>">
              <div class="logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_white.svg" alt="">
              </div>
            </a>
          </h1>

          <div class="inner">
            <div class="main-wrapper">
              <div class="main-nav">
                <div class="menu-lavel">
                  <p>Company Information</p>
                  <ul>
                    <li><a href="<?php echo home_url(); ?>">ホーム<span>Home</span></a></li>
                    <li><a href="<?php echo home_url(); ?>/news/">お知らせ<span>News</span></a></li>
                    <li><a href="<?php echo home_url(); ?>/about/">会社概要<span>About</span></a></li>
                  </ul>

                  <div class="sub-nav sub-nav-pc">
                    <div class="search-link">
                      <a href="<?php echo home_url(); ?>/plan/">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                          <g transform="translate(-1201 -22)">
                            <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                            <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                          </g>
                        </svg>
                        <span>動画ライブラリ</span>
                      </a>
                    </div>

                    <div class="search-link">
                      <a href="<?php echo home_url(); ?>/corporation/">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                          <g transform="translate(-1201 -22)">
                            <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                            <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                          </g>
                        </svg>
                        <span>スライド資料</span>
                      </a>
                    </div>
                  </div>
                </div>

                <div class="menu-lavel">
                  <p>Medical Resources</p>
                  <ul>
                    <li><a href="<?php echo home_url(); ?>//">疾患別コンテンツ<span>Disease-Specific</span></a></li>
                    <li><a href="<?php echo home_url(); ?>//">医療制度コンテンツ<span>Medical System</span></a></li>
                    <li><a href="<?php echo home_url(); ?>//">スキル研修<span>Skills Training</span></a></li>
                    <li><a href="<?php echo home_url(); ?>//">Web講演会<span>Webinars</span></a></li>
                    <li><a href="<?php echo home_url(); ?>//">情報提供資材<span>Webinars</span></a></li>
                  </ul>
                </div>
              </div>

              <div class="sub-nav sub-nav-sp">
                <div class="search-link">
                  <a href="<?php echo home_url(); ?>/plan/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                      <g transform="translate(-1201 -22)">
                        <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                        <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                      </g>
                    </svg>
                    <span>動画ライブラリ</span>
                  </a>
                </div>

                <div class="search-link">
                  <a href="<?php echo home_url(); ?>/corporation/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30.253" height="33.159" viewBox="0 0 30.253 33.159" aria-hidden="true" focusable="false">
                      <g transform="translate(-1201 -22)">
                        <path d="M14,2A12,12,0,0,0,5.515,22.485,12,12,0,1,0,22.485,5.515,11.921,11.921,0,0,0,14,2m0-2A14,14,0,1,1,0,14,14,14,0,0,1,14,0Z" transform="translate(1201 22)" fill="currentColor"/>
                        <path d="M6.247,8.658l-7-8L.753-.659l7,8Z" transform="translate(1223.5 46.5)" fill="currentColor"/>
                      </g>
                    </svg>
                    <span>スライド資料</span>
                  </a>
                </div>
              </div>
            </div>
            
            <div class="buttom-nav">
              <ul>
                <li class="inquiry"><a href="" target="_blank"><span>お問い合わせ</span></a></li>
                <li class="download"><a href="<?php echo home_url(); ?>/faq/"><span>ログイン・会員登録</span></a></li>
              </ul>
            </div>
          </div>
            
        </nav>
      </div>
    </div>

    <div class="header-pc">
      <nav class="header-bottom">
        <ul class="menu">
          <li><a href="#">ホーム</a></li>
          <li><a href="#">お知らせ</a></li>
          <li><a href="#">会社概要</a></li>
          
          <li class="menu-item">
            <a href="#" class="parent-menu">疾患別コンテンツ</a>
            <div class="submenu">
              <ul>
                <li><a href="#">消化器</a></li>
                <li><a href="#">免疫・膠原病・感染症</a></li>
                <li><a href="#">脳・神経</a></li>
                <li><a href="#">腎・泌尿器</a></li>
                <li><a href="#">婦人科・乳腺</a></li>
                <li><a href="#">呼吸器</a></li>
                <li><a href="#">眼・耳鼻</a></li>
                <li><a href="#">皮膚</a></li>
                <li><a href="#">悪性腫瘍</a></li>
                <li><a href="#">希少疾患</a></li>
                <li><a href="#">血液疾患</a></li>
                <li class="last-row"><a href="#">統計</a></li>
              </ul>
            </div>
          </li>

          <li class="menu-item">
            <a href="#" class="parent-menu">医療制度コンテンツ</a>
            <div class="submenu">
              <ul>
                <li><a href="#">消化器</a></li>
                <li><a href="#">免疫・膠原病・感染症</a></li>
                <li><a href="#">脳・神経</a></li>
                <li><a href="#">腎・泌尿器</a></li>
                <li><a href="#">婦人科・乳腺</a></li>
                <li><a href="#">呼吸器</a></li>
                <li><a href="#">眼・耳鼻</a></li>
                <li><a href="#">皮膚</a></li>
                <li><a href="#">悪性腫瘍</a></li>
                <li><a href="#">希少疾患</a></li>
                <li><a href="#">血液疾患</a></li>
              </ul>
            </div>
          </li>

          <li class="menu-item">
            <a href="#" class="parent-menu">スキル研修</a>
            <div class="submenu">
              <ul>
                <li><a href="#">消化器</a></li>
                <li><a href="#">免疫・膠原病・感染症</a></li>
                <li><a href="#">脳・神経</a></li>
                <li><a href="#">腎・泌尿器</a></li>
                <li><a href="#">婦人科・乳腺</a></li>
                <li><a href="#">呼吸器</a></li>
                <li><a href="#">眼・耳鼻</a></li>
                <li><a href="#">皮膚</a></li>
                <li><a href="#">悪性腫瘍</a></li>
                <li><a href="#">希少疾患</a></li>
                <li><a href="#">血液疾患</a></li>
              </ul>
            </div>
          </li>

          <li><a href="#">Web講演会</a></li>
          <li><a href="#">情報提供資料</a></li>
          
        </ul>
      </nav>
    </div>

    <!-- <div class="header-pc">
      <nav class="header-bottom">
        <ul class="content-menu">
          <li><a href="#">ホーム</a></li>
          <li><a href="#">お知らせ</a></li>
          <li><a href="#">会社概要</a></li>
          <li>
            <a href="#" class="parent-menu">疾患別コンテンツ</a>
            <ul class="children-menu">
              <li><a href="#">消化器</a></li>
              <li><a href="#">免疫・膠原病・感染症</a></li>
              <li><a href="#">脳・神経</a></li>
              <li><a href="#">腎・泌尿器</a></li>
            </ul>
          </li>
          <li><a href="#">Web講演会</a></li>
          <li><a href="#">情報提供資料</a></li>
        </ul>
      </nav>
    </div> -->
  </div>