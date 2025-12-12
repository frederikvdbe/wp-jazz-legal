<?php
if( has_post_thumbnail() ) :
	the_post_thumbnail();
endif;
?>

<h1><?php the_title(); ?></h1>
<?php the_content(); ?>
