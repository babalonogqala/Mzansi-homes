<?php
/**
 * Mzansi Homes — functions.php
 * Theme setup, custom post types, taxonomies, ACF fields, widgets, helpers
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'MH_VERSION', '1.0.0' );
define( 'MH_DIR',     get_template_directory() );
define( 'MH_URI',     get_template_directory_uri() );

/* ═══════════════════════════════════════════════
   1. THEME SETUP
═══════════════════════════════════════════════ */
function mh_setup() {
    load_theme_textdomain( 'mzansi-homes', MH_DIR . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_image_size( 'property-card',  600, 420, true );
    add_image_size( 'property-hero', 1200, 700, true );
    add_image_size( 'agent-thumb',    300, 300, true );

    register_nav_menus([
        'primary' => __( 'Primary Navigation', 'mzansi-homes' ),
        'footer'  => __( 'Footer Navigation',  'mzansi-homes' ),
    ]);
}
add_action( 'after_setup_theme', 'mh_setup' );

/* ═══════════════════════════════════════════════
   2. ENQUEUE STYLES & SCRIPTS
═══════════════════════════════════════════════ */
function mh_enqueue() {
    wp_enqueue_style( 'google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap',
        [], null );
    wp_enqueue_style( 'mh-main', MH_URI . '/css/main.css', [], MH_VERSION );

    wp_enqueue_script( 'mh-main', MH_URI . '/js/main.js', [ 'jquery' ], MH_VERSION, true );

    wp_localize_script( 'mh-main', 'mh_ajax', [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'mh_nonce' ),
    ]);
}
add_action( 'wp_enqueue_scripts', 'mh_enqueue' );

/* ═══════════════════════════════════════════════
   3. CUSTOM POST TYPE — PROPERTY
═══════════════════════════════════════════════ */
function mh_register_property_cpt() {
    $labels = [
        'name'               => 'Properties',
        'singular_name'      => 'Property',
        'add_new'            => 'Add Property',
        'add_new_item'       => 'Add New Property',
        'edit_item'          => 'Edit Property',
        'view_item'          => 'View Property',
        'search_items'       => 'Search Properties',
        'not_found'          => 'No properties found.',
        'menu_name'          => 'Properties',
    ];
    register_post_type( 'property', [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => [ 'slug' => 'properties' ],
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'menu_icon'          => 'dashicons-building',
        'menu_position'      => 5,
        'show_in_rest'       => true,
    ]);
}
add_action( 'init', 'mh_register_property_cpt' );

/* ═══════════════════════════════════════════════
   4. CUSTOM POST TYPE — AGENT
═══════════════════════════════════════════════ */
function mh_register_agent_cpt() {
    $labels = [
        'name'          => 'Agents',
        'singular_name' => 'Agent',
        'add_new_item'  => 'Add New Agent',
        'edit_item'     => 'Edit Agent',
        'menu_name'     => 'Agents',
    ];
    register_post_type( 'agent', [
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'agents' ],
        'supports'      => [ 'title', 'editor', 'thumbnail' ],
        'menu_icon'     => 'dashicons-businessman',
        'menu_position' => 6,
        'show_in_rest'  => true,
    ]);
}
add_action( 'init', 'mh_register_agent_cpt' );

