<?php /*
Template Name: 消化器
*/ ?>


<?php get_header(); ?>

<main>
  <section id="section-title">
    <h2>疾患別コンテンツ</h2>
  </section>

  <div class="container">
    <div class="category-icon">
      <figure>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/medical/medical_icon01.svg" alt="消化器">
      </figure>
      <p>消化器</p>
    </div>
  </div>

  <section id="section-post" class="post-movie">
    <div class="title-label">
      <h3>動画ライブラリ</h3>
    </div>

    <div class="posts">
      <?php
      // child01 のタームを取得
      $child_term = get_term_by('slug', 'child01', 'common_category');

      if ($child_term) {
        $query = new WP_Query([
          'post_type'      => ['video_library'],
          'posts_per_page' => 5,
          'tax_query'      => [
            [
              'taxonomy'         => 'common_category',
              'field'            => 'term_id',
              'terms'            => $child_term->term_id,
              'include_children' => false, // 子孫は含めない
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
  
                        <p class="slide-taxonomy child01-color">
                          <?php
                          $terms = get_the_terms(get_the_ID(), 'common_category');
  
                          if ($terms && !is_wp_error($terms)) {
                            $child_terms = [];
                            foreach ($terms as $term) {
                              if ($term->term_id == $child_term->term_id) {
                                $child_terms[] = $term->name;
                              }
                            }
                            if (!empty($child_terms)) {
                              foreach ($child_terms as $child_name) {
                                echo '<span class="tag">' . esc_html($child_name) . '</span> ';
                              }
                            }
                          }
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
      // child01 のタームを取得
      $child_term = get_term_by('slug', 'child01', 'common_category');

      if ($child_term) {
        $query = new WP_Query([
          'post_type'      => ['material'],
          'posts_per_page' => 5,
          'tax_query'      => [
            [
              'taxonomy'         => 'common_category',
              'field'            => 'term_id',
              'terms'            => $child_term->term_id,
              'include_children' => false, // 子孫は含めない
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
  
                        <p class="slide-taxonomy child01-color">
                          <?php
                          $terms = get_the_terms(get_the_ID(), 'common_category');
  
                          if ($terms && !is_wp_error($terms)) {
                            $child_terms = [];
                            foreach ($terms as $term) {
                              if ($term->term_id == $child_term->term_id) {
                                $child_terms[] = $term->name;
                              }
                            }
                            if (!empty($child_terms)) {
                              foreach ($child_terms as $child_name) {
                                echo '<span class="tag">' . esc_html($child_name) . '</span> ';
                              }
                            }
                          }
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