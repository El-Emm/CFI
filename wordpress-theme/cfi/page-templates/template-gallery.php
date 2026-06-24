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

	<section class="cfi-section">
		<div class="cfi-container">
			<div id="cfi-gallery-toolbar" class="cfi-gallery-toolbar">
				<header class="cfi-section__header">
					<span class="cfi-section__label"><?php esc_html_e( 'Browse by Location', 'cfi' ); ?></span>
					<h2><?php esc_html_e( 'Filter Field Media', 'cfi' ); ?></h2>
					<p class="cfi-section__lead"><?php esc_html_e( 'Choose a country and program to view photos and videos from that outreach. Counts update as you filter.', 'cfi' ); ?></p>
				</header>
				<div id="cfi-countries-grid" class="cfi-countries-grid" aria-label="<?php esc_attr_e( 'Countries served', 'cfi' ); ?>"></div>
				<div class="cfi-gallery-filters cfi-gallery-filters--row">
					<span class="cfi-gallery-filters__label"><?php esc_html_e( 'Program / cause', 'cfi' ); ?></span>
					<div id="cfi-category-filters" class="cfi-gallery-filters" role="tablist" aria-label="<?php esc_attr_e( 'Filter by program', 'cfi' ); ?>"></div>
				</div>
				<div id="cfi-gallery-meta" class="cfi-gallery-meta" aria-live="polite"></div>
			</div>
			<div id="cfi-gallery-grid" class="cfi-gallery-grid" aria-live="polite">
				<p class="cfi-gallery-empty"><?php esc_html_e( 'Loading gallery…', 'cfi' ); ?></p>
			</div>
			<p id="cfi-gallery-empty" class="cfi-gallery-empty" hidden><?php esc_html_e( 'No media matches these filters. Try another country or program.', 'cfi' ); ?></p>
		</div>
	</section>
</main>

<div class="cfi-lightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Media viewer', 'cfi' ); ?>">
	<button type="button" class="cfi-lightbox__close" aria-label="<?php esc_attr_e( 'Close', 'cfi' ); ?>">&times;</button>
	<div class="cfi-lightbox__content"></div>
</div>

<?php get_footer(); ?>
