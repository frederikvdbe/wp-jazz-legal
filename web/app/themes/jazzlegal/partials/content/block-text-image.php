<?php
/**
 * @var array $args
 * @var string $title
 * @var string $text
 * @var array $image
 */
extract($args);

$title = !empty($title) ? $title : '';
$text = !empty($text) ? $text : '';
$image = $image ?? null;
$image_position = $image_position ?? 'left';
$background = $background ?? true;
$spacer = $spacer ?? 'small';
?>

<section class="content-block block_text-image block--image-<?= $image_position; ?><?php if($background) echo ' block--background-primary'; ?> block--spacer-<?= $spacer; ?>">

	<div class="container--medium">

			<div class="block-body">

				<div class="block-image">

					<div class="image-wrapper">
						<img src="<?= $image['url']; ?>" alt="<?= $image['alt'] ? $image['alt'] : $image['title']; ?>">
						<?php get_template_part( 'partials/vectors/image-mask1.svg' ); ?>
						<?php get_template_part( 'partials/vectors/image-mask-stroke1.svg' ); ?>
					</div>

					<?php if ($image['caption']) : ?>
						<div class="image-caption">
							<?= $image['caption']; ?>
						</div>
					<?php endif; ?>

				</div>

				<div class="block-text s-rich-text<?php if($background) echo ' s-richt-text--inverse'; ?>">
					<h2 class="block-title"><?= $title; ?></h2>
					<?= $text; ?>
				</div>

			</div>

	</div>

	<?php if($background) : ?>
<!--		--><?php //get_template_part( 'partials/vectors/mask1.svg' ); ?>
		<?php get_template_part( 'partials/vectors/mask2.svg' ); ?>
	<?php endif; ?>

</section>
