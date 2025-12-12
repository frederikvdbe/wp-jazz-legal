<?php

/**
 * Template name: Team
 * @var WP_Post $post
 */
?>

<?php get_header(); ?>
<?php $page_data = get_fields( $post->ID ); ?>
<?php $members = $page_data['team_members']; ?>

<div class="block_hero hero--default">
	<div class="block-body">
		<div class="container--medium">
			<h1 class="block-title"><?= get_field( 'page_title' ); ?></h1>
		</div>
	</div>
	<?php get_template_part( 'partials/vectors/mask7.svg' ); ?>
</div>

<?php foreach ( $members as $key => $member ) : ?>

	<?php get_template_part( 'partials/content/block', 'member', array(
		'title'    => $member['member_name'],
		'text'     => $member['member_description'],
		'image'    => $member['member_image'],
		'featured' => $key == 0 ? true : false,
		'order'    => $key % 2 == 0 && $key > 0 ? 'right' : 'left'
	) ); ?>

<?php endforeach; ?>

<?php if ( apply_filters( 'wpml_current_language', null ) == 'nl' ) : ?>
	<?php get_template_part( 'partials/content/block', 'cta', array(
		'title'   => $page_data['cta_title'],
		'text'    => $page_data['cta_text'],
		'buttons' => [
			$page_data['cta_button'],
		],
		'offset'  => true,
	) ); ?>
<?php endif; ?>

<?php get_footer( '', array(
	'style' => 'primary'
) ); ?>
