<?php
/**
 * Field media gallery — CPT, taxonomies, REST manifest, and admin uploads.
 *
 * @package CFI
 */

defined( 'ABSPATH' ) || exit;

define( 'CFI_GALLERY_VERSION', 3 );

/**
 * Program / cause slugs used by the public gallery filters.
 *
 * @return array<string, string> slug => label
 */
function cfi_get_gallery_programs() {
	return array(
		'outreach'        => __( 'Community Outreach', 'cfi' ),
		'crusades'        => __( 'Crusades', 'cfi' ),
		'food'            => __( 'Food Distribution', 'cfi' ),
		'education'       => __( 'Education', 'cfi' ),
		'healthcare'      => __( 'Healthcare', 'cfi' ),
		'widow'     => __( 'Widow Empowerment', 'cfi' ),
		'shelter'   => __( 'Shelter', 'cfi' ),
	);
}

/**
 * Register gallery post type and taxonomies.
 */
function cfi_register_gallery_cpt() {
	register_post_type(
		'cfi_field_media',
		array(
			'labels'              => array(
				'name'               => __( 'Field Media', 'cfi' ),
				'singular_name'      => __( 'Field Media Item', 'cfi' ),
				'add_new'            => __( 'Add Media', 'cfi' ),
				'add_new_item'       => __( 'Add Field Media', 'cfi' ),
				'edit_item'          => __( 'Edit Field Media', 'cfi' ),
				'new_item'           => __( 'New Field Media', 'cfi' ),
				'view_item'          => __( 'View Field Media', 'cfi' ),
				'search_items'       => __( 'Search Field Media', 'cfi' ),
				'not_found'          => __( 'No field media found.', 'cfi' ),
				'not_found_in_trash' => __( 'No field media found in Trash.', 'cfi' ),
				'menu_name'          => __( 'Field Media', 'cfi' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 21,
			'menu_icon'           => 'dashicons-camera',
			'capability_type'     => 'post',
			'has_archive'         => false,
			'hierarchical'        => false,
			'supports'            => array( 'title' ),
			'show_in_rest'        => false,
		)
	);

	register_taxonomy(
		'cfi_country',
		'cfi_field_media',
		array(
			'labels'            => array(
				'name'          => __( 'Countries', 'cfi' ),
				'singular_name' => __( 'Country', 'cfi' ),
				'all_items'     => __( 'All Countries', 'cfi' ),
				'menu_name'     => __( 'Countries', 'cfi' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'hierarchical'      => false,
			'rewrite'           => false,
		)
	);

	register_taxonomy(
		'cfi_program',
		'cfi_field_media',
		array(
			'labels'            => array(
				'name'          => __( 'Programs / Causes', 'cfi' ),
				'singular_name' => __( 'Program', 'cfi' ),
				'all_items'     => __( 'All Programs', 'cfi' ),
				'menu_name'     => __( 'Programs', 'cfi' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'hierarchical'      => false,
			'rewrite'           => false,
		)
	);
}
add_action( 'init', 'cfi_register_gallery_cpt' );

/**
 * Ensure country and program terms exist.
 */
function cfi_seed_gallery_terms() {
	foreach ( cfi_get_countries() as $country ) {
		if ( ! term_exists( $country['id'], 'cfi_country' ) ) {
			wp_insert_term( $country['label'], 'cfi_country', array( 'slug' => $country['id'] ) );
		}
	}

	foreach ( cfi_get_gallery_programs() as $slug => $label ) {
		if ( ! term_exists( $slug, 'cfi_program' ) ) {
			wp_insert_term( $label, 'cfi_program', array( 'slug' => $slug ) );
		}
	}
}

/**
 * Delete every Field Media post (used when resetting the gallery).
 */
function cfi_purge_field_media() {
	$post_ids = get_posts(
		array(
			'post_type'      => 'cfi_field_media',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);

	foreach ( $post_ids as $post_id ) {
		wp_delete_post( (int) $post_id, true );
	}
}

/**
 * Meta box — upload controls for images and videos.
 */
function cfi_gallery_meta_boxes() {
	add_meta_box(
		'cfi_field_media_details',
		__( 'Gallery Media', 'cfi' ),
		'cfi_render_gallery_meta_box',
		'cfi_field_media',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'cfi_gallery_meta_boxes' );

/**
 * Attachment preview markup for the meta box.
 *
 * @param int $attachment_id Attachment ID.
 */
function cfi_gallery_admin_preview_html( $attachment_id ) {
	if ( ! $attachment_id ) {
		return '';
	}

	$url = wp_get_attachment_image_url( $attachment_id, 'medium' );
	if ( ! $url ) {
		return '';
	}

	return '<img src="' . esc_url( $url ) . '" alt="" style="max-width:240px;height:auto;border-radius:8px;display:block">';
}

/**
 * @param WP_Post $post Post object.
 */
function cfi_render_gallery_meta_box( $post ) {
	wp_nonce_field( 'cfi_save_gallery_meta', 'cfi_gallery_meta_nonce' );

	$type     = get_post_meta( $post->ID, '_cfi_media_type', true ) ?: 'image';
	$image_id = (int) get_post_meta( $post->ID, '_cfi_image_id', true );
	$poster_id = (int) get_post_meta( $post->ID, '_cfi_poster_id', true );
	$video_id = (int) get_post_meta( $post->ID, '_cfi_video_id', true );
	$video_url = $video_id ? wp_get_attachment_url( $video_id ) : '';

	?>
	<div id="cfi-field-media-box" class="cfi-field-media-box">
		<p>
			<label for="cfi_media_type"><strong><?php esc_html_e( 'Media type', 'cfi' ); ?></strong></label><br>
			<select name="cfi_media_type" id="cfi_media_type">
				<option value="image" <?php selected( $type, 'image' ); ?>><?php esc_html_e( 'Image', 'cfi' ); ?></option>
				<option value="video" <?php selected( $type, 'video' ); ?>><?php esc_html_e( 'Video', 'cfi' ); ?></option>
			</select>
		</p>
		<p class="description">
			<?php esc_html_e( 'Select one Country and one Program in the sidebar, then upload your file below.', 'cfi' ); ?>
		</p>

		<div id="cfi-image-fields" class="cfi-field-media-panel" style="<?php echo 'image' === $type ? '' : 'display:none'; ?>">
			<p><strong><?php esc_html_e( 'Gallery image', 'cfi' ); ?></strong></p>
			<input type="hidden" name="cfi_image_id" data-cfi-image-id value="<?php echo esc_attr( (string) $image_id ); ?>">
			<p>
				<button type="button" class="button button-primary" data-cfi-image-upload><?php esc_html_e( 'Upload / Select Image', 'cfi' ); ?></button>
				<button type="button" class="button" data-cfi-image-remove style="<?php echo $image_id ? '' : 'display:none'; ?>"><?php esc_html_e( 'Remove', 'cfi' ); ?></button>
			</p>
			<div data-cfi-image-preview><?php echo cfi_gallery_admin_preview_html( $image_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		</div>

		<div id="cfi-video-fields" class="cfi-field-media-panel" style="<?php echo 'video' === $type ? '' : 'display:none'; ?>">
			<div id="cfi-poster-fields" class="cfi-field-media-panel" style="margin-bottom:1.5rem">
				<p><strong><?php esc_html_e( 'Video poster (thumbnail in gallery)', 'cfi' ); ?></strong></p>
				<input type="hidden" name="cfi_poster_id" data-cfi-poster-id value="<?php echo esc_attr( (string) $poster_id ); ?>">
				<p>
					<button type="button" class="button button-primary" data-cfi-poster-upload><?php esc_html_e( 'Upload / Select Poster Image', 'cfi' ); ?></button>
					<button type="button" class="button" data-cfi-poster-remove style="<?php echo $poster_id ? '' : 'display:none'; ?>"><?php esc_html_e( 'Remove', 'cfi' ); ?></button>
				</p>
				<div data-cfi-poster-preview><?php echo cfi_gallery_admin_preview_html( $poster_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			</div>

			<p><strong><?php esc_html_e( 'Video file', 'cfi' ); ?></strong></p>
			<input type="hidden" name="cfi_video_id" data-cfi-video-id value="<?php echo esc_attr( (string) $video_id ); ?>">
			<p>
				<button type="button" class="button button-primary" data-cfi-video-upload><?php esc_html_e( 'Upload / Select Video', 'cfi' ); ?></button>
				<button type="button" class="button" data-cfi-video-remove style="<?php echo $video_id ? '' : 'display:none'; ?>"><?php esc_html_e( 'Remove', 'cfi' ); ?></button>
			</p>
			<p data-cfi-video-preview>
				<?php if ( $video_url ) : ?>
					<code><?php echo esc_html( basename( $video_url ) ); ?></code>
				<?php endif; ?>
			</p>
		</div>
	</div>
	<?php
}

/**
 * Save gallery meta.
 *
 * @param int $post_id Post ID.
 */
function cfi_save_gallery_meta( $post_id ) {
	if ( ! isset( $_POST['cfi_gallery_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cfi_gallery_meta_nonce'] ) ), 'cfi_save_gallery_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( 'cfi_field_media' !== get_post_type( $post_id ) ) {
		return;
	}

	$type = isset( $_POST['cfi_media_type'] ) ? sanitize_key( wp_unslash( $_POST['cfi_media_type'] ) ) : 'image';
	if ( ! in_array( $type, array( 'image', 'video' ), true ) ) {
		$type = 'image';
	}
	update_post_meta( $post_id, '_cfi_media_type', $type );

	$image_id  = isset( $_POST['cfi_image_id'] ) ? absint( $_POST['cfi_image_id'] ) : 0;
	$poster_id = isset( $_POST['cfi_poster_id'] ) ? absint( $_POST['cfi_poster_id'] ) : 0;
	$video_id  = isset( $_POST['cfi_video_id'] ) ? absint( $_POST['cfi_video_id'] ) : 0;

	if ( $image_id ) {
		update_post_meta( $post_id, '_cfi_image_id', $image_id );
	} else {
		delete_post_meta( $post_id, '_cfi_image_id' );
	}

	if ( $poster_id ) {
		update_post_meta( $post_id, '_cfi_poster_id', $poster_id );
	} else {
		delete_post_meta( $post_id, '_cfi_poster_id' );
	}

	if ( $video_id ) {
		update_post_meta( $post_id, '_cfi_video_id', $video_id );
	} else {
		delete_post_meta( $post_id, '_cfi_video_id' );
	}

	delete_post_meta( $post_id, '_cfi_media_thumb' );
	delete_post_meta( $post_id, '_cfi_media_src' );
	delete_post_meta( $post_id, '_cfi_gallery_id' );

	$thumbnail_id = 'video' === $type ? $poster_id : $image_id;
	if ( $thumbnail_id ) {
		set_post_thumbnail( $post_id, $thumbnail_id );
	} else {
		delete_post_thumbnail( $post_id );
	}
}
add_action( 'save_post_cfi_field_media', 'cfi_save_gallery_meta' );

/**
 * Enqueue media scripts on Field Media edit screens.
 *
 * @param string $hook Admin hook.
 */
function cfi_gallery_admin_assets( $hook ) {
	$screen = get_current_screen();
	if ( ! $screen || 'cfi_field_media' !== $screen->post_type ) {
		return;
	}

	if ( ! in_array( $hook, array( 'post.php', 'post-new.php', 'edit.php' ), true ) ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_script(
		'cfi-field-media-admin',
		get_template_directory_uri() . '/assets/js/field-media-admin.js',
		array( 'jquery', 'media-upload', 'media-views' ),
		CFI_VERSION,
		true
	);
	wp_localize_script(
		'cfi-field-media-admin',
		'cfiFieldMedia',
		array(
			'i18n' => array(
				'selectImage'  => __( 'Select gallery image', 'cfi' ),
				'useImage'     => __( 'Use this image', 'cfi' ),
				'selectPoster' => __( 'Select poster image', 'cfi' ),
				'usePoster'    => __( 'Use this poster', 'cfi' ),
				'selectVideo'  => __( 'Select video', 'cfi' ),
				'useVideo'     => __( 'Use this video', 'cfi' ),
			),
		)
	);

	if ( 'edit.php' === $hook ) {
		return;
	}

	wp_add_inline_style(
		'wp-admin',
		'.cfi-field-media-box .cfi-field-media-panel{margin-top:1rem;padding-top:1rem;border-top:1px solid #dcdcde}'
	);
}
add_action( 'admin_enqueue_scripts', 'cfi_gallery_admin_assets' );

/**
 * Admin list columns.
 *
 * @param string[] $columns Columns.
 * @return string[]
 */
function cfi_gallery_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['cfi_media_thumb'] = __( 'Preview', 'cfi' );
			$new['cfi_media_type']  = __( 'Type', 'cfi' );
		}
	}
	return $new;
}
add_filter( 'manage_cfi_field_media_posts_columns', 'cfi_gallery_columns' );

/**
 * @param string $column Column key.
 * @param int    $post_id Post ID.
 */
function cfi_gallery_column_content( $column, $post_id ) {
	if ( 'cfi_media_type' === $column ) {
		$type = get_post_meta( $post_id, '_cfi_media_type', true ) ?: 'image';
		echo esc_html( ucfirst( $type ) );
		return;
	}

	if ( 'cfi_media_thumb' !== $column ) {
		return;
	}

	$type      = get_post_meta( $post_id, '_cfi_media_type', true ) ?: 'image';
	$thumb_id  = 'video' === $type
		? (int) get_post_meta( $post_id, '_cfi_poster_id', true )
		: (int) get_post_meta( $post_id, '_cfi_image_id', true );

	if ( ! $thumb_id && has_post_thumbnail( $post_id ) ) {
		$thumb_id = (int) get_post_thumbnail_id( $post_id );
	}

	if ( $thumb_id ) {
		echo wp_get_attachment_image( $thumb_id, array( 60, 60 ) );
	} else {
		echo '&mdash;';
	}
}
add_action( 'manage_cfi_field_media_posts_custom_column', 'cfi_gallery_column_content', 10, 2 );

/**
 * Country label from slug.
 *
 * @param string $slug Country slug.
 */
function cfi_gallery_country_label( $slug ) {
	foreach ( cfi_get_countries() as $country ) {
		if ( $country['id'] === $slug ) {
			return $country['label'];
		}
	}
	return ucwords( str_replace( '-', ' ', $slug ) );
}

/**
 * Build one manifest item from a Field Media post.
 *
 * @param WP_Post $post Post object.
 * @return array<string, mixed>|null
 */
function cfi_gallery_item_from_post( $post ) {
	$countries = wp_get_post_terms( $post->ID, 'cfi_country', array( 'fields' => 'all' ) );
	$programs  = wp_get_post_terms( $post->ID, 'cfi_program', array( 'fields' => 'all' ) );

	if ( empty( $countries ) || empty( $programs ) || is_wp_error( $countries ) || is_wp_error( $programs ) ) {
		return null;
	}

	$country = $countries[0]->slug;
	$program = $programs[0]->slug;
	$type    = get_post_meta( $post->ID, '_cfi_media_type', true ) ?: 'image';

	$image_id  = (int) get_post_meta( $post->ID, '_cfi_image_id', true );
	$poster_id = (int) get_post_meta( $post->ID, '_cfi_poster_id', true );
	$video_id  = (int) get_post_meta( $post->ID, '_cfi_video_id', true );

	$thumb = '';
	$src   = '';

	if ( 'image' === $type ) {
		if ( $image_id ) {
			$thumb = wp_get_attachment_image_url( $image_id, 'medium_large' ) ?: wp_get_attachment_image_url( $image_id, 'large' );
			$src   = wp_get_attachment_image_url( $image_id, 'full' );
		}
	} else {
		if ( $poster_id ) {
			$thumb = wp_get_attachment_image_url( $poster_id, 'medium_large' ) ?: wp_get_attachment_image_url( $poster_id, 'large' );
		}
		if ( $video_id ) {
			$src = wp_get_attachment_url( $video_id );
		}
	}

	if ( ! $thumb || ! $src ) {
		return null;
	}

	$alt = $post->post_title;
	if ( ! $alt || 'Auto Draft' === $alt ) {
		$programs_label = cfi_get_gallery_programs()[ $program ] ?? $program;
		$alt            = sprintf(
			/* translators: 1: country label, 2: program label */
			__( 'CharityFaith International %1$s — %2$s', 'cfi' ),
			cfi_gallery_country_label( $country ),
			$programs_label
		);
	}

	return array(
		'id'           => 'cfi-media-' . $post->ID,
		'country'      => $country,
		'countryLabel' => cfi_gallery_country_label( $country ),
		'category'     => $program,
		'type'         => $type,
		'thumb'        => $thumb,
		'src'          => $src,
		'alt'          => $alt,
	);
}

/**
 * Gallery manifest for the public page.
 *
 * @return array<string, mixed>
 */
function cfi_get_gallery_manifest() {
	$countries  = array_map(
		function ( $c ) {
			return array( 'id' => $c['id'], 'label' => $c['label'] );
		},
		cfi_get_countries()
	);
	$categories = array_keys( cfi_get_gallery_programs() );

	$posts = get_posts(
		array(
			'post_type'      => 'cfi_field_media',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	$gallery = array();
	foreach ( $posts as $post ) {
		$item = cfi_gallery_item_from_post( $post );
		if ( $item ) {
			$gallery[] = $item;
		}
	}

	return array(
		'countries'  => $countries,
		'categories' => $categories,
		'featured'   => array(),
		'gallery'    => $gallery,
	);
}

/**
 * REST route for gallery manifest.
 */
function cfi_register_gallery_rest() {
	register_rest_route(
		'cfi/v1',
		'/gallery',
		array(
			'methods'             => 'GET',
			'callback'            => function () {
				return rest_ensure_response( cfi_get_gallery_manifest() );
			},
			'permission_callback' => '__return_true',
		)
	);
}
add_action( 'rest_api_init', 'cfi_register_gallery_rest' );

/**
 * Remove deprecated program terms and reassign legacy items.
 */
function cfi_remove_building_houses_program() {
	$term = get_term_by( 'slug', 'building-houses', 'cfi_program' );
	if ( ! $term || is_wp_error( $term ) ) {
		return;
	}

	$posts = get_posts(
		array(
			'post_type'      => 'cfi_field_media',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'cfi_program',
					'field'    => 'slug',
					'terms'    => 'building-houses',
				),
			),
		)
	);

	foreach ( $posts as $post ) {
		wp_set_object_terms( $post->ID, 'shelter', 'cfi_program', false );
	}

	wp_delete_term( $term->term_id, 'cfi_program' );
}

/**
 * Run gallery data upgrades (purge seeded demo items once).
 */
function cfi_maybe_upgrade_gallery() {
	$version = (int) get_option( 'cfi_gallery_version', 0 );
	if ( $version >= CFI_GALLERY_VERSION ) {
		return;
	}

	cfi_seed_gallery_terms();

	if ( $version < 2 ) {
		cfi_purge_field_media();
	}

	if ( $version < 3 ) {
		cfi_remove_building_houses_program();
	}

	update_option( 'cfi_gallery_version', CFI_GALLERY_VERSION );
}
add_action( 'after_setup_theme', 'cfi_maybe_upgrade_gallery', 25 );
