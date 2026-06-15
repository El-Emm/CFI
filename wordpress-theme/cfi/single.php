<?php
/**
 * Single blog post template.
 *
 * @package CFI
 */

get_header();
?>

<main id="main">
	<article <?php post_class( 'cfi-section' ); ?>>
		<div class="cfi-container cfi-container--narrow">
			<header class="cfi-section__header" style="text-align:left;margin-bottom:2rem">
				<span class="cfi-blog-card__meta"><?php the_category( ', ' ); ?> · <?php echo esc_html( get_the_date() ); ?></span>
				<h1><?php the_title(); ?></h1>
			</header>
			<?php if ( has_post_thumbnail() ) : ?>
				<div style="margin-bottom:2rem;border-radius:var(--cfi-radius-lg);overflow:hidden">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<p style="margin-top:2rem">
				<a href="<?php echo esc_url( cfi_blog_url() ); ?>" class="cfi-btn cfi-btn--outline">&larr; <?php esc_html_e( 'Back to News', 'cfi' ); ?></a>
			</p>
		</div>
	</article>
</main>

<?php get_footer(); ?>
