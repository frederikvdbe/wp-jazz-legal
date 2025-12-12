<?php
/**
 * @var array $args
 * @var int $id
 * @var WP_Post $service_post
 * @var array $image
 * @var string $title
 * @var string $text
 * @var array $link
 * @var array $background_color
 * @var array $text_color
 * @var string $spacer
 * @var bool $container
 */
extract( $args );

$inline_styles = [];
$service_post = ! empty( $service_post ) ? $service_post : null;
$image = !empty( $image ) ? $image : get_field( 'hero_image', $service_post->ID );
$title = ! empty( $title ) ? $title : get_field( 'hero_title', $service_post->ID );
$text = ! empty( $text ) ? $text : get_field( 'hero_text', $service_post->ID );
$spacer = ! empty( $spacer ) ? $spacer : 'small';
if( empty( $image ) ) $image = get_field( 'hero_image', $service_post->post_parent );
if(!empty($background_color)){
	echo "<style>.block_service[data-id='{$id}'] .block-body .block-text:before { background-color: {$background_color}}</style>";
}
if(!empty($text_color)){
	echo "
<style>
.block_service[data-id='{$id}'] .block-body,
.block_service[data-id='{$id}'] .block-body a,
.block_service[data-id='{$id}'] .block-body .block-title { color: {$text_color}}
</style>
";
}
?>

<?php if( $service_post ) : ?>

	<section data-id="<?= $id; ?>" class="content-block block_service block--spacer-<?= $spacer; ?>"<?php if(!empty($inline_styles)) echo "style=\"" . implode(";", $inline_styles) . "\""; ?>>

		<div class="container--medium">

			<div class="block-body">

				<div class="block-image">
					<?php if( $image ) : ?>
						<?php the_responsive_image( $image['ID'], [ 'medium', 'large' ] ); ?>
					<?php endif; ?>
				</div>

				<div class="block-text">
					<h2 class="block-title"><?= $title; ?></h2>
					<?= $text; ?>

					<div class="block-actions">
						<?php the_button( [
							'url' => ! empty( $link ) ? $link['url'] : get_permalink( $service_post->ID ),
							'title' => ! empty( $link ) ? $link['title'] : 'Ontdek ' . strtolower( $title ),
						], 'btn-link btn--arrow' ); ?>
					</div>
				</div>

			</div>

		</div>

	</section>

<?php endif; ?>
