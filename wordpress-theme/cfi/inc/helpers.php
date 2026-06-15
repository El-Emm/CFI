<?php
/**
 * Theme helper functions.
 *
 * @package CFI
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme asset URI.
 */
function cfi_asset( $path = '' ) {
	return trailingslashit( get_template_directory_uri() ) . 'assets/' . ltrim( $path, '/' );
}

/**
 * Safe home URL helper.
 */
function cfi_url( $path = '' ) {
	return esc_url( home_url( '/' . ltrim( $path, '/' ) ) );
}

/**
 * Get a page URL by slug with fallback.
 */
function cfi_page_url( $slug, $hash = '' ) {
	$page = get_page_by_path( $slug );
	$url  = $page ? get_permalink( $page ) : cfi_url( $slug );
	if ( $hash ) {
		$url .= '#' . ltrim( $hash, '#' );
	}
	return esc_url( $url );
}

/**
 * Blog / news archive URL.
 */
function cfi_blog_url() {
	$posts_page_id = (int) get_option( 'page_for_posts' );
	if ( $posts_page_id ) {
		return esc_url( get_permalink( $posts_page_id ) );
	}
	return esc_url( get_post_type_archive_link( 'post' ) );
}

/**
 * Format phone for display.
 */
function cfi_format_phone( $number ) {
	$digits = preg_replace( '/\D+/', '', $number );
	if ( strlen( $digits ) === 11 && 0 === strpos( $digits, '1' ) ) {
		return sprintf( '+1 (%s) %s-%s', substr( $digits, 1, 3 ), substr( $digits, 4, 3 ), substr( $digits, 7 ) );
	}
	return $number;
}

/**
 * Theme mod with default.
 */
function cfi_mod( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

/**
 * Impact statistics from Customizer.
 */
function cfi_get_stats() {
	return array(
		array(
			'value'  => cfi_mod( 'cfi_stat_lives', '15000' ),
			'suffix' => '+',
			'label'  => __( 'Lives Impacted', 'cfi' ),
		),
		array(
			'value'  => cfi_mod( 'cfi_stat_countries', '9' ),
			'suffix' => '',
			'label'  => __( 'Countries Reached', 'cfi' ),
		),
		array(
			'value'  => cfi_mod( 'cfi_stat_children', '3200' ),
			'suffix' => '+',
			'label'  => __( 'Children Supported', 'cfi' ),
		),
		array(
			'value'  => cfi_mod( 'cfi_stat_families', '4800' ),
			'suffix' => '+',
			'label'  => __( 'Families Assisted', 'cfi' ),
		),
		array(
			'value'  => cfi_mod( 'cfi_stat_widows', '850' ),
			'suffix' => '+',
			'label'  => __( 'Widows Empowered', 'cfi' ),
		),
		array(
			'value'  => cfi_mod( 'cfi_stat_crusades', '45' ),
			'suffix' => '+',
			'label'  => __( 'Crusades Conducted', 'cfi' ),
		),
	);
}

/**
 * Countries served.
 */
function cfi_get_countries() {
	return array(
		array( 'id' => 'zimbabwe', 'label' => 'Zimbabwe' ),
		array( 'id' => 'namibia', 'label' => 'Namibia' ),
		array( 'id' => 'lesotho', 'label' => 'Lesotho' ),
		array( 'id' => 'south-africa', 'label' => 'South Africa' ),
		array( 'id' => 'nigeria', 'label' => 'Nigeria' ),
		array( 'id' => 'philippines', 'label' => 'The Philippines' ),
		array( 'id' => 'niger', 'label' => 'Niger Republic' ),
		array( 'id' => 'botswana', 'label' => 'Botswana' ),
		array( 'id' => 'malawi', 'label' => 'Malawi' ),
	);
}

/**
 * Map stories — editable via Customizer or filters.
 */
function cfi_get_map_stories() {
	$defaults = array(
		'zimbabwe'     => 'CFI serves communities across Zimbabwe through food distribution, widow empowerment, and faith-based outreach programs that restore dignity and hope.',
		'namibia'      => 'In Namibia, CharityFaith International supports vulnerable families with humanitarian aid, community development, and Christian outreach initiatives.',
		'lesotho'      => 'Lesotho outreach includes education assistance, practical support for widows, and community gatherings that combine compassion with the gospel message.',
		'south-africa' => 'South Africa programs span food relief, shelter support, and crusades that bring together churches, volunteers, and families in need.',
		'nigeria'      => 'Nigeria is a cornerstone of CFI\'s mission — with crusades, food distributions, widow empowerment, and healthcare assistance reaching thousands of families.',
		'philippines'  => 'In The Philippines, CFI teams conduct children\'s programs, community outreach, and faith gatherings — sharing practical support and the love of Christ.',
		'niger'        => 'Niger Republic field work includes food relief, education support, and evangelistic outreach serving families facing hardship in vulnerable regions.',
		'botswana'     => 'Botswana initiatives focus on community development, humanitarian assistance, and partnership with local believers to serve those most in need.',
		'malawi'       => 'Malawi programs deliver school support, food distribution, and faith outreach — helping children, widows, and families build brighter futures.',
	);
	$stories = array();
	foreach ( $defaults as $id => $text ) {
		$stories[ $id ] = cfi_mod( 'cfi_map_' . str_replace( '-', '_', $id ), $text );
	}
	return apply_filters( 'cfi_map_stories', $stories );
}

/**
 * Programs grid data.
 */
function cfi_get_programs() {
	return apply_filters(
		'cfi_programs',
		array(
			array( 'icon' => '🏥', 'title' => __( 'Healthcare Assistance', 'cfi' ), 'text' => __( 'Supporting individuals and families with hospital bills and urgent medical needs.', 'cfi' ) ),
			array( 'icon' => '🍽️', 'title' => __( 'Food Distribution', 'cfi' ), 'text' => __( 'Providing meals and food support to vulnerable communities and families facing hardship.', 'cfi' ) ),
			array( 'icon' => '📚', 'title' => __( 'Education Support', 'cfi' ), 'text' => __( 'Paying school fees and helping children access quality education.', 'cfi' ) ),
			array( 'icon' => '✏️', 'title' => __( 'School Supplies Program', 'cfi' ), 'text' => __( 'Providing uniforms, books, stationery, and learning materials to children in need.', 'cfi' ) ),
			array( 'icon' => '💛', 'title' => __( 'Widow Empowerment', 'cfi' ), 'text' => __( 'Financial assistance, skills development, and sustainable livelihood opportunities for widows.', 'cfi' ) ),
			array( 'icon' => '🏠', 'title' => __( 'Shelter Projects', 'cfi' ), 'text' => __( 'Building and improving safe housing for vulnerable individuals and families.', 'cfi' ) ),
			array( 'icon' => '🌱', 'title' => __( 'Small Business Startup Support', 'cfi' ), 'text' => __( 'Seed capital and business support for widows and struggling families.', 'cfi' ) ),
			array( 'icon' => '✝️', 'title' => __( 'Faith & Evangelism Outreach', 'cfi' ), 'text' => __( 'Crusades, community outreach, and faith gatherings paired with food and practical support.', 'cfi' ) ),
		)
	);
}

/**
 * Nav link active class helper.
 */
function cfi_nav_active( $slug ) {
	if ( is_front_page() && 'home' === $slug ) {
		return ' is-active';
	}
	if ( is_page( $slug ) ) {
		return ' is-active';
	}
	if ( ( is_home() || is_singular( 'post' ) || is_category() ) && 'blog' === $slug ) {
		return ' is-active';
	}
	return '';
}
