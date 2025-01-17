<?php

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'adem_setup' ) ) {
	function adem_setup() {
		add_theme_support('woocommerce');
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);
		add_theme_support( 'editor-styles' );
		add_editor_style();

		register_nav_menus(
			array(
				'menu_main' => 'Основное меню',
				'cats_menu' => 'Меню категорий',
				'about_menu' => 'Меню о нас',
				'clients_menu' => 'Клиентское меню',
			)
		);
	}

	//	register thumbnails
	// add_image_size( 'huge', 1920, 1920, false );

	//register taxonomies
	register_taxonomy( 'review-category', [ 'reviews' ], [
		'label'                 => '',
		'labels'                => [
			'name'              => 'Категории отзывов',
			'singular_name'     => 'Категория отзыва',
			'search_items'      => 'Найти категорию',
			'all_items'         => 'Все категории',
			'view_item '        => 'Посмотреть категорию',
			'edit_item'         => 'Редактировать категорию',
			'update_item'       => 'Обновить категорию',
			'add_new_item'      => 'Добавить новую категорию',
			'new_item_name'     => 'Новое название категории',
			'menu_name'         => 'Категории',
			'back_to_items'     => '← Вернуться к категориям',
		],
		'description'           => '',
		'public'                => true,
		'hierarchical'          => true,

		'rewrite'               => true,
		'capabilities'          => [],
		'meta_box_cb'           => null,
		'show_admin_column'     => false,
		'show_in_rest'          => null,
		'rest_base'             => null,
	] );

	//	register post types
	register_post_type( 'faq', [
		'label' => null,
		'labels' => [
			'name' => 'Вопрос - ответ',
			'singular_name' => 'Вопрос - ответ',
			'add_new' => 'Добавить вопрос',
			'add_new_item' => 'Добавить вопрос',
			'edit_item' => 'Редактировать вопрос',
			'new_item' => 'Новый вопрос',
			'view_item' => 'Смотреть вопрос',
			'search_items' => 'Найти вопрос',
			'not_found' => 'Не найдено',
			'not_found_in_trash' => 'Не найдено в корзине',
			'menu_name' => 'Вопрос - ответ',
		],
		'public' => true,
		'exclude_from_search' => true,
		'show_in_menu' => true,
		'menu_position' => 22,
		'menu_icon' => 'dashicons-editor-help',
		'supports' => ['title'],
		'taxonomies' => ['faq_type'],
		'has_archive' => false,
		'rewrite' => true,
		'query_var' => true,
		'publicly_queryable' => false
	] );

	register_post_type( 'reviews', [
		'label' => null,
		'labels' => [
			'name' => 'Отзывы',
			'singular_name' => 'Отзыв',
			'add_new' => 'Добавить отзыв',
			'add_new_item' => 'Добавить отзыв',
			'edit_item' => 'Редактировать отзыв',
			'new_item' => 'Новый отзыв',
			'view_item' => 'Смотреть отзыв',
			'search_items' => 'Найти отзыв',
			'not_found' => 'Не найдено',
			'not_found_in_trash' => 'Не найдено в корзине',
			'menu_name' => 'Отзывы',
		],
		'public' => true,
		'exclude_from_search' => true,
		'show_in_menu' => true,
		'menu_position' => 23,
		'menu_icon' => 'dashicons-admin-comments',
		'supports' => ['title', 'editor'],
		'taxonomies' => ['reviews_type'],
		'has_archive' => false,
		'rewrite' => false,
		'query_var' => false,
		'publicly_queryable' => false
	] );
}

add_action( 'after_setup_theme', 'adem_setup' );

// Register Sidebar
function adem_register_sidebars() {
	register_sidebar( [
		'name' => 'Сайдбар каталога',
		'id' => 'catalog_sidebar',
		'before_sidebar' => '<ul class="reset-list catalog__filters" id="filters">',
		'after_sidebar'  => '</ul>',
	] );
}

