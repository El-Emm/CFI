<?php
/**
 * Homepage stories section.
 *
 * @package CFI
 */
$homepage_stories = cfi_get_homepage_stories();
$featured         = $homepage_stories['featured'];
$cards            = $homepage_stories['cards'];
?>
<section class="cfi-section cfi-section--ivory" id="stories" aria-labelledby="stories-heading">
	<div class="cfi-container">
		<header class="cfi-section__header">
			<span class="cfi-section__label"><?php esc_html_e( 'Stories of Hope', 'cfi' ); ?></span>
			<h2 id="stories-heading"><?php esc_html_e( 'Lives Transformed', 'cfi' ); ?></h2>
			<p class="cfi-section__lead"><?php esc_html_e( 'Real stories from beneficiaries, widows, children, and volunteers whose lives have been changed.', 'cfi' ); ?></p>
		</header>
		<?php if ( $featured ) : ?>
			<div class="cfi-stories">
				<article class="cfi-story-featured">
					<img src="<?php echo esc_url( $featured['image_url'] ); ?>" alt="<?php echo esc_attr( $featured['title'] ); ?>" width="900" height="600" loading="lazy">
					<div class="cfi-story-featured__overlay">
						<span class="cfi-story-card__tag"><?php echo esc_html( $featured['tag'] ); ?></span>
						<h3><?php echo esc_html( $featured['title'] ); ?></h3>
						<p><?php echo esc_html( $featured['excerpt'] ); ?></p>
						<a href="<?php echo esc_url( $featured['url'] ); ?>" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Read Full Story', 'cfi' ); ?></a>
					</div>
				</article>
				<div class="cfi-story-list">
					<?php foreach ( $cards as $card ) : ?>
						<a href="<?php echo esc_url( $card['url'] ); ?>" class="cfi-story-card">
							<img src="<?php echo esc_url( $card['thumb_url'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" width="240" height="160" loading="lazy">
							<div class="cfi-story-card__body">
								<span class="cfi-story-card__tag"><?php echo esc_html( $card['tag'] ); ?></span>
								<h4><?php echo esc_html( $card['title'] ); ?></h4>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
		<p class="cfi-text-center" style="margin-top:2.5rem">
			<a href="<?php echo esc_url( cfi_page_url( 'gallery' ) ); ?>" class="cfi-btn cfi-btn--outline"><?php esc_html_e( 'Explore Photo & Video Gallery', 'cfi' ); ?></a>
		</p>
	</div>
</section>
