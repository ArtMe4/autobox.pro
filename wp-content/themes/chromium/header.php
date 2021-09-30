<?php /* The Header */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

	<head>
        <?php
        if ($_SERVER['HTTP_HOST'] == 'basszone.tmweb.ru')
            echo '<meta name="robots" content="noindex" />';
        ?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta id="mvp" name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <script>function v(){let e=screen.width<=360?"width=360,user-scalable=no":"width=device-width,initial-scale=1,maximum-scale=1";document.getElementById("mvp").setAttribute("content",e)}v();window.onresize=function(n){v()}</script>
        <link rel="profile" href="https://gmpg.org/xfn/11">
		<link rel="icon" href="/favicon.png" type="image/x-icon">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>
		<?php wp_head(); ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-153981354-2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-153981354-2');
        </script>
        <meta name="cmsmagazine" content="4be1bfa70b3d4b0b650c5469488496b4" />
        <meta name="yandex-verification" content="7ca37235c8ed3262" />
	</head>

	<body <?php body_class(); ?>>


		<div id="page" class="site"><!-- Site's Wrapper -->
            <div class="bg__filter"></div>

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
                    <?php if ( ( '' !== get_theme_mod('header_custom_area', '') ) && ( is_front_page() ) ) : ?>
                        <div class="home-header-static-hero-block">
                        <?php
                            echo do_shortcode(wp_kses_post(get_theme_mod('header_custom_area', '')));
                        ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
			</header><!-- end of Site's Header -->

			<?php // Breadcrumbs by Yoast
				if ( function_exists('chromium_yoast_breadcrumbs') && function_exists('yoast_breadcrumb') ) { chromium_yoast_breadcrumbs(); }
			?>