// Return classic widgets
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );

add_action( 'wp_enqueue_scripts', 'adem_scripts' );
function adem_scripts() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/assets/vendor/css/fancybox.css', array(), '4.0.31' );
	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/vendor/js/fancybox.umd.js', array(), '4.0.31', true );
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/assets/vendor/css/swiper-bundle.min.css', array(), '10.3.1' );
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/vendor/js/swiper-bundle.min.js', array(), '10.3.1', true );
	wp_enqueue_style( 'adem', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_script( 'adem', get_template_directory_uri() . '/assets/js/main.js', array(), _S_VERSION, true ); //! change to minified version
	wp_localize_script( 'adem', 'adem_ajax', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
}

add_action('widgets_init', 'adem_register_sidebars');

// disable scale images
add_filter( 'big_image_size_threshold', '__return_false' );

// remove prefix in archive title
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

// excerpt
function adem_excerpt( $limit, $ID = null ) {
	return mb_substr( get_the_excerpt( $ID ), 0, $limit ) . '...';
}

// Custom breadcrumbs yoast
add_filter( 'wpseo_breadcrumb_links', 'custom_breadcrumbs' );
function custom_breadcrumbs( $links ) {
	global $post;

	if ( in_category( 22 ) && is_single() ) {
		$breadcrumb[] = array(
			'url' => get_category_link( 22 ),
			'text' => 'Новости',
		);

		array_splice( $links, 1, -2, $breadcrumb );
	} else if ( in_category( 23 ) && is_single() ) {
		$breadcrumb[] = array(
			'url' => get_category_link( 23 ),
			'text' => 'Статьи',
		);

		array_splice( $links, 1, -2, $breadcrumb );
	}

	return $links;
}

//SearchWP plugin configs
add_filter( 'searchwp_live_search_configs', 'adem_searchwp_live_search_configs' );
function adem_searchwp_live_search_configs( $configs ) {
	$configs['default'] = array(
		'engine' => 'default',
		'input' => array(
			'delay'     => 300,
			'min_chars' => 1,
		),
		'parent_el' => '.header__search-result',
		'results' => array(
			'position'  => 'bottom',
			'width'     => 'auto',
			'offset'    => array(
				'x' => 0,
				'y' => 15
			),
		),
		'spinner' => array(
			'lines'     => 0,
			'length'    => 0,
			'width'     => 'auto',
			'radius'    => 0,
			'scale'     => 1,
			'corners'   => 0,
			'color'     => 'inherit',
			'fadeColor' => 'transparent',
			'speed'     => 1,
			'rotate'    => 0,
			'direction' => 1,
			'className' => 'loader',
			'top'       => '50%',
			'left'      => '50%',
			'position'  => 'absolute'
		),
	);

	return $configs;
}

add_filter( 'searchwp_live_search_base_styles', '__return_false' );

add_filter( 'searchwp_exclude', function( $exclude, $engine ) {
    $excluded_post_types = ['custom_post_type1', 'custom_post_type2'];

    // Получаем ID постов с определённым типом и условием (например, метаполе)
    $query = new WP_Query( [
        'post_type'   => $excluded_post_types,
        'meta_key'    => 'exclude_from_search',
        'meta_value'  => '1',
        'fields'      => 'ids',
        'posts_per_page' => -1,
    ] );

    if ( $query->have_posts() ) {
        $exclude = array_merge( $exclude, $query->posts );
    }

    return $exclude;
}, 10, 2 );

require 'inc/acf.php';
require 'inc/add-to-favorite.php';
require 'inc/load-more.php';
require 'inc/login.php';
require 'inc/mail.php';
require 'inc/registration.php';
require 'inc/remove-from-favorite.php';
require 'inc/svg.php';
require 'inc/tiny-mce.php';
require 'inc/traffic.php';
require 'inc/wc-catalog-view.php';
require 'inc/woocommerce.php';
