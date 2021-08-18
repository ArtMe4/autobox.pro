<?php
/**
 * Theme functions and definitions.
 */


/* Set up the content width value based on the theme's design. */
if ( !function_exists('chromium_content_width') ) {
	function chromium_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'chromium_content_width', 1200 );
	}
	add_action( 'after_setup_theme', 'chromium_content_width', 0 );
}


/* Adding additional image sizes. */
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'chromium-recent-posts-thumb-s', 160, 190, true);
	add_image_size( 'chromium-recent-posts-thumb-m', 225, 267, true);
	add_image_size( 'chromium-recent-posts-thumb-top', 384, 216, true);
	add_image_size( 'chromium-gallery-s', 384, 216, true);
	add_image_size( 'chromium-gallery-m', 640, 360, true);
	add_image_size( 'chromium-gallery-l', 1024, 576, true);
	add_image_size( 'chromium-grid-blog', 350, 350, true);
	add_image_size( 'chromium-grid-blog-m', 600, 600, true);
}


/* Sets up theme defaults and registers support for various WordPress features. */
if ( ! function_exists( 'chromium_setup' ) ) :
	function chromium_setup() {

		// Translation availability
		load_theme_textdomain( 'chromium', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'post-thumbnail', 870, 350, true);

		// Custom Logo
		$logo_defaults = apply_filters( 'chromium-custom-logo-defaults', array(
	      'height'      => 40,
	      'width'       => 235,
	      'flex-height' => true,
	      'flex-width'  => true, )
	    );
    add_theme_support( 'custom-logo', $logo_defaults );

		// Nav menus
		register_nav_menus( array(
			'primary-nav' => esc_html__( 'Primary Menu (Under Logo Group)', 'chromium' ),
			'logo-group-nav' => esc_html__( 'Logo Group Menu', 'chromium' ),
		) );

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
		) );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Enable woocommerce support
		add_theme_support( 'woocommerce' );

		// Enable layouts support
		$chromium_default_layouts = array(
				array('value' => 'one-col', 'label' => esc_html__('1 Column (no sidebars)', 'chromium'), 'icon' => get_template_directory_uri().'/assets/img/one-col.png'),
				array('value' => 'two-col-left', 'label' => esc_html__('2 Columns, sidebar on left', 'chromium'), 'icon' => get_template_directory_uri().'/assets/img/two-col-left.png'),
				array('value' => 'two-col-right', 'label' => esc_html__('2 Columns, sidebar on right', 'chromium'), 'icon' => get_template_directory_uri().'/assets/img/two-col-right.png'),
		);
		add_theme_support( 'chromium-layouts', apply_filters('chromium_default_layouts', $chromium_default_layouts) );
	}
endif; /* end of if (!function_exists('chromium_setup')) */
add_action( 'after_setup_theme', 'chromium_setup' );


/**
 * Enqueue scripts and styles for the front end.
 */

if ( ! function_exists( 'chromium_inline_styles' ) ) :

	function chromium_inline_styles(){
		$styles = '';
		$thumb_width = get_theme_mod( 'product_thumb_width', '85' );
		$styles = '@media screen and (min-width: 1024px){
						.product-images-wrapper .flex-control-thumbs {
							width: '.$thumb_width.'px !important;
						}
					}';

		return $styles;
	}

endif;

