<?php
/**
 * @var array $args
 * @var array $image
 */
extract( $args );

$image   = ! empty( $image ) ? $image : null;
$image_shape = !empty($image_shape) ? $image_shape : false;
$spacer   = ! empty( $spacer ) ? $spacer : 'small';
$container = ! empty( $container ) ? $container : 'medium';
?>

<section class="content-block content-container content-image block_image block--spacer-<?= $spacer; ?>">

	<div class="container">
		<div class="row">
			<div class="<?= get_block_col_class($container); ?>">

				<div class="block-image">

					<div class="image-wrapper">

						<?php the_responsive_image($image['ID'], ['medium', 'large']); ?>

						<?php if($image_shape) : ?>
							<?php get_template_part( 'partials/vectors/image-mask1.svg' ); ?>
							<?php get_template_part( 'partials/vectors/image-mask-stroke1.svg' ); ?>
						<?php endif; ?>

					</div>

					<?php if ($image['caption']) : ?>
						<div class="image-caption">
							<?= $image['caption']; ?>
						</div>
					<?php endif; ?>

				</div>

			</div>
		</div>
	</div>

</section>
