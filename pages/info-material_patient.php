<?php /*
Template Name: 患者向け
*/ ?>


<?php get_header(); ?>

<main>
  <section id="section-title">
    <h2>情報提供資料</h2>
  </section>

  <div class="container">
    <div class="category-icon">
      <figure>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/material/material_icon02.svg" alt="患者向け">
      </figure>
      <p>患者向け</p>
    </div>
  </div>

  <section id="section-post" class="post-movie">
    <div class="title-label">
      <h3>動画ライブラリ</h3>
    </div>

    <div class="posts">
      <?php
      $child_term = get_term_by('slug', 'child02-parent05', 'common_category');

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
          echo '<p class="not-post">投稿はまだありません。</p>';
        endif;

        wp_reset_postdata();
        } else {
          echo '<p class="not-post">「child01」カテゴリーが存在しません。</p>';
        }
      ?>
    </div>

    <div class="default-button">
      <a href="<?php echo home_url(); ?>/about/" class="button-more"><span>もっと見る</span></a>
    </div>
  </section>

  <section id="section-post" class="post-slide">
    <div class="title-label">
      <h3>スライド資料</h3>
    </div>

    <div class="posts">
      <?php
      $child_term = get_term_by('slug', 'child02-parent05', 'common_category');

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
          echo '<p class="not-post">投稿はまだありません。</p>';
        endif;

        wp_reset_postdata();
        } else {
          echo '<p class="not-post">「child01」カテゴリーが存在しません。</p>';
        }
      ?>
    </div>

    <div class="default-button">
      <a href="<?php echo home_url(); ?>/about/" class="button-more"><span>もっと見る</span></a>
    </div>
  </section>

  <div class="secondarynav">
    <div class="container">
      <ul>
        <li class="passive">
          <a href="<?php echo home_url(); ?>/info-material/professional">
            <div class="nav-box">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40.753" height="30.274" viewBox="0 0 40.753 30.274">
                <g id="グループ_2581" data-name="グループ 2581" transform="translate(0 0)">
                  <g id="グループ_2565" data-name="グループ 2565" transform="translate(0 0)" clip-path="url(#clip-path)">
                    <path class="icon-path" d="M24.229,21.637l-.046,0a17.645,17.645,0,0,0-2.766,0,.591.591,0,0,1-.637-.589v-2.43a17.612,17.612,0,0,0-2.34.434.59.59,0,0,1-.737-.572V15.646a.591.591,0,0,1,.444-.572A18.859,18.859,0,0,1,20.78,14.6V12.052a.591.591,0,0,1,.544-.589,18.874,18.874,0,0,1,2.952,0,.591.591,0,0,1,.544.589V14.6a18.859,18.859,0,0,1,2.633.478.591.591,0,0,1,.444.572v2.832a.59.59,0,0,1-.737.572,17.588,17.588,0,0,0-2.34-.434v2.43a.591.591,0,0,1-.591.591m-2.859-4.262a.591.591,0,0,1,.591.591v2.452c.558-.025,1.119-.025,1.678,0V17.965a.59.59,0,0,1,.637-.589,18.771,18.771,0,0,1,2.44.356V16.11a17.554,17.554,0,0,0-2.533-.388.591.591,0,0,1-.544-.589V12.607c-.558-.027-1.12-.027-1.678,0v2.527a.591.591,0,0,1-.544.589,17.554,17.554,0,0,0-2.533.388v1.622a18.79,18.79,0,0,1,2.44-.356l.047,0" transform="translate(-10.814 -6.967)" fill="#fff"/>
                    <path class="icon-path" d="M8.313,26.819a.591.591,0,0,1-.591-.591V2.063a.591.591,0,0,1,.39-.555,25.239,25.239,0,0,1,17.184,0,.59.59,0,0,1,.389.555V26.228a.591.591,0,1,1-1.181,0V2.481a24.061,24.061,0,0,0-15.6,0V25.4a25.136,25.136,0,0,1,13.817-.507.591.591,0,1,1-.281,1.147,23.96,23.96,0,0,0-13.925.743.593.593,0,0,1-.2.035" transform="translate(-4.717 0)" fill="#fff"/>
                    <path class="icon-path" d="M68.218,26.819a.593.593,0,0,1-.2-.035,24.058,24.058,0,0,0-16.378,0,.59.59,0,0,1-.792-.555V2.063a.59.59,0,0,1,.389-.555,25.24,25.24,0,0,1,17.184,0,.591.591,0,0,1,.389.555v5.8a.591.591,0,1,1-1.181,0V2.481a24.061,24.061,0,0,0-15.6,0V25.4a25.246,25.246,0,0,1,15.6,0V12.82a.591.591,0,1,1,1.181,0V26.228a.591.591,0,0,1-.591.591" transform="translate(-31.06 0)" fill="#fff"/>
                    <path class="icon-path" d="M18.918,49.673A.591.591,0,0,1,18.8,48.5a22.839,22.839,0,0,1,8.758,0,.591.591,0,1,1-.232,1.158,21.648,21.648,0,0,0-8.295,0,.593.593,0,0,1-.116.012" transform="translate(-11.196 -29.369)" fill="#fff"/>
                    <path class="icon-path" d="M70.569,26.459a.6.6,0,0,1-.116-.012,21.646,21.646,0,0,0-8.295,0,.591.591,0,1,1-.232-1.158,22.852,22.852,0,0,1,8.758,0,.591.591,0,0,1-.115,1.17" transform="translate(-37.538 -15.189)" fill="#fff"/>
                    <path class="icon-path" d="M70.569,14.852a.6.6,0,0,1-.116-.012,21.646,21.646,0,0,0-8.295,0,.591.591,0,1,1-.232-1.158,22.837,22.837,0,0,1,8.758,0,.591.591,0,0,1-.115,1.17" transform="translate(-37.538 -8.099)" fill="#fff"/>
                    <path class="icon-path" d="M70.569,38.066a.6.6,0,0,1-.116-.012,21.646,21.646,0,0,0-8.295,0,.591.591,0,1,1-.232-1.158,22.852,22.852,0,0,1,8.758,0,.591.591,0,0,1-.115,1.17" transform="translate(-37.538 -22.279)" fill="#fff"/>
                    <path class="icon-path" d="M70.569,49.673a.6.6,0,0,1-.116-.012,21.646,21.646,0,0,0-8.295,0,.591.591,0,1,1-.232-1.158,22.837,22.837,0,0,1,8.758,0,.591.591,0,0,1-.115,1.17" transform="translate(-37.538 -29.369)" fill="#fff"/>
                    <path class="icon-path" d="M20.377,35.315a5.718,5.718,0,0,1-3.4-1.125H.59A.59.59,0,0,1,0,33.6V8.844a.591.591,0,0,1,.59-.591h.92a.591.591,0,0,1,0,1.181H1.181V33.009H17.174a.589.589,0,0,1,.367.128,4.538,4.538,0,0,0,5.671,0,.589.589,0,0,1,.367-.128H39.572V9.434h-.329a.591.591,0,0,1,0-1.181h.92a.591.591,0,0,1,.59.591V33.6a.59.59,0,0,1-.59.59H23.78a5.717,5.717,0,0,1-3.4,1.125" transform="translate(0 -5.041)" fill="#fff"/>
                  </g>
                </g>
              </svg>
              <p>医療従事者向け</p>
            </div>
          </a>
        </li>
  
        <li class="active">
          <div class="nav-box">
            <svg id="グループ_2582" data-name="グループ 2582" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="33.116" height="35.064" viewBox="0 0 33.116 35.064">
              <g id="グループ_2566" data-name="グループ 2566" clip-path="url(#clip-path)">
                <path class="icon-path" d="M27.7,35.064h-.012a.586.586,0,0,1-.574-.6,20.266,20.266,0,0,1,2.572-9.657,17.686,17.686,0,0,0,2.053-11.78C30.37,2,19.608,1.275,19.15,1.249l-.042,0a18.939,18.939,0,0,0-6.911.637,11.194,11.194,0,0,0-8.341,9.343c-.01.047-.4,1.78.507,2.547a1.16,1.16,0,0,1,.406.837c.1,1.462-2.2,4.241-3.576,5.768a.072.072,0,0,0-.02.038c.049.13.257.5,1.086.879,1.7.783,1.548,3.094,1.424,3.972a3.667,3.667,0,0,1,1.133,3.318c-.223.993-.411,2.109.177,2.778.529.6,1.717.837,3.432.681a28.9,28.9,0,0,0,7.912-1.912.586.586,0,1,1,.446,1.083,29.529,29.529,0,0,1-8.264,2c-2.154.2-3.6-.154-4.407-1.075-1.03-1.174-.646-2.887-.44-3.808a2.679,2.679,0,0,0-.986-2.388.586.586,0,0,1-.207-.582c.005-.023.484-2.447-.712-3a3,3,0,0,1-1.7-1.55,1.2,1.2,0,0,1,.253-1.216c2.507-2.776,3.421-4.561,3.27-4.942-1.45-1.214-.907-3.565-.883-3.665C4.963-1.38,18.614.009,19.236.08c.595.042,12.206,1.038,13.66,12.806a18.882,18.882,0,0,1-2.164,12.44,19.277,19.277,0,0,0-2.452,9.162.586.586,0,0,1-.586.575" transform="translate(0 0)" fill="#011976"/>
                <path class="icon-path" d="M29.993,85.433a.586.586,0,0,1-.581-.518L29.155,82.7a.586.586,0,1,1,1.164-.135l.257,2.218a.586.586,0,0,1-.515.649.579.579,0,0,1-.068,0" transform="translate(-17.896 -50.369)" fill="#011976"/>
                <path class="icon-path" d="M34.211,34.8a.588.588,0,0,1-.311-.089,5.954,5.954,0,1,1,6.321,0,.586.586,0,1,1-.622-.993,4.782,4.782,0,1,0-5.076,0,.586.586,0,0,1-.312,1.082" transform="translate(-19.097 -14.554)" fill="#011976"/>
                <path class="icon-path" d="M41.067,59.389a3.3,3.3,0,0,1-.912-.129,3.5,3.5,0,0,1-2.523-3.35v-.4a.586.586,0,0,1,.586-.586h5.7a.586.586,0,0,1,.586.586v.4a3.5,3.5,0,0,1-2.523,3.35,3.3,3.3,0,0,1-.912.129m-2.255-3.294a2.325,2.325,0,0,0,1.667,2.039,2.127,2.127,0,0,0,1.176,0,2.326,2.326,0,0,0,1.667-2.039Z" transform="translate(-23.103 -33.719)" fill="#011976"/>
                <path class="icon-path" d="M45.6,16.49a.586.586,0,0,1-.586-.586V14.251a.586.586,0,0,1,1.173,0V15.9a.586.586,0,0,1-.586.586" transform="translate(-27.633 -8.389)" fill="#011976"/>
                <path class="icon-path" d="M34.514,19.46a.585.585,0,0,1-.508-.293l-.827-1.432a.586.586,0,0,1,1.015-.586l.827,1.432a.586.586,0,0,1-.507.879" transform="translate(-20.321 -10.349)" fill="#011976"/>
                <path class="icon-path" d="M26.4,27.574a.583.583,0,0,1-.292-.079l-1.432-.827a.586.586,0,0,1,.586-1.015l1.432.827a.586.586,0,0,1-.293,1.094" transform="translate(-14.968 -15.702)" fill="#011976"/>
                <path class="icon-path" d="M23.429,38.659H21.776a.586.586,0,1,1,0-1.172h1.653a.586.586,0,1,1,0,1.172" transform="translate(-13.009 -23.014)" fill="#011976"/>
                <path class="icon-path" d="M24.968,49.254a.586.586,0,0,1-.293-1.094l1.432-.827a.586.586,0,0,1,.586,1.015l-1.432.827a.582.582,0,0,1-.292.079" transform="translate(-14.968 -29.011)" fill="#011976"/>
                <path class="icon-path" d="M63.949,49.254a.582.582,0,0,1-.292-.079l-1.432-.827a.586.586,0,0,1,.586-1.015l1.432.827a.586.586,0,0,1-.293,1.094" transform="translate(-38.022 -29.011)" fill="#011976"/>
                <path class="icon-path" d="M66.789,38.659H65.136a.586.586,0,1,1,0-1.172h1.653a.586.586,0,1,1,0,1.172" transform="translate(-39.629 -23.014)" fill="#011976"/>
                <path class="icon-path" d="M62.519,27.574a.586.586,0,0,1-.294-1.094l1.432-.827a.586.586,0,0,1,.586,1.015l-1.432.827a.583.583,0,0,1-.292.079" transform="translate(-38.022 -15.702)" fill="#011976"/>
                <path class="icon-path" d="M55.366,19.46a.586.586,0,0,1-.507-.879l.827-1.432a.586.586,0,0,1,1.015.586l-.827,1.432a.585.585,0,0,1-.508.293" transform="translate(-33.631 -10.349)" fill="#011976"/>
                <path class="icon-path" d="M42.766,44.2a.587.587,0,0,1-.586-.585L42.168,39.5,40.6,37.537a.934.934,0,0,1,.73-1.514h2.842a.933.933,0,0,1,.733,1.511l-.673.853a.586.586,0,0,1-.92-.726l.368-.466H41.829l1.383,1.74a.582.582,0,0,1,.127.363l.013,4.317a.586.586,0,0,1-.585.588Z" transform="translate(-24.803 -22.115)" fill="#011976"/>
              </g>
            </svg>

            <p>患者向け</p>
          </div>
        </li>
      </ul>
    </div>
  </div>

</main>

<?php get_footer(); ?>