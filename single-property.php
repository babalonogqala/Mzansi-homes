<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<?php
$price      = mh_get_property_meta( get_the_ID(), 'mh_price' );
$bedrooms   = mh_get_property_meta( get_the_ID(), 'mh_bedrooms' );
$bathrooms  = mh_get_property_meta( get_the_ID(), 'mh_bathrooms' );
$garages    = mh_get_property_meta( get_the_ID(), 'mh_garages' );
$floor_size = mh_get_property_meta( get_the_ID(), 'mh_floor_size' );
$erf_size   = mh_get_property_meta( get_the_ID(), 'mh_erf_size' );
$address    = mh_get_property_meta( get_the_ID(), 'mh_address' );
$suburb     = mh_get_property_meta( get_the_ID(), 'mh_suburb' );
$city       = mh_get_property_meta( get_the_ID(), 'mh_city' );
$province   = mh_get_property_meta( get_the_ID(), 'mh_province' );
$maps_url   = mh_get_property_meta( get_the_ID(), 'mh_google_maps' );
$tour_url   = mh_get_property_meta( get_the_ID(), 'mh_virtual_tour' );
$levy       = mh_get_property_meta( get_the_ID(), 'mh_levy' );
$rates      = mh_get_property_meta( get_the_ID(), 'mh_rates' );
$ref        = mh_get_property_meta( get_the_ID(), 'mh_ref' );
$features   = mh_get_features( get_the_ID() );
$statuses   = get_the_terms( get_the_ID(), 'property_status' );
$status     = ( $statuses && ! is_wp_error( $statuses ) ) ? $statuses[0] : null;
$types      = get_the_terms( get_the_ID(), 'property_type' );
$type       = ( $types && ! is_wp_error( $types ) ) ? $types[0] : null;
$full_addr  = implode( ', ', array_filter( [ $address, $suburb, $city, $province ] ) );
?>

