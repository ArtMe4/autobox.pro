<?php /* The Header */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

	<head>
        <?php
        if ($_SERVER['HTTP_HOST'] == 'basszone.tmweb.ru')
            echo '<meta name="robots" content="noindex" />';
        ?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="cmsmagazine" content="4be1bfa70b3d4b0b650c5469488496b4" />
		<link rel="profile" href="https://gmpg.org/xfn/11">
		<link rel="icon" href="/favicon.png" type="image/x-icon">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<div id="page" class="site"><!-- Site's Wrapper -->

			<header class="site-header"><!-- Site's Header -->
                <?php do_action( 'chromium_before_header' ); ?>
                <?php if (! chromium_elementor_header_enabled() ) :?>
                    <?php /* Top panel */
                    if ( true == get_theme_mod( 'header_top_panel', true ) && (is_active_sidebar('top-sidebar-left') || is_active_sidebar('top-sidebar-right')) ) {
                        get_template_part( 'template-parts/top-panel' );
                    } ?>

                    <?php /* Logo group */
                        get_template_part( 'template-parts/logo-group' );
                    ?>

                    <?php if (has_nav_menu( 'primary-nav' )) :
                        $nav_class = '';
                        if ( true == get_theme_mod('primary_nav_widgets', false) && (is_active_sidebar('primary-nav-widgets')) ) {
                            $nav_class = ' with-widgets';
                            if ( 'left' == get_theme_mod('primary_nav_widgets_position', 'right') ) {
                                $nav_class .= ' reversed';
                            }
                        } ?>
                        <nav id="site-navigation" class="main-navigation primary-nav<?php echo esc_attr($nav_class); ?>" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement" role="navigation"><!-- Primary nav -->
                            <a class="screen-reader-text skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'chromium' ); ?></a>
                            <?php if ( true == get_theme_mod('primary_nav_widgets', false) && (is_active_sidebar('primary-nav-widgets')) ) { echo '<div class="primary-nav-wrapper">'; } ?>
                            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'chromium' ); ?></button>
                            <?php
                            wp_nav_menu( array('theme_location'  => 'primary-nav') );
                            ?>
                            <?php if ( true == get_theme_mod('primary_nav_widgets', false) && (is_active_sidebar('primary-nav-widgets')) ) { ?>
                                <aside id="sidebar-nav" class="widget-area nav-sidebar" role="complementary">
                                    <?php dynamic_sidebar( 'primary-nav-widgets' ); ?>
                                </aside>
                            <?php } ?>
                            <?php if ( true == get_theme_mod('primary_nav_widgets', false) && (is_active_sidebar('primary-nav-widgets')) ) { echo '</div>'; } ?>
                        </nav><!-- end of Primary nav -->
                    <?php endif; ?>
                    <?php if ( ( '' !== get_theme_mod('header_custom_area', '') ) && ( is_front_page() ) ) : ?>
                        <div class="home-header-static-hero-block">
                        <?php
                            echo do_shortcode(wp_kses_post(get_theme_mod('header_custom_area', '')));
                        ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <!-- Global site tag (gtag.js) - Google Analytics -->
                <script async src="https://www.googletagmanager.com/gtag/js?id=UA-153981354-2"></script>
                <script>
                  window.dataLayer = window.dataLayer || [];
                  function gtag(){dataLayer.push(arguments);}
                  gtag('js', new Date());

                  gtag('config', 'UA-153981354-2');
                </script>
        <meta name="cmsmagazine" content="4be1bfa70b3d4b0b650c5469488496b4" />
			</header><!-- end of Site's Header -->

			<?php // Breadcrumbs by Yoast
				if ( function_exists('chromium_yoast_breadcrumbs') && function_exists('yoast_breadcrumb') ) { chromium_yoast_breadcrumbs(); }
			?>
