		<footer id="global-footer">
      <div class="contact">
        <div class="container">
          <div class="text-area">
            <p>会員登録をしていただくと<span>動画やスライド詳細をご確認いただけます。</span></p>
          </div>

          <div class="contact-button">
            <ul>
              <li>
                <a href="">
                  <div class="flex-box">
                    <figure>
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/login.svg" alt="YTL">
                    </figure>
                    <span>会員登録はこちら</span>
                  </div>
                </a>
              </li>

              <li>
                <a href="">
                  <div class="flex-box">
                    <figure>
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/login.svg" alt="YTL">
                    </figure>
                    <span>ログインはこちら</span>
                  </div>
                </a>
              </li>
            </ul>
          </div>


          <!-- <div class="contact-button">
            <ul>
              <li>
                <figure>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/login.svg" alt="YTL">
                </figure>
                <p>新規会員登録</p>

                <div class="default-button">
                  <a href="<?php echo home_url(); ?>/about/" class="button-more"><span>会員登録はこちら</span></a>
                </div>
              </li>
            </ul>
          </div>

          <div class="contact-button">
            <ul>
              <li>
                <figure>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/login.svg" alt="YTL">
                </figure>
                <p>ログイン</p>

                <div class="default-button">
                  <a href="<?php echo home_url(); ?>/about/" class="button-more"><span>ログインはこちら</span></a>
                </div>
              </li>
            </ul>
          </div> -->
        </div>
      </div>

      <div class="top">
				<div class="container">
					<div class="flex-box">
						<div class="left">
              <h1>
                <a href="<?php echo home_url(); ?>">
                <div class="logo">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="">
                </div>
                </a>
              </h1>
						</div>

            <div class="right">
              <div class="company-link">
                <p>Information</p>
                <ul>
                  <li><a href="<?php echo home_url(); ?>"><span>ホーム</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/news/"><span>お知らせ</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/about/"><span>会社概要</span></a></li>
                  <li><a href="<?php echo home_url(); ?>"><span>お問い合わせ</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/news/"><span>ログイン・会員登録</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/about/"><span>利用規約</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/about/"><span>プライバシーポリシー</span></a></li>
                </ul>
              </div>

              <div class="company-link">
                <p>Medical Content</p>
                <ul>
                  <li><a href="<?php echo home_url(); ?>"><span>疾患別コンテンツ</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/news/"><span>医療制度コンテンツ</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/about/"><span>スキル研修</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/about/"><span>Web講演会</span></a></li>
                  <li><a href="<?php echo home_url(); ?>/about/"><span>情報提供資料</span></a></li>
                </ul>
              </div>

              
            </div>
					</div>
				</div>
			</div>

			<div class="bottom">©︎ 2025 YTL</div>
		</footer>
    <?php wp_footer(); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/scripts.js"></script>
  </body>
</html>
