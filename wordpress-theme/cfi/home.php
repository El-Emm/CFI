<?php
/**
 * Blog posts index (News & Impact).
 *
 * @package CFI
 */

get_header();
?>

<main id="main">
	<header class="cfi-page-hero">
		<div class="cfi-container">
			<h1><?php esc_html_e( 'News & Impact Blog', 'cfi' ); ?></h1>
			<p><?php esc_html_e( 'Stories from the field, event updates, and announcements from CharityFaith International.', 'cfi' ); ?></p>
		</div>
	</header>

	<section class="cfi-section">
		<div class="cfi-container">
			<?php if ( have_posts() ) : ?>
				<div class="cfi-blog-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<a href="<?php the_permalink(); ?>" class="cfi-blog-card">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="cfi-blog-card__img"><?php the_post_thumbnail( 'medium_large' ); ?></div>
							<?php else : ?>
								<div class="cfi-blog-card__img">
									<img src="<?php echo esc_url( cfi_asset( 'media/featured/mission.jpg' ) ); ?>" alt="" loading="lazy">
								</div>
							<?php endif; ?>
							<div class="cfi-blog-card__body">
								<span class="cfi-blog-card__meta"><?php the_category( ', ' ); ?></span>
								<h3><?php the_title(); ?></h3>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
								<span class="cfi-blog-card__link"><?php esc_html_e( 'Read more →', 'cfi' ); ?></span>
							</div>
						</a>
					<?php endwhile; ?>
				</div>
				<div class="cfi-text-center" style="margin-top:2rem"><?php the_posts_pagination(); ?></div>
			<?php else : ?>
				<p class="cfi-text-center"><?php esc_html_e( 'No posts yet. Check back soon for impact stories and field reports.', 'cfi' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
