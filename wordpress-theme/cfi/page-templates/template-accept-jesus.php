<?php
/**
 * Template Name: Accept Jesus
 * Template Post Type: page
 *
 * @package CFI
 */

get_header();
?>

<main id="main">
	<header class="cfi-page-hero cfi-page-hero--faith">
		<div class="cfi-container">
			<span class="cfi-section__label"><?php esc_html_e( 'Salvation', 'cfi' ); ?></span>
			<h1><?php esc_html_e( 'Accept Jesus Today', 'cfi' ); ?></h1>
			<p><?php esc_html_e( 'Are you ready for Jesus to change your life? You are one prayer away from forgiveness, peace, and everlasting hope.', 'cfi' ); ?></p>
		</div>
	</header>

	<section class="cfi-section">
		<div class="cfi-container cfi-container--narrow">
			<div class="cfi-salvation-card">
				<h2><?php esc_html_e( 'The Gospel in Simple Truth', 'cfi' ); ?></h2>
				<p><?php esc_html_e( 'God loves you. Jesus Christ died for your sins, rose again, and offers you new life. You do not have to carry guilt, fear, or emptiness any longer. Turn to Him, believe in your heart, and confess Jesus as Lord.', 'cfi' ); ?></p>
				<blockquote class="cfi-founder__quote">&ldquo;<?php esc_html_e( 'If you confess with your mouth that Jesus is Lord and believe in your heart that God raised him from the dead, you will be saved.', 'cfi' ); ?>&rdquo; <cite><?php esc_html_e( 'Romans 10:9', 'cfi' ); ?></cite></blockquote>

				<h3><?php esc_html_e( 'Pray This Prayer', 'cfi' ); ?></h3>
				<p class="cfi-salvation-prayer"><?php esc_html_e( 'Lord Jesus, I admit I am a sinner. I believe You died for me and rose again. I turn from my old ways and receive You as my Savior and Lord. Fill me with Your Holy Spirit. Help me follow You all the days of my life. Amen.', 'cfi' ); ?></p>

				<div class="cfi-btn-group" style="justify-content:center;margin-top:2rem">
					<a href="<?php echo esc_url( cfi_page_url( 'prayer-requests' ) ); ?>" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Send a Prayer Request', 'cfi' ); ?></a>
					<a href="<?php echo esc_url( cfi_page_url( 'contact' ) ); ?>" class="cfi-btn cfi-btn--outline"><?php esc_html_e( 'Talk With Our Team', 'cfi' ); ?></a>
				</div>
			</div>

			<div class="cfi-salvation-steps">
				<h2><?php esc_html_e( 'Your Next Steps', 'cfi' ); ?></h2>
				<ol>
					<li><?php esc_html_e( 'Tell someone you have given your life to Christ — a pastor, friend, or our team.', 'cfi' ); ?></li>
					<li><?php esc_html_e( 'Find a Bible-believing church and grow in fellowship and prayer.', 'cfi' ); ?></li>
					<li><?php esc_html_e( 'Share your prayer requests so we can stand in faith with you.', 'cfi' ); ?></li>
					<li><?php esc_html_e( 'Walk in love by serving others as Christ has served you.', 'cfi' ); ?></li>
				</ol>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>
