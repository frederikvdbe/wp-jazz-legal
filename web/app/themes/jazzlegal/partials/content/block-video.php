<?php
/**
 * @var array $args
 * @var string $video_url
 */
extract($args);

$video = !empty($video) ? $video : '';
$spacer = !empty($spacer) ? $spacer : 'small';
?>

<section class="content-block content-container content-video block--spacer-<?= $spacer; ?>">
	<div class="container--medium">
		<div class="video-container">
			<?= $video; ?>
		</div>
	</div>
</section>
