<?php
/**
 * Basic SEO fallbacks when no SEO plugin is active.
 *
 * @package CFI
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether a major SEO plugin is handling meta tags.
 */
function cfi_seo_plugin_active() {
	return defined( 'RANK_MATH_VERSION' ) || defined( 'WPSEO_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

/**
 * Page-specific meta descriptions.
 */
function cfi_meta_description() {
	if ( cfi_seo_plugin_active() ) {
		return '';
	}

	$description = get_bloginfo( 'description' );

	if ( is_front_page() ) {
		$description = 'CharityFaith International is a global humanitarian and faith-based nonprofit founded by Evangelist Ebel Philips, serving vulnerable communities through aid, education, widow empowerment, and Christian outreach across nine nations.';
	} elseif ( is_page( 'accept-jesus' ) ) {
		$description = 'Accept Jesus Christ today. Learn the gospel, pray the salvation prayer, and begin your new life in faith with CharityFaith International.';
	} elseif ( is_page( 'prayer-requests' ) ) {
		$description = 'Submit your prayer request to CharityFaith International. Our prayer team stands with you for healing, breakthrough, salvation, and restoration.';
	} elseif ( is_page( 'donate' ) ) {
		$description = 'Support CharityFaith International humanitarian programs — healthcare, education, food relief, widow empowerment, and shelter projects worldwide.';
	} elseif ( is_page( 'gallery' ) ) {
		$description = 'Photo and video gallery from CharityFaith International field work in Zimbabwe, Namibia, Nigeria, South Africa, The Philippines, and more.';
	} elseif ( is_singular() ) {
		$excerpt = get_the_excerpt();
		if ( $excerpt ) {
			$description = wp_strip_all_tags( $excerpt );
		}
	}

	return wp_strip_all_tags( $description );
}

/**
 * Output meta description + Open Graph tags.
 */
function cfi_output_seo_tags() {
	if ( cfi_seo_plugin_active() || is_admin() ) {
		return;
	}

	$description = cfi_meta_description();
	$title       = wp_get_document_title();
	$url         = is_singular() ? get_permalink() : home_url( '/' );
	$image       = cfi_asset( 'images/cfi-logo.png' );

	if ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( null, 'large' );
	}

	if ( $description ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
	}

	printf( '<meta property="og:type" content="%s">' . "\n", is_front_page() ? 'website' : 'article' );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	if ( $description ) {
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) );
	}
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
	printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url ) );
}
add_action( 'wp_head', 'cfi_output_seo_tags', 1 );
