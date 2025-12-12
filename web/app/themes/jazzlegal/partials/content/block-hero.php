<?php
/**
 * @var array $args
 * @var string $title
 * @var string $title_size
 * @var string $title_align
 * @var array $image
 */
extract($args);

$title = !empty($title) ? $title : get_the_title();
$size = !empty($size) ? $size : 'small';
$title_size = $title_size ?? 'large';
$title_align = $title_align ?? 'left';
$image = $size != 'small' && $image ? $image : null;
$container = ! empty( $container ) ? $container : 'medium';
?>

<div class="block_hero<?= $size != 'small' && $image ? ' hero--image' : ' hero--default'?> hero--default-<?= $size; ?> hero--title-align-<?= $title_align; ?> hero--title-<?= $title_size; ?>">

	<div class="block-body">

		<div class="block-body">
			<div class="container">
				<div class="row">
					<div class="<?= get_block_col_class($container); ?>">
						<h1 class="block-title"><?= $title; ?></h1>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if($size != 'small' && $image) : ?>
		<div class="block-bg">

			<picture>
				<source srcset="<?php echo $image['sizes']['hero-medium-desktop']; ?>" media="(min-width: 861px)">
				<source srcset="<?php echo $image['sizes']['hero-medium-tablet']; ?>" media="(min-width: 560px)">
				<img srcset="<?php echo $image['sizes']['hero-medium']; ?>" alt="<?php the_title(); ?>">
			</picture>

			<?php if ($image['caption']) : ?>
				<div class="block-credits">
					<?= $image['caption']; ?>
				</div>
			<?php endif; ?>

			<?php get_template_part('partials/vectors/mask5.svg'); ?>

		</div>

	<?php else : ?>

		<?php get_template_part('partials/vectors/mask7.svg'); ?>

	<?php endif; ?>


</div>
