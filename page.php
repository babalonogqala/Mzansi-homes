<?php get_header(); ?>

<div class="mh-page-wrap">
    <div class="mh-container" style="padding-top:40px;padding-bottom:80px;">
        <?php mh_breadcrumbs(); ?>

        <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class('mh-page-content'); ?>>
            <h1 style="margin-bottom:28px;"><?php the_title(); ?></h1>
            <div class="mh-prop-description">
                <?php the_content(); ?>
            </div>
        </article>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
