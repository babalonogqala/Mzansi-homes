<?php
/**
 * Template Name: Contact Page
 */
get_header(); ?>

<div class="mh-page-wrap">
    <div class="mh-container">
        <?php mh_breadcrumbs(); ?>

        <div class="mh-contact-grid">
            <!-- Contact Form -->
            <div class="mh-contact-form-wrap">
                <h1><?php esc_html_e( 'Get in Touch', 'mzansi-homes' ); ?></h1>
                <p><?php esc_html_e( 'Whether you\'re buying, selling or renting — our team is ready to help. Fill in the form and we\'ll be in touch within 1 business day.', 'mzansi-homes' ); ?></p>

                <form class="mh-contact-form" id="main-contact-form">
                    <?php wp_nonce_field( 'mh_nonce', 'mh_form_nonce' ); ?>
                    <div class="mh-form-row">
                        <div class="mh-form-field">
                            <label for="contact-name"><?php esc_html_e( 'Full Name *', 'mzansi-homes' ); ?></label>
                            <input type="text" id="contact-name" name="name" required placeholder="<?php esc_attr_e( 'e.g. Sipho Dlamini', 'mzansi-homes' ); ?>" />
                        </div>
                        <div class="mh-form-field">
                            <label for="contact-email"><?php esc_html_e( 'Email Address *', 'mzansi-homes' ); ?></label>
                            <input type="email" id="contact-email" name="email" required placeholder="sipho@example.co.za" />
                        </div>
                    </div>
                    <div class="mh-form-row">
                        <div class="mh-form-field">
                            <label for="contact-phone"><?php esc_html_e( 'Phone Number', 'mzansi-homes' ); ?></label>
                            <input type="tel" id="contact-phone" name="phone" placeholder="+27 82 000 0000" />
                        </div>
                        <div class="mh-form-field">
                            <label for="contact-subject"><?php esc_html_e( 'Subject', 'mzansi-homes' ); ?></label>
                            <select id="contact-subject" name="subject">
                                <option value="buying"><?php esc_html_e( 'Buying a Property', 'mzansi-homes' ); ?></option>
                                <option value="selling"><?php esc_html_e( 'Selling a Property', 'mzansi-homes' ); ?></option>
                                <option value="renting"><?php esc_html_e( 'Renting / To Let', 'mzansi-homes' ); ?></option>
                                <option value="valuation"><?php esc_html_e( 'Property Valuation', 'mzansi-homes' ); ?></option>
                                <option value="other"><?php esc_html_e( 'Other Enquiry', 'mzansi-homes' ); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="mh-form-field">
                        <label for="contact-message"><?php esc_html_e( 'Message *', 'mzansi-homes' ); ?></label>
                        <textarea id="contact-message" name="message" rows="6" required placeholder="<?php esc_attr_e( 'Tell us how we can help you…', 'mzansi-homes' ); ?>"></textarea>
                    </div>
                    <button type="submit" class="mh-btn mh-btn-primary mh-btn-lg">
                        <?php esc_html_e( 'Send Message', 'mzansi-homes' ); ?>
                    </button>
                    <div class="mh-form-response"></div>
                </form>
            </div>

            <!-- Contact Info Sidebar -->
            <aside class="mh-contact-info">
                <div class="mh-contact-info-card">
                    <h3><?php esc_html_e( 'Contact Information', 'mzansi-homes' ); ?></h3>
                    <ul class="mh-contact-list">
                        <li>
                            <span class="contact-icon">📍</span>
                            <div>
                                <strong><?php esc_html_e( 'Office Address', 'mzansi-homes' ); ?></strong>
                                <span>14 Long Street, Cape Town, 8001</span>
                            </div>
                        </li>
                        <li>
                            <span class="contact-icon">📞</span>
                            <div>
                                <strong><?php esc_html_e( 'Phone', 'mzansi-homes' ); ?></strong>
                                <a href="tel:+27214001234">+27 21 400 1234</a>
                            </div>
                        </li>
                        <li>
                            <span class="contact-icon">💬</span>
                            <div>
                                <strong><?php esc_html_e( 'WhatsApp', 'mzansi-homes' ); ?></strong>
                                <a href="https://wa.me/27821234567" target="_blank">+27 82 123 4567</a>
                            </div>
                        </li>
                        <li>
                            <span class="contact-icon">✉️</span>
                            <div>
                                <strong><?php esc_html_e( 'Email', 'mzansi-homes' ); ?></strong>
                                <a href="mailto:info@mzansihomes.co.za">info@mzansihomes.co.za</a>
                            </div>
                        </li>
                        <li>
                            <span class="contact-icon">🕐</span>
                            <div>
                                <strong><?php esc_html_e( 'Office Hours', 'mzansi-homes' ); ?></strong>
                                <span>Mon–Fri: 8:00 – 17:00<br>Sat: 9:00 – 13:00</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="mh-contact-map">
                    <iframe src="https://maps.google.com/maps?q=Long+Street+Cape+Town&output=embed" width="100%" height="250" style="border:0;border-radius:10px;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </aside>
        </div>
    </div>
</div>

<?php get_footer(); ?>
