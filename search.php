<?php
/*
Template Name: 検索結果
*/
get_header();
?>

<main>
<section id="library-section-title">
  <h2>キーワード検索</h2>
</section>

<div class="container">
  <div class="tag-archive">
    <div class="keyword">
      <small>キーワード</small>
      <h3><?php echo esc_html(get_search_query()); ?></h3>
    </div>

    <div class="flex-box">
      <?php
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

        $args = [
            'post_type'      => ['video_library', 'material'], // カスタム投稿だけ
            's'              => get_search_query(),
            'posts_per_page' => 10,
            'paged'          => $paged,
        ];

        $query = new WP_Query($args);

          if ($query->have_posts()) :
          while ($query->have_posts()) : $query->the_post(); ?>
          
          <div class="background">
            <a href="<?php the_permalink(); ?>" class="contents-box-link">
              <div class="contents-box">
                <div class="thumbnail">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('medium'); ?>
                  <?php endif; ?>
                </div>

                <div class="text-box">
                  <p class="slide-title"><?php echo esc_html(mb_strimwidth(get_the_title(), 0, 40, '…', 'UTF-8')); ?></p>
                  <p class="slide-excerpt"><?php echo esc_html(mb_strimwidth(get_the_excerpt(), 0, 100, '…', 'UTF-8')); ?></p>

                  <?php
                    // 子カテゴリー・タグの出力はそのまま
                  ?>
                </div>
              </div>
            </a>
          </div>
        <?php
        endwhile;
    else :
        echo '<p>該当する投稿は見つかりませんでした。</p>';
    endif;
    wp_reset_postdata();
    ?>
</div>

<!-- ページネーション -->
<div class="pagination">
<?php
echo paginate_links([
    'total'   => $query->max_num_pages,
    'current' => $paged,
]);
?>
</div>

  </div>
</div>

</main>

<?php get_footer(); ?>