<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page' );
}

/*-----------------------------------------------------------------------------------*/
/* Register CPT
/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'custom_post_type_services' );
function custom_post_type_services() {

	$labels = array(
		'name' => __('Services', 'jazzlegal_back'),
		'singular_name' => __('Service', 'jazzlegal_back'),
		'all_items' => __( 'All services', 'jazzlegal_back' ),
		'add_new' => __('Add New', 'jazzlegal_back'), __('Service', 'jazzlegal_back'),
		'add_new_item' => __('Service', 'jazzlegal_back'),
		'edit_item' => __('Edit service', 'jazzlegal_back'),
		'new_item' => __('New service', 'jazzlegal_back'),
		'view_item' => __('View service', 'jazzlegal_back'),
		'search_items' => __('Search service', 'jazzlegal_back'),
		'not_found' =>  __('No service found', 'jazzlegal_back'),
		'not_found_in_trash' => __('No service found in Trash', 'jazzlegal_back'),
		'parent_item_colon' => ''
	);

	$supports = array(
		'title',
		'editor',
        'page-attributes'
	);
  
	register_post_type( 'service',
		array(
			'labels' => $labels,
			'public' => true,
			'menu_position' => 6,
			'hierarchical' => true,
			'publicly_queryable'  => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-portfolio',
			'supports' => $supports,
			'capability_type' => 'post'
		)
	);
	
}