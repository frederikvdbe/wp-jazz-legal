<?php
/**
 * @var array $args
 * @var bool $container
 * @var WP_Post $post
 */
extract($args);
$container = $container ?? true;
?>
<?php if (have_rows('content_blocks')): while (have_rows('content_blocks')) : the_row(); ?>

    <?php if (get_row_layout() == 'content_block_text'): ?>
		<?php get_template_part('partials/content/block', 'text', array(
			'title' => get_sub_field('block_title'),
			'text' => get_sub_field('block_text'),
			'buttons' => get_sub_field('button_group'),
			'spacer' => get_sub_field('block_spacer'),
			'container' => $container
		)); ?>
    <?php endif; ?>

	<?php if (get_row_layout() == 'content_block_image'): ?>
		<?php get_template_part('partials/content/block', 'image', array(
			'image' => get_sub_field('block_image'),
			'image_shape' => get_sub_field('block_image_shape'),
			'spacer' => get_sub_field('block_spacer'),
			'container' => $container
		)); ?>
	<?php endif; ?>

	<?php if (get_row_layout() == 'content_block_text-image'): ?>
		<?php get_template_part('partials/content/block', 'text-image', array(
			'title' => get_sub_field('block_title'),
			'text' => get_sub_field('block_text'),
			'image' => get_sub_field('block_image'),
			'image_position' => get_sub_field('block_image_position'),
			'background' => get_sub_field('block_background'),
			'spacer' => get_sub_field('block_spacer'),
			'container' => $container
		)); ?>
	<?php endif; ?>

    <?php if (get_row_layout() == 'content_block_video'): ?>
		<?php get_template_part('partials/content/block', 'video', array(
			'video' => get_sub_field('block_url'),
			'spacer' => get_sub_field('block_spacer'),
			'container' => $container
		)); ?>
    <?php endif; ?>

	<?php if (get_row_layout() == 'content_block_service'): ?>
		<?php get_template_part('partials/content/block', 'service', array(
			'id' => get_row_index(),
			'service_post' => get_sub_field('block_service_post'),
			'image' => get_sub_field('block_image'),
			'title' => get_sub_field('block_title'),
			'text' => get_sub_field('block_text'),
			'link' => get_sub_field('block_link'),
			'background_color' => get_sub_field('block_background_color'),
			'text_color' => get_sub_field('block_text_color'),
			'spacer' => get_sub_field('block_spacer'),
			'container' => $container
		)); ?>
	<?php endif; ?>

	<?php if (get_row_layout() == 'content_block_gallery'): ?>
		<?php get_template_part('partials/content/block', 'gallery', array(
			'images' => get_sub_field('block_images'),
			'spacer' => get_sub_field('block_spacer'),
			'container' => $container
		)); ?>
	<?php endif; ?>

<?php endwhile; endif; ?>
<?php wp_reset_postdata(); ?>
