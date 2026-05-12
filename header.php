<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'mzansi-homes' ); ?></a>

<header class="mh-header" id="site-header">
    <div class="mh-container">
        <div class="mh-header-inner">

            <!-- Logo -->
            <div class="mh-logo">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mh-logo-text">
                        <span class="logo-icon">🏡</span>
                        <span class="logo-primary">Mzansi</span><span class="logo-secondary">Homes</span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Primary Nav -->
            <nav class="mh-nav" id="primary-nav" aria-label="Primary navigation">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class'     => 'mh-nav-list',
                    'container'      => false,
                    'fallback_cb'    => 'mh_fallback_nav',
                ]);
                ?>
            </nav>

            <!-- Header CTA -->
            <div class="mh-header-cta">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>" class="mh-btn mh-btn-ghost">
                    <?php esc_html_e( 'View Listings', 'mzansi-homes' ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="mh-btn mh-btn-primary">
                    <?php esc_html_e( 'Contact Us', 'mzansi-homes' ); ?>
                </a>
            </div>

            <!-- Mobile Toggle -->
            <button class="mh-mobile-toggle" id="mobile-toggle" aria-label="Toggle navigation" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>

        </div>
    </div>
</header>

<?php
function mh_fallback_nav() {
    echo '<ul class="mh-nav-list">';
    echo '<li><a href="' . home_url( '/' ) . '">Home</a></li>';
    echo '<li><a href="' . get_post_type_archive_link( 'property' ) . '">Properties</a></li>';
    echo '<li><a href="' . get_post_type_archive_link( 'agent' ) . '">Agents</a></li>';
    echo '<li><a href="' . home_url( '/blog' ) . '">Blog</a></li>';
    echo '<li><a href="' . home_url( '/contact' ) . '">Contact</a></li>';
    echo '</ul>';
}
?>

<div id="main-content">
