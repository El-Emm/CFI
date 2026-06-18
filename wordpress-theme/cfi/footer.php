<?php
/**
 * Footer template.
 *
 * @package CFI
 */
?>
<footer class="cfi-footer" role="contentinfo">
	<div class="cfi-container">
		<div class="cfi-footer__grid">
			<div class="cfi-footer__brand">
				<img src="<?php echo esc_url( cfi_asset( 'images/cfi-logo.png' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="cfi-footer__logo" width="120" height="72">
				<p><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
				<div class="cfi-footer__social" aria-label="<?php esc_attr_e( 'Social media', 'cfi' ); ?>">
					<?php if ( $fb = cfi_mod( 'cfi_facebook' ) ) : ?>
						<a href="<?php echo esc_url( $fb ); ?>" rel="noopener noreferrer" aria-label="Facebook">FB</a>
					<?php endif; ?>
					<?php if ( $ig = cfi_mod( 'cfi_instagram' ) ) : ?>
						<a href="<?php echo esc_url( $ig ); ?>" rel="noopener noreferrer" aria-label="Instagram">IG</a>
					<?php endif; ?>
					<?php if ( $yt = cfi_mod( 'cfi_youtube' ) ) : ?>
						<a href="<?php echo esc_url( $yt ); ?>" rel="noopener noreferrer" aria-label="YouTube">YT</a>
					<?php endif; ?>
				</div>
			</div>
			<div>
				<h4><?php esc_html_e( 'Programs', 'cfi' ); ?></h4>
				<ul class="cfi-footer__links">
					<li><a href="<?php echo esc_url( home_url( '/#programs' ) ); ?>"><?php esc_html_e( 'Healthcare Assistance', 'cfi' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#programs' ) ); ?>"><?php esc_html_e( 'Education Support', 'cfi' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#programs' ) ); ?>"><?php esc_html_e( 'Widow Empowerment', 'cfi' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#programs' ) ); ?>"><?php esc_html_e( 'Shelter Projects', 'cfi' ); ?></a></li>
				</ul>
			</div>
			<div>
				<h4><?php esc_html_e( 'Faith &amp; Prayer', 'cfi' ); ?></h4>
				<ul class="cfi-footer__links">
					<li><a href="<?php echo esc_url( cfi_page_url( 'accept-jesus' ) ); ?>"><?php esc_html_e( 'Accept Jesus Today', 'cfi' ); ?></a></li>
					<li><a href="<?php echo esc_url( cfi_page_url( 'prayer-requests' ) ); ?>"><?php esc_html_e( 'Prayer Requests', 'cfi' ); ?></a></li>
					<li><a href="<?php echo esc_url( cfi_page_url( 'donate' ) ); ?>"><?php esc_html_e( 'Donate', 'cfi' ); ?></a></li>
					<li><a href="<?php echo esc_url( cfi_page_url( 'partners' ) ); ?>"><?php esc_html_e( 'Partner With Us', 'cfi' ); ?></a></li>
				</ul>
			</div>
			<div>
				<h4><?php esc_html_e( 'Contact', 'cfi' ); ?></h4>
				<ul class="cfi-footer__links">
					<li><a href="mailto:<?php echo esc_attr( cfi_get_email() ); ?>"><?php echo esc_html( cfi_get_email() ); ?></a></li>
					<?php foreach ( cfi_get_phones() as $phone ) : ?>
						<li><a href="tel:<?php echo esc_attr( preg_replace( '/\D+/', '', $phone ) ); ?>"><?php echo esc_html( cfi_format_phone( $phone ) ); ?></a></li>
					<?php endforeach; ?>
					<li><?php echo esc_html( cfi_mod( 'cfi_address', '2727 Overlook Dr, Twinsburg, OH 44087' ) ); ?></li>
					<li><a href="<?php echo esc_url( cfi_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact Form', 'cfi' ); ?></a></li>
					<li><a href="<?php echo esc_url( cfi_blog_url() ); ?>"><?php esc_html_e( 'News & Blog', 'cfi' ); ?></a></li>
				</ul>
			</div>
		</div>
		<div class="cfi-footer__bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'cfi' ); ?></span>
			<span><?php esc_html_e( 'US-Registered Nonprofit · EIN available upon request', 'cfi' ); ?></span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
