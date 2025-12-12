<?php

/**
 * @var WP_Post $post
 */
?>

<?php
get_header( null, array(
	'logo_inverse' => true,
	'nav_inverse'  => true
) );
$children  = get_posts( array(
		'post_type'   => 'service',
		'post_parent' => $post->ID
	) );
$page_data = get_fields( $post->ID );

if ( empty( $children ) && $post->post_parent ) {

	$children = get_posts( array(
			'post_type'   => 'service',
			'post_parent' => $post->post_parent
		) );

	$page_data = get_fields( $post->post_parent );
}

?>

<section class="block_hero hero--medium">

	<div class="hero-bg">
		<picture>
			<source srcset="<?php echo $page_data['hero_image']['sizes']['hero-medium-desktop']; ?>" media="(min-width: 861px)">
			<source srcset="<?php echo $page_data['hero_image']['sizes']['hero-medium-tablet']; ?>" media="(min-width: 560px)">
			<img srcset="<?php echo $page_data['hero_image']['sizes']['hero-medium']; ?>" alt="<?php the_title(); ?>">
		</picture>

		<div class="hero-mask">
			<?php get_template_part( 'partials/vectors/mask4.svg' ); ?>
		</div>
	</div>

	<div class="hero-body">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-lg-10 col-lg-offset-1">
					<div class="hero-content">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							<h1 class="hero-title">
								<?php if ( $post->post_parent ) : ?>
									<?php if ( get_field( 'hero_title', $post->post_parent ) ) : ?>
										<?php the_field( 'hero_title', $post->post_parent ); ?>
									<?php else : ?>
										<?= get_the_title( $post->post_parent ); ?>
									<?php endif; ?>
								<?php else : ?>
									<?php if ( get_field( 'hero_title' ) ) : ?>
										<?php the_field( 'hero_title' ); ?>
									<?php else : ?>
										<?= get_the_title( $post->ID ); ?>
									<?php endif; ?>
								<?php endif; ?>
							</h1>
							<?= isset( $page_data['hero_text'] ) ? $page_data['hero_text'] : ''; ?>
						<?php endwhile;
						endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>

