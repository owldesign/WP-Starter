<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<!-- article -->
			<article id="post-404">

				<h1><?php _e('Page not found', $textdomain); ?></h1>
				<h2>
					<a href="<?php echo home_url(); ?>"><?php _e('Return home?', $textdomain); ?></a>
				</h2>

			</article>
			<!-- /article -->

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
