</div><!-- /#main-content -->

<footer class="mh-footer">
    <div class="mh-container">
        <div class="mh-footer-grid">

            <!-- Brand Column -->
            <div class="mh-footer-brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mh-logo-text">
                    <span class="logo-icon">🏡</span>
                    <span class="logo-primary">Mzansi</span><span class="logo-secondary">Homes</span>
                </a>
                <p class="mh-footer-tagline">
                    <?php esc_html_e( 'South Africa\'s trusted real estate partner. Helping families find their perfect home from Cape Town to Johannesburg.', 'mzansi-homes' ); ?>
                </p>
                <div class="mh-social-links">
                    <a href="#" aria-label="Facebook"  class="mh-social-btn">f</a>
                    <a href="#" aria-label="Instagram" class="mh-social-btn">in</a>
                    <a href="#" aria-label="Twitter"   class="mh-social-btn">tw</a>
                    <a href="#" aria-label="LinkedIn"  class="mh-social-btn">li</a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="mh-footer-col">
                <h4 class="mh-footer-heading"><?php esc_html_e( 'Quick Links', 'mzansi-homes' ); ?></h4>
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'menu_class'     => 'mh-footer-nav',
                    'container'      => false,
                    'fallback_cb'    => function() {
                        echo '<ul class="mh-footer-nav">';
                        $links = [
                            'Properties'   => get_post_type_archive_link( 'property' ),
                            'For Sale'     => home_url( '/properties/?status=for-sale' ),
                            'To Let'       => home_url( '/properties/?status=to-let' ),
                            'Our Agents'   => get_post_type_archive_link( 'agent' ),
                            'Blog'         => home_url( '/blog' ),
                            'Contact Us'   => home_url( '/contact' ),
                        ];
                        foreach ( $links as $label => $url ) {
                            echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
                        }
                        echo '</ul>';
                    },
                ]);
                ?>
            </div>

            <!-- Property Types -->
            <div class="mh-footer-col">
                <h4 class="mh-footer-heading"><?php esc_html_e( 'Property Types', 'mzansi-homes' ); ?></h4>
                <?php
                $types = get_terms( [ 'taxonomy' => 'property_type', 'hide_empty' => false ] );
                if ( $types && ! is_wp_error( $types ) ) :
                    echo '<ul class="mh-footer-nav">';
                    foreach ( $types as $type ) {
                        echo '<li><a href="' . esc_url( get_term_link( $type ) ) . '">' . esc_html( $type->name ) . '</a></li>';
                    }
                    echo '</ul>';
                else :
                    echo '<ul class="mh-footer-nav">';
                    $default_types = [ 'Houses', 'Apartments', 'Townhouses', 'Plots & Land', 'Commercial', 'Farms' ];
                    foreach ( $default_types as $t ) echo '<li><span>' . esc_html( $t ) . '</span></li>';
                    echo '</ul>';
                endif;
                ?>
            </div>

            <!-- Contact Info -->
            <div class="mh-footer-col">
                <h4 class="mh-footer-heading"><?php esc_html_e( 'Contact Us', 'mzansi-homes' ); ?></h4>
                <ul class="mh-contact-list">
                    <li>
                        <span class="contact-icon">📍</span>
                        <span><?php esc_html_e( '14 Long Street, Cape Town, 8001', 'mzansi-homes' ); ?></span>
                    </li>
                    <li>
                        <span class="contact-icon">📞</span>
                        <a href="tel:+27214001234"><?php esc_html_e( '+27 21 400 1234', 'mzansi-homes' ); ?></a>
                    </li>
                    <li>
                        <span class="contact-icon">✉️</span>
                        <a href="mailto:info@mzansihomes.co.za"><?php esc_html_e( 'info@mzansihomes.co.za', 'mzansi-homes' ); ?></a>
                    </li>
                    <li>
                        <span class="contact-icon">🕐</span>
                        <span><?php esc_html_e( 'Mon–Fri: 8am–5pm', 'mzansi-homes' ); ?></span>
                    </li>
                </ul>
            </div>

        </div><!-- /.mh-footer-grid -->

        <div class="mh-footer-bottom">
            <p class="mh-footer-copy">
                &copy; <?php echo date( 'Y' ); ?>
                <?php esc_html_e( ' Mzansi Homes. All rights reserved. PPRA Registered.', 'mzansi-homes' ); ?>
            </p>
            <ul class="mh-footer-legal">
                <li><a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'mzansi-homes' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/terms' ) ); ?>"><?php esc_html_e( 'Terms of Use', 'mzansi-homes' ); ?></a></li>
            </ul>
        </div>

    </div><!-- /.mh-container -->
</footer>

<?php wp_footer(); ?>
</body>
</html>
