<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page' );
}

/*-----------------------------------------------------------------------------------*/
/* General helpers
/*-----------------------------------------------------------------------------------*/
function var_dump_die($object) {
    echo '<pre>'; var_dump($object); echo '</pre>'; die();
}

function the_page_title(){
  global $post;
  if(get_field('page_title_text')){
    echo get_field('page_title_text');
  } else {
    echo get_the_title();
  }
}

function the_image_alt_tag(){
    // Todo
    // if img caption ? else title
}

function get_image_alt($attachment_id, $custom_alt = false){
    global $post;

    if($custom_alt)
        return $custom_alt;

    $attachment_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true);
    if($attachment_alt)
        return $attachment_alt;

    return $post->post_title;

}

function the_responsive_image($attachment_id, $sizes = false, $custom_alt = false, $caption = false, $lightbox = false){
    global $post;

    $image_alt = get_image_alt($attachment_id, ($custom_alt != false) ? $custom_alt : false);
    $attachment_full = wp_get_attachment_image_src($attachment_id, 'full');

    if($sizes && is_array($sizes) && sizeof($sizes) == 2){
        $attachment_mobile = wp_get_attachment_image_src($attachment_id, $sizes[0]);
        $attachment_desktop = wp_get_attachment_image_src($attachment_id, $sizes[1]);
    } else {
        $attachment_mobile = wp_get_attachment_image_src($attachment_id, 'medium');
        $attachment_desktop = wp_get_attachment_image_src($attachment_id, 'large');
    }

    if($caption){
        echo '<div class="image-wrapper">';
    }

    if($lightbox){
        echo '<a href="'. $attachment_full[0] .'" data-fancybox>';
    }

    echo '<picture>
        <source srcset="'. $attachment_desktop[0] .'" media="(min-width: 768px)">
        <img srcset="'. $attachment_mobile[0] .'" alt="'. $image_alt .'">
    </picture>';

    if($lightbox){
        echo '</a>';
    }

    if($caption){
        echo '<div class="image-caption">';
            echo wp_get_attachment_caption($attachment_id);
        echo '</div>';
        echo '</div>';
    }

}

function get_responsive_image($attachment_id, $custom_alt = false, $caption = false, $lightbox = false){
    ob_start();
    the_responsive_image($attachment_id, $custom_alt, $caption, $lightbox);
    return ob_get_clean();
}

function the_button($link, $classes = '', $arguments = array())
{

    if (!$link) return;

    $defaults = array(
        'icon' => false,
        'icon_position' => null
    );

    $args = wp_parse_args($arguments, $defaults);

    $link_url = $link['url'];
    $link_title = $link['title'];
    $link_target = !empty($link['target']) ? $link['target'] : '_self';

    echo '<a class="' . $classes . '" href="' . esc_url($link_url) . '" target="' . esc_attr($link_target) . '">';
    echo esc_html($link_title);

    if ($args['icon'] && $args['icon'] == 'arrow') {

        if ($args['icon_position'] == 'right')
            echo '<i class="far fa-long-arrow-right"></i>';

    }
    echo '</a>';
}

/*-----------------------------------------------------------------------------------*/
/* SEO functions
/*-----------------------------------------------------------------------------------*/
function get_og_image_url(){
    global $post;
    if ( has_post_thumbnail() ) {
        return the_post_thumbnail_url('medium');
    } else {
        return bloginfo('stylesheet_directory') . '/images/clm_image.jpg';
    }
}

function get_og_description(){
    global $post;
    if(is_singular('knowledge')){
        return get_the_title($post->ID);
    } else {
        if($post->post_content){
            return wp_trim_words($post->post_content, 20, '...');
        } else {
            return 'Innovative approaches on dealing with collective violence and opportunities for enhanced cooperation between holocaust museums & memorials, civil servants and human rights institutions.';
        }
    }
}

function load_template_part($template_name, $part_name = null, $args = null) {
	ob_start();
	get_template_part($template_name, $part_name, $args);
	$var = ob_get_contents();
	ob_end_clean();
	return $var;
}

function get_block_col_class($container = 'small') {
	$col_class = 'col-xs-12';
	if($container == 'small') $col_class = 'col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3';
	if($container == 'medium') $col_class = 'col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2';

	return $col_class;
}
