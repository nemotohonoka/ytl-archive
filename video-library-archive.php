<?php
/*
Template Name: 動画ライブラリ
*/
get_header();
?>

<main>
<section id="library-section-title">
  <h2>動画ライブラリ</h2>
</section>

<?php
$parents = [
    'parent01' => '疾患別',
    'parent02' => '医療制度',
    'parent03' => 'スキル研修',
    'parent04' => '情報提供資材'
];
?>

<div class="video-library-container">

    <!-- 親タブ -->
    <div class="video-library-tabs">
      <h3>動画を探す</h3>
      <div class="flex-box">
        <?php foreach($parents as $slug => $label): ?>
          <button class="tab-button" data-parent="<?php echo esc_attr($slug); ?>">
            <?php echo esc_html($label); ?>
          </button>
        <?php endforeach; ?>
      </div>
        
    </div>

    <!-- 子カテゴリー -->
    <div id="child-filters">
      
        <?php
          foreach($parents as $slug => $label){
            if($slug === 'parent03') continue; // 子なし

            $parent_term = get_term_by('slug', $slug, 'common_category');
            if($parent_term){
              $child_terms = get_terms([
                  'taxonomy' => 'common_category',
                  'hide_empty' => true,
                  'parent' => $parent_term->term_id
              ]);

              if(!empty($child_terms)){
                echo '<div class="inner">';
                echo '<div class="child-buttons" data-parent="'.$slug.'" style="display:none;">';
                echo '<button class="child-button" data-term="all">すべて</button>';
                foreach($child_terms as $term){
                  echo '<button class="child-button" data-term="'.$term->slug.'">'.$term->name.'</button>';
                }
                echo '</div>';
                echo '</div>';
              }
            }
          }
        ?>
    </div>

    <div class="container">
      <!-- 投稿表示 -->
      <div id="video-library-results"></div>
    </div>

    

</div>
</main>

<?php get_footer(); ?>