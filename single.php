<?php get_header(); ?>

<main>	
  <section id="library-section-title">
    <h2>お知らせ</h2>
  </section>

<div class="container">
		
		
		<?php if(have_posts()): ?>
		<ul class="breadcrumb">
			<li><a href="<?php echo home_url(); ?>/news/">ニュース一覧</a></li>
			<li class="title"><?php the_title(); ?></li>
		</ul>
		
	  <?php while(have_posts()):the_post(); ?>
		<?php
			$cat = get_the_category();
			$cat = $cat[0];
		?>
		
		<div class="flexbox">
			
			
			
			<article>
				<div class="top">
					<div class="information">
						<time><?php the_time("Y年n月j日"); ?></time>
						<span class="label <?php echo $cat->category_nicename; ?>"><?php echo $cat->cat_name; ?></span>
					</div>
					<h3><?php the_title(); ?></h3>
				</div>
				<div class="contents">
					<?php the_content(); ?>
				</div>
	
				<ul class="button_area">
  					<?php if (get_previous_post()):?>
  						<li class="prev"><?php previous_post_link('%link', '前の記事'); ?></li>
  					<?php endif; ?>
  
  
  					<?php if (get_next_post()):?>
  						<li class="next"><?php next_post_link('%link', '次の記事'); ?></li>
  					<?php endif; ?>
  
  				</ul>
			</article>
		  <?php endwhile;endif; ?>

			<div class="sideber">
				<?php
					$the_query = new WP_Query(
						array(
							'post_type' => 'post',
							'posts_per_page' => 5
						)
					);
				?>
				<?php if($the_query->have_posts()): ?>
				<!-- <section class="latest">
					<h3>最近のニュース</h3>
					<ul class="article_list">
						<?php while($the_query->have_posts()):$the_query->the_post(); ?>
						<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
						<?php endwhile; ?>
					</ul>
				</section> -->
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
				
				<section class="archive">
					<h3>ARCHIVE</h3>
					<ul>
						<?php wp_get_archives(); ?>
					</ul>
				</section>
			</div>			
		</div>
	</div>

</main>

<?php get_footer(); ?>