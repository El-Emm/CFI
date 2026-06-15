<?php
/**
 * Map section template part.
 *
 * @package CFI
 */
$countries = cfi_get_countries();
$markers   = array(
	'nigeria'      => array( 388, 218, 10 ),
	'niger'        => array( 370, 205, 8 ),
	'zimbabwe'     => array( 435, 272, 8 ),
	'namibia'      => array( 405, 295, 8 ),
	'botswana'     => array( 412, 288, 8 ),
	'south-africa' => array( 415, 312, 9 ),
	'lesotho'      => array( 422, 308, 6 ),
	'malawi'       => array( 448, 268, 8 ),
	'philippines'  => array( 675, 215, 10 ),
);
?>
<section class="cfi-section" id="impact" aria-labelledby="map-heading">
	<div class="cfi-container">
		<header class="cfi-section__header">
			<span class="cfi-section__label"><?php esc_html_e( 'Global Reach', 'cfi' ); ?></span>
			<h2 id="map-heading"><?php esc_html_e( 'Where We Serve', 'cfi' ); ?></h2>
			<p class="cfi-section__lead"><?php esc_html_e( 'Select a country to explore our field work across Africa and Asia. View photos and videos from each nation in our media gallery.', 'cfi' ); ?></p>
		</header>
		<div class="cfi-map-section">
			<div class="cfi-map-wrap">
				<svg class="cfi-map-svg" viewBox="0 0 800 400" role="img" aria-label="<?php esc_attr_e( 'World map showing CFI impact regions', 'cfi' ); ?>">
					<rect fill="#FFF8F1" width="800" height="400" rx="12"/>
					<path fill="#e8e4df" d="M120,180 Q200,120 280,150 T400,140 T520,160 T650,140 L700,200 Q650,280 500,300 T300,290 T120,250 Z" opacity="0.6"/>
					<text x="400" y="30" text-anchor="middle" fill="#5F5F5F" font-size="14" font-family="sans-serif"><?php esc_html_e( 'Click a marker to explore our work by country', 'cfi' ); ?></text>
					<?php foreach ( $countries as $country ) :
						$m = $markers[ $country['id'] ] ?? array( 400, 200, 8 );
						?>
						<g class="cfi-map-marker" data-country="<?php echo esc_attr( $country['id'] ); ?>" tabindex="0" role="button" aria-label="<?php echo esc_attr( $country['label'] ); ?>" transform="translate(<?php echo (int) $m[0]; ?>, <?php echo (int) $m[1]; ?>)">
							<circle r="<?php echo (int) $m[2]; ?>"/><title><?php echo esc_html( $country['label'] ); ?></title>
						</g>
					<?php endforeach; ?>
				</svg>
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
