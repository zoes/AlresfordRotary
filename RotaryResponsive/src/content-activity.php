<?php
/**
 * Template for retrieving content for activity pages
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php show_the_activity_content(); ?>
</article><!-- #post-<?php the_ID(); ?> -->

