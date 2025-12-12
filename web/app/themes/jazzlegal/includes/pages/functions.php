<?php
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die ( 'You do not have sufficient permissions to access this page' );
}

add_filter('page_template', 'page_single_template');
function page_single_template($template) {
	global $post;

	if(get_page_template_slug($post)) return $template;

	if ( file_exists( get_template_directory() . '/includes/pages/single.php' ) )
		return get_template_directory() . '/includes/pages/single.php';

	return $template;
}
