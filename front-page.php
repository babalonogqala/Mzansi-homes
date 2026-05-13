<?php get_header(); ?>

<!-- HERO SECTION -->
<section class="mh-hero">
    <div class="mh-hero-bg">
        <?php
        $hero_img = get_theme_mod( 'mh_hero_image' );
        if ( $hero_img ) {
            echo '<img src="' . esc_url( $hero_img ) . '" alt="Mzansi Homes Hero" class="mh-hero-img" />';
        }
        ?>
        <div class="mh-hero-overlay"></div>
    </div>
    <div class="mh-container">
        <div class="mh-hero-content">
            <span class="mh-hero-eyebrow"><?php esc_html_e( 'South Africa\'s Trusted Property Platform', 'mzansi-homes' ); ?></span>
            <h1 class="mh-hero-title">
                <?php esc_html_e( 'Find Your Perfect', 'mzansi-homes' ); ?><br>
                <span class="mh-hero-accent"><?php esc_html_e( 'South African Home', 'mzansi-homes' ); ?></span>
            </h1>
            <p class="mh-hero-sub">
                <?php esc_html_e( 'Browse thousands of verified property listings across South Africa. Houses, apartments, plots and commercial — all in one place.', 'mzansi-homes' ); ?>
            </p>

            <!-- HERO SEARCH FORM -->
            <div class="mh-hero-search">
                <div class="mh-search-tabs">
                    <button class="mh-search-tab active" data-status="for-sale"><?php esc_html_e( 'For Sale', 'mzansi-homes' ); ?></button>
                    <button class="mh-search-tab" data-status="to-let"><?php esc_html_e( 'To Let', 'mzansi-homes' ); ?></button>
                    <button class="mh-search-tab" data-status="new-development"><?php esc_html_e( 'New Developments', 'mzansi-homes' ); ?></button>
                </div>
                <div class="mh-search-form" id="hero-search-form">
                    <div class="mh-search-fields">
                        <div class="mh-search-field mh-field-wide">
                            <label><?php esc_html_e( 'Location', 'mzansi-homes' ); ?></label>
                            <input type="text" id="search-keyword" placeholder="<?php esc_attr_e( 'City, suburb or address…', 'mzansi-homes' ); ?>" />
                        </div>
                        <div class="mh-search-field">
                            <label><?php esc_html_e( 'Property Type', 'mzansi-homes' ); ?></label>
                            <select id="search-type">
                                <option value=""><?php esc_html_e( 'Any Type', 'mzansi-homes' ); ?></option>
                                <?php
                                $types = get_terms( [ 'taxonomy' => 'property_type', 'hide_empty' => false ] );
                                if ( $types && ! is_wp_error( $types ) ) {
                                    foreach ( $types as $t ) {
                                        echo '<option value="' . esc_attr( $t->slug ) . '">' . esc_html( $t->name ) . '</option>';
                                    }
                                } else {
                                    $defaults = [ 'house' => 'House', 'apartment' => 'Apartment', 'townhouse' => 'Townhouse', 'plot' => 'Plot & Land', 'commercial' => 'Commercial' ];
                                    foreach ( $defaults as $val => $label ) {
                                        echo '<option value="' . esc_attr( $val ) . '">' . esc_html( $label ) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mh-search-field">
                            <label><?php esc_html_e( 'Bedrooms', 'mzansi-homes' ); ?></label>
                            <select id="search-beds">
                                <option value=""><?php esc_html_e( 'Any', 'mzansi-homes' ); ?></option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                                <option value="5">5+</option>
                            </select>
                        </div>
                        <div class="mh-search-field">
                            <label><?php esc_html_e( 'Max Price', 'mzansi-homes' ); ?></label>
                            <select id="search-max-price">
                                <option value=""><?php esc_html_e( 'Any Price', 'mzansi-homes' ); ?></option>
                                <option value="500000">R 500 000</option>
                                <option value="1000000">R 1 000 000</option>
                                <option value="2000000">R 2 000 000</option>
                                <option value="3500000">R 3 500 000</option>
                                <option value="5000000">R 5 000 000</option>
                                <option value="10000000">R 10 000 000</option>
                            </select>
                        </div>
                    </div>
                    <button class="mh-btn mh-btn-primary mh-search-submit" id="hero-search-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        <?php esc_html_e( 'Search Properties', 'mzansi-homes' ); ?>
                    </button>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="mh-hero-stats">
                <?php
                $prop_count  = wp_count_posts( 'property' )->publish;
                $agent_count = wp_count_posts( 'agent' )->publish;
                ?>
                <div class="mh-stat"><strong><?php echo number_format( $prop_count ?: 1200 ); ?>+</strong><span><?php esc_html_e( 'Active Listings', 'mzansi-homes' ); ?></span></div>
                <div class="mh-stat-divider"></div>
                <div class="mh-stat"><strong><?php echo number_format( $agent_count ?: 80 ); ?>+</strong><span><?php esc_html_e( 'Verified Agents', 'mzansi-homes' ); ?></span></div>
                <div class="mh-stat-divider"></div>
                <div class="mh-stat"><strong>9</strong><span><?php esc_html_e( 'Provinces Covered', 'mzansi-homes' ); ?></span></div>
                <div class="mh-stat-divider"></div>
                <div class="mh-stat"><strong>15+</strong><span><?php esc_html_e( 'Years Experience', 'mzansi-homes' ); ?></span></div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED LISTINGS -->
<section class="mh-section mh-featured">
    <div class="mh-container">
        <div class="mh-section-header">
            <div>
                <span class="mh-eyebrow"><?php esc_html_e( 'Hand-picked for You', 'mzansi-homes' ); ?></span>
                <h2 class="mh-section-title"><?php esc_html_e( 'Featured Properties', 'mzansi-homes' ); ?></h2>
            </div>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>" class="mh-btn mh-btn-ghost">
                <?php esc_html_e( 'View All Listings', 'mzansi-homes' ); ?>
            </a>
        </div>

        <div class="mh-property-grid" id="featured-listings">
            <?php
            $featured = new WP_Query([
                'post_type'      => 'property',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
                'meta_key'       => 'mh_price',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
            ]);
            if ( $featured->have_posts() ) :
                while ( $featured->have_posts() ) :
                    $featured->the_post();
                    get_template_part( 'template-parts/property', 'card' );
                endwhile;
                wp_reset_postdata();
            else :
                // Show placeholder cards if no listings yet
                for ( $i = 0; $i < 6; $i++ ) :
                    get_template_part( 'template-parts/property', 'placeholder' );
                endfor;
            endif;
            ?>
        </div>
    </div>
</section>

<!-- BROWSE BY TYPE -->
<section class="mh-section mh-browse-types mh-bg-light">
    <div class="mh-container">
        <div class="mh-section-header centered">
            <span class="mh-eyebrow"><?php esc_html_e( 'What Are You Looking For?', 'mzansi-homes' ); ?></span>
            <h2 class="mh-section-title"><?php esc_html_e( 'Browse by Property Type', 'mzansi-homes' ); ?></h2>
        </div>
        <div class="mh-type-grid">
            <?php
            $type_icons = [
                'house'      => [ 'icon' => '🏠', 'label' => 'Houses' ],
                'apartment'  => [ 'icon' => '🏢', 'label' => 'Apartments' ],
                'townhouse'  => [ 'icon' => '🏘', 'label' => 'Townhouses' ],
                'plot'       => [ 'icon' => '🌿', 'label' => 'Plots & Land' ],
                'commercial' => [ 'icon' => '🏬', 'label' => 'Commercial' ],
                'farm'       => [ 'icon' => '🌾', 'label' => 'Farms' ],
            ];
            foreach ( $type_icons as $slug => $data ) :
                $term = get_term_by( 'slug', $slug, 'property_type' );
                $url  = $term ? get_term_link( $term ) : get_post_type_archive_link( 'property' );
                $count = $term ? $term->count : 0;
            ?>
            <a href="<?php echo esc_url( $url ); ?>" class="mh-type-card">
                <span class="mh-type-icon"><?php echo $data['icon']; ?></span>
                <span class="mh-type-label"><?php echo esc_html( $data['label'] ); ?></span>
                <?php if ( $count ) : ?>
                <span class="mh-type-count"><?php echo $count; ?> listings</span>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="mh-section mh-why">
    <div class="mh-container">
        <div class="mh-why-grid">
            <div class="mh-why-content">
                <span class="mh-eyebrow"><?php esc_html_e( 'Why Mzansi Homes?', 'mzansi-homes' ); ?></span>
                <h2 class="mh-section-title"><?php esc_html_e( 'Your Trusted Property Partner', 'mzansi-homes' ); ?></h2>
                <p><?php esc_html_e( 'We combine deep local knowledge with modern technology to help South Africans buy, sell, and rent property with confidence.', 'mzansi-homes' ); ?></p>
                <div class="mh-why-features">
                    <?php
                    $features = [
                        [ 'icon' => '✅', 'title' => 'Verified Listings',     'desc' => 'Every property is verified by our team before going live.' ],
                        [ 'icon' => '🔒', 'title' => 'Secure Transactions',   'desc' => 'Safe, transparent processes compliant with SA property law.' ],
                        [ 'icon' => '📍', 'title' => 'Local Expertise',       'desc' => 'Agents who know their areas — from townships to suburbs.' ],
                        [ 'icon' => '💬', 'title' => '24/7 Support',          'desc' => 'Our team is always available to answer your questions.' ],
                    ];
                    foreach ( $features as $f ) : ?>
                    <div class="mh-why-item">
                        <span class="mh-why-icon"><?php echo $f['icon']; ?></span>
                        <div>
                            <strong><?php echo esc_html( $f['title'] ); ?></strong>
                            <p><?php echo esc_html( $f['desc'] ); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="mh-btn mh-btn-primary">
                    <?php esc_html_e( 'Get in Touch', 'mzansi-homes' ); ?>
                </a>
            </div>
            <div class="mh-why-image">
                <div class="mh-why-img-wrap">
                    <div class="mh-why-img-placeholder">
                        <span>📸</span>
                        <p>Add image via Customizer</p>
                    </div>
                    <div class="mh-why-badge">
                        <strong>PPRA</strong>
                        <span>Registered Agency</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MEET OUR AGENTS -->
<section class="mh-section mh-agents-preview mh-bg-light">
    <div class="mh-container">
        <div class="mh-section-header">
            <div>
                <span class="mh-eyebrow"><?php esc_html_e( 'Professional Team', 'mzansi-homes' ); ?></span>
                <h2 class="mh-section-title"><?php esc_html_e( 'Meet Our Agents', 'mzansi-homes' ); ?></h2>
            </div>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'agent' ) ); ?>" class="mh-btn mh-btn-ghost">
                <?php esc_html_e( 'All Agents', 'mzansi-homes' ); ?>
            </a>
        </div>
        <div class="mh-agents-grid">
            <?php
            $agents = new WP_Query([
                'post_type'      => 'agent',
                'posts_per_page' => 4,
                'post_status'    => 'publish',
            ]);
            if ( $agents->have_posts() ) :
                while ( $agents->have_posts() ) :
                    $agents->the_post();
                    get_template_part( 'template-parts/agent', 'card' );
                endwhile;
                wp_reset_postdata();
            else :
                for ( $i = 0; $i < 4; $i++ ) get_template_part( 'template-parts/agent', 'placeholder' );
            endif;
            ?>
        </div>
    </div>
