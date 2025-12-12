<?php
/**
 * @var WP_Post $post
 */
?>

<?php
$data = get_fields($post->ID);
$hero_has_image = !empty($data['hero']['block_image']);
?>

<?php get_header(null, array(
	'logo_inverse' => $hero_has_image,
	'nav_inverse' => $hero_has_image
)); ?>

<?php get_template_part('partials/content/block', 'hero', array(
	'title' => $data['hero']['block_title'] ?? '',
	'title_size' => $data['hero']['block_title_size'] ?? '',
	'title_align' => $data['hero']['block_title_align'] ?? '',
	'size' => $data['hero']['block_size'] ?? 'small',
	'image' => $data['hero']['block_image'] ?? null,
	'container' => $data['hero']['block_title_align'] == 'center' ? 'medium' : 'small'
)); ?>

<section class="block_content page-content">
	<div class="container">

		<div class="row block-header">
			<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">

				<div class="header-nav">
					<a href="<?php echo get_permalink(apply_filters('wpml_object_id', 25, 'page')); ?>" class="btn-icon btn--back"><?php _e('Terug naar overzicht', 'jazzlegal-front'); ?></a>
				</div>

				<div class="header-title"><?php echo $data['post_hero_title']; ?></div>

				<div class="header-meta">
					<div class="meta-date"><?php echo get_the_date('d F Y'); ?></div>
				</div>

			</div>
		</div>

		<div class="row block-body">
			<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">

				<div class="body-intro">
					<?php echo $data['post_content_intro']; ?>
				</div>

			</div>
		</div>

	</div>
</section>

<div class="block_content">
	<?php get_template_part('partials/content/content', 'blocks', array(
		'container' => 'small'
	)); ?>
</div>

<?php get_template_part('partials/content/block', 'cta', array(
	'title' => get_field('home_cta_title', apply_filters( 'wpml_object_id', get_option('page_on_front'), 'page', true)),
	'text' => get_field('home_cta_text', apply_filters( 'wpml_object_id', get_option('page_on_front'), 'page', true)),
	'button' => get_field('home_cta_button', apply_filters( 'wpml_object_id', get_option('page_on_front'), 'page', true)),
)); ?>

<?php get_footer('', array(
	'style' => 'primary'
)); ?>
