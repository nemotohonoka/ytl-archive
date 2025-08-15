<?php get_header(); ?>
<main>
  <section id="welcome">
		<div class="inner">
			<!-- <div class="text-box">
				<h2>
					<figure>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/catchcopy.png" alt="YTL">
					</figure>
				</h2>
			</div> -->
		</div>
	</section>

  <section id="message">
    <div class="inner">
      <div class="container">
        <div class="message-text fadein">
          <h3>
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/message_sp.png" alt="YTL">
            </figure>
          </h3>
          
          <div class="text-area">
            <p>私たちYTLは、患者様や医療従事者に寄り添った活動ができる<span>「学び」のサポートをいたします。</span></p>
          </div>
        </div>
        
        <div class="default-button">
          <a href="<?php echo home_url(); ?>/about/" class="button-more"><span>詳しくみる</span></a>
        </div>
      </div>
    </div>
	</section>
</main>
<?php get_footer(); ?>