<?php get_header(); ?>

<div class="mh-archive-wrap">
    <div class="mh-container">
        <?php mh_breadcrumbs(); ?>

        <div class="mh-archive-header">
            <h1><?php esc_html_e( 'Property Listings', 'mzansi-homes' ); ?></h1>
            <p><?php esc_html_e( 'Find your perfect property across South Africa', 'mzansi-homes' ); ?></p>
        </div>

        <!-- ADVANCED SEARCH FILTER -->
        <div class="mh-filter-bar" id="property-filter">
            <form class="mh-filter-form" id="filter-form">
                <div class="mh-filter-row">
                    <div class="mh-filter-field">
                        <label><?php esc_html_e( 'Keyword / Location', 'mzansi-homes' ); ?></label>
                        <input type="text" name="keyword" id="f-keyword" placeholder="<?php esc_attr_e( 'Search suburb, city…', 'mzansi-homes' ); ?>" value="<?php echo esc_attr( $_GET['keyword'] ?? '' ); ?>" />
                    </div>
                    <div class="mh-filter-field">
                        <label><?php esc_html_e( 'Status', 'mzansi-homes' ); ?></label>
                        <select name="status" id="f-status">
                            <option value=""><?php esc_html_e( 'Any Status', 'mzansi-homes' ); ?></option>
                            <?php
                            $statuses = get_terms( [ 'taxonomy' => 'property_status', 'hide_empty' => false ] );
                            if ( $statuses && ! is_wp_error( $statuses ) ) {
                                foreach ( $statuses as $s ) {
                                    $sel = ( ( $_GET['status'] ?? '' ) === $s->slug ) ? 'selected' : '';
                                    echo '<option value="' . esc_attr( $s->slug ) . '" ' . $sel . '>' . esc_html( $s->name ) . '</option>';
                                }
                            } else {
                                echo '<option value="for-sale">For Sale</option>';
                                echo '<option value="to-let">To Let</option>';
                                echo '<option value="sold">Sold</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mh-filter-field">
                        <label><?php esc_html_e( 'Property Type', 'mzansi-homes' ); ?></label>
                        <select name="property_type" id="f-type">
                            <option value=""><?php esc_html_e( 'Any Type', 'mzansi-homes' ); ?></option>
                            <?php
                            $types = get_terms( [ 'taxonomy' => 'property_type', 'hide_empty' => false ] );
                            if ( $types && ! is_wp_error( $types ) ) {
                                foreach ( $types as $t ) {
                                    $sel = ( ( $_GET['property_type'] ?? '' ) === $t->slug ) ? 'selected' : '';
                                    echo '<option value="' . esc_attr( $t->slug ) . '" ' . $sel . '>' . esc_html( $t->name ) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mh-filter-field">
                        <label><?php esc_html_e( 'Location', 'mzansi-homes' ); ?></label>
                        <select name="location" id="f-location">
                            <option value=""><?php esc_html_e( 'Any Province', 'mzansi-homes' ); ?></option>
                            <?php
                            $provinces = [ 'western-cape' => 'Western Cape', 'gauteng' => 'Gauteng', 'kwazulu-natal' => 'KwaZulu-Natal',
                                'eastern-cape' => 'Eastern Cape', 'limpopo' => 'Limpopo', 'mpumalanga' => 'Mpumalanga',
                                'north-west' => 'North West', 'free-state' => 'Free State', 'northern-cape' => 'Northern Cape' ];
                            foreach ( $provinces as $slug => $name ) {
                                $sel = ( ( $_GET['location'] ?? '' ) === $slug ) ? 'selected' : '';
                                echo '<option value="' . esc_attr( $slug ) . '" ' . $sel . '>' . esc_html( $name ) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mh-filter-field">
                        <label><?php esc_html_e( 'Min Bedrooms', 'mzansi-homes' ); ?></label>
                        <select name="bedrooms" id="f-beds">
                            <option value=""><?php esc_html_e( 'Any', 'mzansi-homes' ); ?></option>
                            <?php for ( $i = 1; $i <= 6; $i++ ) echo '<option value="' . $i . '">' . $i . '+</option>'; ?>
                        </select>
                    </div>
                    <div class="mh-filter-field">
                        <label><?php esc_html_e( 'Min Price', 'mzansi-homes' ); ?></label>
                        <select name="min_price" id="f-min-price">
                            <option value=""><?php esc_html_e( 'No Min', 'mzansi-homes' ); ?></option>
                            <?php
                            $prices = [ 250000 => 'R 250 000', 500000 => 'R 500 000', 1000000 => 'R 1M', 2000000 => 'R 2M', 5000000 => 'R 5M' ];
                            foreach ( $prices as $v => $l ) echo '<option value="' . $v . '">' . $l . '</option>';
                            ?>
                        </select>
                    </div>
                    <div class="mh-filter-field">
                        <label><?php esc_html_e( 'Max Price', 'mzansi-homes' ); ?></label>
                        <select name="max_price" id="f-max-price">
                            <option value=""><?php esc_html_e( 'No Max', 'mzansi-homes' ); ?></option>
                            <?php
                            $prices = [ 500000 => 'R 500 000', 1000000 => 'R 1M', 2000000 => 'R 2M', 5000000 => 'R 5M', 10000000 => 'R 10M' ];
                            foreach ( $prices as $v => $l ) echo '<option value="' . $v . '">' . $l . '</option>';
                            ?>
                        </select>
                    </div>
                    <div class="mh-filter-field mh-filter-submit">
                        <button type="submit" class="mh-btn mh-btn-primary" id="filter-submit">
                            <?php esc_html_e( 'Search', 'mzansi-homes' ); ?>
                        </button>
                        <button type="reset" class="mh-btn mh-btn-ghost" id="filter-reset">
                            <?php esc_html_e( 'Clear', 'mzansi-homes' ); ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- RESULTS BAR -->
        <div class="mh-results-bar">
            <span class="mh-results-count" id="results-count">
                <?php
                global $wp_query;
                echo '<strong>' . number_format( $wp_query->found_posts ) . '</strong> ' . __( 'properties found', 'mzansi-homes' );
                ?>
            </span>
            <div class="mh-view-toggle">
                <button class="mh-view-btn active" data-view="grid" aria-label="Grid view">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                </button>
                <button class="mh-view-btn" data-view="list" aria-label="List view">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                </button>
            </div>
        </div>

        <!-- LISTINGS GRID -->
        <div class="mh-property-grid" id="listings-grid">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/property', 'card' ); ?>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="mh-no-results">
                    <span>🏠</span>
                    <h3><?php esc_html_e( 'No properties found', 'mzansi-homes' ); ?></h3>
                    <p><?php esc_html_e( 'Try adjusting your search filters.', 'mzansi-homes' ); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- PAGINATION -->
        <div class="mh-pagination" id="mh-pagination">
            <?php
            echo paginate_links([
                'total'     => $wp_query->max_num_pages,
                'prev_text' => '← ' . __( 'Previous', 'mzansi-homes' ),
                'next_text' => __( 'Next', 'mzansi-homes' ) . ' →',
            ]);
            ?>
        </div>

    </div><!-- /.mh-container -->
</div>

<?php get_footer(); ?>
