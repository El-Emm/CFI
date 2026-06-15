<?php
/**
 * Template Name: Partner With Us
 * Template Post Type: page
 *
 * @package CFI
 */

get_header();
?>

<main id="main">
	<header class="cfi-page-hero">
		<div class="cfi-container">
			<h1><?php esc_html_e( 'Partner With Us', 'cfi' ); ?></h1>
			<p><?php esc_html_e( 'There are many ways to stand with CharityFaith International. Choose the path that fits your heart and capacity to give.', 'cfi' ); ?></p>
		</div>
	</header>

	<?php get_template_part( 'template-parts/section', 'partners-cta' ); ?>

	<section class="cfi-section cfi-section--dark">
		<div class="cfi-container cfi-text-center">
			<img src="<?php echo esc_url( cfi_asset( 'images/cfi-logo.png' ) ); ?>" alt="" width="80" height="48" style="margin:0 auto 1.5rem;filter:brightness(0) invert(1)">
			<h2><?php esc_html_e( 'Become a Monthly Partner', 'cfi' ); ?></h2>
			<p class="cfi-section__lead"><?php esc_html_e( 'Sustained giving helps us plan crusades, food programs, and long-term community development with confidence.', 'cfi' ); ?></p>
			<a href="<?php echo esc_url( cfi_page_url( 'donate' ) ); ?>" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Set Up Monthly Giving', 'cfi' ); ?></a>
		</div>
	</section>
</main>

<?php get_footer(); ?>
