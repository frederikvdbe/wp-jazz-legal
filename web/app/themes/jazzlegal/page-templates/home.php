<?php

/**
 * Template name: Home
 * @var WP_Post $post
 */
?>

<?php get_header( null, array(
	'logo_inverse' => false,
	'nav_inverse'  => true,
) ); ?>

<?php $page_data = get_fields( $post->ID ); ?>

	<section class="block_hero hero--large">

		<div class="container container-image">
			<div class="row row-image">
				<div class="col-image col-xs-12 col-lg-8 col-lg-offset-4">
					<div class="block-image">
						<picture>
							<source srcset="<?php echo get_stylesheet_directory_uri() . '/assets/build/images/hero_desktop2023.png'; ?>" media="(min-width: 768px)">
							<img srcset="<?php echo get_stylesheet_directory_uri() . '/assets/build/images/hero_mobile2023.png'; ?>" alt="Jazz legal">
						</picture>
					</div>
				</div>
			</div>
		</div>

		<div class="container container-body">
			<div class="row row-body middle-md">
				<div class="col-xs-12 col-lg-10 col-lg-offset-1">

					<div class="hero-body">

						<h1 class="hero-title">
							<?php echo $page_data['home_hero_text']; ?>
						</h1>
						<div class="hero-cta">
							<a href="https://calendly.com/thierryvanransbeeck" target="_blank" rel="noopener" class="btn-rounded btn--backdrop btn--small btn--dark"><?php _e( 'Vraag een meeting aan', 'jazzlegal' ); ?></a>
						</div>

					</div>

				</div>
			</div>
		</div>

		<div class="container container-nav">
			<div class="row row-body middle-md">
				<div class="col-xs-12 col-lg-10 col-lg-offset-1">
					<div class="hero-nav">
						<a class="js_scrollto btn-scroll" href="javascript:;" data-scroll-type="skip">
							<i class="fal fa-long-arrow-down"></i>
						</a>
					</div>
				</div>
			</div>
		</div>

	</section>

	<section class="block_services">

		<div class="block-header">
			<div class="container">
				<div class="row row-header">
					<div class="col-xs-12 col-lg-10 col-lg-offset-1">
						<div class="block-header">
							<div class="block-title"><?php echo $page_data['home_services_title']; ?></div>
							<div class="block-intro">
								<?php echo $page_data['home_services_text']; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="block-body">
			<div class="container">
				<div class="row row-body">
					<div class="col-xs-12 col-xlg-10 col-xlg-offset-1">

						<div class="block-items">
							<?php foreach ( $page_data['home_services'] as $service ) : ?>
								<div class="service-item">
									<h2 class="item-title"><?= $service['service_title']; ?></h2>
									<div class="item-text"><?= $service['service_text']; ?></div>
									<div class="item-icon">
										<img src="<?= $service['service_icon']['url']; ?>" alt="<?= $service['service_title']; ?>">
									</div>
									<div class="item-action">
										<?php the_button( $service['service_link'], 'btn-link btn--arrow' ); ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>

					</div>
				</div>
			</div>
		</div>

		<!--        <div class="block-mask">-->
		<?php get_template_part( 'partials/vectors/mask1.svg' ); ?>
		<!--        </div>-->

	</section>

	<section class="block_text-image block--background-primary block_about">

		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-xlg-10 col-xlg-offset-1">

					<div class="block-body">

						<div class="block-text">
							<h3 class="block-title"><?php echo $page_data['home_about_title']; ?></h3>
							<?php echo $page_data['home_about_text']; ?>
						</div>

						<div class="block-image">

							<div class="image-wrapper">
								<img src="<?= $page_data['home_about_image']['url']; ?>" alt="<?= $page_data['home_about_image']['alt'] ? $page_data['home_about_image']['alt'] : $page_data['home_about_image']['title']; ?>">
								<?php // get_template_part( 'partials/vectors/image-mask1.svg' ); ?>
								<?php // get_template_part( 'partials/vectors/image-mask-stroke1.svg' ); ?>
							</div>

						</div>

					</div>

				</div>
			</div>
		</div>

		<?php get_template_part( 'partials/vectors/mask2.svg' ); ?>

	</section>

	<section class="block_expectations">

		<div class="block-header">
			<div class="container">
				<div class="row">
					<div class="col-title col-xs-12">
						<div class="block-title"><?= $page_data['home_expectations_title']; ?></div>
					</div>
				</div>
			</div>
		</div>

		<div class="block-body">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-lg-10 col-lg-offset-1">

						<div class="block-items">

							<?php foreach ( $page_data['home_expectations'] as $key => $expectation ) : ?>
								<div class="block-item expectation-item">
									<div class="item-icon"><?php get_template_part( 'partials/vectors/icon-expectation' . ( $key + 1 ) . '.svg' ); ?></div>
									<div class="item-title"><?= $expectation['expectation_title']; ?></div>
									<div class="item-text">
										<?= $expectation['expectation_text']; ?>
									</div>
								</div>
							<?php endforeach; ?>

						</div>

					</div>
				</div>
			</div>
		</div>

	</section>

	<section class="block_references">

		<div class="block-header">
			<div class="container">
				<div class="row">
					<div class="col-title col-xs-12">
						<div class="block-title">
							<?php if ( get_field( 'home_references_title' ) ) : ?>
								<?php the_field( 'home_references_title' ); ?>
							<?php else : ?>
								<?php _e( 'Referenties', 'jazzlegal-front' ); ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="block-body block-slider">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="slider-container">
							<div class="swiper">

								<div class="swiper-wrapper block-items">

									<?php foreach ( $page_data['home_references'] as $reference ) : ?>
										<div class="block-item reference-item swiper-slide">
											<div class="item-image">
												<img src="<?= $reference['reference_logo']['url']; ?>" alt="<?= $reference['reference_name']; ?>">
												<?php get_template_part( 'partials/vectors/shape1.svg' ); ?>
											</div>
											<div class="item-title"><?= $reference['reference_name']; ?></div>
										</div>
									<?php endforeach; ?>

								</div>

								<div class="swiper-pagination"></div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>

<?php get_template_part( 'partials/content/block', 'cta', array(
	'title'  => $page_data['home_cta_title'] ?: '',
	'text'   => $page_data['home_cta_text'] ?: '',
	'button' => $page_data['home_cta_button'] ?: ''
) ); ?>

<?php get_template_part( 'partials/vectors/path1.svg' ); ?>

<?php get_footer( '', array(
	'style' => 'primary'
) ); ?>
