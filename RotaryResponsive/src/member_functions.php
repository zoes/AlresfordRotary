<?php
/**
 * MEMBER POST TYPE
 * Functions for adding and displaying 'Member' photographs and biographies
 */
add_action('init', 'create_members_post_type');
/**
 * Create members post type
 */
function create_members_post_type() {
	register_post_type( 'member',
	array(
			'labels' => array(
					'name'=>__('Members' ),
					'singular_name' => __( 'Member' ),
					'add_new' => __( 'Add New'),
					'add_new_item' => __( 'Add New Member'),
		            'edit' => __( 'Edit'),
		            'new_item' => __( 'New Member'),
					'view' => __( 'View Member'),
					'view_item' => __( 'View Member'),
					'search_items' => __( 'Search Members'),
					'not_found' => __( 'No Members found'),
					'not_found_in_trash' => __( 'No Members found in trash'),				
	),
			'public' => true,
	        'hierarchical' => true,
	        'has_archive' => true,
	        'taxonomies' => array('category'),
	        'rewrite' => array('slug'=>'members'),
			'supports' => array(
					'title', 'page-attributes', 'thumbnail', 'editor', 'revisions', 'excerpt'
	        ),
	)
	);
}

add_action( 'add_meta_boxes', 'member_metadata_add' );
/**
 * Add member meta data
 */
function member_metadata_add()
{
	add_meta_box( 'member-meta-box-id', 'Member data', 'member_link_cb', 'member', 'normal', 'high' );
}

/**
 * Code to display member fields in the WP admin menu
 */
function member_link_cb()
{
	global $post;
	$values = get_post_custom( $post->ID );

	wp_nonce_field( basename(__FILE__), 'member_nonce' );
	
	zaptpi_add_string($values, 'Role', 'Enter the member\'s current role in Rotary', 'role');
	zaptpi_add_string($values, 'Last name', 'Enter the member\'s last name. This is just used for ordering the images', 'lastname');
		
}

add_action( 'save_post', 'member_metadata_save' );
/**
 * Save member meta data
 */
function member_metadata_save( $post_id )
{
	// Allow to put paragraph tags in the summary member description
	
	$allowedtags = array(
	'p'=>array()
	);
	
	// Bail if doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// If nonce isn't there, or can't verify it, bail
	if( !isset( $_POST['member_nonce'] ) || !wp_verify_nonce( $_POST['member_nonce'], basename(__FILE__) ) ) return;

	// If current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;

	
	zaptpi_save_string($post_id, 'role');
	zaptpi_save_string($post_id, 'lastname');	
	
}
/**
 * Display the 'Member' information on a single page
 */
function show_the_member_content() { ?>
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
	    $role = get_post_meta(get_the_id(), 'role', true);
	    
	    echo "<h3>$role<br></h3>";
	    echo "<p>" .get_the_content(). "</p>";
	    
	    ?>
	    </div>

	</div>
	<!-- .entry-content -->
	<?php 	
}
/**
 * Display 'Member' summary (just the photo and name)
 */
function show_the_member_summary() {
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
		echo '</div>';
		echo '</div>';
		
		if ((($i + 1) % 3) == 0) {
			echo '<div id="linebreak"></div>';
		} 
		
		$i ++;
	endwhile;
}