</section>

<!-- RECENT BLOG POSTS -->
<section class="mh-section mh-blog-preview">
    <div class="mh-container">
        <div class="mh-section-header">
            <div>
                <span class="mh-eyebrow"><?php esc_html_e( 'Property Insights', 'mzansi-homes' ); ?></span>
                <h2 class="mh-section-title"><?php esc_html_e( 'Latest from Our Blog', 'mzansi-homes' ); ?></h2>
            </div>
            <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="mh-btn mh-btn-ghost">
                <?php esc_html_e( 'Read All Articles', 'mzansi-homes' ); ?>
            </a>
        </div>
        <div class="mh-blog-grid">
            <?php
            $posts = new WP_Query([
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
            ]);
            if ( $posts->have_posts() ) :
                while ( $posts->have_posts() ) :
                    $posts->the_post();
                    get_template_part( 'template-parts/blog', 'card' );
                endwhile;
                wp_reset_postdata();
            else :
                for ( $i = 0; $i < 3; $i++ ) get_template_part( 'template-parts/blog', 'placeholder' );
            endif;
            ?>
        </div>
    </div>
</section>

<!-- CTA BANNER -->
<section class="mh-cta-banner">
    <div class="mh-container">
        <div class="mh-cta-inner">
            <div>
                <h2><?php esc_html_e( 'Ready to Find Your Dream Home?', 'mzansi-homes' ); ?></h2>
                <p><?php esc_html_e( 'Talk to one of our agents today — no obligation, just expert advice.', 'mzansi-homes' ); ?></p>
            </div>
            <div class="mh-cta-actions">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>" class="mh-btn mh-btn-white">
                    <?php esc_html_e( 'Browse Properties', 'mzansi-homes' ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="mh-btn mh-btn-outline-white">
                    <?php esc_html_e( 'Contact an Agent', 'mzansi-homes' ); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
