<?php
// File Security Check
if (!empty($_SERVER['SCRIPT_FILENAME']) && basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    die ('You do not have sufficient permissions to access this page');
}

/*-----------------------------------------------------------------------------------*/
/* Selectively Hide WP Admin Menus */
/*-----------------------------------------------------------------------------------*/
add_action('admin_menu', 'custom_admin_remove_admin_menus');
function custom_admin_remove_admin_menus(){
    global $current_user;

    if ($current_user->ID != 1) {

        // Remove menu pages
//        remove_menu_page('edit.php');
        remove_menu_page('plugins.php');
        remove_menu_page('options-general.php');
        remove_menu_page('tools.php');
        remove_menu_page('edit.php?post_type=acf-field-group');
        remove_menu_page('edit-comments.php');
        remove_menu_page('themes.php');
        remove_menu_page('wpml-multi-lingual-cms');
        remove_submenu_page('themes.php', 'themes.php');
        remove_submenu_page('themes.php', 'customize.php');
        remove_submenu_page('themes.php', 'theme-editor.php');

        // Remove Plugin Update Nag
        remove_action('load-update-core.php', 'wp_update_plugins');
        add_filter('pre_site_transient_update_plugins', '__return_false');

    }

}


/*-----------------------------------------------------------------------------------*/
/* Selectively Hide WP Admin Bar Menu Items */
/*-----------------------------------------------------------------------------------*/
add_action('admin_bar_menu', 'custom_admin_remove_wp_nodes', 999);
function custom_admin_remove_wp_nodes(){

    global $wp_admin_bar;
    global $current_user;

    $wp_admin_bar->remove_menu('comments');

    if ($current_user->ID != 1) {
        $wp_admin_bar->remove_node('new-link');
    }
}


/*-----------------------------------------------------------------------------------*/
/* Update notifications */
/*-----------------------------------------------------------------------------------*/
// Remove WP Update nag
add_action('admin_menu', 'custom_admin_hide_nag');
function custom_admin_hide_nag(){
    global $current_user;

    if ($current_user->ID != 1) {
        remove_action('admin_notices', 'update_nag', 3);
    }
}

// Hide super admin is user list
add_action('pre_user_query', 'custom_admin_pre_user_query');
function custom_admin_pre_user_query($user_search){
    $user = wp_get_current_user();

    if ($user->ID != 1) {
        global $wpdb;
        $user_search->query_where = str_replace('WHERE 1=1',
            "WHERE 1=1 AND {$wpdb->users}.ID<>1", $user_search->query_where);
    }
}

/*-----------------------------------------------------------------------------------*/
/* Whitelableling */
/*-----------------------------------------------------------------------------------*/
add_action('admin_menu', 'custom_admin_new_nav_menu');
function custom_admin_new_nav_menu(){
    global $menu;
    global $current_user;

    if ($current_user->ID != 1) {
        add_menu_page('Nav Menu', 'Menu', 'manage_options', 'nav-menus.php', '', 'dashicons-menu', 24);
    }
}

add_action('wp_before_admin_bar_render', 'custom_admin_admin_bar_remove', 0);
function custom_admin_admin_bar_remove(){
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('updates');
    $wp_admin_bar->remove_menu('comments');
}

add_action( 'admin_bar_menu', 'custom_admin_remove_wp_logo', 999 );
function custom_admin_remove_wp_logo( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'customize' );
    $wp_admin_bar->remove_node( 'new' );
}

add_filter( 'admin_footer_text', 'custom_admin_footer' );
function custom_admin_footer(){
    echo '';
}

/*-----------------------------------------------------------------------------------*/
/* Disable support for comments and trackbacks in post types */
/*-----------------------------------------------------------------------------------*/
add_filter('comments_open', 'custom_admin_disable_comments_status', 20, 2);
add_filter('pings_open', 'custom_admin_disable_comments_status', 20, 2);
function custom_admin_disable_comments_status(){
    return false;
}

add_filter('comments_array', 'custom_admin_disable_comments_hide_existing_comments', 10, 2);
function custom_admin_disable_comments_hide_existing_comments($comments){
    $comments = array();
    return $comments;
}

add_action('admin_menu', 'custom_admin_disable_comments_admin_menu');
function custom_admin_disable_comments_admin_menu(){
    remove_menu_page('edit-comments.php');
}

// Redirect any user trying to access comments page
add_action('admin_init', 'custom_admin_disable_comments_admin_menu_redirect');
function custom_admin_disable_comments_admin_menu_redirect(){
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
}

// Remove comments metabox from dashboard
add_action('admin_init', 'custom_admin_disable_comments_dashboard');
function custom_admin_disable_comments_dashboard(){
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}

// Remove comments links from admin bar
add_action('init', 'custom_admin_disable_comments_admin_bar');
function custom_admin_disable_comments_admin_bar(){
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}

// Disable support for comments and trackbacks in post types
add_action('admin_init', function () {
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});


/*-----------------------------------------------------------------------------------*/
/* Empty dashboard */
/*-----------------------------------------------------------------------------------*/
add_action('wp_dashboard_setup', 'custom_admin_remove_dashboard_widgets');
function custom_admin_remove_dashboard_widgets(){
    global $wp_meta_boxes;

    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}


/*-----------------------------------------------------------------------------------*/
/* Admin menu structure */
/*-----------------------------------------------------------------------------------*/
// Hide ACF edit buttons for non-admins
add_action('admin_head', 'custom_admin_hide_acf_cog_icons');
function custom_admin_hide_acf_cog_icons(){
    global $current_user;
    if ($current_user->ID != 1) {

        echo '<style>
            .acf-hndle-cog,
            .acf-handle-cog{
                display: none !important;
            }
        </style>';

    }
}

add_filter( 'mce_buttons', 'add_the_table_button' );
function add_the_table_button( $buttons ) {
	array_push( $buttons, 'separator', 'table' );
	return $buttons;
}

add_filter( 'mce_external_plugins', 'add_the_table_plugin' );
function add_the_table_plugin( $plugins ) {
	$plugins['table'] = get_template_directory_uri() . '/assets/vendor/tinymce/plugins/table/plugin.min.js';
	return $plugins;
}

add_action('admin_head', 'add_the_table_plugin_options');
function add_the_table_plugin_options() {
	?>

	<script>
		window.addEventListener("load", function() {
			tinymce.settings.table_appearance_options = false;
			tinymce.settings.external_plugins.table.table_responsive_width = true;
			tinymce.settings.block_formats = 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6';
		});
	</script>

	<?php
}

add_filter('acf_the_content', function($content) {
	return str_replace(["<table", "</table>"], ["<div class='table-container'><table", "</table></div>"], $content);
});
