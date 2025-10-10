<?php /*
Template Name:新規会員登録フォーム
*/ ?>


<?php get_header(); ?>

<main>
	<section id="library-section-title">
    <h2>新規会員登録</h2>
  </section>

	<div class="container">

		<?php echo do_shortcode('[wpmem_form register]'); ?>

	</div>
		
	
</main>

<?php get_footer(); ?>