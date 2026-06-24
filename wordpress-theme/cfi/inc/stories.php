<?php
/**
 * Impact story definitions and sample blog post seeding.
 *
 * @package CFI
 */

defined( 'ABSPATH' ) || exit;

define( 'CFI_STORIES_VERSION', 1 );

/**
 * Featured impact stories shown on the homepage and blog.
 *
 * @return array<int, array<string, mixed>>
 */
function cfi_get_story_definitions() {
	return array(
		array(
			'slug'       => 'grace-education-classroom',
			'title'      => 'From Uncertainty to the Classroom',
			'tag'        => 'Education Success',
			'category'   => 'Impact Stories',
			'image'      => 'media/featured/story-featured.jpg',
			'excerpt'    => 'After losing her father, Grace could not afford school fees. CFI\'s education fund restored her hope — today she excels in her studies and dreams of becoming a nurse.',
			'featured'   => true,
			'content'    => <<<'HTML'
<p>When Grace was twelve, her world changed overnight. After her father passed away, her mother struggled to provide food and rent — let alone school fees, uniforms, and books. Grace stopped attending classes and began helping at home, quietly accepting that her education might be over.</p>
<p>Local church partners connected Grace's family with CharityFaith International's education support program. Through donor generosity, CFI paid her school fees, provided a uniform, notebooks, and essential supplies, and checked in on her progress throughout the term.</p>
<p>Today, Grace is back in the classroom — not simply attending, but thriving. Her teachers describe her as diligent, kind, and determined. She dreams of becoming a nurse so she can care for others the way CFI and its partners cared for her family.</p>
<p>"I thought my future was closed," Grace shared. "Now I believe God has a plan for me. I want to help children who feel forgotten, the way people helped me."</p>
<p>Grace's story reflects why education is central to CFI's mission: when a child returns to school, hope returns to a household. Every gift to our education fund opens doors that poverty tried to shut.</p>
HTML,
		),
		array(
			'slug'       => 'widow-small-business-support',
			'title'      => 'A New Beginning Through Small Business Support',
			'tag'        => 'Widow Empowerment',
			'category'   => 'Community Development',
			'image'      => 'media/featured/story-1.jpg',
			'excerpt'    => 'After her husband\'s passing, Esther had no steady income. A CFI micro-grant and mentoring helped her launch a tailoring business that now supports her children.',
			'featured'   => false,
			'content'    => <<<'HTML'
<p>Esther became a widow in her early forties, left to raise three children without savings or stable employment. She knew how to sew and had repaired clothes for neighbors, but she lacked a sewing machine, fabric capital, and the confidence to turn skill into income.</p>
<p>CFI's widow empowerment initiative provided Esther with a small business startup grant, a reliable sewing machine, and mentoring from a local business volunteer. Over several months, she learned pricing, customer service, and how to manage household and business expenses faithfully.</p>
<p>Esther now runs a modest tailoring shop from her home. She makes school uniforms for children in her community — including garments for families who cannot afford market prices. Her income covers food, school costs, and basic healthcare for her children.</p>
<p>"I am not only surviving," Esther said. "I am building. CFI did not give me charity alone — they gave me dignity and a path forward."</p>
<p>Widow empowerment is not a single gift; it is a partnership. When widows gain sustainable livelihoods, entire families are strengthened and communities are transformed.</p>
HTML,
		),
		array(
			'slug'       => 'healing-hands-hospital-bills',
			'title'      => 'Healing Hands: Hospital Bills Covered',
			'tag'        => 'Healthcare',
			'category'   => 'Impact Stories',
			'image'      => 'media/featured/story-2.jpg',
			'excerpt'    => 'When Samuel needed urgent surgery, his family faced impossible hospital bills. CFI\'s healthcare fund stepped in so he could receive treatment and recover at home.',
			'featured'   => false,
			'content'    => <<<'HTML'
<p>Samuel, a father of four, fell seriously ill with complications that required hospitalization and surgery. The family sold belongings and borrowed from relatives, but the remaining bill was still far beyond their means. Without payment, Samuel could not be discharged — and without discharge, he could not heal surrounded by his family.</p>
<p>A CFI field partner submitted an urgent request to our healthcare assistance fund. Donors responded, and the outstanding hospital balance was covered. Samuel received the procedure he needed and returned home to recover with his wife and children beside him.</p>
<p>Months later, Samuel has regained strength and returned to work part-time. His family still speaks with gratitude about the night they thought all options were exhausted.</p>
<p>"We prayed for a miracle," his wife shared. "God answered through people we had never met — people who chose compassion."</p>
<p>Healthcare assistance is often the difference between crisis and recovery. CFI's fund exists for families facing urgent medical needs when hope seems out of reach.</p>
HTML,
		),
		array(
			'slug'       => 'crusade-volunteer-outreach',
			'title'      => 'Serving Together at the Crusade Outreach',
			'tag'        => 'Volunteer Story',
			'category'   => 'Crusades',
			'image'      => 'media/featured/story-3.jpg',
			'excerpt'    => 'Volunteers from three nations joined CFI for a crusade outreach — sharing the gospel, distributing food, and welcoming hundreds into fellowship.',
			'featured'   => false,
			'content'    => <<<'HTML'
<p>CFI crusades bring together worship, preaching, and practical compassion. At a recent outreach, volunteers from local churches and international partners served side by side — setting up tents, preparing food packages, praying with families, and welcoming newcomers into community fellowship.</p>
<p>James, a volunteer from a partner church, arrived early each morning to help organize children's activities while parents attended sessions. "I came to serve tables," he laughed, "but God used me to listen — so many people needed someone to hear their story."</p>
<p>Over three days, hundreds received food support, dozens of children participated in faith-based programs, and many made first-time decisions to follow Christ. Local pastors continued follow-up discipleship in the weeks that followed.</p>
<p>Crusade outreach is not a single event on a calendar — it is a launch point for ongoing ministry. Volunteers extend CFI's reach and remind communities that the Church is present in both word and deed.</p>
<p>Whether you serve locally or abroad, there is a place for your gifts in CFI's mission. Visit our Partner page to learn how you can join the next outreach.</p>
HTML,
		),
		array(
			'slug'       => 'shelter-safe-home',
			'title'      => 'Shelter Project: A Safe Home at Last',
			'tag'        => 'Before & After',
			'category'   => 'Community Development',
			'image'      => 'media/featured/story-4.jpg',
			'excerpt'    => 'The Okonkwo family lived in a damaged structure for years. CFI\'s shelter project built a safe, dignified home where their children can sleep without fear of rain or collapse.',
			'featured'   => false,
			'content'    => <<<'HTML'
<p>For years, the Okonkwo family slept beneath a leaking roof in a structure that worsened each rainy season. The parents worried constantly — especially at night — that the walls would not hold. Their children studied by lamplight in corners where water did not pool.</p>
<p>CFI's shelter initiative selected the family for a new home build supported by donors and local volunteers. Over several weeks, teams laid foundation, raised walls, and installed a secure roof. The family participated in the work alongside builders, taking ownership of the blessing unfolding before them.</p>
<p>On dedication day, the Okonkwos welcomed neighbors, pastors, and CFI partners into a dry, solid home — simple, but safe. The mother wept as she thanked God and the supporters who made it possible.</p>
<p>"My children can sleep," she said. "That is everything."</p>
<p>Shelter is more than construction — it is stability, safety, and dignity restored. CFI continues to identify families in critical housing need and invites partners to help build the next home.</p>
HTML,
		),
	);
}

