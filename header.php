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
		<div class="header__cities"><?php //TODO: cities ?>
			<svg width="10" height="11"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-city-geo"></use></svg>
			Москва
		</div>

		<?php wp_nav_menu( array(
			'theme_location' => 'menu_main',
			'container' => '',
			'menu_id' => 'menu-main',
			'menu_class' => 'reset-list header__menu'
		) ); ?>

		<div class="header__user">
			<a href="<?php //TODO: login ?>" class="header__user-link header__user-link--login">
				<svg width="16" height="15"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-login"></use></svg>
				Вход
			</a>

			<a href="<?php //TODO: register ?>" class="header__user-link header__user-link--register">
				Регистрация
			</a>
		</div>

		<button class="btn btn--thic header__catalog" type="button">
			Каталог
			<span>оборудования</span>
			<svg width="8" height="8"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
		</button>

		<button class="btn btn--square header__search-modal" aria-label="Открыть поиск" data-src="#search" data-fancybox>
			<svg width="20" height="21"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-search"></use></svg>
		</button>

		<div class="header__search" id="search"><?php //TODO: search ?>
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

			<button class="header__callback" type="button" data-fancybox data-src="<?php //TODO: callback ?>">Обратный звонок</button>

			<?php if( $email ) : ?>
				<a href="mailto:<?php echo $email; ?>" class="header__email">
					<svg width="18" height="14"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-email"></use></svg>
					<?php echo $email; ?>
				</a>
			<?php endif; ?>
		</div>

		<div class="header__buttons">
			<a href="<?php //TODO: ?>" class="btn btn--square header__comparison" aria-label="Открыть сравнение">
				<svg width="25" height="21"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-comparison"></use></svg>

				<span class="btn__counter header__counter active">12</span>
			</a>

			<a href="<?php //TODO: ?>" class="btn btn--square header__fav" aria-label="Открыть избранное">
				<svg width="26" height="23"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-fav"></use></svg>

				<span class="btn__counter header__counter">0</span>
			</a>

			<a href="<?php echo wc_get_cart_url(); ?>" class="btn btn--square header__cart" aria-label="Открыть избранное">
				<svg width="23" height="23"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-cart"></use></svg>

				<?php $contents_count = WC()->cart->cart_contents_count; ?>

				<span id="header-cart-counter" class="btn__counter header__counter<?php echo ( $contents_count > 0 ) ? ' active' : ''; ?>"><?php echo $contents_count; ?></span>
			</a>

			<button class="btn btn--square header__burger" type="button">
				<span></span>
			</button>
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
