<?php
// File Security Check
if (!empty($_SERVER['SCRIPT_FILENAME']) && basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
	die('You do not have sufficient permissions to access this page');
}

/*-----------------------------------------------------------------------------------*/
/* Nav Menus */
/*-----------------------------------------------------------------------------------*/
add_action('init', 'register_menus');
function register_menus()
{
	register_nav_menus(
		array(
			'site-nav' => __('Site Navigation', 'jazzlegal_back'),
			'footer-nav' => __('Footer Navigation', 'jazzlegal_back')
		)
	);
}

/*-----------------------------------------------------------------------------------*/
/* Custom Current Menu Conditions */
/*-----------------------------------------------------------------------------------*/
function remove_parent_classes($class)
{
	return ($class == 'current_page_item' || $class == 'current_page_parent' || $class == 'current_page_ancestor'  || $class == 'current-menu-item') ? FALSE : TRUE;
}

add_filter('nav_menu_css_class', 'special_nav_class', 10, 3);
function special_nav_class($classes, $item, $args)
{

	if ('site-nav' == $args->theme_location) {
		if (is_singular('post') || is_archive('post')) {
			$classes = array_filter($classes, "remove_parent_classes");
			if ($item->ID == 30) {
				$classes[] = 'current-menu-item';
			}
		}
	}

	return $classes;
}


/*-----------------------------------------------------------------------------------*/
/* Add custom menu items */
/*-----------------------------------------------------------------------------------*/
add_filter('wp_nav_menu_items', 'add_static_menu_items', 10, 2);
function add_static_menu_items($items, $args)
{
	if ($args->theme_location == 'site-nav') {
		$items .= '<li class="menu-socials">';
		$items .= '<a href="https://www.facebook.com/jazz.legal/" target="_blank"><i class="fab fa-facebook-square"></i></a>';
		$items .= '<a href="https://twitter.com/JazzLegal" target="_blank"><i class="fab fa-twitter-square"></i></a>';
		$items .= '<a href="http://www.linkedin.com/company/jazz-legal" target="_blank"><i class="fab fa-linkedin"></i></a>';
		$items .= '<a href="https://www.instagram.com/jazz.legal/" target="_blank"><i class="fab fa-instagram-square"></i></a>';
		$items .= '</li>';
	}

	if ($args->theme_location == 'footer-nav') {
		$items .= '<li class="menu-socials"><a href="javascript:," data-cc="c-settings">'. __('Cookies beheren', 'jazzlegal-front') .'</a></li>';
	}

	return $items;
}

/*-----------------------------------------------------------------------------------*/
/* Add wrapper around dropdown
/*-----------------------------------------------------------------------------------*/
class WPSE_78121_Sublevel_Walker extends Walker_Nav_Menu
{
	function start_lvl(&$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<div class='sub-menu-wrap'><ul class='sub-menu'>\n";
	}
	function end_lvl(&$output, $depth = 0, $args = array())
	{
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div>\n";
	}
}
