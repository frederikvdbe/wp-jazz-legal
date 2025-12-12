<?php

/**
 * @var array $args
 * @var string $title
 * @var string $text
 * @var array $image
 */
extract($args);
?>

<section class="block_member <?= isset($featured) && $featured ? ' block_member-featured' : '' ?> <?= 'block_member-' . $order ?>">


	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-xlg-10 col-xlg-offset-1">

				<div class="block-body">

					<div class="block-text">
						<?php if (isset($featured) && !$featured) : ?>
							<h2 class="block-title">
								<?= $title; ?>
							</h2>
						<?php endif; ?>
						<?= $text ?>
					</div>

					<div class="block-image">
						<?php if (isset($featured) && $featured) : ?>
							<h2 class="block-title">
								<?= $title; ?>
							</h2>
						<?php endif; ?>
						<img src="<?= $image['url']; ?>" alt="<?= $image['alt'] ? $image['alt'] : $image['title']; ?>">
						<?php // get_template_part('partials/vectors/image-mask1.svg'); ?>
					</div>

				</div>

			</div>
		</div>
	</div>


</section>
