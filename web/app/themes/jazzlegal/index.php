<?php get_header(); ?>

    <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

        <div class="block_hero hero--default">
            <div class="block-body">
                <div class="container--medium">
                    <h1 class="block-title"><?php the_title(); ?></h1>
                </div>
            </div>
            <?php get_template_part('partials/vectors/mask7.svg'); ?>
        </div>

        <section class="block_page">
            <div class="container--medium">
                <?php get_template_part('partials/content/content-blocks'); ?>
            </div>
        </section>

        <?php endwhile; else : ?>

        <div class="block_hero hero--default">
            <div class="block-body">
                <div class="container--medium">
                    <h1 class="block-title">Whoops</h1>
                </div>
            </div>
            <?php get_template_part('partials/vectors/mask7.svg'); ?>
        </div>

        <section class="block_page">
            <div class="container--medium">

                <?php get_template_part('partials/content/content', '404' ); ?>
            </div>
        </section>

    <?php endif; ?>

<?php get_footer(); ?>