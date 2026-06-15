<?php
/**
 * Generic page template.
 *
 * @package CFI
 */

get_header();
?>

<main id="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<header class="cfi-page-hero">
			<div class="cfi-container">
				<h1><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</div>
		</header>
		<section class="cfi-section">
			<div class="cfi-container cfi-container--narrow entry-content">
				<?php the_content(); ?>
			</div>
		</section>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
