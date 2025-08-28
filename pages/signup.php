<?php /*
Template Name:新規会員登録フォーム
*/ ?>


<?php get_header(); ?>

<main>
	<section id="library-section-title">
    <h2>新規会員登録</h2>
  </section>

	<div class="container">
		<?php
		while ( have_posts() ) : the_post();
				the_content(); // ← これがないとWPFormsのショートコードも表示されない
		endwhile;
		?>

	</div>
		
	
</main>

<?php get_footer(); ?>