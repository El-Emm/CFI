<?php
/**
 * Header template.
 *
 * @package CFI
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main" class="cfi-skip-link"><?php esc_html_e( 'Skip to main content', 'cfi' ); ?></a>

<header class="cfi-header" role="banner">
	<div class="cfi-container cfi-header__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cfi-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' — Home' ); ?>">
			<?php
			$custom_logo_id = get_theme_mod( 'custom_logo' );
			if ( $custom_logo_id ) :
				$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
				if ( $logo ) :
					?>
					<img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> logo" class="cfi-logo__img custom-logo" width="<?php echo esc_attr( $logo[1] ); ?>" height="<?php echo esc_attr( $logo[2] ); ?>">
					<?php
				endif;
			else :
				?>
				<img src="<?php echo esc_url( cfi_asset( 'images/cfi-logo.png' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> logo" class="cfi-logo__img" width="120" height="56">
			<?php endif; ?>
			<span class="cfi-logo__text"><?php bloginfo( 'name' ); ?></span>
		</a>

		<nav class="cfi-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'cfi' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cfi-nav__link<?php echo esc_attr( cfi_nav_active( 'home' ) ); ?>"><?php esc_html_e( 'Home', 'cfi' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/#mission' ) ); ?>" class="cfi-nav__link"><?php esc_html_e( 'Mission', 'cfi' ); ?></a>
			<a href="<?php echo esc_url( home_url( '/#programs' ) ); ?>" class="cfi-nav__link"><?php esc_html_e( 'Programs', 'cfi' ); ?></a>
			<a href="<?php echo esc_url( cfi_page_url( 'prayer-requests' ) ); ?>" class="cfi-nav__link<?php echo esc_attr( cfi_nav_active( 'prayer-requests' ) ); ?>"><?php esc_html_e( 'Prayer Requests', 'cfi' ); ?></a>
			<a href="<?php echo esc_url( cfi_page_url( 'gallery' ) ); ?>" class="cfi-nav__link<?php echo esc_attr( cfi_nav_active( 'gallery' ) ); ?>"><?php esc_html_e( 'Media', 'cfi' ); ?></a>
			<a href="<?php echo esc_url( cfi_page_url( 'founder' ) ); ?>" class="cfi-nav__link<?php echo esc_attr( cfi_nav_active( 'founder' ) ); ?>"><?php esc_html_e( 'Founder', 'cfi' ); ?></a>
			<a href="<?php echo esc_url( cfi_blog_url() ); ?>" class="cfi-nav__link<?php echo esc_attr( cfi_nav_active( 'blog' ) ); ?>"><?php esc_html_e( 'News', 'cfi' ); ?></a>
			<a href="<?php echo esc_url( cfi_page_url( 'contact' ) ); ?>" class="cfi-nav__link<?php echo esc_attr( cfi_nav_active( 'contact' ) ); ?>"><?php esc_html_e( 'Contact', 'cfi' ); ?></a>
		</nav>

		<div class="cfi-header__actions">
			<a href="<?php echo esc_url( cfi_page_url( 'accept-jesus' ) ); ?>" class="cfi-btn cfi-btn--primary cfi-header__cta"><?php esc_html_e( 'Accept Jesus Today', 'cfi' ); ?></a>
			<button type="button" class="cfi-menu-toggle" aria-expanded="false" aria-controls="mobile-nav" aria-label="<?php esc_attr_e( 'Open menu', 'cfi' ); ?>">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<nav id="mobile-nav" class="cfi-mobile-nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'cfi' ); ?>" hidden>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="cfi-mobile-nav__link"><?php esc_html_e( 'Home', 'cfi' ); ?></a>
	<a href="<?php echo esc_url( cfi_page_url( 'prayer-requests' ) ); ?>" class="cfi-mobile-nav__link"><?php esc_html_e( 'Prayer Requests', 'cfi' ); ?></a>
	<a href="<?php echo esc_url( home_url( '/#programs' ) ); ?>" class="cfi-mobile-nav__link"><?php esc_html_e( 'Programs', 'cfi' ); ?></a>
	<a href="<?php echo esc_url( cfi_page_url( 'gallery' ) ); ?>" class="cfi-mobile-nav__link"><?php esc_html_e( 'Media Gallery', 'cfi' ); ?></a>
	<a href="<?php echo esc_url( cfi_page_url( 'founder' ) ); ?>" class="cfi-mobile-nav__link"><?php esc_html_e( 'Founder', 'cfi' ); ?></a>
	<a href="<?php echo esc_url( cfi_page_url( 'partners' ) ); ?>" class="cfi-mobile-nav__link"><?php esc_html_e( 'Partner With Us', 'cfi' ); ?></a>
	<a href="<?php echo esc_url( cfi_blog_url() ); ?>" class="cfi-mobile-nav__link"><?php esc_html_e( 'News & Impact', 'cfi' ); ?></a>
	<a href="<?php echo esc_url( cfi_page_url( 'contact' ) ); ?>" class="cfi-mobile-nav__link"><?php esc_html_e( 'Contact', 'cfi' ); ?></a>
	<a href="<?php echo esc_url( cfi_page_url( 'donate' ) ); ?>" class="cfi-mobile-nav__link"><?php esc_html_e( 'Donate', 'cfi' ); ?></a>
	<a href="<?php echo esc_url( cfi_page_url( 'accept-jesus' ) ); ?>" class="cfi-btn cfi-btn--primary" style="margin-top:1.5rem;width:100%"><?php esc_html_e( 'Accept Jesus Today', 'cfi' ); ?></a>
</nav>
