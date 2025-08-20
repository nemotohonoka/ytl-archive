<?php get_header(); ?>

<main>	
  <section id="library-section-title">
    <h2>動画ライブラリ</h2>
  </section>


  <?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <footer class="entry-footer">
                <?php
                // カスタムフィールドやタクソノミーを表示したい場合
                $video_url = get_post_meta(get_the_ID(), 'video_url', true);
                if ($video_url) {
                    echo '<div class="video-player">';
                    echo '<video src="' . esc_url($video_url) . '" controls></video>';
                    echo '</div>';
                }
                ?>
            </footer>

        </article>

    <?php endwhile;
endif;
?>

  


    


  

</main>

<?php get_footer(); ?>