/**
 * URL for a story — WordPress post if available, else static fallback path.
 */
function cfi_get_story_post( $slug ) {
	$posts = get_posts(
		array(
			'name'          => $slug,
			'post_type'     => 'post',
			'post_status'   => 'publish',
			'numberposts'   => 1,
		)
	);
	return $posts ? $posts[0] : null;
}

function cfi_story_url( $slug ) {
	$post = cfi_get_story_post( $slug );
	if ( $post ) {
		return get_permalink( $post );
	}
	return cfi_blog_url() . '?story=' . rawurlencode( $slug );
}

/**
 * Featured image URL for a story post, with theme fallback.
 *
 * @param array<string, mixed> $story Story definition.
 * @param string               $size  Image size.
 */
function cfi_story_image_url( $story, $size = 'large' ) {
	$post = cfi_get_story_post( $story['slug'] );
	if ( $post && has_post_thumbnail( $post ) ) {
		$url = get_the_post_thumbnail_url( $post, $size );
		if ( $url ) {
			return $url;
		}
	}
	return cfi_asset( $story['image'] );
}

/**
 * Merge story definition with published blog post data.
 *
 * @param array<string, mixed> $story Story definition.
 * @return array<string, mixed>
 */
function cfi_enrich_story_from_post( $story ) {
	$post = cfi_get_story_post( $story['slug'] );
	if ( ! $post ) {
		return array_merge(
			$story,
			array(
				'url'       => cfi_story_url( $story['slug'] ),
				'image_url' => cfi_asset( $story['image'] ),
				'thumb_url' => cfi_asset( $story['image'] ),
			)
		);
	}

	$tag = get_post_meta( $post->ID, '_cfi_story_tag', true );

	return array_merge(
		$story,
		array(
			'title'     => get_the_title( $post ),
			'excerpt'   => has_excerpt( $post ) ? get_the_excerpt( $post ) : $story['excerpt'],
			'tag'       => $tag ? $tag : $story['tag'],
			'url'       => get_permalink( $post ),
			'image_url' => cfi_story_image_url( $story, 'large' ),
			'thumb_url' => cfi_story_image_url( $story, 'medium_large' ),
		)
	);
}

