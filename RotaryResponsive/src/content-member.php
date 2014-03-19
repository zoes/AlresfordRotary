<?php
/**
 * Template for retrieving content for member pages
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php show_the_member_content(); ?>
</article><!-- #post-<?php the_ID(); ?> -->

