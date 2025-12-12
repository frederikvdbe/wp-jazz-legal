<?php

/**
 * Template name: Contact
 * @var WP_Post $post
 */
?>
<?php $page_data = get_fields($post->ID); ?>
<?php get_header(); ?>

<div class="block_hero hero--default">
	<div class="block-body">
		<div class="container--medium">
			<h1 class="block-title">Contact</h1>
		</div>
	</div>
	<?php get_template_part('partials/vectors/mask7.svg'); ?>
</div>

<section class="block_contact">
	<div class="container--medium">

		<div class="block-header">

			<div class="contact-details">
				<div class="details-header"><strong>Jazz.legal BV</strong></div>
				<div class="details-body">
					<div class="details-col details-address">
						<?php echo nl2br(get_field('settings_address', 'option')); ?>
					</div>
					<div class="details-col details-contact">
						<a href="tel:<?php the_field('settings_phone', 'option'); ?>"><?php the_field('settings_phone', 'option'); ?></a><br>
						<a href="mailto:<?php the_field('settings_email', 'option'); ?>"><?php the_field('settings_email', 'option'); ?></a>
					</div>
				</div>
			</div>

			<div class="form-header">
				<h2 class="form-title"><?= $page_data['contact_title'] ?></h2>
				<div class="form-intro">
					<?php the_content(); ?>
				</div>
			</div>

		</div>

		<div class="block-body">

			<div class="block-form">
				<?php gravity_form(ICL_LANGUAGE_CODE == 'nl' ? 1 : 4, $display_title = false, $display_description = false, $display_inactive = false, $field_values = null, $ajax = true, 1, $echo = true); ?>
			</div>

			<div class="body-image">
				<picture>
					<source srcset="<?php echo $page_data['contact_image']['sizes']['contact_desktop']; ?>" media="(min-width: 768px)">
					<img srcset="<?php echo $page_data['contact_image']['sizes']['contact_mobile'] ?>" alt="<?= $page_data['contact_image']['title'] ?>">
				</picture>
			</div>

		</div>

		<div class="block-footer">
			<div id="map"></div>
		</div>

	</div>
</section>

<?php get_footer('', array(
	'style' => 'default'
)); ?>
