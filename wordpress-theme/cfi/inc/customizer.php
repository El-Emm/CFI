<?php
/**
 * Theme Customizer settings.
 *
 * @package CFI
 */

defined( 'ABSPATH' ) || exit;

function cfi_customize_register( $wp_customize ) {
	/* Contact */
	$wp_customize->add_section(
		'cfi_contact',
		array(
			'title'    => __( 'CFI Contact Info', 'cfi' ),
			'priority' => 30,
		)
	);

	$contact_fields = array(
		'cfi_email'   => array( 'label' => __( 'Email', 'cfi' ), 'default' => 'info@charityfaithinternational.org' ),
		'cfi_phone_1' => array( 'label' => __( 'Phone 1', 'cfi' ), 'default' => '+13309999170' ),
		'cfi_phone_2' => array( 'label' => __( 'Phone 2', 'cfi' ), 'default' => '+12163559320' ),
		'cfi_address' => array( 'label' => __( 'Address (one line)', 'cfi' ), 'default' => '2727 Overlook Dr, Twinsburg, OH 44087' ),
		'cfi_facebook'  => array( 'label' => __( 'Facebook URL', 'cfi' ), 'default' => 'https://facebook.com' ),
		'cfi_instagram' => array( 'label' => __( 'Instagram URL', 'cfi' ), 'default' => 'https://instagram.com' ),
		'cfi_youtube'   => array( 'label' => __( 'YouTube URL', 'cfi' ), 'default' => 'https://youtube.com' ),
	);

	foreach ( $contact_fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field['label'],
				'section' => 'cfi_contact',
				'type'    => 'text',
			)
		);
	}

	/* Impact stats */
	$wp_customize->add_section(
		'cfi_stats',
		array(
			'title'    => __( 'CFI Impact Statistics', 'cfi' ),
			'priority' => 31,
		)
	);

	$stats = array(
		'cfi_stat_lives'     => array( 'Lives Impacted', '15000' ),
		'cfi_stat_countries' => array( 'Countries Reached', '9' ),
		'cfi_stat_children'  => array( 'Children Supported', '3200' ),
		'cfi_stat_families'  => array( 'Families Assisted', '4800' ),
		'cfi_stat_widows'    => array( 'Widows Empowered', '850' ),
		'cfi_stat_crusades'  => array( 'Crusades Conducted', '45' ),
	);

	foreach ( $stats as $id => $data ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $data[1],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $data[0],
				'section' => 'cfi_stats',
				'type'    => 'text',
			)
		);
	}

	/* Hero */
	$wp_customize->add_section(
		'cfi_hero',
		array(
			'title'    => __( 'CFI Homepage Hero', 'cfi' ),
			'priority' => 32,
		)
	);

	$wp_customize->add_setting( 'cfi_hero_title', array(
		'default'           => 'Transforming Lives Through Faith, Compassion, and Action',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'cfi_hero_title', array(
		'label'   => __( 'Headline', 'cfi' ),
		'section' => 'cfi_hero',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'cfi_hero_subtitle', array(
		'default'           => 'CharityFaith International is a global humanitarian and faith-based nonprofit dedicated to uplifting vulnerable communities through education, healthcare assistance, widow empowerment, shelter initiatives, food support, and Christian outreach.',
		'sanitize_callback' => 'sanitize_textarea_field',
	) );
	$wp_customize->add_control( 'cfi_hero_subtitle', array(
		'label'   => __( 'Subheadline', 'cfi' ),
		'section' => 'cfi_hero',
		'type'    => 'textarea',
	) );

	/* Donate shortcode */
	$wp_customize->add_section(
		'cfi_integrations',
		array(
			'title'    => __( 'CFI Integrations', 'cfi' ),
			'priority' => 33,
		)
	);

	$wp_customize->add_setting( 'cfi_give_shortcode', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'cfi_give_shortcode', array(
		'label'       => __( 'GiveWP Donation Shortcode', 'cfi' ),
		'description' => __( 'Example: [give_form id="123"]', 'cfi' ),
		'section'     => 'cfi_integrations',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'cfi_contact_shortcode', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'cfi_contact_shortcode', array(
		'label'       => __( 'Contact Form Shortcode', 'cfi' ),
		'description' => __( 'Example: [contact-form-7 id="abc"] or WPForms shortcode', 'cfi' ),
		'section'     => 'cfi_integrations',
		'type'        => 'text',
	) );
}
add_action( 'customize_register', 'cfi_customize_register' );
