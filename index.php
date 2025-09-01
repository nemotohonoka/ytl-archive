<?php get_header(); ?>

<main>
  <section id="library-section-title">
    <h2>お知らせ</h2>
  </section>

  <div class="container">
    <?php if(have_posts()): ?>
  		<ul class="article_list">
  			<?php while(have_posts()):the_post(); ?>
  			<?php
  				$cat = get_the_category();
  				$cat = $cat[0];
  			?>
  			
  			<li>
  				<a href="<?php the_permalink(); ?>">
  					<!-- <figure>
  						<?php if (has_post_thumbnail()) : ?>
  							<?php echo get_thumb_img('thumbnail'); ?>
  						<?php else : ?>
  							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/no_image.jpg" alt="アスベスト患者と家族の会 連絡会">
  						<?php endif ; ?>	              
  					</figure> -->
  					<section>
  						<div class="label <?php echo $cat->category_nicename; ?>"><?php echo $cat->cat_name; ?></div>
  						<?php if (in_category('system')):?>
  							<span class="sub-category">
  								<?php $cats = get_the_category();
  								foreach($cats as $cat):
  								if($cat->parent)
  								echo $cat->cat_name;
  								endforeach;
  								?>
  							</span>
  						<?php endif; ?>
  						<?php if (in_category('medical')):?>
  							<span class="sub-category">
  								<?php $cats = get_the_category();
  								foreach($cats as $cat):
  								if($cat->parent)
  								echo $cat->cat_name;
  								endforeach;
  								?>
  							</span>
  						<?php endif; ?>
  
  						<time><?php the_time("Y.m.d"); ?></time>
  						<h3><?php the_title(); ?></h3>
  						<?php the_excerpt(); ?>
  						<span class="readmore">続きを読む</span>
  					</section>
  				</a>
  			</li>
  			<?php endwhile; ?>
  		</ul>
    <?php endif; ?>
  		
    <?php do_shortcode('[pagination]') ?>
  </div>

</main>
	  
<?php get_footer(); ?>