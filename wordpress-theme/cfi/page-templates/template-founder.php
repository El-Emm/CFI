<?php
/**
 * Template Name: Founder
 * Template Post Type: page
 *
 * @package CFI
 */

get_header();
?>

<main id="main">
	<header class="cfi-page-hero">
		<div class="cfi-container">
			<span class="cfi-section__label"><?php esc_html_e( 'Founder & Visionary', 'cfi' ); ?></span>
			<h1><?php esc_html_e( 'Meet Evangelist Ebele Philips', 'cfi' ); ?></h1>
			<p><?php esc_html_e( 'Faith leader, humanitarian, and global advocate for the vulnerable.', 'cfi' ); ?></p>
		</div>
	</header>

	<section class="cfi-section">
		<div class="cfi-container">
			<div class="cfi-founder">
				<div class="cfi-founder__photo">
					<img src="<?php echo esc_url( cfi_asset( 'media/featured/founder.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Evangelist Ebele Philips blessing children during a CharityFaith International outreach', 'cfi' ); ?>" width="1500" height="2000" loading="lazy">
				</div>
				<div class="entry-content">
					<?php
					while ( have_posts() ) :
						the_post();
						if ( get_the_content() ) {
							the_content();
						} else {
							?>
							<h2><?php esc_html_e( 'Vision & Calling', 'cfi' ); ?></h2>
							<p><?php esc_html_e( 'Evangelist Ebele Philips answered a divine calling to serve those the world often overlooks — widows without support, children without school fees, families without food, and communities without hope. What began as grassroots compassion has grown into CharityFaith International, a US-registered nonprofit reaching nations across Africa and beyond.', 'cfi' ); ?></p>
							<blockquote class="cfi-founder__quote">&ldquo;<?php esc_html_e( 'Faith without action is incomplete. We are called to love in word and in deed — meeting both spiritual and physical needs.', 'cfi' ); ?>&rdquo;</blockquote>
							<h3><?php esc_html_e( 'Humanitarian Mission', 'cfi' ); ?></h3>
							<p><?php esc_html_e( 'Under her leadership, CFI delivers healthcare assistance, education support, food distribution, widow empowerment, shelter projects, small business startup support, and faith-based outreach.', 'cfi' ); ?></p>
							<h3><?php esc_html_e( 'Faith Leadership & Global Outreach', 'cfi' ); ?></h3>
							<p><?php esc_html_e( 'Evangelist Ebele has led numerous crusades and community gatherings where the gospel is shared alongside practical aid. Her ministry bridges continents — mobilizing churches, partners, and donors to fuel transformation in vulnerable communities worldwide.', 'cfi' ); ?></p>
							<?php
						}
					endwhile;
					?>
					<div class="cfi-btn-group">
						<a href="<?php echo esc_url( cfi_page_url( 'partners' ) ); ?>" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Partner With CFI', 'cfi' ); ?></a>
						<a href="<?php echo esc_url( cfi_page_url( 'contact' ) ); ?>" class="cfi-btn cfi-btn--outline"><?php esc_html_e( 'Invite to Speak', 'cfi' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="cfi-section cfi-section--ivory">
		<div class="cfi-container cfi-text-center">
			<h2><?php esc_html_e( 'Support the Vision', 'cfi' ); ?></h2>
			<p class="cfi-section__lead" style="margin:0 auto 2rem"><?php esc_html_e( 'Join Evangelist Ebele and the CFI family in bringing hope to the nations.', 'cfi' ); ?></p>
			<a href="<?php echo esc_url( cfi_page_url( 'donate' ) ); ?>" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Donate Today', 'cfi' ); ?></a>
		</div>
	</section>
</main>

<?php get_footer(); ?>
