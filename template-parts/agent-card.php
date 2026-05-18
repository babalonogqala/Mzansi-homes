<?php
// template-parts/agent-card.php
$phone    = mh_get_property_meta( get_the_ID(), 'mh_agent_phone' );
$email    = mh_get_property_meta( get_the_ID(), 'mh_agent_email' );
$whatsapp = mh_get_property_meta( get_the_ID(), 'mh_agent_whatsapp' );
$areas    = mh_get_property_meta( get_the_ID(), 'mh_agent_areas' );
?>
<div class="mh-agent-card">
    <div class="mh-agent-photo">
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'agent-thumb', [ 'alt' => get_the_title() ] ); ?></a>
        <?php else : ?>
            <div class="mh-agent-initials"><?php echo esc_html( strtoupper( substr( get_the_title(), 0, 2 ) ) ); ?></div>
        <?php endif; ?>
    </div>
    <div class="mh-agent-info">
        <h3 class="mh-agent-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php if ( $areas ) : ?>
        <p class="mh-agent-areas">📍 <?php echo esc_html( $areas ); ?></p>
        <?php endif; ?>
        <div class="mh-agent-contacts">
            <?php if ( $phone )    : ?><a href="tel:<?php echo esc_attr( $phone ); ?>" class="mh-agent-contact-btn">📞</a><?php endif; ?>
            <?php if ( $email )    : ?><a href="mailto:<?php echo esc_attr( $email ); ?>" class="mh-agent-contact-btn">✉️</a><?php endif; ?>
            <?php if ( $whatsapp ) : ?><a href="https://wa.me/<?php echo esc_attr( preg_replace('/\D/', '', $whatsapp) ); ?>" target="_blank" class="mh-agent-contact-btn">💬</a><?php endif; ?>
        </div>
        <a href="<?php the_permalink(); ?>" class="mh-btn mh-btn-sm mh-btn-ghost"><?php esc_html_e( 'View Profile', 'mzansi-homes' ); ?></a>
    </div>
</div>
