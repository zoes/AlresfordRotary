<?php
/**
 * The template for displaying activity archive pages. 
 * This generates the top level activity summary page.
 *
 */
get_header(); ?>

		<section id="primary">
			<div id="content" role="main">        					
			<header class="page-header">
					<h1 class="page-title"><?php post_type_archive_title(); ?>					
					</h1>
			</header>
			<div id="archive-summary"><?php echo category_description( get_cat_ID( 'activity' ) ); ?> </div>
	     <?php if (have_posts() ) :
								
			show_the_activity_summary();
	
			 else : ?>

				<article id="post-0" class="post no-results not-found">

					<div class="entry-content">
						<p><?php echo "No activities found"; ?></p>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>