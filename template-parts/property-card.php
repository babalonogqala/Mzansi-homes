<?php
$price      = mh_get_property_meta( get_the_ID(), 'mh_price' );
$bedrooms   = mh_get_property_meta( get_the_ID(), 'mh_bedrooms' );
$bathrooms  = mh_get_property_meta( get_the_ID(), 'mh_bathrooms' );
$floor_size = mh_get_property_meta( get_the_ID(), 'mh_floor_size' );
$suburb     = mh_get_property_meta( get_the_ID(), 'mh_suburb' );
$city       = mh_get_property_meta( get_the_ID(), 'mh_city' );
$statuses   = get_the_terms( get_the_ID(), 'property_status' );
$status     = ( $statuses && ! is_wp_error( $statuses ) ) ? $statuses[0] : null;
?>
<article class="mh-property-card" id="property-<?php the_ID(); ?>">
    <a href="<?php the_permalink(); ?>" class="mh-card-image-link">
        <div class="mh-card-image">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'property-card', [ 'alt' => get_the_title() ] ); ?>
            <?php else : ?>
                <div class="mh-card-img-placeholder"><span>🏠</span></div>
            <?php endif; ?>
            <?php if ( $status ) : ?>
                <span class="mh-card-status mh-status-<?php echo esc_attr( $status->slug ); ?>">
                    <?php echo esc_html( $status->name ); ?>
                </span>
            <?php endif; ?>
        </div>
    </a>
    <div class="mh-card-body">
        <div class="mh-card-price"><?php echo mh_format_price( $price ); ?></div>
        <h3 class="mh-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <?php if ( $suburb || $city ) : ?>
        <p class="mh-card-location">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <?php echo esc_html( implode( ', ', array_filter( [ $suburb, $city ] ) ) ); ?>
        </p>
        <?php endif; ?>
        <div class="mh-card-specs">
            <?php if ( $bedrooms ) : ?>
            <span class="mh-spec" title="Bedrooms">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"/><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"/><path d="M12 4v6"/><path d="M2 18h20"/></svg>
                <?php echo esc_html( $bedrooms ); ?> Bed
            </span>
            <?php endif; ?>
            <?php if ( $bathrooms ) : ?>
            <span class="mh-spec" title="Bathrooms">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 6 6.5 3.5a1.5 1.5 0 0 0-1-.5C4.683 3 4 3.683 4 4.5V17a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5"/><line x1="10" y1="5" x2="8" y2="7"/><line x1="2" y1="12" x2="22" y2="12"/></svg>
                <?php echo esc_html( $bathrooms ); ?> Bath
            </span>
            <?php endif; ?>
            <?php if ( $floor_size ) : ?>
            <span class="mh-spec" title="Floor Size">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                <?php echo esc_html( $floor_size ); ?> m²
            </span>
            <?php endif; ?>
        </div>
        <div class="mh-card-footer">
            <a href="<?php the_permalink(); ?>" class="mh-btn mh-btn-sm mh-btn-primary">
                <?php esc_html_e( 'View Property', 'mzansi-homes' ); ?>
            </a>
            <button class="mh-save-btn" data-id="<?php the_ID(); ?>" aria-label="Save property">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </button>
        </div>
    </div>
</article>
