<?php
/**
 * Field media gallery — CPT, taxonomies, REST manifest, and seeding.
 *
 * @package CFI
 */

defined( 'ABSPATH' ) || exit;

define( 'CFI_GALLERY_VERSION', 1 );

/**
 * Program / cause slugs used by the public gallery filters.
 *
 * @return array<string, string> slug => label
 */
function cfi_get_gallery_programs() {
	return array(
		'outreach'         => __( 'Community Outreach', 'cfi' ),
		'crusades'         => __( 'Crusades', 'cfi' ),
		'food'             => __( 'Food Distribution', 'cfi' ),
		'education'        => __( 'Education', 'cfi' ),
		'healthcare'       => __( 'Healthcare', 'cfi' ),
		'widow'            => __( 'Widow Empowerment', 'cfi' ),
		'shelter'          => __( 'Shelter', 'cfi' ),
		'building-houses'  => __( 'Building Houses for Folks', 'cfi' ),
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
			'supports'            => array( 'title', 'thumbnail' ),
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
				'search_items'  => __( 'Search Countries', 'cfi' ),
				'all_items'     => __( 'All Countries', 'cfi' ),
				'edit_item'     => __( 'Edit Country', 'cfi' ),
				'update_item'   => __( 'Update Country', 'cfi' ),
				'add_new_item'  => __( 'Add Country', 'cfi' ),
				'new_item_name' => __( 'New Country', 'cfi' ),
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
				'search_items'  => __( 'Search Programs', 'cfi' ),
				'all_items'     => __( 'All Programs', 'cfi' ),
				'edit_item'     => __( 'Edit Program', 'cfi' ),
				'update_item'   => __( 'Update Program', 'cfi' ),
				'add_new_item'  => __( 'Add Program', 'cfi' ),
				'new_item_name' => __( 'New Program', 'cfi' ),
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
 * Meta box — media type and optional video file.
 */
function cfi_gallery_meta_boxes() {
	add_meta_box(
		'cfi_field_media_details',
		__( 'Media Details', 'cfi' ),
		'cfi_render_gallery_meta_box',
		'cfi_field_media',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'cfi_gallery_meta_boxes' );

/**
 * @param WP_Post $post Post object.
 */
function cfi_render_gallery_meta_box( $post ) {
	wp_nonce_field( 'cfi_save_gallery_meta', 'cfi_gallery_meta_nonce' );

	$type     = get_post_meta( $post->ID, '_cfi_media_type', true ) ?: 'image';
	$video_id = (int) get_post_meta( $post->ID, '_cfi_video_id', true );
	$video_url = $video_id ? wp_get_attachment_url( $video_id ) : '';

	?>
	<p>
		<label for="cfi_media_type"><strong><?php esc_html_e( 'Media type', 'cfi' ); ?></strong></label><br>
		<select name="cfi_media_type" id="cfi_media_type">
			<option value="image" <?php selected( $type, 'image' ); ?>><?php esc_html_e( 'Image', 'cfi' ); ?></option>
			<option value="video" <?php selected( $type, 'video' ); ?>><?php esc_html_e( 'Video', 'cfi' ); ?></option>
		</select>
	</p>
	<p class="description">
		<?php esc_html_e( 'Assign one Country and one Program using the boxes on the right. Use Featured Image as the gallery thumbnail (required for videos).', 'cfi' ); ?>
	</p>
	<div id="cfi-video-field" style="<?php echo 'video' === $type ? '' : 'display:none'; ?>">
		<p>
			<label><strong><?php esc_html_e( 'Video file', 'cfi' ); ?></strong></label><br>
			<input type="hidden" name="cfi_video_id" id="cfi_video_id" value="<?php echo esc_attr( (string) $video_id ); ?>">
			<button type="button" class="button" id="cfi-video-upload"><?php esc_html_e( 'Select / Upload Video', 'cfi' ); ?></button>
			<button type="button" class="button" id="cfi-video-remove" style="<?php echo $video_id ? '' : 'display:none'; ?>"><?php esc_html_e( 'Remove', 'cfi' ); ?></button>
		</p>
		<p id="cfi-video-preview">
			<?php if ( $video_url ) : ?>
				<code><?php echo esc_html( basename( $video_url ) ); ?></code>
			<?php endif; ?>
		</p>
	</div>
	<script>
	(function () {
		const typeSelect = document.getElementById('cfi_media_type');
		const videoField = document.getElementById('cfi-video-field');
		const videoInput = document.getElementById('cfi_video_id');
		const preview = document.getElementById('cfi-video-preview');
		const removeBtn = document.getElementById('cfi-video-remove');
		if (!typeSelect || !videoField) return;

		typeSelect.addEventListener('change', function () {
			videoField.style.display = typeSelect.value === 'video' ? '' : 'none';
		});

		document.getElementById('cfi-video-upload')?.addEventListener('click', function (e) {
			e.preventDefault();
			const frame = wp.media({
				title: '<?php echo esc_js( __( 'Select Video', 'cfi' ) ); ?>',
				library: { type: 'video' },
				button: { text: '<?php echo esc_js( __( 'Use this video', 'cfi' ) ); ?>' },
				multiple: false
			});
			frame.on('select', function () {
				const attachment = frame.state().get('selection').first().toJSON();
				videoInput.value = attachment.id;
				preview.innerHTML = '<code>' + attachment.filename + '</code>';
				removeBtn.style.display = '';
			});
			frame.open();
		});

		removeBtn?.addEventListener('click', function (e) {
			e.preventDefault();
			videoInput.value = '';
			preview.innerHTML = '';
			removeBtn.style.display = 'none';
		});
	})();
	</script>
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

	$video_id = isset( $_POST['cfi_video_id'] ) ? absint( $_POST['cfi_video_id'] ) : 0;
	if ( $video_id ) {
		update_post_meta( $post_id, '_cfi_video_id', $video_id );
	} else {
		delete_post_meta( $post_id, '_cfi_video_id' );
	}
}
add_action( 'save_post_cfi_field_media', 'cfi_save_gallery_meta' );

/**
 * Enqueue media scripts on Field Media edit screens.
 *
 * @param string $hook Admin hook.
 */
function cfi_gallery_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || 'cfi_field_media' !== $screen->post_type ) {
		return;
	}
	wp_enqueue_media();
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
			$new['cfi_media_type'] = __( 'Type', 'cfi' );
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
	if ( 'cfi_media_type' !== $column ) {
		return;
	}
	$type = get_post_meta( $post_id, '_cfi_media_type', true ) ?: 'image';
	echo esc_html( ucfirst( $type ) );
}
add_action( 'manage_cfi_field_media_posts_custom_column', 'cfi_gallery_column_content', 10, 2 );

/**
 * Resolve a theme-relative asset path to a full URL.
 *
 * @param string $path Relative or absolute path.
 */
function cfi_gallery_resolve_url( $path ) {
	if ( ! $path ) {
		return '';
	}
	if ( 0 === strpos( $path, 'http' ) ) {
		return $path;
	}
	if ( 0 === strpos( $path, 'assets/' ) ) {
		return trailingslashit( get_template_directory_uri() ) . $path;
	}
	return $path;
}

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

	$thumb = get_post_meta( $post->ID, '_cfi_media_thumb', true );
	$src   = get_post_meta( $post->ID, '_cfi_media_src', true );

	if ( has_post_thumbnail( $post->ID ) ) {
		$thumb_id = get_post_thumbnail_id( $post->ID );
		if ( ! $thumb ) {
			$thumb = wp_get_attachment_image_url( $thumb_id, 'medium_large' ) ?: wp_get_attachment_image_url( $thumb_id, 'large' );
		}
		if ( 'image' === $type && ! $src ) {
			$src = wp_get_attachment_image_url( $thumb_id, 'full' );
		}
	}

	if ( 'video' === $type ) {
		$video_id = (int) get_post_meta( $post->ID, '_cfi_video_id', true );
		if ( $video_id ) {
			$src = wp_get_attachment_url( $video_id ) ?: $src;
		}
	}

	$thumb = cfi_gallery_resolve_url( $thumb );
	$src   = cfi_gallery_resolve_url( $src );

	if ( ! $thumb || ! $src ) {
		return null;
	}

	$gallery_id = get_post_meta( $post->ID, '_cfi_gallery_id', true );
	$id         = $gallery_id ? $gallery_id : 'cfi-media-' . $post->ID;

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
		'id'           => $id,
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
 * Load bundled gallery.json manifest.
 *
 * @return array<string, mixed>|null
 */
function cfi_get_bundled_gallery_manifest() {
	$path = get_template_directory() . '/assets/data/gallery.json';
	if ( ! file_exists( $path ) ) {
		return null;
	}

	$data = json_decode( file_get_contents( $path ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	return is_array( $data ) ? $data : null;
}

/**
 * Gallery manifest for the public page (WordPress posts + bundled fallback).
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

	$bundled = cfi_get_bundled_gallery_manifest();
	$featured = $bundled['featured'] ?? array();

	if ( empty( $gallery ) && $bundled ) {
		$gallery = $bundled['gallery'] ?? array();
	}

	return array(
		'countries'  => $countries,
		'categories' => $categories,
		'featured'   => $featured,
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
 * Seed bundled gallery.json items into Field Media (idempotent).
 */
function cfi_seed_gallery_media() {
	cfi_seed_gallery_terms();

	$bundled = cfi_get_bundled_gallery_manifest();
	if ( ! $bundled || empty( $bundled['gallery'] ) ) {
		update_option( 'cfi_gallery_version', CFI_GALLERY_VERSION );
		return;
	}

	foreach ( $bundled['gallery'] as $item ) {
		if ( empty( $item['id'] ) ) {
			continue;
		}

		$existing = get_posts(
			array(
				'post_type'      => 'cfi_field_media',
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'meta_key'       => '_cfi_gallery_id',
				'meta_value'     => $item['id'],
				'fields'         => 'ids',
			)
		);
		if ( $existing ) {
			continue;
		}

		$title = ! empty( $item['alt'] ) ? $item['alt'] : $item['id'];
		$post_id = wp_insert_post(
			array(
				'post_title'  => $title,
				'post_status' => 'publish',
				'post_type'   => 'cfi_field_media',
			),
			true
		);
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_post_meta( $post_id, '_cfi_gallery_id', sanitize_text_field( $item['id'] ) );
		update_post_meta( $post_id, '_cfi_media_type', ! empty( $item['type'] ) ? $item['type'] : 'image' );
		update_post_meta( $post_id, '_cfi_media_thumb', sanitize_text_field( $item['thumb'] ?? '' ) );
		update_post_meta( $post_id, '_cfi_media_src', sanitize_text_field( $item['src'] ?? '' ) );

		if ( ! empty( $item['country'] ) ) {
			wp_set_object_terms( $post_id, $item['country'], 'cfi_country', false );
		}
		if ( ! empty( $item['category'] ) ) {
			wp_set_object_terms( $post_id, $item['category'], 'cfi_program', false );
		}
	}

	update_option( 'cfi_gallery_version', CFI_GALLERY_VERSION );
}

/**
 * Upgrade hook for gallery seeding.
 */
function cfi_maybe_seed_gallery() {
	$version = (int) get_option( 'cfi_gallery_version', 0 );
	if ( $version >= CFI_GALLERY_VERSION ) {
		return;
	}
	cfi_seed_gallery_media();
}
add_action( 'after_setup_theme', 'cfi_maybe_seed_gallery', 25 );
