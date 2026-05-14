<?php // single.php — blog posts
get_header(); ?>
<div class="mh-container" style="padding:40px 24px 80px;">
    <div style="display:grid;grid-template-columns:1fr 320px;gap:48px;align-items:start;">
        <main>
            <?php mh_breadcrumbs(); ?>
            <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class('mh-single-post'); ?>>
                <header style="margin-bottom:28px;">
                    <div style="font-size:13px;color:var(--text3);margin-bottom:10px;"><?php echo get_the_date('j F Y'); ?> &bull; <?php the_category(', '); ?></div>
                    <h1 style="margin-bottom:12px;"><?php the_title(); ?></h1>
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div style="border-radius:var(--radius-lg);overflow:hidden;margin-bottom:28px;max-height:480px;">
                        <?php the_post_thumbnail('property-hero', ['alt' => get_the_title()]); ?>
                    </div>
                    <?php endif; ?>
                </header>
                <div class="mh-prop-description" style="font-size:16px;line-height:1.85;"><?php the_content(); ?></div>
            </article>
            <?php endwhile; ?>
        </main>
        <aside><?php if ( is_active_sidebar('blog-sidebar') ) dynamic_sidebar('blog-sidebar'); ?></aside>
    </div>
</div>
<?php get_footer();
