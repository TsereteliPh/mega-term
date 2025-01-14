<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
	<div class="container header__container">
		<div class="header__logo">
			<a href="<?php echo bloginfo( 'url' ); ?>" class="header__logo-link">
				<svg width="100" height="48"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-logo"></use></svg>
			</a>

			<?php
				$slogan = get_field( 'slogan', 'options' );
				if ( $slogan ) :
					?>

					<div class="header__logo-text"><?php echo $slogan; ?></div>

					<?php
				endif;
			?>
		</div>

		<?php wp_nav_menu( array(
			'theme_location' => 'menu_main',
			'container' => '',
			'menu_id' => 'menu-main',
			'menu_class' => 'reset-list header__menu'
		) ); ?>

		<div class="header__user">
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>" class="header__user-link header__user-link--login">
					<svg width="16" height="15"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-login"></use></svg>
					Профиль
				</a>
			<?php else : ?>
				<button class="header__user-link header__user-link--login" type="button" data-fancybox data-src="#login">
					<svg width="16" height="15"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-login"></use></svg>
					Вход
				</button>

				<button class="header__user-link header__user-link--registration" type="button" data-fancybox data-src="#registration">
					Регистрация
				</button>
			<?php endif; ?>
		</div>

		<button class="btn btn--thic header__catalog-btn" type="button">
			<div class="header__catalog-btn-open-text">
				Каталог
				<span>оборудования</span>
				<svg width="8" height="8"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
			</div>

			<div class="header__catalog-btn-close-text">
				Закрыть
				<span></span>
			</div>
		</button>

		<div class="header__search" id="search">
			<form role="search" method="get" class="header__search-form" action="<?php bloginfo( 'url' ); ?>" id="searchform">
				<input type="search" id="search" class="input header__search-input" value="<?php echo get_search_query(); ?>" name="s" placeholder="Поиск по сайту" data-swplive="true">

				<button type="submit" class="header__search-btn">
					<svg width="20" height="21"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-search"></use></svg>
				</button>
			</form>

			<div class="header__search-result"></div>
		</div>

		<div class="header__contacts">
			<?php
				$tel = get_field( 'tel', 'options' );
				$email = get_field( 'email', 'options' );
			?>

			<?php if ( $tel ) : ?>
				<a href="tel:<?php echo preg_replace( '/[^0-9,+]/', '', $tel ); ?>" class="header__tel">
					<?php echo $tel; ?>
				</a>
			<?php endif; ?>

			<button class="header__callback" type="button" data-fancybox data-src="#callback">Обратный звонок</button>

			<?php if( $email ) : ?>
				<a href="mailto:<?php echo $email; ?>" class="header__email">
					<svg width="18" height="14"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-email"></use></svg>
					<?php echo $email; ?>
				</a>
			<?php endif; ?>
		</div>

		<div class="header__buttons">
			<button class="btn btn--square header__search-modal" aria-label="Открыть поиск" data-src="#search" data-fancybox>
				<svg width="20" height="21"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-search"></use></svg>
			</button>

			<?php if ( false ) : //! temporarily remove comparison ?>
				<a href="<?php  ?>" class="btn btn--square header__comparison" aria-label="Открыть сравнение">
					<svg width="25" height="21"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-comparison"></use></svg>

					<span class="btn__counter header__counter active">12</span>
				</a>
			<?php endif; ?>

			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo get_page_link( 484 ); ?>" class="btn btn--square header__fav" aria-label="Открыть избранное">
					<svg width="26" height="23"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-fav"></use></svg>

					<?php $favorites_count = adem_count_all_favorites(); ?>

					<span class="btn__counter header__counter header__fav-counter<?php echo ( $favorites_count > 0 ) ? ' active' : ''; ?>"><?php echo $favorites_count; ?></span>
				</a>
			<?php endif; ?>

			<a href="<?php echo wc_get_cart_url(); ?>" class="btn btn--square header__cart" aria-label="Открыть избранное">
				<svg width="23" height="23"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-cart"></use></svg>

				<?php $contents_count = WC()->cart->cart_contents_count; ?>

				<span id="header-cart-counter" class="btn__counter header__counter<?php echo ( $contents_count > 0 ) ? ' active' : ''; ?>"><?php echo $contents_count; ?></span>
			</a>

			<button class="btn btn--square header__burger" type="button">
				<span></span>
			</button>
		</div>

		<div class="header__catalog" id="header_catalog">
			<div class="header__catalog-wrapper header__catalog-wrapper--cats">
				<div class="header__catalog-title">Каталог</div>

				<div class="header__cats">
					<?php
						if ( function_exists( 'adem_recursive_header_categories' ) ) {
							adem_recursive_header_categories();
						}
					?>
				</div>
			</div>

			<div class="header__catalog-wrapper header__catalog-wrapper--brands">
				<div class="header__catalog-title">Бренды</div>

				<?php get_template_part( '/layouts/partials/brands-slider', null, array(
					'class' => 'header__catalog-brands',
				) ); ?>
			</div>
		</div>

		<div class="header__small-cats">
			<?php
				$cats = get_terms( [
					'taxonomy' => 'product_cat',
					'hide_empty' => false, //? Display empty cats
					'parent' => 0,
					'exclude' => 15, // Misc cat
				] );

				foreach ( $cats as $cat ) {
					$icon = get_field( 'cat_icon', $cat );
					$icon_tag = wp_get_attachment_image( $icon, array( 20, 20 ), false );

					echo '<a href="'. get_term_link( $cat ) . '" class="header__small-cat">' . $icon_tag . $cat->name . '</a>';
				}
			?>

			<button class="header__small-cat-button hidden" type="button">Еще</button>
		</div>
	</div>
</header>

<?php if ( ! is_front_page() && function_exists( 'yoast_breadcrumb' ) ) : ?>
	<div class="breadcrumb">
		<div class="container">
			<?php echo yoast_breadcrumb(); ?>
		</div>
	</div>
<?php endif ?>

<main class="main">
	<?php if ( is_page( 484 ) ) get_template_part( 'layouts/partials/favorites' ); ?>
