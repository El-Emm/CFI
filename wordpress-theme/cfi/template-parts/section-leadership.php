<?php
/**
 * Homepage leadership slider.
 *
 * @package CFI
 */
$profiles = cfi_get_leadership_profiles();
?>
<section class="cfi-section" id="founder" aria-labelledby="founder-heading">
	<div class="cfi-container">
		<div class="cfi-founder-slider" data-leadership-slider>
			<div class="cfi-founder-slider__track" aria-live="polite">
				<?php foreach ( $profiles as $index => $profile ) : ?>
					<article class="cfi-founder cfi-founder-slider__slide<?php echo 0 === $index ? ' is-active' : ''; ?>"
						aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>">
						<div class="cfi-founder__photo">
							<img src="<?php echo esc_url( cfi_asset( $profile['photo'] ) ); ?>"
								alt="<?php echo esc_attr( $profile['photo_alt'] ); ?>"
								width="1500" height="2000" loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>">
						</div>
						<div>
							<span class="cfi-section__label"><?php esc_html_e( 'Leadership', 'cfi' ); ?></span>
							<h2<?php echo 0 === $index ? ' id="founder-heading"' : ''; ?>><?php echo esc_html( $profile['heading'] ); ?></h2>
							<?php
							$quote_after = isset( $profile['quote_after'] ) ? (int) $profile['quote_after'] : -1;
							foreach ( $profile['paragraphs'] as $p_index => $paragraph ) :
								?>
								<p><?php echo esc_html( $paragraph ); ?></p>
								<?php if ( ! empty( $profile['quote'] ) && $p_index === $quote_after ) : ?>
									<blockquote class="cfi-founder__quote">&ldquo;<?php echo esc_html( $profile['quote'] ); ?>&rdquo;</blockquote>
								<?php endif; ?>
							<?php endforeach; ?>
							<a href="<?php echo esc_url( $profile['cta']['url'] ); ?>" class="cfi-btn cfi-btn--dark"><?php echo esc_html( $profile['cta']['label'] ); ?></a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<div class="cfi-founder-slider__nav" role="tablist" aria-label="<?php esc_attr_e( 'Leadership profiles', 'cfi' ); ?>">
				<button type="button" class="cfi-founder-slider__arrow cfi-founder-slider__arrow--prev" aria-label="<?php esc_attr_e( 'Previous leader', 'cfi' ); ?>">&larr;</button>
				<div class="cfi-founder-slider__dots">
					<?php foreach ( $profiles as $index => $profile ) : ?>
						<button type="button"
							class="cfi-founder-slider__dot<?php echo 0 === $index ? ' is-active' : ''; ?>"
							aria-label="<?php echo esc_attr( $profile['heading'] ); ?>"
							aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"></button>
					<?php endforeach; ?>
				</div>
				<button type="button" class="cfi-founder-slider__arrow cfi-founder-slider__arrow--next" aria-label="<?php esc_attr_e( 'Next leader', 'cfi' ); ?>">&rarr;</button>
			</div>
		</div>
	</div>
</section>
