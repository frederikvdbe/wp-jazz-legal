<?php
// File Security Check
if (!empty($_SERVER['SCRIPT_FILENAME']) && basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    die ('You do not have sufficient permissions to access this page');
}

// Add options page
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> __('General settings', 'jazzlegal-back'),
        'menu_title'	=> __('General settings', 'jazzlegal-back'),
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));
}