/**
 * Homepage stories split into featured + cards.
 *
 * @return array{featured: array<string, mixed>|null, cards: array<int, array<string, mixed>>}
 */
function cfi_get_homepage_stories() {
	$featured = null;
	$cards    = array();

	foreach ( cfi_get_story_definitions() as $story ) {
		$enriched = cfi_enrich_story_from_post( $story );
		if ( ! empty( $story['featured'] ) ) {
			$featured = $enriched;
		} else {
			$cards[] = $enriched;
		}
	}

	return array(
		'featured' => $featured,
		'cards'    => $cards,
	);
}

/**
 * Seed sample impact stories as blog posts (idempotent).
 */
function cfi_seed_story_posts() {
	if ( ! function_exists( 'wp_insert_post' ) ) {
		return;
	}

	foreach ( cfi_get_story_definitions() as $story ) {
		$existing = get_posts(
			array(
				'name'        => $story['slug'],
				'post_type'   => 'post',
				'post_status' => 'any',
				'numberposts' => 1,
			)
		);
		if ( $existing ) {
			continue;
		}

		$cat_id = 0;
		if ( ! empty( $story['category'] ) ) {
			$term = term_exists( $story['category'], 'category' );
			if ( ! $term ) {
				$term = wp_insert_term( $story['category'], 'category' );
			}
			if ( ! is_wp_error( $term ) ) {
				$cat_id = (int) ( is_array( $term ) ? $term['term_id'] : $term );
			}
		}

		$post_id = wp_insert_post(
			array(
				'post_title'   => $story['title'],
				'post_name'    => $story['slug'],
				'post_content' => $story['content'],
				'post_excerpt' => $story['excerpt'],
				'post_status'  => 'publish',
				'post_type'    => 'post',
				'post_category'=> $cat_id ? array( $cat_id ) : array(),
			),
			true
		);

		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}

		update_post_meta( $post_id, '_cfi_story_tag', sanitize_text_field( $story['tag'] ) );
		cfi_maybe_set_story_thumbnail( $post_id, $story['image'] );
	}

	update_option( 'cfi_stories_version', CFI_STORIES_VERSION );
}

/**
 * Attach theme image as featured image when possible.
 */
function cfi_maybe_set_story_thumbnail( $post_id, $relative_path ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return;
	}

	$path = get_template_directory() . '/assets/' . ltrim( $relative_path, '/' );
	if ( ! file_exists( $path ) ) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = wp_tempnam( basename( $path ) );
	if ( ! $tmp ) {
		return;
	}

	copy( $path, $tmp ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_copy

	$file_array = array(
		'name'     => basename( $path ),
		'tmp_name' => $tmp,
	);

	$attach_id = media_handle_sideload( $file_array, $post_id );
	if ( is_wp_error( $attach_id ) ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		return;
	}

	set_post_thumbnail( $post_id, $attach_id );
}

/**
 * Upgrade hook for story seeding.
 */
function cfi_maybe_seed_stories() {
	$version = (int) get_option( 'cfi_stories_version', 0 );
	if ( $version >= CFI_STORIES_VERSION ) {
		return;
	}
	cfi_seed_story_posts();
}
add_action( 'after_setup_theme', 'cfi_maybe_seed_stories', 20 );
