<?php
/**
 * ACTIVITY POST TYPE
 * Functions for adding and displaying 'Activity' photographs and descriptions
 */

add_action('init', 'create_activities_post_type');
/**
 * Create activities post type
 */
function create_activities_post_type() {
	register_post_type( 'activity',
	array(
			'labels' => array(
					'name'=>__('Activities' ),
					'singular_name' => __( 'Activity' ),
					'add_new' => __( 'Add New'),
					'add_new_item' => __( 'Add New Activity'),
		            'edit' => __( 'Edit'),
		            'new_item' => __( 'New Activity'),
					'view' => __( 'View Activity'),
					'view_item' => __( 'View Activity'),
					'search_items' => __( 'Search Activities'),
					'not_found' => __( 'No Activities found'),
					'not_found_in_trash' => __( 'No Activities found in trash'),				
	),
			'public' => true,
	        'hierarchical' => true,
	        'has_archive' => true,
	        'taxonomies' => array('category'),
	        'rewrite' => array('slug'=>'activities'),
			'supports' => array(
					'title', 'page-attributes', 'thumbnail', 'editor', 'revisions', 'excerpt',
	        ),
	)
	);
}

add_action( 'add_meta_boxes', 'activity_metadata_add' );
/**
 * Add activity meta data
 */
function activity_metadata_add()
{
	add_meta_box( 'activity-meta-box-id', 'Activity data', 'activity_link_cb', 'activity', 'normal', 'high' );
}

/**
 * Code to display activity fields in the WP admin menu
 */
function activity_link_cb()
{
	global $post;
	$values = get_post_custom( $post->ID );

	wp_nonce_field( basename(__FILE__), 'activity_nonce' );
		
}

add_action( 'save_post', 'activity_metadata_save' );

/**
 * Save activity meta data
 */
function activity_metadata_save( $post_id )
{
	// Allow to put paragraph tags in the summary activity description
	
	$allowedtags = array(
	'p'=>array()
	);
	
	// Bail if doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// If nonce isn't there, or can't verify it, bail
	if( !isset( $_POST['activity_nonce'] ) || !wp_verify_nonce( $_POST['activity_nonce'], basename(__FILE__) ) ) return;

	// If current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	
}

/**
 * Single page activity display
 */
function show_the_activity_content() { ?>
<?php 
	$back =$_SERVER['HTTP_REFERER'];
	    if((isset($back) && $back != "" )) {
			echo '<span class="right" ><a href="'.$back.'">Back</a></span>';
		} ?>
<header class="entry-header heading-icon">
	<h1 class="page-title"><?php the_title(); ?></h1>
</header>
<!-- .entry-header -->


<div class="entry-content">
	<div class="row">
		<div class="col-940">
	    <?php 
	   
	    
	    echo get_the_post_thumbnail( $post_id, $size, $attr );
	    echo "<p>" .get_the_content(). "</p>";
	    
	    ?>
	    </div>

	</div>
	<!-- .entry-content -->
	<?php 	
}

/**
 * Summary activity display. Just the heading, photo and excerpt
 */
function show_the_activity_summary() {
	$i = 0;
	
	while ( have_posts () ) :
		the_post ();
		
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
		} 
		
		$i ++;
	endwhile;
}