<div class="block_content">

	<?php if ( $children ) : ?>

		<div class="js_tabs-container">

			<ul class="tabs-nav">
				<?php foreach ( $children as $key => $child ) : ?>
					<li class="tab-item<?= ! isset( $_POST['calculator_service'] ) && ! $post->post_parent && $key == 0 || ! isset( $_POST['calculator_service'] ) && $post->post_parent && $post->ID == $child->ID || isset( $_POST['calculator_service'] ) && $_POST['calculator_service'] == $child->post_title ? ' --active --initial' : ''; ?>">
						<a href="<?php the_permalink( $child->ID ); ?>"><?= $child->post_title; ?></a>
					</li>
				<?php endforeach; ?>
			</ul>

			<div class="tabs-content">

				<?php foreach ( $children as $key => $child ) : ?>
					<?php $child_data = get_fields( $child->ID ); ?>
					<?php $calculated = isset( $_POST['calculate'] ) && isset( $_POST['calculator_service'] ) && $_POST['calculator_service'] == $child->post_title; ?>
					<?php if ( $child->ID == 84 ) {
						$totals = calculate_idepot_calculator_totals( $child, $child_data );
					} else {
						$totals = calculate_region_calculator_totals( $child, $child_data );
					} ?>

					<div class="tab-pane<?= ! isset( $_POST['calculator_service'] ) && ! $post->post_parent && $key == 0 || ! isset( $_POST['calculator_service'] ) && $post->post_parent && $post->ID == $child->ID || isset( $_POST['calculator_service'] ) && $_POST['calculator_service'] == $child->post_title ? ' --active --initial' : ''; ?>" id="<?= $child->post_name; ?>">

						<div class="pane-header pane-toggle">
							<div class="container">
								<div class="row">
									<div class="col-xs-12">
										<div class="pane-title">
											<a href="<?php the_permalink($child->ID); ?>"><?php echo apply_filters( 'the_title', $child->post_title ); ?></a>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="pane-body">

							<div class="pane-content">
								<?php get_template_part( 'partials/content/content-blocks', null, array(
									'post' => $child,
									'container' => false
								) ); ?>
							</div>

							<?php if ( isset( $child_data['benelux_options'] ) || isset( $child_data['eu_options'] ) ) : ?>

								<?php get_template_part( 'includes/services/calculators/calculator', 'regions', array(
									'child'      => $child,
									'data'       => $child_data,
									'calculated' => $calculated,
									'totals'     => $totals
								) ); ?>

							<?php elseif ( isset( $child_data['idepot_options'] ) ) : ?>

								<?php get_template_part( 'includes/services/calculators/calculator', 'idepot', array(
									'child'      => $child,
									'data'       => $child_data,
									'calculated' => $calculated,
									'totals'     => $totals
								) ); ?>

							<?php endif; ?>

							<section class="block_form form-lead<?= $calculated ? ' form--calculated' : ''; ?>">
								<div class="container">
									<div class="row">
										<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">

											<div class="form-wrap">
												<div class="form-header">
													<div class="form-title">
														<span><?php echo get_field( 'contact_form_title', $child->ID ) ? get_field( 'contact_form_title', $child->ID ) : 'Contacteer Jazz.legal voor jouw ' . strtolower( $child->post_title ); ?></span>
													</div>
												</div>
												<?php

												if ( !$post->post_parent || $child->ID == $post->ID ) {

													if ( isset( $_POST['calculate'] ) && $_POST['calculate'] == '84' ) {
														gravity_form( ICL_LANGUAGE_CODE == 'nl' ? 3 : 5, $display_title = false, $display_description = false, $display_inactive = false, $field_values = array(
															'service' => $child->post_title,
															'region'  => null,
															'option'  => $totals ? $totals['option'] : null,
															'extras'  => null,
															'total'   => $totals ? $totals['total']['price'] : null
														), $ajax = true, 1, $echo = true );
													} else {
														gravity_form( ICL_LANGUAGE_CODE == 'nl' ? 3 : 5, $display_title = false, $display_description = false, $display_inactive = false, $field_values = array(
															'service' => $child->post_title,
															'region'  => $totals ? $totals['region'] : null,
															'option'  => $totals ? $totals['option'] : null,
															'extras'  => $totals && isset( $totals['extras'] ) ? implode( ', ', $totals['extras'] ) : null,
															'total'   => $totals ? $totals['total']['price'] : null
														), $ajax = true, 1, $echo = true );
													}

												}

												?>
											</div>

										</div>
									</div>
								</div>

								<?php if ( isset( $_POST['calculate'] ) ) : ?>
									<?php get_template_part( 'partials/vectors/mask8.svg' ); ?>
								<?php endif; ?>

								<?php if ( ! isset( $child_data['benelux_options'] ) && ! isset( $child_data['eu_options'] ) && ! isset( $child_data['idepot_options'] ) ) : ?>
									<?php get_template_part( 'partials/vectors/mask6.svg' ); ?>
								<?php endif; ?>

							</section>

						</div>

					</div>
				<?php endforeach; ?>

			</div>

		</div>

	<?php else : ?>
		<?php $calculated = isset( $_POST[ 'region_' . $post->ID ] ) && $_POST[ 'region_' . $post->ID ] != '0' && isset( $_POST[ 'option_' . $post->ID . '_' . $_POST[ 'region_' . $post->ID ] ] ) && $_POST[ 'option_' . $post->ID . '_' . $_POST[ 'region_' . $post->ID ] ] != '0'; ?>
		<?php $totals = calculate_region_calculator_totals( $post, $page_data ); ?>

		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">
					<div class="service-content">
						<?php get_template_part( 'partials/content/content-blocks', null, array(
							'post' => $post,
							'container' => false
						) ); ?>
					</div>
				</div>
			</div>
		</div>

		<section class="block_form form-lead">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xlg-6 col-xlg-offset-3">

						<div class="form-wrap">
							<div class="form-header">
								<div class="form-title">
									<span><?php _e( 'Contacteer Jazz.legal voor jouw ', 'jazzlegal-front' ); ?><?php echo strtolower( $post->post_title ); ?></span>
								</div>
							</div>
							<?php gravity_form( ICL_LANGUAGE_CODE == 'nl' ? 3 : 5, $display_title = false, $display_description = false, $display_inactive = false, $field_values = array(
								'service' => $post->post_title,
								'region'  => null,
								'option'  => null,
								'extras'  => null,
								'total'   => null
							), $ajax = true, 1, $echo = true ); ?>
						</div>

					</div>
				</div>
			</div>

			<?php if ( isset( $_POST['calculate'] ) ) : ?>
				<?php get_template_part( 'partials/vectors/mask8.svg' ); ?>
			<?php endif; ?>

			<?php if ( ! isset( $child_data['benelux_options'] ) && ! isset( $child_data['eu_options'] ) && ! isset( $child_data['idepot_options'] ) ) : ?>
				<?php get_template_part( 'partials/vectors/mask6.svg' ); ?>
			<?php endif; ?>

		</section>

	<?php endif; ?>

</div>


<?php get_footer( '', array(
	'style' => isset( $_POST['calculate'] ) ? 'default' : 'primary-light'
) ); ?>
