<?php get_header(); ?>

<div class="mh-archive-wrap">
    <div class="mh-container">
        <?php mh_breadcrumbs(); ?>

        <div class="mh-archive-header">
            <h1><?php esc_html_e( 'Our Property Agents', 'mzansi-homes' ); ?></h1>
            <p><?php esc_html_e( 'Experienced, verified agents ready to help you find your perfect property.', 'mzansi-homes' ); ?></p>
        </div>

        <div class="mh-agents-grid" style="grid-template-columns:repeat(4,1fr);">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/agent', 'card' ); ?>
                <?php endwhile; ?>
            <?php else : ?>
                <?php for ( $i = 0; $i < 8; $i++ ) get_template_part( 'template-parts/agent', 'placeholder' ); ?>
            <?php endif; ?>
        </div>

        <div class="mh-pagination">
            <?php echo paginate_links(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
