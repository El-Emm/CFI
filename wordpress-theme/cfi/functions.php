<?php
/**
 * CharityFaith International Theme functions.
 *
 * @package CFI
 */

defined( 'ABSPATH' ) || exit;

define( 'CFI_VERSION', '1.0.1' );

require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/theme-setup.php';

/**
 * Theme setup.
 */
function cfi_setup() {
	load_theme_textdomain( 'cfi', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support( 'custom-logo', array(
		'height'      => 120,
		'width'       => 120,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'cfi' ),
			'footer'  => __( 'Footer Menu', 'cfi' ),
		)
	);
}
add_action( 'after_setup_theme', 'cfi_setup' );

/**
 * Enqueue scripts and styles.
 */
function cfi_enqueue_assets() {
	$uri = get_template_directory_uri();

	wp_enqueue_style(
		'cfi-fonts',
		'https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Source+Sans+3:wght@400;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'cfi-main', $uri . '/assets/css/main.css', array( 'cfi-fonts' ), CFI_VERSION );

	wp_enqueue_script( 'cfi-main', $uri . '/assets/js/main.js', array(), CFI_VERSION, true );

	if ( is_page_template( 'page-templates/template-gallery.php' ) ) {
		wp_enqueue_script( 'cfi-gallery', $uri . '/assets/js/gallery.js', array( 'cfi-main' ), CFI_VERSION, true );
	}

	$countries = array();
	foreach ( cfi_get_countries() as $c ) {
		$countries[] = array(
			'id'    => $c['id'],
			'label' => $c['label'],
			'map'   => array( 'x' => 0, 'y' => 0 ),
		);
	}

	$site_data = array(
		'name'       => get_bloginfo( 'name' ),
		'email'      => cfi_mod( 'cfi_email', 'info@charityfaithinternational.org' ),
		'phones'     => array_filter( array(
			cfi_mod( 'cfi_phone_1', '+13309999170' ),
			cfi_mod( 'cfi_phone_2', '+12163559320' ),
		) ),
		'address'    => array(
			'line1'   => '2727 Overlook Dr',
			'city'    => 'Twinsburg',
			'state'   => 'Ohio',
			'zip'     => '44087',
			'country' => 'United States',
		),
		'countries'  => $countries,
		'mapStories' => cfi_get_map_stories(),
	);

	wp_add_inline_script(
		'cfi-main',
		'window.CFI_SITE = ' . wp_json_encode( $site_data ) . ';',
		'before'
	);

	wp_localize_script(
		'cfi-main',
		'cfiTheme',
		array(
			'homeUrl'     => home_url( '/' ),
			'themeUri'    => $uri,
			'galleryUrl'  => cfi_page_url( 'gallery' ),
			'galleryJson' => $uri . '/assets/data/gallery.json',
		)
	);

	if ( wp_script_is( 'cfi-gallery', 'enqueued' ) ) {
		wp_localize_script(
			'cfi-gallery',
			'cfiTheme',
			array(
				'homeUrl'     => home_url( '/' ),
				'themeUri'    => $uri,
				'galleryUrl'  => cfi_page_url( 'gallery' ),
				'galleryJson' => $uri . '/assets/data/gallery.json',
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'cfi_enqueue_assets' );

/**
 * JSON-LD schema on front page.
 */
function cfi_schema_markup() {
	if ( ! is_front_page() ) {
		return;
	}
	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'NGO',
		'name'            => get_bloginfo( 'name' ),
		'alternateName'   => 'CFI',
		'url'             => home_url( '/' ),
		'logo'            => cfi_asset( 'images/cfi-logo.png' ),
		'description'     => get_bloginfo( 'description' ),
		'email'           => cfi_mod( 'cfi_email', 'info@charityfaithinternational.org' ),
		'founder'         => array(
			'@type'    => 'Person',
			'name'     => 'Evangelist Ebele Philips',
			'jobTitle' => 'Founder',
		),
		'address'         => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => '2727 Overlook Dr',
			'addressLocality' => 'Twinsburg',
			'addressRegion'   => 'OH',
			'postalCode'      => '44087',
			'addressCountry'  => 'US',
		),
		'areaServed'      => wp_list_pluck( cfi_get_countries(), 'label' ),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}
add_action( 'wp_head', 'cfi_schema_markup', 99 );

/**
 * Favicon.
 */
function cfi_site_icon() {
	printf(
		'<link rel="icon" href="%s" type="image/png">' . "\n",
		esc_url( cfi_asset( 'images/cfi-logo.png' ) )
	);
}
add_action( 'wp_head', 'cfi_site_icon', 5 );

/**
 * Body classes.
 */
function cfi_body_classes( $classes ) {
	$classes[] = 'cfi-theme';
	return $classes;
}
add_filter( 'body_class', 'cfi_body_classes' );
