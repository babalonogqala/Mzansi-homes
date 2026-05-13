<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<?php
$phone    = mh_get_property_meta( get_the_ID(), 'mh_agent_phone' );
$email    = mh_get_property_meta( get_the_ID(), 'mh_agent_email' );
$whatsapp = mh_get_property_meta( get_the_ID(), 'mh_agent_whatsapp' );
$license  = mh_get_property_meta( get_the_ID(), 'mh_agent_license' );
$languages= mh_get_property_meta( get_the_ID(), 'mh_agent_languages' );
$areas    = mh_get_property_meta( get_the_ID(), 'mh_agent_areas' );
?>

<div class="mh-page-wrap">
    <div class="mh-container">
        <?php mh_breadcrumbs(); ?>

        <div class="mh-agent-profile-grid">

            <!-- Agent Info Card -->
            <aside class="mh-agent-profile-card">
                <div class="mh-agent-profile-photo">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'agent-thumb', [ 'alt' => get_the_title() ] ); ?>
                    <?php else : ?>
                        <div class="mh-agent-initials mh-agent-initials-lg">
                            <?php echo esc_html( strtoupper( substr( get_the_title(), 0, 2 ) ) ); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <h1 class="mh-agent-profile-name"><?php the_title(); ?></h1>

                <?php if ( $areas ) : ?>
                    <p class="mh-agent-profile-areas">📍 <?php echo esc_html( $areas ); ?></p>
                <?php endif; ?>

                <div class="mh-agent-profile-contacts">
                    <?php if ( $phone ) : ?>
                    <a href="tel:<?php echo esc_attr( $phone ); ?>" class="mh-agent-profile-contact-btn">
                        <span>📞</span> <?php echo esc_html( $phone ); ?>
                    </a>
                    <?php endif; ?>
                    <?php if ( $email ) : ?>
                    <a href="mailto:<?php echo esc_attr( $email ); ?>" class="mh-agent-profile-contact-btn">
                        <span>✉️</span> <?php echo esc_html( $email ); ?>
                    </a>
                    <?php endif; ?>
                    <?php if ( $whatsapp ) : ?>
                    <a href="https://wa.me/<?php echo esc_attr( preg_replace( '/\D/', '', $whatsapp ) ); ?>" target="_blank" class="mh-agent-profile-contact-btn mh-wa-btn">
                        <span>💬</span> WhatsApp
                    </a>
                    <?php endif; ?>
                </div>

                <?php if ( $license || $languages ) : ?>
                <div class="mh-agent-details-list">
                    <?php if ( $license ) : ?>
                    <div class="mh-agent-detail-row">
                        <span class="mh-agent-detail-label"><?php esc_html_e( 'FFC License', 'mzansi-homes' ); ?></span>
                        <span><?php echo esc_html( $license ); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ( $languages ) : ?>
                    <div class="mh-agent-detail-row">
                        <span class="mh-agent-detail-label"><?php esc_html_e( 'Languages', 'mzansi-homes' ); ?></span>
                        <span><?php echo esc_html( $languages ); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Quick Enquiry -->
                <div class="mh-agent-enquiry-form" style="margin-top:24px;">
                    <h3 style="font-size:15px;margin-bottom:14px;"><?php esc_html_e( 'Send a Message', 'mzansi-homes' ); ?></h3>
                    <form id="agent-enquiry-form" data-property="<?php echo esc_attr( 'Agent enquiry — ' . get_the_title() ); ?>">
                        <?php wp_nonce_field( 'mh_nonce', 'mh_form_nonce' ); ?>
                        <input type="text"  name="name"    placeholder="<?php esc_attr_e( 'Your Name *', 'mzansi-homes' ); ?>" required />
                        <input type="email" name="email"   placeholder="<?php esc_attr_e( 'Email Address *', 'mzansi-homes' ); ?>" required />
                        <input type="tel"   name="phone"   placeholder="<?php esc_attr_e( 'Phone Number', 'mzansi-homes' ); ?>" />
                        <textarea name="message" rows="4"  placeholder="<?php esc_attr_e( 'Your message…', 'mzansi-homes' ); ?>" required></textarea>
                        <button type="submit" class="mh-btn mh-btn-primary mh-btn-full">
                            <?php esc_html_e( 'Send Message', 'mzansi-homes' ); ?>
                        </button>
                        <div class="mh-form-response"></div>
                    </form>
                </div>
            </aside>

            <!-- Agent Main Content -->
            <main class="mh-agent-profile-main">
                <?php if ( get_the_content() ) : ?>
                <div class="mh-agent-bio mh-prop-section">
                    <h2><?php esc_html_e( 'About', 'mzansi-homes' ); ?> <?php the_title(); ?></h2>
                    <div class="mh-prop-description">
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Agent Listings -->
                <div class="mh-prop-section">
                    <h2><?php printf( esc_html__( 'Properties by %s', 'mzansi-homes' ), get_the_title() ); ?></h2>

                    <?php
                    // In a real build you'd store agent ID on each property and query by it.
                    // This queries latest properties as a demonstration.
                    $agent_listings = new WP_Query([
                        'post_type'      => 'property',
                        'posts_per_page' => 6,
                        'post_status'    => 'publish',
                    ]);
                    ?>
                    <?php if ( $agent_listings->have_posts() ) : ?>
                        <div class="mh-property-grid">
                            <?php while ( $agent_listings->have_posts() ) : $agent_listings->the_post(); ?>
                                <?php get_template_part( 'template-parts/property', 'card' ); ?>
                            <?php endwhile; ?>
                        </div>
                        <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                        <p style="color:var(--text3);"><?php esc_html_e( 'No listings found for this agent yet.', 'mzansi-homes' ); ?></p>
                    <?php endif; ?>
                </div>
            </main>

        </div>
    </div>
</div>

<script>
jQuery('#agent-enquiry-form').on('submit', function(e) {
    e.preventDefault();
    var $form = jQuery(this);
    var $btn  = $form.find('button[type="submit"]');
    var $res  = $form.find('.mh-form-response');
    $btn.prop('disabled', true).text('Sending…');
    jQuery.post(mh_ajax.ajax_url, {
        action: 'mh_contact', nonce: mh_ajax.nonce,
        name: $form.find('[name="name"]').val(),
        email: $form.find('[name="email"]').val(),
        phone: $form.find('[name="phone"]').val(),
        message: $form.find('[name="message"]').val(),
        property: $form.data('property')
    }).done(function(res) {
        if (res.success) { $res.addClass('success').text(res.data); $form[0].reset(); }
        else { $res.addClass('error').text(res.data); }
    }).always(function() { $btn.prop('disabled', false).text('Send Message'); });
});
</script>

<?php endwhile; ?>
<?php get_footer(); ?>
