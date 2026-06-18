<?php
/**
 * Map section template part.
 *
 * @package CFI
 */
$countries = cfi_get_countries();
?>
<section class="cfi-section" id="impact" aria-labelledby="map-heading">
	<div class="cfi-container">
		<header class="cfi-section__header">
			<span class="cfi-section__label"><?php esc_html_e( 'Global Reach', 'cfi' ); ?></span>
			<h2 id="map-heading"><?php esc_html_e( 'Where We Serve', 'cfi' ); ?></h2>
			<p class="cfi-section__lead"><?php esc_html_e( 'Select a country to explore our field work across Africa and Asia. View photos and videos from each nation in our media gallery.', 'cfi' ); ?></p>
		</header>
		<div class="cfi-map-section">
			<div class="cfi-map-wrap is-loading" data-map-src="<?php echo esc_url( cfi_asset( 'images/africa-map.svg' ) ); ?>" aria-busy="true">
				<p class="cfi-map-story__placeholder"><?php esc_html_e( 'Loading map…', 'cfi' ); ?></p>
			</div>
			<aside class="cfi-map-story" aria-live="polite">
				<div class="cfi-map-story__content">
					<p class="cfi-map-story__placeholder"><?php esc_html_e( 'Select a country on the map to view impact stories.', 'cfi' ); ?></p>
				</div>
			</aside>
		</div>
		<p class="cfi-map-legend">
			<strong><?php esc_html_e( 'Countries served:', 'cfi' ); ?></strong>
			<?php
			$links = array();
			foreach ( $countries as $country ) {
				$links[] = '<a href="' . esc_url( cfi_page_url( 'gallery' ) . '?country=' . $country['id'] ) . '">' . esc_html( $country['label'] ) . '</a>';
			}
			echo implode( ' · ', $links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</p>
	</div>
</section>
