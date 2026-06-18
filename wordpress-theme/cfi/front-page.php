<?php
/**
 * Front page template.
 *
 * @package CFI
 */

get_header();
?>

<main id="main">

	<section class="cfi-hero" aria-label="<?php esc_attr_e( 'Welcome', 'cfi' ); ?>">
		<div class="cfi-hero__slides" aria-hidden="true">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<div class="cfi-hero__slide<?php echo 1 === $i ? ' is-active' : ''; ?>" style="background-image:url('<?php echo esc_url( cfi_asset( "media/featured/hero-{$i}.jpg" ) ); ?>')"></div>
			<?php endfor; ?>
		</div>
		<div class="cfi-hero__overlay" aria-hidden="true"></div>
		<div class="cfi-container cfi-hero__content cfi-hero__content--centered">
			<h1><?php echo esc_html( cfi_mod( 'cfi_hero_title', 'Transforming Lives Through Faith, Compassion, and Action' ) ); ?></h1>
			<p class="cfi-hero__sub"><?php echo esc_html( cfi_mod( 'cfi_hero_subtitle', 'CharityFaith International is a global humanitarian and faith-based nonprofit dedicated to uplifting vulnerable communities through education, healthcare assistance, widow empowerment, shelter initiatives, food support, and Christian outreach.' ) ); ?></p>
			<div class="cfi-btn-group cfi-btn-group--center">
				<a href="<?php echo esc_url( cfi_page_url( 'accept-jesus' ) ); ?>" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Accept Jesus Today', 'cfi' ); ?></a>
				<a href="<?php echo esc_url( cfi_page_url( 'prayer-requests' ) ); ?>" class="cfi-btn cfi-btn--secondary"><?php esc_html_e( 'Prayer Requests', 'cfi' ); ?></a>
				<a href="#impact" class="cfi-btn cfi-btn--secondary"><?php esc_html_e( 'Explore Our Impact', 'cfi' ); ?></a>
			</div>
		</div>
		<div class="cfi-hero__dots" role="tablist" aria-label="<?php esc_attr_e( 'Hero slideshow', 'cfi' ); ?>">
			<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
				<button type="button" class="cfi-hero__dot<?php echo 1 === $i ? ' is-active' : ''; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Slide %d', 'cfi' ), $i ) ); ?>"<?php echo 1 === $i ? ' aria-selected="true"' : ''; ?>></button>
			<?php endfor; ?>
		</div>
	</section>

	<section class="cfi-section cfi-section--ivory" id="stats" aria-labelledby="stats-heading">
		<div class="cfi-container">
			<header class="cfi-section__header">
				<span class="cfi-section__label"><?php esc_html_e( 'Our Impact', 'cfi' ); ?></span>
				<h2 id="stats-heading"><?php esc_html_e( 'Lives Changed, Hope Restored', 'cfi' ); ?></h2>
				<p class="cfi-section__lead"><?php esc_html_e( 'Every number represents a family, a child, or a community touched by your generosity and faith in action.', 'cfi' ); ?></p>
			</header>
			<div class="cfi-stats">
				<?php foreach ( cfi_get_stats() as $stat ) : ?>
					<div class="cfi-stat">
						<div class="cfi-stat__number" data-target="<?php echo esc_attr( preg_replace( '/\D/', '', $stat['value'] ) ); ?>"<?php echo $stat['suffix'] ? ' data-suffix="' . esc_attr( $stat['suffix'] ) . '"' : ''; ?>>0</div>
						<div class="cfi-stat__label"><?php echo esc_html( $stat['label'] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="cfi-section cfi-section--dark cfi-salvation-banner" id="salvation" aria-labelledby="salvation-heading">
		<div class="cfi-container cfi-salvation-banner__inner">
			<div>
				<span class="cfi-section__label"><?php esc_html_e( 'Salvation', 'cfi' ); ?></span>
				<h2 id="salvation-heading"><?php esc_html_e( 'Are You Ready for Jesus to Change Your Life?', 'cfi' ); ?></h2>
				<p><?php esc_html_e( 'Wherever you are in the world, you can receive Christ today — and our prayer team will stand with you in faith for what comes next.', 'cfi' ); ?></p>
			</div>
			<div class="cfi-btn-group cfi-btn-group--center">
				<a href="<?php echo esc_url( cfi_page_url( 'accept-jesus' ) ); ?>" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Accept Jesus Today', 'cfi' ); ?></a>
				<a href="<?php echo esc_url( cfi_page_url( 'prayer-requests' ) ); ?>" class="cfi-btn cfi-btn--secondary"><?php esc_html_e( 'Prayer Requests', 'cfi' ); ?></a>
			</div>
		</div>
	</section>

	<section class="cfi-section" id="mission" aria-labelledby="mission-heading">
		<div class="cfi-container">
			<div class="cfi-split">
				<div class="cfi-split__media">
					<img src="<?php echo esc_url( cfi_asset( 'media/featured/mission.jpg' ) ); ?>" alt="<?php esc_attr_e( 'CharityFaith International team serving communities in the field', 'cfi' ); ?>" width="900" height="675" loading="lazy">
					<span class="cfi-split__badge"><?php esc_html_e( 'Faith in action · Dignity for every person', 'cfi' ); ?></span>
				</div>
				<div>
					<span class="cfi-section__label"><?php esc_html_e( 'Our Mission', 'cfi' ); ?></span>
					<h2 id="mission-heading"><?php esc_html_e( 'Bringing Hope Where It Is Needed Most', 'cfi' ); ?></h2>
					<p><?php esc_html_e( 'We believe every person deserves dignity, opportunity, and hope. Through humanitarian assistance and faith-driven outreach, we work alongside communities to create lasting change and restore lives.', 'cfi' ); ?></p>
					<p><?php esc_html_e( 'From hospital bills and school fees to shelter builds and widow livelihood programs, CharityFaith International meets practical needs while sharing the love of Christ — locally and globally.', 'cfi' ); ?></p>
					<a href="<?php echo esc_url( cfi_page_url( 'partners' ) ); ?>" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Join Our Mission', 'cfi' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<section class="cfi-section cfi-section--ivory" id="programs" aria-labelledby="programs-heading">
		<div class="cfi-container">
			<header class="cfi-section__header">
				<span class="cfi-section__label"><?php esc_html_e( 'What We Do', 'cfi' ); ?></span>
				<h2 id="programs-heading"><?php esc_html_e( 'Programs That Transform Communities', 'cfi' ); ?></h2>
				<p class="cfi-section__lead"><?php esc_html_e( 'Comprehensive humanitarian initiatives rooted in compassion, sustainability, and faith.', 'cfi' ); ?></p>
			</header>
			<div class="cfi-programs">
				<?php foreach ( cfi_get_programs() as $program ) : ?>
					<article class="cfi-program-card">
						<div class="cfi-program-card__icon" aria-hidden="true"><?php echo esc_html( $program['icon'] ); ?></div>
						<div class="cfi-program-card__body">
							<h3><?php echo esc_html( $program['title'] ); ?></h3>
							<p><?php echo esc_html( $program['text'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/section', 'map' ); ?>

	<section class="cfi-section cfi-section--ivory" id="stories" aria-labelledby="stories-heading">
		<div class="cfi-container">
			<header class="cfi-section__header">
				<span class="cfi-section__label"><?php esc_html_e( 'Stories of Hope', 'cfi' ); ?></span>
				<h2 id="stories-heading"><?php esc_html_e( 'Lives Transformed', 'cfi' ); ?></h2>
				<p class="cfi-section__lead"><?php esc_html_e( 'Real stories from beneficiaries, widows, children, and volunteers whose lives have been changed.', 'cfi' ); ?></p>
			</header>
			<div class="cfi-stories">
				<article class="cfi-story-featured">
					<img src="<?php echo esc_url( cfi_asset( 'media/featured/story-featured.jpg' ) ); ?>" alt="" width="900" height="600" loading="lazy">
					<div class="cfi-story-featured__overlay">
						<span class="cfi-story-card__tag"><?php esc_html_e( 'Education Success', 'cfi' ); ?></span>
						<h3><?php esc_html_e( 'From Uncertainty to the Classroom', 'cfi' ); ?></h3>
						<p><?php esc_html_e( 'After losing her father, Grace could not afford school fees. CFI\'s education fund restored her hope — today she excels in her studies and dreams of becoming a nurse.', 'cfi' ); ?></p>
						<a href="<?php echo esc_url( cfi_blog_url() ); ?>" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Read Full Story', 'cfi' ); ?></a>
					</div>
				</article>
				<div class="cfi-story-list">
					<?php
					$story_cards = array(
						array( 'img' => 'story-1.jpg', 'tag' => __( 'Widow Empowerment', 'cfi' ), 'title' => __( 'A New Beginning Through Small Business Support', 'cfi' ) ),
						array( 'img' => 'story-2.jpg', 'tag' => __( 'Healthcare', 'cfi' ), 'title' => __( 'Healing Hands: Hospital Bills Covered', 'cfi' ) ),
						array( 'img' => 'story-3.jpg', 'tag' => __( 'Volunteer Story', 'cfi' ), 'title' => __( 'Serving Together at the Crusade Outreach', 'cfi' ) ),
						array( 'img' => 'story-4.jpg', 'tag' => __( 'Before & After', 'cfi' ), 'title' => __( 'Shelter Project: A Safe Home at Last', 'cfi' ) ),
					);
					foreach ( $story_cards as $card ) :
						?>
						<a href="<?php echo esc_url( cfi_blog_url() ); ?>" class="cfi-story-card">
							<img src="<?php echo esc_url( cfi_asset( 'media/featured/' . $card['img'] ) ); ?>" alt="" width="240" height="160" loading="lazy">
							<div class="cfi-story-card__body">
								<span class="cfi-story-card__tag"><?php echo esc_html( $card['tag'] ); ?></span>
								<h4><?php echo esc_html( $card['title'] ); ?></h4>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<p class="cfi-text-center" style="margin-top:2.5rem">
				<a href="<?php echo esc_url( cfi_page_url( 'gallery' ) ); ?>" class="cfi-btn cfi-btn--outline"><?php esc_html_e( 'Explore Photo & Video Gallery', 'cfi' ); ?></a>
			</p>
		</div>
	</section>

	<section class="cfi-section" id="founder" aria-labelledby="founder-heading">
		<div class="cfi-container">
			<div class="cfi-founder">
				<div class="cfi-founder__photo">
					<img src="<?php echo esc_url( cfi_asset( 'media/featured/founder.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Evangelist Ebel Philips blessing children during a CharityFaith International outreach', 'cfi' ); ?>" width="1500" height="2000" loading="lazy">
				</div>
				<div>
					<span class="cfi-section__label"><?php esc_html_e( 'Leadership', 'cfi' ); ?></span>
					<h2 id="founder-heading"><?php esc_html_e( 'Meet Evangelist Ebel Philips', 'cfi' ); ?></h2>
					<p><?php esc_html_e( 'Evangelist Ebel Philips is a faith leader and humanitarian visionary called to serve the poor, the widow, and the fatherless. Her heart for global outreach has shaped CharityFaith International into a trusted channel of compassion and gospel hope.', 'cfi' ); ?></p>
					<blockquote class="cfi-founder__quote">&ldquo;<?php esc_html_e( 'God did not call us to pity the vulnerable — He called us to stand with them, restore their dignity, and point them to everlasting hope.', 'cfi' ); ?>&rdquo;</blockquote>
					<p><?php esc_html_e( 'Through crusades, community development, and hands-on aid, Evangelist Ebel leads CFI with integrity, prayer, and an unwavering commitment to Christ-centered service.', 'cfi' ); ?></p>
					<a href="<?php echo esc_url( cfi_page_url( 'founder' ) ); ?>" class="cfi-btn cfi-btn--dark"><?php esc_html_e( 'Read Full Biography', 'cfi' ); ?></a>
				</div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/section', 'partners-cta' ); ?>

	<section class="cfi-section">
		<div class="cfi-container">
			<div class="cfi-cta">
				<img src="<?php echo esc_url( cfi_asset( 'images/cfi-logo.png' ) ); ?>" alt="" width="80" height="48" style="margin:0 auto 1.5rem;opacity:0.95">
				<h2><?php esc_html_e( 'Stand With Us in Faith and Compassion', 'cfi' ); ?></h2>
				<p><?php esc_html_e( 'Pray with us, partner with our mission, or give to support humanitarian outreach across nine nations.', 'cfi' ); ?></p>
				<div class="cfi-btn-group cfi-btn-group--center">
					<a href="<?php echo esc_url( cfi_page_url( 'prayer-requests' ) ); ?>" class="cfi-btn cfi-btn--primary"><?php esc_html_e( 'Submit a Prayer Request', 'cfi' ); ?></a>
					<a href="<?php echo esc_url( cfi_page_url( 'donate' ) ); ?>" class="cfi-btn cfi-btn--secondary"><?php esc_html_e( 'Give to CFI', 'cfi' ); ?></a>
					<a href="<?php echo esc_url( cfi_page_url( 'contact' ) ); ?>" class="cfi-btn cfi-btn--secondary"><?php esc_html_e( 'Contact Our Team', 'cfi' ); ?></a>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