/* ═══════════════════════════════════════════════
   5. TAXONOMIES
═══════════════════════════════════════════════ */
function mh_register_taxonomies() {
    // Property Type (House, Apartment, Townhouse…)
    register_taxonomy( 'property_type', 'property', [
        'label'        => 'Property Type',
        'rewrite'      => [ 'slug' => 'property-type' ],
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);
    // Location / Province
    register_taxonomy( 'property_location', 'property', [
        'label'        => 'Location',
        'rewrite'      => [ 'slug' => 'location' ],
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);
    // Status (For Sale, To Let, Sold)
    register_taxonomy( 'property_status', 'property', [
        'label'        => 'Status',
        'rewrite'      => [ 'slug' => 'status' ],
        'hierarchical' => false,
        'show_in_rest' => true,
    ]);
}
add_action( 'init', 'mh_register_taxonomies' );

/* ═══════════════════════════════════════════════
   6. PROPERTY META BOXES
═══════════════════════════════════════════════ */
function mh_add_meta_boxes() {
    add_meta_box( 'mh_property_details', 'Property Details', 'mh_property_details_cb', 'property', 'normal', 'high' );
    add_meta_box( 'mh_agent_details',    'Agent Details',    'mh_agent_details_cb',    'agent',    'normal', 'high' );
}
add_action( 'add_meta_boxes', 'mh_add_meta_boxes' );

function mh_property_details_cb( $post ) {
    wp_nonce_field( 'mh_property_nonce', 'mh_property_nonce' );
    $fields = [
        'mh_price'        => [ 'label' => 'Price (ZAR)',        'type' => 'number' ],
        'mh_bedrooms'     => [ 'label' => 'Bedrooms',           'type' => 'number' ],
        'mh_bathrooms'    => [ 'label' => 'Bathrooms',          'type' => 'number' ],
        'mh_garages'      => [ 'label' => 'Garages',            'type' => 'number' ],
        'mh_floor_size'   => [ 'label' => 'Floor Size (m²)',    'type' => 'number' ],
        'mh_erf_size'     => [ 'label' => 'Erf Size (m²)',      'type' => 'number' ],
        'mh_address'      => [ 'label' => 'Street Address',     'type' => 'text'   ],
        'mh_suburb'       => [ 'label' => 'Suburb',             'type' => 'text'   ],
        'mh_city'         => [ 'label' => 'City',               'type' => 'text'   ],
        'mh_province'     => [ 'label' => 'Province',           'type' => 'text'   ],
        'mh_google_maps'  => [ 'label' => 'Google Maps Embed URL', 'type' => 'url' ],
        'mh_virtual_tour' => [ 'label' => 'Virtual Tour URL',   'type' => 'url'    ],
        'mh_levy'         => [ 'label' => 'Levy (R/month)',     'type' => 'number' ],
        'mh_rates'        => [ 'label' => 'Rates & Taxes (R/month)', 'type' => 'number' ],
        'mh_ref'          => [ 'label' => 'Reference Number',   'type' => 'text'   ],
    ];
    echo '<div class="mh-meta-grid">';
    foreach ( $fields as $key => $field ) {
        $val = get_post_meta( $post->ID, $key, true );
        printf(
            '<div class="mh-meta-field"><label for="%1$s">%2$s</label><input type="%3$s" id="%1$s" name="%1$s" value="%4$s" /></div>',
            esc_attr( $key ),
            esc_html( $field['label'] ),
            esc_attr( $field['type'] ),
            esc_attr( $val )
        );
    }
    echo '</div>';

    // Features checkboxes
    $features = [ 'Pool', 'Garden', 'Security Estate', 'Fibre Ready', 'Solar', 'Backup Water', 'Pet Friendly', 'Flatlet', 'Staff Quarters', 'Borehole' ];
    $saved = get_post_meta( $post->ID, 'mh_features', true ) ?: [];
    echo '<div class="mh-features-label"><strong>Features</strong></div><div class="mh-features-grid">';
    foreach ( $features as $feature ) {
        $checked = in_array( $feature, (array) $saved ) ? 'checked' : '';
        printf(
            '<label class="mh-checkbox"><input type="checkbox" name="mh_features[]" value="%1$s" %2$s /> %1$s</label>',
            esc_html( $feature ), $checked
        );
    }
    echo '</div>';
}

function mh_agent_details_cb( $post ) {
    wp_nonce_field( 'mh_agent_nonce', 'mh_agent_nonce' );
    $fields = [
        'mh_agent_phone'     => 'Phone Number',
        'mh_agent_email'     => 'Email Address',
        'mh_agent_whatsapp'  => 'WhatsApp Number',
        'mh_agent_license'   => 'FFC License Number',
        'mh_agent_languages' => 'Languages Spoken',
        'mh_agent_areas'     => 'Areas Covered',
    ];
    echo '<div class="mh-meta-grid">';
    foreach ( $fields as $key => $label ) {
        $val = get_post_meta( $post->ID, $key, true );
        printf(
            '<div class="mh-meta-field"><label for="%1$s">%2$s</label><input type="text" id="%1$s" name="%1$s" value="%3$s" /></div>',
            esc_attr( $key ), esc_html( $label ), esc_attr( $val )
        );
    }
    echo '</div>';
}

/* ═══════════════════════════════════════════════
   7. SAVE META BOXES
═══════════════════════════════════════════════ */
function mh_save_meta( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // Property meta
    if ( isset( $_POST['mh_property_nonce'] ) && wp_verify_nonce( $_POST['mh_property_nonce'], 'mh_property_nonce' ) ) {
        $property_fields = [ 'mh_price','mh_bedrooms','mh_bathrooms','mh_garages','mh_floor_size',
            'mh_erf_size','mh_address','mh_suburb','mh_city','mh_province','mh_google_maps',
            'mh_virtual_tour','mh_levy','mh_rates','mh_ref' ];
        foreach ( $property_fields as $field ) {
            if ( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
            }
        }
        $features = isset( $_POST['mh_features'] ) ? array_map( 'sanitize_text_field', $_POST['mh_features'] ) : [];
        update_post_meta( $post_id, 'mh_features', $features );
    }

    // Agent meta
    if ( isset( $_POST['mh_agent_nonce'] ) && wp_verify_nonce( $_POST['mh_agent_nonce'], 'mh_agent_nonce' ) ) {
        $agent_fields = [ 'mh_agent_phone','mh_agent_email','mh_agent_whatsapp','mh_agent_license','mh_agent_languages','mh_agent_areas' ];
        foreach ( $agent_fields as $field ) {
            if ( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
            }
        }
    }
}
add_action( 'save_post', 'mh_save_meta' );

/* ═══════════════════════════════════════════════
   8. AJAX PROPERTY SEARCH
═══════════════════════════════════════════════ */
function mh_ajax_search() {
    check_ajax_referer( 'mh_nonce', 'nonce' );

    $args = [
        'post_type'      => 'property',
        'posts_per_page' => 12,
        'post_status'    => 'publish',
        'paged'          => max( 1, intval( $_POST['page'] ?? 1 ) ),
    ];

    $meta_query = [ 'relation' => 'AND' ];
    $tax_query  = [];

    if ( ! empty( $_POST['min_price'] ) ) {
        $meta_query[] = [ 'key' => 'mh_price', 'value' => intval( $_POST['min_price'] ), 'compare' => '>=', 'type' => 'NUMERIC' ];
    }
    if ( ! empty( $_POST['max_price'] ) ) {
        $meta_query[] = [ 'key' => 'mh_price', 'value' => intval( $_POST['max_price'] ), 'compare' => '<=', 'type' => 'NUMERIC' ];
    }
    if ( ! empty( $_POST['bedrooms'] ) ) {
        $meta_query[] = [ 'key' => 'mh_bedrooms', 'value' => intval( $_POST['bedrooms'] ), 'compare' => '>=', 'type' => 'NUMERIC' ];
    }
    if ( ! empty( $_POST['property_type'] ) ) {
        $tax_query[] = [ 'taxonomy' => 'property_type', 'field' => 'slug', 'terms' => sanitize_text_field( $_POST['property_type'] ) ];
    }
    if ( ! empty( $_POST['status'] ) ) {
        $tax_query[] = [ 'taxonomy' => 'property_status', 'field' => 'slug', 'terms' => sanitize_text_field( $_POST['status'] ) ];
    }
    if ( ! empty( $_POST['location'] ) ) {
        $tax_query[] = [ 'taxonomy' => 'property_location', 'field' => 'slug', 'terms' => sanitize_text_field( $_POST['location'] ) ];
    }
    if ( ! empty( $_POST['keyword'] ) ) {
        $args['s'] = sanitize_text_field( $_POST['keyword'] );
    }

    if ( count( $meta_query ) > 1 ) $args['meta_query'] = $meta_query;
    if ( ! empty( $tax_query ) )    $args['tax_query']  = $tax_query;

    $query = new WP_Query( $args );
    ob_start();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/property', 'card' );
        }
    } else {
        echo '<div class="mh-no-results"><p>No properties found matching your search. Try adjusting your filters.</p></div>';
    }

    $html = ob_get_clean();
    wp_reset_postdata();

    wp_send_json_success([
        'html'       => $html,
        'found'      => $query->found_posts,
        'max_pages'  => $query->max_num_pages,
        'current'    => intval( $_POST['page'] ?? 1 ),
    ]);
}
add_action( 'wp_ajax_mh_search',        'mh_ajax_search' );
add_action( 'wp_ajax_nopriv_mh_search', 'mh_ajax_search' );

