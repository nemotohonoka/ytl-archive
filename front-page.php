<?php get_header(); ?>
<main>
  <section id="welcome">
		<div class="inner">
			<div class="text-box">
        <div class="txt top">
          <p>人</p>
          <p>材</p>
          <p>育</p>
          <p>成</p>
          <p>に</p>
          <p>も</p>
        </div>

        <div class="txt bottom">
          <p>最</p>
          <p>先</p>
          <p>端</p>
          <p>技</p>
          <p>術</p>
          <p>を</p>
          <p>。</p>
        </div>
      </div>
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

  <section id="contents">
    <div class="inner">
      <div class="contents-box contents-medical">
        <div class="section-title">
            <h3>
                <figure>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contentsname_01.png" alt="疾患別コンテンツ">
                </figure>
                <small>Medical Category</small>
            </h3>
        </div>

        <div class="posts">
          <?php
            $parent_term = get_term_by('slug', 'parent01', 'common_category');

            if ($parent_term) {
              $query = new WP_Query([
                'post_type' => ['video_library','web_seminar','material'],
                'posts_per_page' => 5,
                'tax_query' => [
                  [
                    'taxonomy' => 'common_category',
                    'field' => 'term_id',
                    'terms' => $parent_term->term_id,
                    'include_children' => true,
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
                                echo mb_strimwidth($title, 0, 40, '…', 'UTF-8'); // 40バイトに調整
                                ?>
                              </p>
  
                              <p class="slide-excerpt">
                                <?php 
                                $excerpt = get_the_excerpt(); 
                                echo mb_strimwidth($excerpt, 0, 100, '…', 'UTF-8'); // 40バイトに調整
                                ?>
                              </p>
  
                              <p class="slide-taxonomy parent01-color">
                                <?php
                                // 投稿に紐づく common_category タクソノミーのタームを取得
                                $terms = get_the_terms(get_the_ID(), 'common_category');
  
                                if ($terms && !is_wp_error($terms)) {
  
                                    $child_terms = [];
  
                                    foreach ($terms as $term) {
                                        // 親が parent01 のタームだけ取得
                                        if ($term->parent == $parent_term->term_id) {
                                            $child_terms[] = $term->name; // 子カテゴリー名を配列に追加
                                        }
                                    }
  
                                    if (!empty($child_terms)) {
                                        // タグ風に出力
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
              echo '<p>「parent01」カテゴリーが存在しません。</p>';
            }
          ?>
        </div>

        <div class="default-button">
          <a href="<?php echo home_url(); ?>/medical/" class="button-more"><span>もっと見る</span></a>
        </div>
      </div>

      <div class="contents-box contents-healthcare">
        <div class="section-title">
          <h3>
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contentsname_02.png" alt="疾患別コンテンツ">
            </figure>
            <small>Healthcare System</small>
          </h3>
        </div>

        <div class="posts">
          <?php
            $parent_term = get_term_by('slug', 'parent02', 'common_category');

            if ($parent_term) {
              $query = new WP_Query([
                'post_type' => ['video_library','web_seminar','material'],
                'posts_per_page' => 5,
                'tax_query' => [
                  [
                    'taxonomy' => 'common_category',
                    'field' => 'term_id',
                    'terms' => $parent_term->term_id,
                    'include_children' => true,
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
                                echo mb_strimwidth($title, 0, 40, '…', 'UTF-8'); // 40バイトに調整
                                ?>
                              </p>
  
                              <p class="slide-excerpt">
                                <?php 
                                $excerpt = get_the_excerpt(); 
                                echo mb_strimwidth($excerpt, 0, 100, '…', 'UTF-8'); // 40バイトに調整
                                ?>
                              </p>
  
                              <p class="slide-taxonomy parent02-color">
                                <?php
                                // 投稿に紐づく common_category タクソノミーのタームを取得
                                $terms = get_the_terms(get_the_ID(), 'common_category');
  
                                if ($terms && !is_wp_error($terms)) {
  
                                    $child_terms = [];
  
                                    foreach ($terms as $term) {
                                        // 親が parent02 のタームだけ取得
                                        if ($term->parent == $parent_term->term_id) {
                                            $child_terms[] = $term->name; // 子カテゴリー名を配列に追加
                                        }
                                    }
  
                                    if (!empty($child_terms)) {
                                        // タグ風に出力
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
              echo '<p>「parent02」カテゴリーが存在しません。</p>';
            }
          ?>
        </div>
        
        <div class="default-button">
          <a href="<?php echo home_url(); ?>/healthcare/" class="button-more"><span>もっと見る</span></a>
        </div>
      </div>

      <div class="contents-box contents-skill">
        <div class="section-title">
          <h3>
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contentsname_03.png" alt="疾患別コンテンツ">
            </figure>
            <small>Skill Training</small>
          </h3>
        </div>

        <div class="posts">
          <?php
            $parent_term = get_term_by('slug', 'parent03', 'common_category');

            if ($parent_term) {
              $query = new WP_Query([
                'post_type' => ['video_library','web_seminar','material'],
                'posts_per_page' => 5,
                'tax_query' => [
                  [
                    'taxonomy' => 'common_category',
                    'field' => 'term_id',
                    'terms' => $parent_term->term_id,
                    'include_children' => true,
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
                                echo mb_strimwidth($title, 0, 40, '…', 'UTF-8'); // 40バイトに調整
                                ?>
                              </p>
  
                              <p class="slide-excerpt">
                                <?php 
                                $excerpt = get_the_excerpt(); 
                                echo mb_strimwidth($excerpt, 0, 100, '…', 'UTF-8'); // 40バイトに調整
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
              echo '<p>「parent03」カテゴリーが存在しません。</p>';
            }
          ?>
        </div>
        
        <div class="default-button">
          <a href="<?php echo home_url(); ?>/skill/" class="button-more"><span>もっと見る</span></a>
        </div>
      </div>
    </div>
  </section>

  <section id="news">

		<div class="container">
			<div class="flex-box">
				<div class="text-box">
					<h3>
            <figure>
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news_title.png" alt="YTL">
            </figure>
            <span>お知らせ</span>
          </h3>

					<div class="default-button pc-view">
            <a href="<?php echo home_url(); ?>/news/" class="button-more"><span>もっと見る</span></a>
          </div>
				</div>

				<div class="news-box">
					<?php
						$the_query = new WP_Query(
							array(
								'posts_per_page' => 3
							)
						);
					?>
					
					<?php if($the_query->have_posts()): ?>
					
						
					<ul class="news-list">
						<?php while($the_query->have_posts()):$the_query->the_post(); ?>
						
						<?php
							$cat = get_the_category();
							$cat = $cat[0];
						?>
						<li>
							<a href="<?php the_permalink(); ?>">
								<date><?php the_time("Y.m.d"); ?></date>
								<!-- <span class="label <?php echo $cat->category_nicename; ?>"><?php echo $cat->cat_name; ?></span> -->
								<span class="text">
									<?php
									if(mb_strlen($post->post_title, 'UTF-8')>20){
										$title= mb_substr($post->post_title, 0, 26, 'UTF-8');
										echo $title.'…';
									}else{
										echo $post->post_title;
									}
									?>				    
								</span>
							</a>
						</li>
						<?php endwhile; ?>
					</ul>
					<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				</div>

        <div class="default-button sp-view">
          <a href="<?php echo home_url(); ?>/news/" class="button-more"><span>もっと見る</span></a>
        </div>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>