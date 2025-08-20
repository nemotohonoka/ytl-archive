<?php get_header(); ?>

<main>	
  <section id="library-section-title">
    <h2>動画ライブラリ</h2>
  </section>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <!-- タイトル -->
  <h1><?php the_title(); ?></h1>

  <!-- サムネイル -->
  <?php if ( has_post_thumbnail() ) : ?>
    <div class="post-thumbnail"><?php the_post_thumbnail('large'); ?></div>
  <?php endif; ?>

  <!-- 本文 -->
  <div class="post-content"><?php the_content(); ?></div>

  <?php if ( is_user_logged_in() ) : ?>

<!-- Vimeo動画 -->
<?php if ( $video_url = get_field('video_url') ) : ?>
    <?php
        // Vimeo ID を取得
        preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches);
        $video_id = $matches[1] ?? '';
        $embed_url = $video_id ? "https://player.vimeo.com/video/{$video_id}" : '';
    ?>
    <?php if ( $embed_url ) : ?>
        <div class="video-wrapper">
            <iframe src="<?php echo esc_url($embed_url); ?>" 
                    frameborder="0" 
                    allow="fullscreen; picture-in-picture" 
                    allowfullscreen>
            </iframe>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- 補足テキスト -->
<?php if ( $extra_text = get_field('extra_text') ) : ?>
  <div class="extra-text"><?php echo wp_kses_post($extra_text); ?></div>
<?php endif; ?>

<!-- お問い合わせボタン（共通固定） -->
<div class="contact-btn">
  <a href="/contact/" class="btn">資材について問い合わせる</a>
</div>

<?php else : ?>
<div class="login-message">
  <p>資材の閲覧には会員登録・ログインが必要です</p>
  <a href="<?php echo wp_login_url(get_permalink()); ?>" class="btn">ログインはこちら</a>
</div>
<?php endif; ?>

</article>


  

  


    


  

</main>

<?php get_footer(); ?>