/* ═══════════════════════════════════════════════
   9. CONTACT FORM AJAX
═══════════════════════════════════════════════ */
function mh_ajax_contact() {
    check_ajax_referer( 'mh_nonce', 'nonce' );

    $name       = sanitize_text_field( $_POST['name']    ?? '' );
    $email      = sanitize_email(      $_POST['email']   ?? '' );
    $phone      = sanitize_text_field( $_POST['phone']   ?? '' );
    $message    = sanitize_textarea_field( $_POST['message'] ?? '' );
    $property   = sanitize_text_field( $_POST['property'] ?? '' );

    if ( ! $name || ! $email || ! $message ) {
        wp_send_json_error( 'Please fill in all required fields.' );
    }
    if ( ! is_email( $email ) ) {
        wp_send_json_error( 'Please enter a valid email address.' );
    }

    $to      = get_option( 'admin_email' );
    $subject = $property ? "Enquiry about: $property" : "Website Enquiry from $name";
    $body    = "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";
    $headers = [ "Reply-To: $name <$email>", 'Content-Type: text/plain; charset=UTF-8' ];

    $sent = wp_mail( $to, $subject, $body, $headers );
    if ( $sent ) {
        wp_send_json_success( 'Thank you! We will be in touch shortly.' );
    } else {
        wp_send_json_error( 'Message could not be sent. Please try again.' );
    }
}
add_action( 'wp_ajax_mh_contact',        'mh_ajax_contact' );
add_action( 'wp_ajax_nopriv_mh_contact', 'mh_ajax_contact' );

