<?php
/**
 * @var array $args
 * @var string $title
 * @var string $text
 * @var array $button
 * @var array $buttons
 */
extract($args);
?>
<section class="block_cta block--background">

	<div class="block-header"></div>
	<div class="block-body">
		<div class="Container">
			<div class="row">
				<div class="col-xs-12">

					<div class="card card--inverse card--wide">
						<div class="c-card__header"></div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<div class="block-footer"></div>

	<div class="container">
		<div class="row">
			<div class="block-body col-xs-12 <?= isset($offset) && $offset ? ' block-body--left col-lg-10 col-lg-offset-1' : ''; ?>">

				<div class="block-title">
					<?= $title; ?>
				</div>
				<div class="block-text">
					<?= $text; ?>
				</div>
				<div class="block-action">

					<?php if(!empty($buttons)) : ?>

						<?php foreach($buttons as $button) : ?>
							<?php the_button($button, 'btn-rounded btn--large btn--dark btn--arrow'); ?>
						<?php endforeach; ?>

					<?php else : ?>

						<?php if ($button) : ?>
							<?php the_button($button, 'btn-rounded btn--large btn--dark btn--arrow'); ?>
						<?php else : ?>
							<a href="https://calendly.com/thierryvanransbeeck" target="_blank" rel="noopener" data-src="#calendly-popup" data-fancybox class="btn-rounded btn--large btn--dark btn--arrow"><?php _e('Vraag een meeting aan', 'jazzlegal-front'); ?></a>
						<?php endif; ?>

					<?php endif; ?>

				</div>

			</div>
		</div>
	</div>

	<?php get_template_part('partials/vectors/mask3.svg'); ?>

</section>
