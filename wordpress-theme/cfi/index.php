<?php
/**
 * Fallback index template.
 *
 * @package CFI
 */

get_header();
?>

<main id="main" class="cfi-section">
	<div class="cfi-container">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'cfi-blog-card' ); ?> style="display:block;margin-bottom:2rem">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="cfi-blog-card__img"><?php the_post_thumbnail(); ?></div>
					<?php endif; ?>
					<div class="cfi-blog-card__body">
						<span class="cfi-blog-card__meta"><?php the_category( ', ' ); ?></span>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php the_excerpt(); ?>
					</div>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No content found.', 'cfi' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
