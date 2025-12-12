<?php
/**
 * @var array $args
 * @var string $title
 * @var string $text
 * @var array $buttons
 */
extract( $args );

$title     = ! empty( $title ) ? $title : '';
$text      = ! empty( $text ) ? $text : '';
$buttons   = ! empty( $buttons ) ? $buttons : null;
$spacer   = ! empty( $spacer ) ? $spacer : 'small';
$container = ! empty( $container ) ? $container : 'small';
?>

<section class="content-block content-container content-text block--spacer-<?= $spacer; ?>">

	<div class="container">
		<div class="row">
			<div class="<?= get_block_col_class($container); ?>">

				<?php if( $title ) : ?>
					<h2 class="block-title"><?= $title; ?></h2>
				<?php endif; ?>

				<div class="block-content s-rich-text">
					<?= $text; ?>

					<?php if( $buttons ) : ?>
						<?php get_template_part( 'partials/content/button-group', null, array(
							'buttons' => $buttons
						) ); ?>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>

</section>
