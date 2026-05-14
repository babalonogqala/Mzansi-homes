<?php // archive.php — blog listing
get_header(); ?>
<div class="mh-archive-wrap">
    <div class="mh-container">
        <div class="mh-archive-header">
            <h1><?php esc_html_e( 'Property Insights & News', 'mzansi-homes' ); ?></h1>
            <p><?php esc_html_e( 'Tips, trends and news from the South African property market', 'mzansi-homes' ); ?></p>
        </div>
        <div class="mh-blog-grid">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php get_template_part('template-parts/blog', 'card'); ?>
            <?php endwhile; else : ?>
                <p><?php esc_html_e('No posts found.', 'mzansi-homes'); ?></p>
            <?php endif; ?>
        </div>
        <div class="mh-pagination"><?php echo paginate_links(); ?></div>
    </div>
</div>
<?php get_footer();
