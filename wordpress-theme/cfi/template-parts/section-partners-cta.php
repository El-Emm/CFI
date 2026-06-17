<?php
/**
 * Partners CTA grid template part.
 *
 * @package CFI
 */
?>
<section class="cfi-section cfi-section--ivory" aria-labelledby="partner-heading">
	<div class="cfi-container">
		<header class="cfi-section__header">
			<span class="cfi-section__label"><?php esc_html_e( 'Get Involved', 'cfi' ); ?></span>
			<h2 id="partner-heading"><?php esc_html_e( 'Partner With Us', 'cfi' ); ?></h2>
			<p class="cfi-section__lead"><?php esc_html_e( 'Your generosity fuels transformation. Choose how you want to make a difference.', 'cfi' ); ?></p>
		</header>
		<div class="cfi-partner-grid">
			<div class="cfi-partner-card">
				<div class="cfi-partner-card__icon" aria-hidden="true">✝️</div>
				<h3><?php esc_html_e( 'Accept Jesus', 'cfi' ); ?></h3>
				<p><?php esc_html_e( 'Receive Christ and begin a new life of faith, forgiveness, and hope.', 'cfi' ); ?></p>
				<a href="<?php echo esc_url( cfi_page_url( 'accept-jesus' ) ); ?>" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Accept Jesus Today', 'cfi' ); ?></a>
			</div>
			<div class="cfi-partner-card">
				<div class="cfi-partner-card__icon" aria-hidden="true">🙏</div>
				<h3><?php esc_html_e( 'Prayer Requests', 'cfi' ); ?></h3>
				<p><?php esc_html_e( 'Share your need and let our team agree with you in prayer for breakthrough.', 'cfi' ); ?></p>
				<a href="<?php echo esc_url( cfi_page_url( 'prayer-requests' ) ); ?>" class="cfi-btn cfi-btn--outline"><?php esc_html_e( 'Send Request', 'cfi' ); ?></a>
			</div>
			<div class="cfi-partner-card" id="sponsor">
				<div class="cfi-partner-card__icon" aria-hidden="true">👧</div>
				<h3><?php esc_html_e( 'Sponsor a Child', 'cfi' ); ?></h3>
				<p><?php esc_html_e( 'Provide school fees, supplies, and ongoing support for a child in need.', 'cfi' ); ?></p>
				<a href="<?php echo esc_url( cfi_page_url( 'partners' ) . '#sponsor' ); ?>" class="cfi-btn cfi-btn--outline"><?php esc_html_e( 'Learn More', 'cfi' ); ?></a>
			</div>
			<div class="cfi-partner-card" id="volunteer">
				<div class="cfi-partner-card__icon" aria-hidden="true">🤝</div>
				<h3><?php esc_html_e( 'Volunteer', 'cfi' ); ?></h3>
				<p><?php esc_html_e( 'Join outreach teams, events, and local partnership opportunities.', 'cfi' ); ?></p>
				<a href="<?php echo esc_url( cfi_page_url( 'partners' ) . '#volunteer' ); ?>" class="cfi-btn cfi-btn--outline"><?php esc_html_e( 'Volunteer', 'cfi' ); ?></a>
			</div>
			<div class="cfi-partner-card" id="church">
				<div class="cfi-partner-card__icon" aria-hidden="true">⛪</div>
				<h3><?php esc_html_e( 'Church Partnerships', 'cfi' ); ?></h3>
				<p><?php esc_html_e( 'Mobilize your congregation for missions, crusades, and giving campaigns.', 'cfi' ); ?></p>
				<a href="<?php echo esc_url( cfi_page_url( 'partners' ) . '#church' ); ?>" class="cfi-btn cfi-btn--outline"><?php esc_html_e( 'Partner', 'cfi' ); ?></a>
			</div>
			<div class="cfi-partner-card" id="corporate">
				<div class="cfi-partner-card__icon" aria-hidden="true">🏢</div>
				<h3><?php esc_html_e( 'Corporate Partnerships', 'cfi' ); ?></h3>
				<p><?php esc_html_e( 'Align your organization\'s CSR goals with measurable global impact.', 'cfi' ); ?></p>
				<a href="<?php echo esc_url( cfi_page_url( 'partners' ) . '#corporate' ); ?>" class="cfi-btn cfi-btn--outline"><?php esc_html_e( 'Contact Us', 'cfi' ); ?></a>
			</div>
			<div class="cfi-partner-card">
				<div class="cfi-partner-card__icon" aria-hidden="true">📖</div>
				<h3><?php esc_html_e( 'Sponsor Education', 'cfi' ); ?></h3>
				<p><?php esc_html_e( 'Fund school fees and learning materials for children across our regions.', 'cfi' ); ?></p>
				<a href="<?php echo esc_url( cfi_page_url( 'donate' ) ); ?>" class="cfi-btn cfi-btn--outline"><?php esc_html_e( 'Give to Education', 'cfi' ); ?></a>
			</div>
		</div>
	</div>
</section>
