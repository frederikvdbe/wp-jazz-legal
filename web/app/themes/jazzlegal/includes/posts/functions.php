<?php
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page' );
}

add_filter('single_template', 'post_single_template');
function post_single_template($template) {
    global $post;

    if ( $post->post_type == 'post' )
        if ( file_exists( get_template_directory() . '/includes/posts/single.php' ) )
            return get_template_directory() . '/includes/posts/single.php';

    return $template;
}