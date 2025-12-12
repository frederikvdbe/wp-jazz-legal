<?php
/**
 * Template name: Offer
 * @var WP_Post $post
 */
?>

<?php get_header(); ?>

<?php $child = get_post(apply_filters( 'wpml_object_id', 380, 'service' )); ?>
<?php $child_data = get_fields($child->ID); ?>
<?php $calculated = isset($_POST['calculate']) && isset($_POST['calculator_service']) && $_POST['calculator_service'] == $child->post_title; ?>
<?php $discount = 'AMDISCOUNT'; ?>
<?php $totals = calculate_region_calculator_totals($child, $child_data, $discount); ?>

<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

	<div class="block_hero hero--default">
		<div class="block-body">
			<div class="container--medium">
				<h1 class="block-title"><?php the_title(); ?></h1>
			</div>
		</div>
		<?php get_template_part('partials/vectors/mask7.svg'); ?>
	</div>

	<section class="block_page">
		<?php get_template_part('partials/content/content-blocks'); ?>
	</section>

	<?php get_template_part('includes/services/calculators/calculator', 'regions', array(
		'child' => $child,
		'data' => $child_data,
		'calculated' => $calculated,
		'totals' => $totals
	)); ?>

	<section class="block_form form-lead<?= $calculated ? ' form--calculated' : ''; ?>">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">

					<div class="form-wrap">
						<div class="form-header">
							<div class="form-title">
								<span><?php echo get_field('contact_form_title', $child->ID) ? get_field('contact_form_title', $child->ID) : __('Contacteer Jazz.legal voor jouw ', 'jazzlegal-front') . strtolower($child->post_title); ?></span>
							</div>
						</div>
						<?php
						gravity_form(ICL_LANGUAGE_CODE == 'nl' ? 3 : 5, $display_title = false, $display_description = false, $display_inactive = false, $field_values = array(
							'service' => $child->post_title,
							'region' => $totals ? $totals['region'] : null,
							'option' => $totals ? $totals['option'] : null,
							'extras' => $totals && isset($totals['extras']) ? implode(', ', $totals['extras']) : null,
							'total' => $totals ? $totals['total']['price'] : null
						), $ajax = true, 1, $echo = true);
						?>
					</div>

				</div>
			</div>
		</div>

		<?php if (isset($_POST['calculate'])) : ?>
			<?php get_template_part('partials/vectors/mask8.svg'); ?>
		<?php endif; ?>

		<?php if (!isset($child_data['benelux_options']) && !isset($child_data['eu_options']) && !isset($child_data['idepot_options'])) : ?>
			<?php get_template_part('partials/vectors/mask6.svg'); ?>
		<?php endif; ?>

	</section>

<?php endwhile;  endif; ?>

<?php get_footer(); ?>
