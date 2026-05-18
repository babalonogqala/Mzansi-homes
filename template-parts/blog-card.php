<?php // template-parts/blog-card.php ?>
<article class="mh-blog-card" id="post-<?php the_ID(); ?>">
    <a href="<?php the_permalink(); ?>" class="mh-blog-card-image">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'property-card', [ 'alt' => get_the_title() ] ); ?>
        <?php else : ?>
            <div class="mh-blog-img-placeholder">📰</div>
        <?php endif; ?>
    </a>
    <div class="mh-blog-card-body">
        <div class="mh-blog-meta">
            <span><?php echo get_the_date( 'j M Y' ); ?></span>
            <span class="mh-blog-cat">
                <?php the_category( ', ' ); ?>
            </span>
        </div>
        <h3 class="mh-blog-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="mh-blog-excerpt"><?php the_excerpt(); ?></p>
        <a href="<?php the_permalink(); ?>" class="mh-blog-read-more">
            <?php esc_html_e( 'Read More', 'mzansi-homes' ); ?> →
        </a>
    </div>
</article>