if ( !function_exists('chromium_scripts') ) :
	function chromium_scripts() {
		//---- CSS Styles
		wp_enqueue_style( 'chromium-style', get_stylesheet_uri() );
		wp_enqueue_style( 'chromium-fonts', get_template_directory_uri().'/assets/css/fonts.css' );
		wp_enqueue_style( 'fontawesome', get_template_directory_uri().'/assets/css/font-awesome.min.css' );

		wp_add_inline_style( 'chromium-style', chromium_inline_styles() );

		if ( class_exists('WooCommerce') ) {
			wp_enqueue_style( 'chromium-woo-styles', get_template_directory_uri().'/assets/css/woo-styles.css' );
		}

        wp_enqueue_style( 'custom', get_template_directory_uri().'/assets/css/custom.css?v=1.3' );

		//---- JS libraries
		wp_enqueue_script( 'chromium-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );
		wp_enqueue_script( 'hoverIntent', array('jquery') );
		wp_enqueue_script( 'chromium-theme-helper', get_template_directory_uri() . '/assets/js/theme-helper.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/js/magnific-popup.js', array('jquery'), '1.1.0', true ); // 3rd party script
		if ( is_page_template( 'page-templates/gallery-page.php' ) ) {
			wp_enqueue_script( 'filterizr', get_template_directory_uri() . '/assets/js/filterizr.js', array('jquery'), '1.2.3', true ); // 3rd party script
		}

		wp_enqueue_script('simple-scrollbar', get_template_directory_uri() . '/assets/js/simple-scrollbar.min.js', [], '1.2.3', true);

		//---- Comments script
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

        wp_enqueue_script('goals', get_template_directory_uri() . '/assets/js/goals.js', [], '1.0', true);
        wp_enqueue_script('href', get_template_directory_uri() . '/assets/js/href.js', [], '1.0', true);

//        wp_dequeue_script();
//        wp_deregister_script('tm-woowishlist');
//        wp_enqueue_script('href', get_template_directory_uri() . '/assets/js/new-tm-woowishlist.js', [], '1.0', true);
	}
endif; /* end of if (!function_exists('chromium_scripts')) */
add_action( 'wp_enqueue_scripts', 'chromium_scripts' );


/**
 * Init Sidebars.
 */
if ( !function_exists('chromium_sidebars_init') ) :
	function chromium_sidebars_init() {
		// Default Sidebars
		register_sidebar( array(
			'name' => esc_html__( 'Blog Sidebar', 'chromium' ),
			'id' => 'sidebar-blog',
			'description' => esc_html__( 'Appears on singular blog posts and on Blog Page', 'chromium' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<div class="like-h3 widget-title" itemprop="name"><span>',
			'after_title' => '</span></div>',
		) );
        register_sidebar( array(
            'name' => esc_html__( 'Header Basket Sidebar', 'chromium' ),
            'id' => 'sidebar-basket',
            'description' => esc_html__( 'For mobile logo basket', 'chromium' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<!--',
            'after_title' => '-->',
        ) );
        register_sidebar( array(
            'name' => esc_html__( 'Header Search Sidebar', 'chromium' ),
            'id' => 'sidebar-search',
            'description' => esc_html__( 'For mobile logo search', 'chromium' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<!--',
            'after_title' => '-->',
        ) );
		register_sidebar( array(
			'name' => esc_html__( 'Front Page Sidebar', 'chromium' ),
			'id' => 'sidebar-front',
			'description' => esc_html__( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'chromium' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<div class="like-h3 widget-title" itemprop="name"><span>',
			'after_title' => '</span></div>',
		) );
		register_sidebar( array(
			'name' => esc_html__( 'Pages Sidebar', 'chromium' ),
			'id' => 'sidebar-pages',
			'description' => esc_html__( 'Appears on Pages', 'chromium' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<div class="like-h3 widget-title" itemprop="name"><span>',
			'after_title' => '</span></div>',
		) );
        register_sidebar( array(
            'name' => 'Сайдбар в хедере (возле лого)',
            'id' => 'hgroup-sidebar-r',
            'description' => esc_html__( 'Located in header section on right', 'chromium' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<!--',
            'after_title' => '-->',
        ) );
		register_sidebar( array(
			'name' => esc_html__( 'Header (Logo group) sidebar', 'chromium' ),
			'id' => 'hgroup-sidebar',
			'description' => esc_html__( 'Located in header section', 'chromium' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<!--',
			'after_title' => '-->',
		) );
		// Store Sidebars
		if ( class_exists('WooCommerce') ) {
			register_sidebar( array(
				'name' => esc_html__( 'Shop Page Sidebar', 'chromium' ),
				'id' => 'sidebar-shop',
				'description' => esc_html__( 'Appears on Products page', 'chromium' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<div class="like-h3 widget-title category__collapse" itemprop="name"><img class="catalog-mobile__icon" src="/wp-content/themes/chromium/assets/img/catalog-mobile-button.png" alt=""><span>',
				'after_title' => '</span><img class="filter-close-mob" src="/wp-content/themes/chromium/assets/img/close-filter-category.png" alt=""></div>',
			) );
			register_sidebar( array(
				'name' => esc_html__( 'Single Product Page Sidebar', 'chromium' ),
				'id' => 'sidebar-product',
				'description' => esc_html__( 'Appears on Single Products page', 'chromium' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<div class="like-h3 widget-title" itemprop="name"><span>',
				'after_title' => '</span></div>',
			) );
			register_sidebar( array(
				 'name' => esc_html__( 'Special Filters Sidebar', 'chromium' ),
				 'id' => 'filters-sidebar',
				 'description' => esc_html__( 'Located at the top of the products page', 'chromium' ),
				 'before_widget' => '<div id="%1$s" class="widget sortby-div %2$s">',
				 'after_widget' => '</div>',
				 'before_title' => '<div class="like-h3 dropdown-filters-title">',
				 'after_title' => '</div>',
			) );
			if ( true == get_theme_mod( 'add_cart_sidebar', true ) ) {
				register_sidebar( array(
					'name' => esc_html__( 'Cart Page Sidebar', 'chromium' ),
					'id' => 'sidebar-cart',
					'description' => esc_html__( 'Appears on Cart page under main table', 'chromium' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget' => '</section>',
					'before_title' => '<div class="like-h3 widget-title" itemprop="name"><span>',
					'after_title' => '</span></div>',
				) );
			}
		}
	  /* Footer Sidebars */
	  register_sidebar( array(
	    'name' => esc_html__( 'Footer Sidebar (1 Col)', 'chromium' ),
	    'id' => 'footer-sidebar-1',
	    'before_widget' => '<section id="%1$s" class="widget %2$s">',
	    'after_widget' => '</section>',
	    'before_title' => '<div class="like-h3 widget-title" itemprop="name">',
	    'after_title' => '</div>',
	  ) );
		register_sidebar( array(
	    'name' => esc_html__( 'Footer Sidebar (2 Col)', 'chromium' ),
	    'id' => 'footer-sidebar-2',
	    'before_widget' => '<section id="%1$s" class="widget %2$s">',
	    'after_widget' => '</section>',
	    'before_title' => '<div class="like-h3 widget-title" itemprop="name">',
	    'after_title' => '</div>',
	  ) );
		register_sidebar( array(
			'name' => esc_html__( 'Footer Sidebar (3 Col)', 'chromium' ),
			'id' => 'footer-sidebar-3',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<div class="like-h3 widget-title" itemprop="name">',
			'after_title' => '</div>',
		) );
		register_sidebar( array(
			'name' => esc_html__( 'Footer Sidebar (4 Col)', 'chromium' ),
			'id' => 'footer-sidebar-4',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<div class="like-h3 widget-title" itemprop="name">',
			'after_title' => '</div>',
		) );
		/* Top top_panel_text_color Sidebars */
		if ( true == get_theme_mod( 'header_top_panel', true ) ) {
			register_sidebar( array(
				'name' => esc_html__( 'Header Top Panel Left Sidebar', 'chromium' ),
				'id' => 'top-sidebar-left',
				'description' => esc_html__( 'Located at the top left corner of the site', 'chromium' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="like-h3 widget-title" itemprop="name">',
				'after_title' => '</div>',
			) );
			register_sidebar( array(
				'name' => esc_html__( 'Header Top Panel Right Sidebar', 'chromium' ),
				'id' => 'top-sidebar-right',
				'description' => esc_html__( 'Located at the top right corner of the site', 'chromium' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="like-h3 widget-title" itemprop="name">',
				'after_title' => '</div>',
			) );
		}
		/* Primary Nav Sidebar */
		if ( true == get_theme_mod('primary_nav_widgets', true) ) {
			register_sidebar( array(
				'name' => esc_html__( 'Primary navigation widgets', 'chromium' ),
				'id' => 'primary-nav-widgets',
				'description' => esc_html__( 'Located in the same row as primary navigation', 'chromium' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<!--',
				'after_title' => '-->',
			) );
		}

        register_sidebar( array(
            'name' => esc_html__( 'Home Page Sidebar', 'chromium' ),
            'id' => 'home-page',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<div class="like-h3 widget-title" itemprop="name">',
            'after_title' => '</div>',
        ) );

	}
endif; /* end of if (!function_exists('chromium_sidebars_init')) */
add_action( 'widgets_init', 'chromium_sidebars_init' );


/**
 * Adding Theme features
 */
require_once( get_template_directory() . '/inc/theme-fonts.php');
require_once( get_template_directory() . '/inc/theme-kirki.php');
require_once( get_template_directory() . '/inc/theme-options.php');
require_once( get_template_directory() . '/inc/theme-layouts.php');
require_once( get_template_directory() . '/inc/theme-functions.php');

if ( class_exists('WooCommerce') ) {
	require_once( get_template_directory() . '/inc/theme-woo-modification.php');
}
require_once( get_template_directory() . '/inc/theme-demo-install.php');


function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


function WOO_account_menu_items($items) {
    unset($items['dashboard']);
    return $items;
}
add_filter ('woocommerce_account_menu_items', 'WOO_account_menu_items');


function product_advantages() {
    echo '
    <div class="product-custom-labels-wrapper">
        <div class="single-label">
            <img width="64" height="64" src="/wp-content/uploads/2018/05/shield-64x64.png" alt="">
            <span>1 год гарантии</span>
            <div class="single-label__popup">
                Гарантийный срок исчисляется со дня даты продажи товара покупателю и составляет 12 (двенадцать) месяцев.
            </div>
        </div>
        <div class="single-label">
            <img width="64" height="64" src="/wp-content/uploads/2018/05/medal-64x64.png" alt="">
            <span>100% качество</span>
            <div class="single-label__popup">
                Наша организация является сертифицированным дилером, а так же авторизованным центром продаж 
                большинства представленных в нашем интернет-магазине брендов. Таким образом, покупая товар у нас, 
                вы полностью исключаете возможность приобрести  не оригинальную продукцию. Мы гарантируем 
                качество реализуемых товаров.
            </div>
        </div>
        <div class="single-label">
            <img width="64" height="64" src="/wp-content/uploads/2018/05/delivery-truck-2-64x64.png" alt="">
            <span>Доставка по РФ</span>
            <div class="single-label__popup">
                Информация о доставке по <a href="'. get_the_permalink(6045) .'">ссылке</a>
            </div>
        </div>
    </div>';
}
add_action('woocommerce_single_product_summary', 'product_advantages', 49);

function mb_lcfirst($string, $enc = 'UTF-8') {
    return mb_strtolower(mb_substr($string, 0, 1, $enc), $enc) .
        mb_substr($string, 1, mb_strlen($string, $enc), $enc);
}

function get_title_lc() {
    return mb_lcfirst(get_the_title());
}
function register_custom_yoast_variables() {
    wpseo_register_var_replacement('%%title_lc%%', 'get_title_lc', 'advanced', 'Заголовок с маленькой буквы');
}
add_action('wpseo_register_extra_replacements', 'register_custom_yoast_variables');

//add_filter('BeRocket_AAPF_template_full_content', 'some_custom_berocket_aapf_template_full_content', 4000, 1);
//add_filter('BeRocket_AAPF_template_full_element_content', 'some_custom_berocket_aapf_template_full_content', 4000, 1);
//function some_custom_berocket_aapf_template_full_content($template_content) {
//    $template_content['template']['content']['header']['content']['title']['tag'] = 'p';
//    return $template_content;
//}

//add_filter('BeRocket_AAPF_template_full_content', 'some_custom_berocket_aapf_template_full_content', 4000, 3);
//
//function some_custom_berocket_aapf_template_full_content($template_content, $terms, $berocket_query_var_title) {
//    if( $berocket_query_var_title['new_template'] == 'checkbox') {
//        $template_content['template']['content']['filter']['content'] = berocket_insert_to_array(
//            $template_content['template']['content']['filter']['content'],
//            'list',
//            array(
//                'custom_content' => '<div><h1>SOME CUSTOM HTML</h1><p>Display there anything after title</p></div>'
//            ),
//            true
//        );
//    }
//    return $template_content;
//}


// Изменение тега и классов у фильтров в каталоге
add_filter('BeRocket_AAPF_template_full_content', 'some_custom_berocket_aapf_template_full_content', 4000, 1);
add_filter('BeRocket_AAPF_template_full_element_content', 'some_custom_berocket_aapf_template_full_content', 4000, 1);
function some_custom_berocket_aapf_template_full_content($template_content) {
    $template_content['template']['content']['header']['content']['title']['tag'] = 'a';
    $template_content['template']['content']['header']['content']['title']['attributes'] = array(
        'href' => 'javascript:void(0);',
        'class' => 'collapse__filter like-h3',
    );
    return $template_content;
}

// Изменение текста в корзине
add_filter('gettext', 'translate_text');
add_filter('ngettext', 'translate_text');

function translate_text($translated) {
    $translated = str_ireplace('Подытог', 'Итого', $translated);
    return $translated;
}


add_filter( 'template_include', 'my_callback' );
function my_callback( $original_template ) {
    global $wp;
    $url = home_url( $wp->request ) . '/';

    if ($url !== strtolower($url)) {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        get_template_part( 404 );

        exit();
    } else {
        return $original_template;
    }
}


// canonical для пагинации
add_filter('wpseo_canonical', 'removeCanonicalArchivePagination');
function removeCanonicalArchivePagination($link) {
    if (is_paged()) {
        return preg_replace('#\\??/page[\\/=]\\d+#', '', $link);
    } /*else {
        return $link;
    }*/
}


add_filter('wpseo_title', 'addPageNumberOnTitle');
function addPageNumberOnTitle($title) {
    if (is_paged()) {
        global $paged;
        $title .= ' - Страница ' . $paged;
    }

    return $title;
}