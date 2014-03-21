<?php
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'member_functions.php');
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'activity_functions.php');

/**
 * Ordering the retrieval of 'Member' post types
 * @param unknown $query
 */
function member_query( $query ) {
	if( $query->is_main_query() && is_post_type_archive( 'member' ) ) {	
		$query->set( 'meta_key', 'lastname' );
		$query->set( 'orderby', 'meta_value' );		
		$query->set( 'order', 'ASC' );
		
	}
	if(is_post_type_archive( 'member' )) {
		$query->set( 'posts_per_page', 50 );
	}

}
add_action( 'pre_get_posts', 'member_query' );

/**
 * Ordering the retrieval of 'Activity' post types
 * @param unknown $query
 */
function activity_query( $query ) {
	if( $query->is_main_query() &&( is_post_type_archive( 'activity' ) || is_front_page())) {
		$query->set( 'orderby', 'modified' );
		$query->set( 'order', 'DESC' );

	}
	if(is_post_type_archive( 'activity' )) {
		$query->set( 'posts_per_page', 50 );
	}

}
add_action( 'pre_get_posts', 'activity_query' );

/**
 * Set the excerpt length used by the site to be 20 words (default is 55)
 * @param unknown $length
 * @return number
 */
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Remove 'Posts' and 'Comments' from the dashboard - avoids confusion as these are not used.
 */
function remove_menus () {
	global $menu;
	$restricted = array(__('Posts'), __('Comments'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');

/**
 * Function of display a text input box in custom post types
 * @param unknown $values
 * @param unknown $title
 * @param unknown $text
 * @param unknown $id
 */
function zaptpi_add_string($values, $title, $text, $id){
    $dd = isset( $values[$id] ) ? esc_attr( $values[$id][0] ) : false; ?>
<p>
		<label for=<?php echo $id ?>><b><?php echo $title?></b></label>
	</p>
	<p style="color: #7a7a7a"><?php echo $text ?></p>
	<p>
		<input type="text" name=<?php echo $id ?> id=<?php echo $id ?>
			value="<?php echo $dd; ?>" size=50 />
	</p>
	<br>
    <?php
     
}
/**
 * Function for saving a string in a custom post type
 * @param unknown $post_id
 * @param unknown $id
 */
function zaptpi_save_string($post_id, $id) {
	if( isset( $_POST[$id] ) ) {
		update_post_meta( $post_id, $id, $_POST[$id] );
	}
}
?>