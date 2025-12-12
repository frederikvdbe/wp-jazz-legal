<?php
/**
 * @var array $args
 * @var array $gallery
 * @var string $spacer
 */
extract( $args );

$images   = ! empty( $images ) ? $images : null;
$spacer    = ! empty( $spacer ) ? $spacer : 'small';
$container = $container ?? true;
?>

<?php if( $images ) : ?>

	<section class="content-block block_gallery block--spacer-<?= $spacer; ?>">

			<div class="block-body block-slider">

				<div class="slider-container swiper-container swiper">

					<div class="swiper-wrapper block-items">

						<?php foreach( $images as $image ) : ?>
							<div class="swiper-slide">
								<div class="container container--medium">
									<?php the_responsive_image($image['ID'], ['medium', 'large']); ?>
									<?php get_template_part('partials/content/image', 'caption', array(
										'image' => $image
									)); ?>
								</div>
							</div>
						<?php endforeach; ?>

					</div>

					<div class="swiper-navigation">
						<div class="container container--medium">
							<div class="swiper-button-prev"></div>
							<div class="swiper-button-next"></div>
						</div>
					</div>

					<div class="swiper-pagination"></div>

				</div>

			</div>

	</section>

<?php endif; ?>
