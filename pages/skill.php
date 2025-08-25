<?php /*
Template Name: スキル研修
*/ ?>


<?php get_header(); ?>

<main>
  <section id="section-title">
    <h2>スキル研修</h2>
  </section>

  <div class="container">
    <section id="section-message">
      <p>
      患者さまや医療従事者に寄り添った活動ができるよう、「学び」をサポートいたします。
        <span>ご要望に合わせた資材作成から研修プランの立案・運営までサポートし、質の高い人材育成を目指します。</span>
      </p>
    </section>
  </div>

  <section id="section-post" class="post-movie">
    <div class="title-label">
      <h3>動画ライブラリ</h3>
    </div>

    <div class="posts">
      <?php
        // parent03 というスラッグのタームを取得
        $parent_term = get_term_by('slug', 'parent03', 'common_category');

        if ($parent_term) {
          $query = new WP_Query([
            'post_type'      => ['video_library'],
            'posts_per_page' => 5,
            'tax_query'      => [
              [
                'taxonomy'         => 'common_category',
                'field'            => 'term_id',
                'terms'            => $parent_term->term_id,
                'include_children' => false,
              ]
            ]
          ]);

        if ($query->have_posts()): ?>
          <div class="swiper my-medical-swiper">
            <div class="swiper-wrapper">
              <?php while ($query->have_posts()): $query->the_post(); ?>
                <div class="swiper-slide">
                  <div class="background">
                    <a href="<?php the_permalink(); ?>">
                      <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium'); ?>
                      <?php endif; ?>
  
                      <div class="text-box">
                        <p class="slide-title">
                            <?php 
                            $title = get_the_title();
                            echo mb_strimwidth($title, 0, 40, '…', 'UTF-8'); 
                            ?>
                        </p>
  
                        <p class="slide-excerpt">
                            <?php 
                            $excerpt = get_the_excerpt(); 
                            echo mb_strimwidth($excerpt, 0, 100, '…', 'UTF-8'); 
                            ?>
                        </p>
                      </div>
                    </a>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
            <div class="swiper-navigation">
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
          </div>
        <?php
        else:
          echo '<p>投稿はまだありません。</p>';
        endif;

        wp_reset_postdata();
        } else {
          echo '<p>「child01」カテゴリーが存在しません。</p>';
        }
      ?>
    </div>

    <div class="default-button">
      <button class="button-more" data-parent="parent01" data-child="child01">
        <span>もっと見る</span>
      </button>
    </div>
    
  </section>

  <section id="section-post" class="post-slide">
    <div class="title-label">
      <h3>スライド資料</h3>
    </div>

    <div class="posts">
      <?php
        // parent03 というスラッグのタームを取得
        $parent_term = get_term_by('slug', 'parent03', 'common_category');

        if ($parent_term) {
          $query = new WP_Query([
            'post_type'      => ['material'],
            'posts_per_page' => 5,
            'tax_query'      => [
              [
                'taxonomy'         => 'common_category',
                'field'            => 'term_id',
                'terms'            => $parent_term->term_id,
                'include_children' => false,
              ]
            ]
          ]);

        if ($query->have_posts()): ?>
          <div class="swiper my-medical-swiper">
            <div class="swiper-wrapper">
              <?php while ($query->have_posts()): $query->the_post(); ?>
                <div class="swiper-slide">
                  <div class="background">
                    <a href="<?php the_permalink(); ?>">
                      <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium'); ?>
                      <?php endif; ?>
  
                      <div class="text-box">
                        <p class="slide-title">
                            <?php 
                            $title = get_the_title();
                            echo mb_strimwidth($title, 0, 40, '…', 'UTF-8'); 
                            ?>
                        </p>
  
                        <p class="slide-excerpt">
                            <?php 
                            $excerpt = get_the_excerpt(); 
                            echo mb_strimwidth($excerpt, 0, 100, '…', 'UTF-8'); 
                            ?>
                        </p>
                      </div>
                    </a>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
            <div class="swiper-navigation">
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
          </div>
        <?php
        else:
          echo '<p>投稿はまだありません。</p>';
        endif;

        wp_reset_postdata();
        } else {
          echo '<p>「child01」カテゴリーが存在しません。</p>';
        }
      ?>
    </div>

    <div class="default-button">
      <button class="button-more" data-parent="parent01" data-child="child01">
        <span>もっと見る</span>
      </button>
    </div>
  </section>

</main>

<?php get_footer(); ?>