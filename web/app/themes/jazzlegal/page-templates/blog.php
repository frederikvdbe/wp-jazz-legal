<?php
/**
 * Template name: Blog
 * @var WP_Post $post
 */
?>

<?php get_header(); ?>

    <div class="block_hero hero--default">
        <div class="block-body">
            <div class="container--medium">
                <h1 class="block-title">Blog</h1>
            </div>
        </div>
        <?php get_template_part('partials/vectors/mask7.svg'); ?>
    </div>

    <section class="block_cards block-posts">

        <div class="block-body">
            <div class="container--medium">
                <div class="row row-body">
                    <div class="col-xs-12">

                        <div class="block-items">

                            <?php foreach (get_posts(array(
                                'post_type' => 'post',
                                'posts_per_page' => -1,
                                'suppress_filters' => false
                            )) as $post): ?>

                                <a class="block-item" href="<?php the_permalink(); ?>">
                                    <article class="block-card card-post card-hover">
                                        <div class="card-thumbnail">
                                            <?php $thumbnail = acf_get_attachment(get_post_thumbnail_id()); ?>
                                            <picture>
                                                <img srcset="<?= $thumbnail['sizes']['medium']; ?> 1x, <?= $thumbnail['sizes']['large']; ?> 2x" alt="<?= $post->post_title; ?>">
                                            </picture>
                                        </div>
                                        <div class="card-body">
                                            <h2 class="card-title"><?php the_title(); ?></h2>
                                            <div class="card-excerpt">
                                                <?php echo wp_trim_words(get_field('post_content_excerpt'), 32); ?>
                                            </div>
                                            <div class="card-footer">
                                                <div class="btn-link btn--arrow">
                                                    <?php _e('Lees verder', 'jazzlegal-front'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </a>

                            <?php endforeach;
                            wp_reset_postdata(); ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>

<?php get_footer('', array(
    'style' => 'default'
)); ?>
