<?php

/**
 * Overrides the 3 widget boxes on the front page of Responsive with the three most recently modified activities
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}
//Get the last three activities
$args = array(
		'post_type' => 'activity',
		'orderby' => 'modified',
		'order' => 'DESC',
		'showposts' => 3
);

$the_query = new WP_Query( $args );

// The Loop
$i=0;
if ( $the_query->have_posts() ) {
        
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		if (($i + 1) % 3) {
			echo '<div class="grid col-300">';
		} else {
			echo '<div class="grid col-300 fit">';
		}
		echo '<div class="widget-wrapper">';
		
		echo get_the_post_thumbnail ( $post_id, $size, $attr );
		echo '<div id="link-container"><h4><a href="' . get_permalink ( $post_id ) . '">' . get_the_title ( $post_id ) . '</a></h4></div>';
		echo "<p>" .get_the_excerpt(). "</p>";
		echo '</div>';
		echo '</div>';
		
		if ((($i + 1) % 3) == 0) {
			echo '<div id="linebreak"></div>';
			echo '<div id="charity-number">Charity number 101447</div>';
		}
		$i++;				
	}
        
} else {
	// no posts found
}
/* Restore original Post Data */
wp_reset_postdata();

