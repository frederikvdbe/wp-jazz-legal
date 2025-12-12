<?php

/*-----------------------------------------------------------------------------------*/
/* Remove Header Links */
/*-----------------------------------------------------------------------------------*/
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_head', 'rest_output_link_wp_head', 10, 0);
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
add_filter('wp_resource_hints', function ($urls, $relation) {
	if ($relation !== 'dns-prefetch') return $urls;
	$urls = array_filter($urls, function ($url) {
		return strpos($url, 's.w.org') === false;
	});
	return ['fonts.googleapis.com'];
}, 0, 2);
add_action('wp_print_styles', function (): void {
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
});
remove_action('rest_api_init', 'wp_oembed_register_route');
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_oembed_add_host_js');


/*-----------------------------------------------------------------------------------*/
/* Theme Settings */
/*-----------------------------------------------------------------------------------*/
// Disable admin-bar
//add_filter('show_admin_bar', '__return_false');

// disable Gutenberg
add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);

// Post Thumbnail Init
add_theme_support('post-thumbnails');

// Disable responsive images
add_filter('wp_calculate_image_srcset_meta', '__return_null');

// Disable Author Pages
function theme_disable_author_archives()
{
	if (is_author()) {
		global $wp_query;
		$wp_query->set_404();
		status_header(404);
		wp_safe_redirect(get_bloginfo('url'), '301');
	} else {
		redirect_canonical();
	}
}

remove_filter('template_redirect', 'redirect_canonical');
add_action('template_redirect', 'theme_disable_author_archives');

// ACF Google Map API Key
// function theme_acf_init() {
//     acf_update_setting('google_api_key', GOOGLE_API);
// }
// add_action('acf/init', 'theme_acf_init');

// Add favicon
function theme_add_favicon()
{ ?>
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<meta name="msapplication-TileColor" content="#324B50">
	<meta name="theme-color" content="#ffffff">
<?php }

add_action('wp_head', 'theme_add_favicon');

// Redirect WordPress Logout to Home Page
add_action('wp_logout', function () {
	wp_redirect(home_url());
	exit();
});

function create_picture_element()
{
	echo '<script>document.createElement( "picture" );</script>';
}

add_action('wp_head', 'create_picture_element');

/*-----------------------------------------------------------------------------------*/
/* Project Enqueues */
/*-----------------------------------------------------------------------------------*/

// Script attributes
add_filter('script_loader_tag', 'add_attribs_to_scripts', 10, 3);
function add_attribs_to_scripts($tag, $handle, $src)
{

	// The handles of the enqueued scripts we want to defer
	$async_scripts = array();

	$defer_scripts = array();

	$crossorigin_scripts = array(
		'font-awesome',
	);

	if (in_array($handle, $defer_scripts)) {
		return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
	}
	if (in_array($handle, $async_scripts)) {
		return '<script src="' . $src . '" async="async" type="text/javascript"></script>' . "\n";
	}
	if (in_array($handle, $crossorigin_scripts)) {
		return '<script src="' . $src . '" crossorigin="anonymous"></script>' . "\n";
	}
	return $tag;
}

// Disable auto enqueue styles and scripts for WPCF7
if (class_exists('WPCF7')) {
	add_filter('wpcf7_load_js', '__return_false');
	add_filter('wpcf7_load_css', '__return_false');
}


