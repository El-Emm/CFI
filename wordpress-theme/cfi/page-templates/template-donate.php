<?php
/**
 * Template Name: Donate
 * Template Post Type: page
 *
 * @package CFI
 */

get_header();
$give_shortcode = cfi_mod( 'cfi_give_shortcode' );
?>

<main id="main">
	<header class="cfi-page-hero">
		<div class="cfi-container">
			<img src="<?php echo esc_url( cfi_asset( 'images/cfi-logo.png' ) ); ?>" alt="" width="100" height="60" style="margin:0 auto 1.5rem">
			<h1><?php esc_html_e( 'Give Hope Today', 'cfi' ); ?></h1>
			<p><?php esc_html_e( 'Your tax-deductible gift (where applicable) funds life-changing programs for vulnerable families worldwide.', 'cfi' ); ?></p>
		</div>
	</header>

	<section class="cfi-section">
		<div class="cfi-container">
			<div class="cfi-donate-grid">
				<div>
					<?php if ( $give_shortcode ) : ?>
						<div class="cfi-givewp-wrap">
							<?php echo do_shortcode( $give_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					<?php else : ?>
						<h2><?php esc_html_e( 'Choose Your Fund', 'cfi' ); ?></h2>
						<p style="margin-bottom:1.5rem"><?php esc_html_e( 'Install GiveWP and add your donation form shortcode under Appearance → Customize → CFI Integrations.', 'cfi' ); ?></p>
						<form class="cfi-donate-form" action="#" method="post">
							<fieldset class="cfi-fund-cards" style="border:none;padding:0;margin:0 0 2rem">
								<label class="cfi-fund-card is-selected"><input type="radio" name="fund" value="general" checked><h3><?php esc_html_e( 'General Impact Fund', 'cfi' ); ?></h3><p><?php esc_html_e( 'Where needed most across all CFI programs.', 'cfi' ); ?></p></label>
								<label class="cfi-fund-card"><input type="radio" name="fund" value="healthcare"><h3><?php esc_html_e( 'Healthcare Fund', 'cfi' ); ?></h3><p><?php esc_html_e( 'Hospital bills and urgent medical assistance.', 'cfi' ); ?></p></label>
								<label class="cfi-fund-card"><input type="radio" name="fund" value="education"><h3><?php esc_html_e( 'Education Fund', 'cfi' ); ?></h3><p><?php esc_html_e( 'School fees and learning access for children.', 'cfi' ); ?></p></label>
								<label class="cfi-fund-card"><input type="radio" name="fund" value="food"><h3><?php esc_html_e( 'Food Relief Fund', 'cfi' ); ?></h3><p><?php esc_html_e( 'Meals and food support for families in crisis.', 'cfi' ); ?></p></label>
								<label class="cfi-fund-card"><input type="radio" name="fund" value="widow"><h3><?php esc_html_e( 'Widow Empowerment Fund', 'cfi' ); ?></h3><p><?php esc_html_e( 'Livelihoods, skills, and financial support for widows.', 'cfi' ); ?></p></label>
								<label class="cfi-fund-card"><input type="radio" name="fund" value="shelter"><h3><?php esc_html_e( 'Shelter Fund', 'cfi' ); ?></h3><p><?php esc_html_e( 'Safe housing builds and home improvements.', 'cfi' ); ?></p></label>
							</fieldset>
							<div class="cfi-amount-grid" role="group" aria-label="<?php esc_attr_e( 'Donation amount', 'cfi' ); ?>">
								<button type="button" class="cfi-amount-btn" data-amount="25">$25</button>
								<button type="button" class="cfi-amount-btn is-selected" data-amount="50">$50</button>
								<button type="button" class="cfi-amount-btn" data-amount="100">$100</button>
								<button type="button" class="cfi-amount-btn" data-amount="250">$250</button>
								<button type="button" class="cfi-amount-btn" data-amount="500">$500</button>
								<button type="button" class="cfi-amount-btn" data-amount="1000">$1,000</button>
							</div>
							<div class="cfi-form__group"><label for="donate-custom"><?php esc_html_e( 'Custom Amount', 'cfi' ); ?></label><input type="number" id="donate-custom" name="amount" min="1" step="1" value="50"></div>
							<button type="submit" class="cfi-btn cfi-btn--primary" style="width:100%"><?php esc_html_e( 'Proceed to Secure Giving', 'cfi' ); ?></button>
						</form>
						<div class="cfi-donate-notice" hidden tabindex="-1" role="status" style="margin-top:2rem;padding:1.25rem;background:var(--cfi-green);color:white;border-radius:var(--cfi-radius)"><?php esc_html_e( 'Thank you! Connect GiveWP to accept live donations.', 'cfi' ); ?></div>
					<?php endif; ?>
					<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
				</div>
				<aside class="cfi-donate-sidebar">
					<img src="<?php echo esc_url( cfi_asset( 'images/cfi-logo.png' ) ); ?>" alt="" class="cfi-logo__img" style="display:block;margin:0 auto">
					<h3 style="text-align:center;margin:1rem 0"><?php esc_html_e( 'Why Give to CFI?', 'cfi' ); ?></h3>
					<ul style="padding-left:1.25rem;font-size:0.9375rem">
						<li><?php esc_html_e( 'US-registered nonprofit with transparent impact', 'cfi' ); ?></li>
						<li><?php esc_html_e( 'Faith-driven, practically focused humanitarian work', 'cfi' ); ?></li>
						<li><?php esc_html_e( 'Programs spanning healthcare, education, food, widows & shelter', 'cfi' ); ?></li>
						<li><?php esc_html_e( 'Founded by Evangelist Ebele Philips', 'cfi' ); ?></li>
					</ul>
					<img src="<?php echo esc_url( cfi_asset( 'media/featured/hero-2.jpg' ) ); ?>" alt="" width="400" height="260" loading="lazy" style="border-radius:var(--cfi-radius);margin-top:1.5rem;width:100%">
				</aside>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>
