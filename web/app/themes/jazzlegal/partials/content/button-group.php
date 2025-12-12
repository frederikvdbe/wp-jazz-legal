<?php
/**
 * @var array $args
 * @var array $buttons
 */
extract( $args );

$buttons = ! empty( $buttons ) ? $buttons : null;
?>

<?php if( $buttons ) : ?>

	<div class="button_group">

		<div class="container--medium">

			<div class="block-body">

				<?php foreach( $buttons as $button ): ?>

					<?php if( $button['button_type'] == 'primary' ) : ?>
						<?php the_button( $button['button_link'], 'btn-rounded' ); ?>
					<?php endif; ?>

					<?php if( $button['button_type'] == 'secondary' ) : ?>
						<?php the_button( $button['button_link'], 'btn-rounded btn--bordered' ); ?>
					<?php endif; ?>

					<?php if( $button['button_type'] == 'text' ) : ?>
						<?php the_button( $button['button_link'], 'btn-link btn--small' ); ?>
					<?php endif; ?>

				<?php endforeach; ?>

			</div>

		</div>

	</div>

<?php endif; ?>