add_action('wp_enqueue_scripts', 'custom_enqueue_scripts');
function custom_enqueue_scripts()
{
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$ver = '1.0.18';

	// Dequeue plugins scripts
	wp_dequeue_style('cookie-notice-front');

	// Custom fonts
	wp_enqueue_style('fonts', 'https://use.typekit.net/dwm5vgc.css');
	wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/2e2e8bdf8b.js', false, null, false);

	// jQuery
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/build/js/vendor/jquery.js', false, 0.1, false);

	// AnimeJs
	wp_enqueue_script('anime', get_template_directory_uri() . '/assets/build/js/vendor/anime.min.js', false, 0.1, true);

	// JS data
	//	wp_localize_script('scripts', 'jazzlegal', array(
	//		'template_dir' => get_template_directory_uri(),
	//		'ajax_url' => admin_url('admin-ajax.php')
	//	));

	if (WP_DEBUG && WP_DEBUG == true) {

		// Picturefill
		wp_enqueue_script('picturefill', get_template_directory_uri() . '/assets/build/js/vendor/picturefill.js', false, 0.1, true);

		// Images loaded
		wp_enqueue_script('imagesloaded', get_template_directory_uri() . '/assets/build/js/vendor/imagesloaded.pkgd.js', false, 0.1, true);

		// Select2
		wp_enqueue_script('select2', get_template_directory_uri() . '/assets/build/js/vendor/select2.js', false, 0.1, true);
		wp_enqueue_style('select2', get_template_directory_uri() . '/assets/build/css/vendor/select2.css', '', 0.1, 'all');

		// Swiper
		wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/build/js/vendor/swiper-bundle.js', false, 0.1, true);
		wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/build/css/vendor/swiper-bundle.css', '', 0.1, 'all');

		if (is_page_template('page-templates/contact.php')) {
			wp_enqueue_script('jquery-migrate', 'https://code.jquery.com/jquery-migrate-3.0.1.min.js', array('jquery'), '3.0.1', false);
			gravity_form_enqueue_scripts(1, true);
		}

		if (is_singular('service')) {
			gravity_form_enqueue_scripts(3, true);
			wp_enqueue_script('jquery-migrate', 'https://code.jquery.com/jquery-migrate-3.0.1.min.js', array('jquery'), '3.0.1', false);
		}

		// Tooltipster
		wp_enqueue_script('tooltipster', get_template_directory_uri() . '/assets/build/js/vendor/tooltipster.bundle.js', false, 0.1, true);
		wp_enqueue_style('tooltipster', get_template_directory_uri() . '/assets/build/css/vendor/tooltipster.bundle.css', '', 0.1, 'all');

		// jQuery scrollTo
		wp_enqueue_script('scrollto', get_template_directory_uri() . '/assets/build/js/vendor/jquery.scrollTo.js', false, 0.1, true);

		// Cookie consent
		wp_enqueue_style('cookie-consent', get_template_directory_uri() . '/assets/build/css/vendor/cookieconsent.css', '', 0.1, 'all');
		wp_enqueue_script('cookie-consent', get_template_directory_uri() . '/assets/build/js/vendor/cookieconsent.js', array(), 0.1, true);
		wp_enqueue_script('cookie-consent-init', get_template_directory_uri() . '/assets/src/js/cookie-consent.js', array(), 0.1, true);

		// Custom JS
		wp_enqueue_script('responsive-background-images', get_template_directory_uri() . '/assets/src/js/responsive-background-images.js', array('jquery'), 0.1, true);
		wp_enqueue_script('tabs', get_template_directory_uri() . '/assets/src/js/tabs.js', array('jquery'), 0.1, true);
		wp_enqueue_script('gravityforms', get_template_directory_uri() . '/assets/src/js/gravityforms.js', array('jquery'), 0.1, true);

		wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/src/js/scripts.js', array('jquery'), 0.1, true);

		// Custom CSS
		wp_enqueue_style('styles', get_template_directory_uri() . '/assets/build/css/main.css', '', 0.1, 'all');
	} else {

		// Custom CSS
		wp_enqueue_style('styles', get_template_directory_uri() . '/assets/build/css/styles.min.css', '', $ver, 'all');

		// Custom JS
		wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/build/js/scripts.min.js', false, $ver, true);
	}
}


/*-----------------------------------------------------------------------------------*/
/* Image Sizes */
/*-----------------------------------------------------------------------------------*/
// update_option('thumbnail_size_w', 360);
// update_option('thumbnail_size_h', 220);
// update_option('thumbnail_crop', 1);
update_option('medium_size_w', 510);
update_option('medium_size_h', 330);
update_option('medium_crop', 1);
update_option('large_size_w', 680);
update_option('large_size_h', 440);
update_option('large_crop', 1);

