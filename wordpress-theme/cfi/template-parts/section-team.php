<?php
/**
 * Team section for Founder page.
 *
 * @package CFI
 */
?>
<section class="cfi-section cfi-section--ivory" id="team" aria-labelledby="team-heading">
	<div class="cfi-container">
		<header class="cfi-section__header">
			<span class="cfi-section__label"><?php esc_html_e( 'Our Team', 'cfi' ); ?></span>
			<h2 id="team-heading"><?php esc_html_e( 'Leadership &amp; Ministry Team', 'cfi' ); ?></h2>
			<p class="cfi-section__lead"><?php esc_html_e( 'Faithful leaders serving alongside Evangelist Ebel Philips to advance compassion, healing, and the gospel worldwide.', 'cfi' ); ?></p>
		</header>
		<div class="cfi-team__grid">
			<article class="cfi-team-card">
				<div class="cfi-team-card__photo">
					<img src="<?php echo esc_url( cfi_asset( 'media/featured/team-uchenna-ojukwu.png' ) ); ?>" alt="<?php esc_attr_e( 'Dr. Uchenna Collins Ojukwu', 'cfi' ); ?>" width="600" height="800" loading="lazy">
				</div>
				<div class="cfi-team-card__body">
					<h3 class="cfi-team-card__name"><?php esc_html_e( 'Dr. Uchenna Collins Ojukwu', 'cfi' ); ?></h3>
					<p class="cfi-team-card__role"><?php esc_html_e( 'Pastor, Charity Faith International', 'cfi' ); ?></p>
					<p><?php esc_html_e( 'Dr. Uchenna Collins Ojukwu is a Pastor, medical professional, public health advocate, and humanitarian leader committed to advancing both spiritual and physical well-being. He serves with Charity Faith International, where he promotes evangelism, discipleship, medical missions, and community outreach.', 'cfi' ); ?></p>
					<p><?php esc_html_e( 'As a researcher, author, and scientific reviewer, he has contributed to numerous peer-reviewed publications in public health and infectious diseases. He has led medical missions and humanitarian programs among underserved communities across different nations. His mission is to bring hope, healing, and the love of Christ to people through faith, service, and compassionate action.', 'cfi' ); ?></p>
				</div>
			</article>
		</div>
	</div>
</section>
