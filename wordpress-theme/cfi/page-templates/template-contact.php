<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * @package CFI
 */

get_header();
$contact_shortcode = cfi_mod( 'cfi_contact_shortcode' );
$map_query         = rawurlencode( '2727 Overlook Dr, Twinsburg, OH 44087' );
?>

<main id="main">
	<header class="cfi-page-hero">
		<div class="cfi-container">
			<h1><?php esc_html_e( 'Contact Us', 'cfi' ); ?></h1>
			<p><?php esc_html_e( 'We would love to hear from you. Reach out for donations, partnerships, volunteering, prayer requests, or media inquiries.', 'cfi' ); ?></p>
		</div>
	</header>

	<section class="cfi-section">
		<div class="cfi-container">
			<div class="cfi-contact-grid">
				<div class="cfi-contact-info">
					<div class="cfi-contact-info__item">
						<div class="cfi-contact-info__icon" aria-hidden="true">✉</div>
						<div>
							<h3><?php esc_html_e( 'Email', 'cfi' ); ?></h3>
							<p><a href="mailto:<?php echo esc_attr( cfi_get_email() ); ?>"><?php echo esc_html( cfi_get_email() ); ?></a></p>
						</div>
					</div>
					<div class="cfi-contact-info__item">
						<div class="cfi-contact-info__icon" aria-hidden="true">☎</div>
						<div>
							<h3><?php esc_html_e( 'Phone', 'cfi' ); ?></h3>
							<?php foreach ( cfi_get_phones() as $phone ) : ?>
								<p><a href="tel:<?php echo esc_attr( preg_replace( '/\D+/', '', $phone ) ); ?>"><?php echo esc_html( cfi_format_phone( $phone ) ); ?></a></p>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="cfi-contact-info__item">
						<div class="cfi-contact-info__icon" aria-hidden="true">📍</div>
						<div>
							<h3><?php esc_html_e( 'Office', 'cfi' ); ?></h3>
							<p>2727 Overlook Dr<br>Twinsburg, Ohio 44087<br>United States</p>
						</div>
					</div>
					<div class="cfi-map-wrap" style="margin-top:1rem;padding:0;overflow:hidden">
						<iframe class="cfi-contact-map" title="<?php esc_attr_e( 'Office location', 'cfi' ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q=<?php echo esc_attr( $map_query ); ?>&amp;output=embed"></iframe>
					</div>
				</div>
				<div>
					<h2><?php esc_html_e( 'Send a Message', 'cfi' ); ?></h2>
					<?php if ( $contact_shortcode ) : ?>
						<?php echo do_shortcode( $contact_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php else : ?>
						<p><?php esc_html_e( 'Install Contact Form 7 or WPForms and add the shortcode under Appearance → Customize → CFI Integrations.', 'cfi' ); ?></p>
						<form class="cfi-form cfi-contact-form" action="#" method="post">
							<div class="cfi-form__group"><label for="name"><?php esc_html_e( 'Full Name', 'cfi' ); ?></label><input type="text" id="name" name="name" required></div>
							<div class="cfi-form__group"><label for="email"><?php esc_html_e( 'Email', 'cfi' ); ?></label><input type="email" id="email" name="email" required></div>
							<div class="cfi-form__group"><label for="message"><?php esc_html_e( 'Message', 'cfi' ); ?></label><textarea id="message" name="message" required></textarea></div>
							<button type="submit" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Send Message', 'cfi' ); ?></button>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>