add_image_size('hero-medium', 560, 340, true);
add_image_size('hero-medium-tablet', 860, 460, true);
add_image_size('hero-medium-desktop', 1480, 620, true);
add_image_size('client_logo', 340, null, true);

add_image_size('contact_mobile', 440, 745, true);
add_image_size('contact_desktop', 660, 1120, true);


/*-----------------------------------------------------------------------------------*/
/* Google Maps JS */
/*-----------------------------------------------------------------------------------*/
function google_map()
{

	if (is_page_template('page-templates/contact.php')) {
		echo '
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaHoW0QwoQLbcaBNk8XtEWdqkn5_3LPk4&sensor=false"></script>
<script type="text/javascript">
function gmaps_init() {

    var latlng = new google.maps.LatLng(50.93700536198188, 4.02664631196082);

    var styles = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#e6f4f1"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"on"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#b9e2d9"},{"visibility":"on"}]}];

    var myOptions = {
        scrollwheel: false,
        navigationControl: true,
        mapTypeControl: true,
        scaleControl: true,
        draggable: true,
        zoom: 17,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: false,
        styles: styles
    };

    var map = new google.maps.Map(document.getElementById("map"), myOptions);

    var icon = {
        url: "' . get_template_directory_uri() . '/assets/build/images/marker@2x.png",
        size: new google.maps.Size(120, 150),
        scaledSize: new google.maps.Size(60, 75),
        anchor: new google.maps.Point(60, 75),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(30, 75)
    };

    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        icon: icon
    });
}

google.maps.event.addDomListener(window, "load", gmaps_init);

</script>

';
	}
}

add_action('wp_head', 'google_map');


/*-----------------------------------------------------------------------------------*/
/* Custom body classes */
/*-----------------------------------------------------------------------------------*/
add_filter('body_class', 'custom_body_classes', 20, 2);
function custom_body_classes($classes, $class)
{
	global $post;
	$classes = array();
	$template_slug = get_page_template_slug();
	$queried_object = get_queried_object();

	$classes[] = 'lang-' . apply_filters( 'wpml_current_language', null );

	// Automatic tpl classes
	if ($template_slug)
		$classes[] = 'tpl-' . basename(explode('/', $template_slug)[1], '.php');

	if (is_single())
		$classes[] = 'sgl-' . $queried_object->post_type;

	if (is_singular('page') && !$template_slug)
		$classes[] = 'sgl-page';

	if (is_singular('post')) {
		$blocks = get_field('post_content_blocks', $post->ID);

		if(!empty($blocks['content_blocks'])){
			$classes[] = 'post--content-blocks';
		}
	}

	// Overwrites and special body classes
	if (is_tax('project_categories')) {
		$classes[] = 'term-' . $queried_object->slug;
		$classes[] = 'tpl-projects';
	}

	if (is_singular('faq')) {
		$classes[] = 'tpl-faq';
	}

	return $classes;
}


function mailtrap($phpmailer) {

	if (WP_ENV == 'development') {
		$phpmailer->isSMTP();
		$phpmailer->Host = 'smtp.mailtrap.io';
		$phpmailer->SMTPAuth = true;
		$phpmailer->Port = 2525;
		$phpmailer->Username = '8a0793c8d4800e';
		$phpmailer->Password = '6705d46b8bd82c';
	}
}

add_action('phpmailer_init', 'mailtrap');

//add_filter('media_send_to_editor', 'inserted_image_div', 10, 3 );
//function inserted_image_div( $html, $send_id, $attachment ) {
//	return '<div class="card">'.$html.'</div>';
//}


/*-----------------------------------------------------------------------------------*/
/* Includes */
/*-----------------------------------------------------------------------------------*/
require_once('plugins/gravityforms.php');
require_once('plugins/acf.php');

require_once('includes/helpers.php');
require_once('includes/nav.php');
require_once('includes/custom-admin.php');
require_once('includes/multilang.php');
require_once('includes/disable-pingback.php');

require_once('includes/services/cpt.php');
require_once('includes/services/functions.php');

require_once('includes/pages/functions.php');

require_once('includes/posts/functions.php');
?>
