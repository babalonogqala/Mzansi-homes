<?php
// Fallback template — WordPress uses archive-property.php for /properties/
// and front-page.php for the homepage.
get_header();

if ( have_posts() ) :
    echo '<div class="mh-container" style="padding:48px 24px;">';
    echo '<div class="mh-property-grid">';
    while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/blog', 'card' );
    endwhile;
    echo '</div></div>';
else :
    echo '<div class="mh-container" style="padding:80px 24px;text-align:center;"><p>' . esc_html__( 'Nothing found.', 'mzansi-homes' ) . '</p></div>';
endif;

get_footer();
