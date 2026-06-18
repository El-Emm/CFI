<?php
/**
 * Template Name: Prayer Requests
 * Template Post Type: page
 *
 * @package CFI
 */

get_header();
$prayer_shortcode = cfi_mod( 'cfi_prayer_shortcode' );
?>

<main id="main">
	<header class="cfi-page-hero cfi-page-hero--faith">
		<div class="cfi-container">
			<span class="cfi-section__label"><?php esc_html_e( 'We Stand With You', 'cfi' ); ?></span>
			<h1><?php esc_html_e( 'Prayer Requests', 'cfi' ); ?></h1>
			<p><?php esc_html_e( 'Share what is on your heart. Evangelist Ebel Philips and the CharityFaith International prayer team are believing God with you for healing, breakthrough, salvation, and restoration.', 'cfi' ); ?></p>
		</div>
	</header>

	<section class="cfi-section">
		<div class="cfi-container">
			<div class="cfi-contact-grid">
				<div class="cfi-prayer-aside">
					<h2><?php esc_html_e( 'How We Pray', 'cfi' ); ?></h2>
					<p><?php esc_html_e( 'Every request is received with compassion and confidentiality. We pray in agreement for your needs — whether spiritual, physical, emotional, or financial.', 'cfi' ); ?></p>
					<ul class="cfi-prayer-list">
						<li><?php esc_html_e( 'Healing and deliverance', 'cfi' ); ?></li>
						<li><?php esc_html_e( 'Salvation for loved ones', 'cfi' ); ?></li>
						<li><?php esc_html_e( 'Family and marriage restoration', 'cfi' ); ?></li>
						<li><?php esc_html_e( 'Provision and breakthrough', 'cfi' ); ?></li>
						<li><?php esc_html_e( 'Guidance and peace', 'cfi' ); ?></li>
					</ul>
					<p><?php esc_html_e( 'You may also call our team directly:', 'cfi' ); ?></p>
					<?php foreach ( cfi_get_phones() as $phone ) : ?>
						<p><a href="tel:<?php echo esc_attr( preg_replace( '/\D+/', '', $phone ) ); ?>" class="cfi-btn cfi-btn--outline"><?php echo esc_html( cfi_format_phone( $phone ) ); ?></a></p>
					<?php endforeach; ?>
				</div>
				<div>
					<h2><?php esc_html_e( 'Submit Your Request', 'cfi' ); ?></h2>
					<?php if ( $prayer_shortcode ) : ?>
						<?php echo do_shortcode( $prayer_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php else : ?>
						<p><?php esc_html_e( 'Install Contact Form 7 or WPForms and add your prayer form shortcode under Appearance → Customize → CFI Integrations.', 'cfi' ); ?></p>
						<form class="cfi-form cfi-prayer-form" action="#" method="post">
							<div class="cfi-form__group"><label for="prayer-name"><?php esc_html_e( 'Full Name', 'cfi' ); ?></label><input type="text" id="prayer-name" name="name" required autocomplete="name"></div>
							<div class="cfi-form__group"><label for="prayer-email"><?php esc_html_e( 'Email', 'cfi' ); ?></label><input type="email" id="prayer-email" name="email" required autocomplete="email"></div>
							<div class="cfi-form__group"><label for="prayer-phone"><?php esc_html_e( 'Phone (optional)', 'cfi' ); ?></label><input type="tel" id="prayer-phone" name="phone" autocomplete="tel"></div>
							<div class="cfi-form__group"><label for="prayer-request"><?php esc_html_e( 'Your Prayer Request', 'cfi' ); ?></label><textarea id="prayer-request" name="request" rows="6" required placeholder="<?php esc_attr_e( 'Share what you would like us to pray for…', 'cfi' ); ?>"></textarea></div>
							<button type="submit" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Submit Prayer Request', 'cfi' ); ?></button>
						</form>
						<div class="cfi-donate-notice" hidden role="status" style="margin-top:1.5rem;padding:1.25rem;background:var(--cfi-green);color:white;border-radius:var(--cfi-radius)"><?php esc_html_e( 'Thank you. Our prayer team has received your request.', 'cfi' ); ?></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>
