<?php
/**
 * Theme activation — create required pages.
 *
 * @package CFI
 */

defined( 'ABSPATH' ) || exit;

function cfi_create_pages_on_activation() {
	if ( get_option( 'cfi_pages_created' ) ) {
		return;
	}

	$pages = array(
		'donate'   => array( 'title' => 'Donate', 'template' => 'page-templates/template-donate.php' ),
		'contact'  => array( 'title' => 'Contact', 'template' => 'page-templates/template-contact.php' ),
		'gallery'  => array( 'title' => 'Media Gallery', 'template' => 'page-templates/template-gallery.php' ),
		'founder'  => array( 'title' => 'Founder', 'template' => 'page-templates/template-founder.php' ),
		'partners' => array( 'title' => 'Partner With Us', 'template' => 'page-templates/template-partners.php' ),
		'news'     => array( 'title' => 'News & Impact', 'template' => '' ),
	);

	$front_id = 0;
	$blog_id  = 0;

	foreach ( $pages as $slug => $data ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			if ( 'news' === $slug ) {
				$blog_id = $existing->ID;
			}
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_title'   => $data['title'],
				'post_name'    => $slug,
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '',
			)
		);

		if ( $page_id && ! empty( $data['template'] ) ) {
			update_post_meta( $page_id, '_wp_page_template', $data['template'] );
		}

		if ( 'news' === $slug ) {
			$blog_id = $page_id;
		}
	}

	/* Create a Home page if front page not set */
	$home = get_page_by_path( 'home' );
	if ( ! $home ) {
		$front_id = wp_insert_post(
			array(
				'post_title'  => 'Home',
				'post_name'   => 'home',
				'post_status' => 'publish',
				'post_type'   => 'page',
			)
		);
	} else {
		$front_id = $home->ID;
	}

	if ( $front_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_id );
	}

	if ( $blog_id ) {
		update_option( 'page_for_posts', $blog_id );
	}

	update_option( 'cfi_pages_created', 1 );

	/* Default site text */
	if ( ! get_option( 'blogdescription' ) || 'Just another WordPress site' === get_option( 'blogdescription' ) ) {
		update_option( 'blogdescription', 'Transforming Lives Through Faith, Compassion, and Action' );
	}

	/* Blog categories */
	$categories = array( 'Impact Stories', 'Field Reports', 'Events', 'Crusades', 'Community Development', 'Announcements' );
	foreach ( $categories as $cat ) {
		if ( ! term_exists( $cat, 'category' ) ) {
			wp_insert_term( $cat, 'category' );
		}
	}
}

function cfi_after_switch_theme() {
	cfi_create_pages_on_activation();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'cfi_after_switch_theme' );
