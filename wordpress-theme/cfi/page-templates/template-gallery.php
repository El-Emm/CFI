<?php
/**
 * Template Name: Media Gallery
 * Template Post Type: page
 *
 * @package CFI
 */

get_header();
?>

<main id="main">
	<header class="cfi-page-hero">
		<div class="cfi-container">
			<h1><?php esc_html_e( 'Photo & Video Gallery', 'cfi' ); ?></h1>
			<p><?php esc_html_e( 'Authentic moments from the field across nine nations — Zimbabwe, Namibia, Lesotho, South Africa, Nigeria, The Philippines, Niger Republic, Botswana, and Malawi.', 'cfi' ); ?></p>
		</div>
	</header>

	<section class="cfi-section cfi-section--ivory">
		<div class="cfi-container">
			<header class="cfi-section__header">
				<span class="cfi-section__label"><?php esc_html_e( 'Global Field Work', 'cfi' ); ?></span>
				<h2><?php esc_html_e( 'Countries We Serve', 'cfi' ); ?></h2>
			</header>
			<div id="cfi-countries-grid" class="cfi-countries-grid" aria-label="<?php esc_attr_e( 'Countries served', 'cfi' ); ?>"></div>
		</div>
	</section>

	<section class="cfi-section">
		<div class="cfi-container">
			<div class="cfi-gallery-filters cfi-gallery-filters--row">
				<span class="cfi-gallery-filters__label"><?php esc_html_e( 'Filter by country', 'cfi' ); ?></span>
				<div id="cfi-country-filters" class="cfi-gallery-filters" role="tablist"></div>
			</div>
			<div class="cfi-gallery-filters cfi-gallery-filters--row">
				<span class="cfi-gallery-filters__label"><?php esc_html_e( 'Filter by program', 'cfi' ); ?></span>
				<div id="cfi-category-filters" class="cfi-gallery-filters" role="tablist"></div>
			</div>
			<div id="cfi-gallery-grid" class="cfi-gallery-grid" aria-live="polite">
				<p class="cfi-gallery-empty"><?php esc_html_e( 'Loading gallery…', 'cfi' ); ?></p>
			</div>
			<p id="cfi-gallery-empty" class="cfi-gallery-empty" hidden><?php esc_html_e( 'No media matches these filters.', 'cfi' ); ?></p>
		</div>
	</section>
</main>

<div class="cfi-lightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Media viewer', 'cfi' ); ?>">
	<button type="button" class="cfi-lightbox__close" aria-label="<?php esc_attr_e( 'Close', 'cfi' ); ?>">&times;</button>
	<div class="cfi-lightbox__content"></div>
</div>

<?php get_footer(); ?>
