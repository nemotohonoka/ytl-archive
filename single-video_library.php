<?php get_header(); ?>

<main>
  <section id="library-section-title">
    <h2>動画ライブラリ</h2>
  </section>

  <section id="post-contents">
    <div class="container">
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="title-box">
          <!-- タイトル -->
        <h3><?php the_title(); ?></h3>
    
        <?php
          // --- 子カテゴリーを取得して表示 ---
          $terms = get_the_terms(get_the_ID(), 'common_category');

          if ($terms && !is_wp_error($terms)) {
            $child_terms = [];
            foreach ($terms as $term) {
              if ($term->parent != 0) { // 子カテゴリーのみ
                // 親カテゴリー情報を取得
                $parent_term = get_term($term->parent, 'common_category');
                $parent_class = $parent_term ? 'p-' . esc_attr($parent_term->slug) : '';
                
                $child_terms[] = '<a class="' . $parent_class . '" href="' . get_term_link($term) . '">' . esc_html($term->name) . '</a>';
              }
            }

            if (!empty($child_terms)) {
              echo '<div class="child-categories">';
              echo implode(', ', $child_terms);
              echo '</div>';
            }
          }

          // --- タグを取得して表示 ---
          $tags = get_the_terms(get_the_ID(), 'common_tag');

          if ($tags && !is_wp_error($tags)) {
            $tag_list = [];
            foreach ($tags as $tag) {
              $tag_list[] = '<a href="' . get_term_link($tag) . '">' . esc_html($tag->name) . '</a>';
            }

            if (!empty($tag_list)) {
              echo '<div class="post-tags">';
              echo implode($tag_list); // リンク付きでカンマ区切り
              echo '</div>';
            }
          }
        ?>

        </div>
    
        <!-- サムネイル -->
        <?php if ( has_post_thumbnail() ) : ?>
          <div class="post-thumbnail"><?php the_post_thumbnail('large'); ?></div>
        <?php endif; ?>
    
        <!-- 本文 -->
        <div class="post-content">
          <?php the_content(); ?>
        </div>
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
            <div class="login-button">
              <a href="<?php echo wp_login_url(get_permalink()); ?>" class="btn">ログインはこちら</a>
            </div>
          </div>
        <?php endif; ?>
    
      </article>
    </div>
  </section>

</main>

<?php get_footer(); ?>