/* ═══════════════════════════════════════════════
   10. HELPER FUNCTIONS
═══════════════════════════════════════════════ */
function mh_format_price( $price ) {
    if ( ! $price ) return 'Price on Application';
    return 'R ' . number_format( (float) $price, 0, '.', ' ' );
}

function mh_get_property_meta( $post_id, $key ) {
    return get_post_meta( $post_id, $key, true );
}

function mh_get_features( $post_id ) {
    return get_post_meta( $post_id, 'mh_features', true ) ?: [];
}

function mh_breadcrumbs() {
    echo '<nav class="mh-breadcrumbs" aria-label="Breadcrumb"><ol>';
    echo '<li><a href="' . home_url() . '">Home</a></li>';
    if ( is_singular( 'property' ) ) {
        echo '<li><a href="' . get_post_type_archive_link( 'property' ) . '">Properties</a></li>';
        echo '<li aria-current="page">' . get_the_title() . '</li>';
    } elseif ( is_singular( 'agent' ) ) {
        echo '<li><a href="' . get_post_type_archive_link( 'agent' ) . '">Agents</a></li>';
        echo '<li aria-current="page">' . get_the_title() . '</li>';
    } elseif ( is_single() ) {
        echo '<li><a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">Blog</a></li>';
        echo '<li aria-current="page">' . get_the_title() . '</li>';
    } else {
        echo '<li aria-current="page">' . get_the_title() . '</li>';
    }
    echo '</ol></nav>';
}

/* ═══════════════════════════════════════════════
   11. WIDGET AREAS
═══════════════════════════════════════════════ */
function mh_register_sidebars() {
    register_sidebar([
        'name'          => 'Blog Sidebar',
        'id'            => 'blog-sidebar',
        'before_widget' => '<div class="mh-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    register_sidebar([
        'name'          => 'Footer Col 1',
        'id'            => 'footer-1',
        'before_widget' => '<div class="mh-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);
    register_sidebar([
        'name'          => 'Footer Col 2',
        'id'            => 'footer-2',
        'before_widget' => '<div class="mh-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ]);
}
add_action( 'widgets_init', 'mh_register_sidebars' );

/* ═══════════════════════════════════════════════
   12. ADMIN META BOX STYLES
═══════════════════════════════════════════════ */
function mh_admin_styles() {
    echo '<style>
        .mh-meta-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; padding:12px 0; }
        .mh-meta-field label { display:block; font-weight:600; margin-bottom:4px; font-size:12px; }
        .mh-meta-field input { width:100%; padding:6px 8px; border:1px solid #ddd; border-radius:4px; }
        .mh-features-label { margin:16px 0 8px; font-weight:600; }
        .mh-features-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:8px; }
        .mh-checkbox { display:flex; align-items:center; gap:6px; font-size:13px; cursor:pointer; }
    </style>';
}
add_action( 'admin_head', 'mh_admin_styles' );

/* ═══════════════════════════════════════════════
   13. FLUSH REWRITE RULES ON ACTIVATION
═══════════════════════════════════════════════ */
function mh_activate() {
    mh_register_property_cpt();
    mh_register_agent_cpt();
    mh_register_taxonomies();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'mh_activate' );

/* ═══════════════════════════════════════════════
   14. CUSTOM EXCERPT LENGTH
═══════════════════════════════════════════════ */
add_filter( 'excerpt_length', fn() => 25 );
add_filter( 'excerpt_more',   fn() => '…' );

// Enqueue agent profile CSS
function mh_enqueue_extra() {
    if ( is_singular( 'agent' ) || is_post_type_archive( 'agent' ) ) {
        wp_enqueue_style( 'mh-agent-profile', MH_URI . '/css/agent-profile.css', [ 'mh-main' ], MH_VERSION );
    }
}
add_action( 'wp_enqueue_scripts', 'mh_enqueue_extra' );