<div class="mh-property-single">
    <div class="mh-container">
        <?php mh_breadcrumbs(); ?>

        <!-- PROPERTY HERO -->
        <div class="mh-prop-hero">
            <div class="mh-prop-gallery">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="mh-gallery-main">
                        <?php the_post_thumbnail( 'property-hero', [ 'alt' => get_the_title() ] ); ?>
                    </div>
                <?php else : ?>
                    <div class="mh-gallery-main mh-gallery-placeholder"><span>🏠</span></div>
                <?php endif; ?>
                <?php if ( $tour_url ) : ?>
                    <a href="<?php echo esc_url( $tour_url ); ?>" target="_blank" rel="noopener" class="mh-virtual-tour-btn">
                        🎥 <?php esc_html_e( 'Virtual Tour', 'mzansi-homes' ); ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="mh-prop-hero-info">
                <?php if ( $status ) : ?>
                    <span class="mh-card-status mh-status-<?php echo esc_attr( $status->slug ); ?> mh-status-lg">
                        <?php echo esc_html( $status->name ); ?>
                    </span>
                <?php endif; ?>
                <h1 class="mh-prop-title"><?php the_title(); ?></h1>
                <?php if ( $full_addr ) : ?>
                <p class="mh-prop-address">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <?php echo esc_html( $full_addr ); ?>
                </p>
                <?php endif; ?>
                <div class="mh-prop-price"><?php echo mh_format_price( $price ); ?></div>

                <div class="mh-prop-specs-bar">
                    <?php if ( $bedrooms )   echo '<div class="mh-prop-spec"><strong>' . esc_html( $bedrooms ) . '</strong><span>Bedrooms</span></div>'; ?>
                    <?php if ( $bathrooms )  echo '<div class="mh-prop-spec"><strong>' . esc_html( $bathrooms ) . '</strong><span>Bathrooms</span></div>'; ?>
                    <?php if ( $garages )    echo '<div class="mh-prop-spec"><strong>' . esc_html( $garages ) . '</strong><span>Garages</span></div>'; ?>
                    <?php if ( $floor_size ) echo '<div class="mh-prop-spec"><strong>' . esc_html( $floor_size ) . ' m²</strong><span>Floor Size</span></div>'; ?>
                    <?php if ( $erf_size )   echo '<div class="mh-prop-spec"><strong>' . esc_html( $erf_size ) . ' m²</strong><span>Erf Size</span></div>'; ?>
                </div>

                <div class="mh-prop-actions">
                    <a href="#contact-agent" class="mh-btn mh-btn-primary mh-btn-lg"><?php esc_html_e( 'Enquire Now', 'mzansi-homes' ); ?></a>
                    <?php if ( $tour_url ) : ?>
                    <a href="<?php echo esc_url( $tour_url ); ?>" target="_blank" class="mh-btn mh-btn-ghost mh-btn-lg"><?php esc_html_e( '360° Tour', 'mzansi-homes' ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- CONTENT GRID -->
        <div class="mh-prop-content-grid">
            <div class="mh-prop-main">

                <!-- Description -->
                <div class="mh-prop-section">
                    <h2><?php esc_html_e( 'About This Property', 'mzansi-homes' ); ?></h2>
                    <div class="mh-prop-description">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Details Table -->
                <div class="mh-prop-section">
                    <h2><?php esc_html_e( 'Property Details', 'mzansi-homes' ); ?></h2>
                    <div class="mh-details-grid">
                        <?php
                        $details = [
                            'Reference'  => $ref,
                            'Type'       => $type ? $type->name : '',
                            'Status'     => $status ? $status->name : '',
                            'Bedrooms'   => $bedrooms,
                            'Bathrooms'  => $bathrooms,
                            'Garages'    => $garages,
                            'Floor Size' => $floor_size ? $floor_size . ' m²' : '',
                            'Erf Size'   => $erf_size   ? $erf_size . ' m²'   : '',
                            'Levy'       => $levy  ? 'R ' . number_format( $levy )  . ' /month' : '',
                            'Rates & Taxes' => $rates ? 'R ' . number_format( $rates ) . ' /month' : '',
                            'Province'   => $province,
                            'City'       => $city,
                        ];
                        foreach ( $details as $label => $value ) :
                            if ( ! $value ) continue;
                        ?>
                        <div class="mh-detail-row">
                            <span class="mh-detail-label"><?php echo esc_html( $label ); ?></span>
                            <span class="mh-detail-value"><?php echo esc_html( $value ); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Features -->
                <?php if ( ! empty( $features ) ) : ?>
                <div class="mh-prop-section">
                    <h2><?php esc_html_e( 'Features & Amenities', 'mzansi-homes' ); ?></h2>
                    <div class="mh-features-list">
                        <?php foreach ( $features as $feature ) : ?>
                        <span class="mh-feature-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            <?php echo esc_html( $feature ); ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Map -->
                <?php if ( $maps_url ) : ?>
                <div class="mh-prop-section">
                    <h2><?php esc_html_e( 'Location', 'mzansi-homes' ); ?></h2>
                    <div class="mh-map-wrap">
                        <iframe src="<?php echo esc_url( $maps_url ); ?>" width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <?php elseif ( $full_addr ) : ?>
                <div class="mh-prop-section">
                    <h2><?php esc_html_e( 'Location', 'mzansi-homes' ); ?></h2>
                    <div class="mh-map-wrap">
                        <iframe src="https://maps.google.com/maps?q=<?php echo urlencode( $full_addr ); ?>&output=embed" width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
                <?php endif; ?>

            </div><!-- /.mh-prop-main -->

            <!-- SIDEBAR -->
            <aside class="mh-prop-sidebar">
                <!-- Contact Form -->
                <div class="mh-prop-enquiry-card" id="contact-agent">
                    <h3><?php esc_html_e( 'Enquire About This Property', 'mzansi-homes' ); ?></h3>
                    <form class="mh-enquiry-form" id="property-enquiry-form" data-property="<?php echo esc_attr( get_the_title() ); ?>">
                        <?php wp_nonce_field( 'mh_nonce', 'mh_form_nonce' ); ?>
                        <input type="text" name="name" placeholder="<?php esc_attr_e( 'Your Full Name *', 'mzansi-homes' ); ?>" required />
                        <input type="email" name="email" placeholder="<?php esc_attr_e( 'Email Address *', 'mzansi-homes' ); ?>" required />
                        <input type="tel" name="phone" placeholder="<?php esc_attr_e( 'Phone Number', 'mzansi-homes' ); ?>" />
                        <textarea name="message" rows="4" placeholder="<?php esc_attr_e( 'I am interested in this property and would like more information…', 'mzansi-homes' ); ?>" required></textarea>
                        <div class="mh-form-check">
                            <label>
                                <input type="checkbox" name="viewing" value="1" />
                                <?php esc_html_e( 'I would like to arrange a viewing', 'mzansi-homes' ); ?>
                            </label>
                        </div>
                        <button type="submit" class="mh-btn mh-btn-primary mh-btn-full">
                            <?php esc_html_e( 'Send Enquiry', 'mzansi-homes' ); ?>
                        </button>
                        <div class="mh-form-response"></div>
                    </form>
                </div>

                <!-- Price Summary -->
                <div class="mh-prop-price-card">
                    <div class="mh-price-display"><?php echo mh_format_price( $price ); ?></div>
                    <?php if ( $levy || $rates ) : ?>
                    <div class="mh-monthly-costs">
                        <h4><?php esc_html_e( 'Monthly Costs', 'mzansi-homes' ); ?></h4>
                        <?php if ( $levy )  echo '<div class="mh-cost-row"><span>Levy</span><span>R ' . number_format( $levy ) . '</span></div>'; ?>
                        <?php if ( $rates ) echo '<div class="mh-cost-row"><span>Rates & Taxes</span><span>R ' . number_format( $rates ) . '</span></div>'; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ( $ref ) : ?>
                    <p class="mh-ref-number"><?php esc_html_e( 'Ref: ', 'mzansi-homes' ); ?><?php echo esc_html( $ref ); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Share -->
                <div class="mh-share-card">
                    <h4><?php esc_html_e( 'Share This Property', 'mzansi-homes' ); ?></h4>
                    <div class="mh-share-btns">
                        <a href="https://wa.me/?text=<?php echo urlencode( get_the_title() . ' - ' . get_permalink() ); ?>" target="_blank" class="mh-share-btn mh-share-wa">WhatsApp</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" class="mh-share-btn mh-share-fb">Facebook</a>
                        <button class="mh-share-btn mh-share-copy" onclick="navigator.clipboard.writeText('<?php echo esc_js( get_permalink() ); ?>')">Copy Link</button>
                    </div>
                </div>
            </aside>
        </div><!-- /.mh-prop-content-grid -->
    </div><!-- /.mh-container -->
</div><!-- /.mh-property-single -->

<?php endwhile; ?>
<?php get_footer(); ?>
