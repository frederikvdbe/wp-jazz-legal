<?php
// File Security Check
if (!empty($_SERVER['SCRIPT_FILENAME']) && basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
	die('You do not have sufficient permissions to access this page');
}

// Remove meta box on each post type
function remove_wpml_meta_box()
{
	$types = get_post_types();
	//    remove_meta_box('icl_div', array_values($types), 'side');
	remove_meta_box('icl_div_config', array_values($types), 'normal');
}
add_action('admin_head', 'remove_wpml_meta_box', 11);

// Languages nav
function languages_nav()
{
	$languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
	if (!empty($languages)) {
		$return = '<ul class="lang-menu">';
		$return .= '<li class="menu-item menu-item-lang_nav menu-item-has-children">';
		$return .= '<span class="lang-current">';
		if (ICL_LANGUAGE_CODE === 'nl') {
			$return .= load_template_part('partials/vectors/nl.svg');
		}
		if (ICL_LANGUAGE_CODE === 'en') {
			$return .= load_template_part('partials/vectors/en.svg');
		}
		$return .= '</span>';
		$return .= '<ul class="sub-menu lang-dropdown">';
		foreach ($languages as $l) {
			if ($l['active']) continue;
			$return .= '<li>';
			$return .= '<a href="' . $l['url'] . '">';
			if ($l['code'] === 'nl') {
				$return .= load_template_part('partials/vectors/nl.svg');
			}
			if ($l['code'] === 'en') {
				$return .= load_template_part('partials/vectors/en.svg');
			}
			$return .= '</a>';
			$return .= '</li>';
		}
		return $return .= '</ul></li></ul>';
	}
}
