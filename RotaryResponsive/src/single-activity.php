<?php
/**
 * The Template for displaying all single activity posts.
 *
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
  
			<?php while ( have_posts() ) : the_post(); ?>
		

				<?php get_template_part( 'content-activity', 'single' ); ?>


			<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->


<?php get_footer(); ?>