<?php
/**
 * @var WP_Post $post
 */
$data = get_fields($post->ID);
$cta_type = !empty($data['cta']['cta_type']) && $data['cta']['cta_type'] ? $data['cta']['cta_type'] : 'none';
$hero_has_image = $data['hero']['block_size'] !== 'small' && !empty($data['hero']['block_image']);
?>

<?php get_header(null, array(
	'logo_inverse' => $hero_has_image,
	'nav_inverse' => $hero_has_image
)); ?>

<?php get_template_part('partials/content/block', 'hero', array(
	'title' => $data['hero']['block_title'] ?? '',
	'title_size' => $data['hero']['block_title_size'] ?? 'small',
	'title_align' => $data['hero']['block_title_align'] ?? '',
	'size' => $data['hero']['block_size'] ?? 'small',
	'image' => $data['hero']['block_image'] ?? null,
)); ?>

<div class="block_content<?php if($cta_type == 'none') echo ' content--offset-bottom'; ?>">
	<?php get_template_part('partials/content/content', 'blocks', array(
		'container' => 'medium'
	)); ?>
</div>

<?php if($cta_type != 'none') : ?>
	<?php get_template_part('partials/content/block', 'cta', array(
		'title' => $cta_type == "default" ? get_field('home_cta_title', apply_filters( 'wpml_object_id', get_option('page_on_front'), 'page', true)) : get_field('cta_title', $post->ID),
		'text' => $cta_type == "default" ? get_field('home_cta_text', apply_filters( 'wpml_object_id', get_option('page_on_front'), 'page', true)) : get_field('cta_text', $post->ID),
		'button' => $cta_type == "default" ? get_field('home_cta_button', apply_filters( 'wpml_object_id', get_option('page_on_front'), 'page', true)) : get_field('cta_button', $post->ID),
	)); ?>
<?php endif; ?>

<?php get_footer( '', array(
	'style' => !empty($data['cta']['cta_type']) && $data['cta']['cta_type'] != 'none' ? 'primary' : 'default'
) ); ?>
