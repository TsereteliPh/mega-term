<?php
remove_action( 'woocommerce_before_main_content','woocommerce_output_content_wrapper', 10, 0 );
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_before_main_content','woocommerce_output_content_wrapper_end', 10, 0 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );

remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

remove_action( 'woocommerce_checkout_before_customer_details', 'wc_get_pay_buttons', 30 );

remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20 );
remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );

// ---------------------------------------------------------------- Filters

// Change title for review tabs
add_filter( 'woocommerce_product_tabs', 'adem_woocommerce_product_tabs', 25 );
function adem_woocommerce_product_tabs( $tabs ) {
	global $product;

	if ( ! empty( $tabs[ 'reviews' ] ) ) $tabs[ 'reviews' ][ 'title' ] = sprintf( 'Отзывы <span>(%d)</span>', $product->get_review_count() );

	return $tabs;
}

// Adem rewrite product-category / Fix 404 error
add_filter( 'init', 'adem_product_category_base_same_shop_base' );
function adem_product_category_base_same_shop_base( $flash = false ){
    $terms = get_terms( array(
        'taxonomy' => 'product_cat',
        'post_type' => 'product',
        'hide_empty' => false,
    ) );
    if ( $terms && ! is_wp_error( $terms ) ) {
        $siteurl = esc_url( home_url( '/' ) );
        foreach ( $terms as $term ) {
            $term_slug = $term->slug;
            $baseterm = str_replace( $siteurl, '', get_term_link( $term->term_id, 'product_cat' ) );

            add_rewrite_rule( $baseterm . '?$', 'index.php?product_cat=' . $term_slug, 'top' );
            add_rewrite_rule( $baseterm . '/page/([0-9]{1,})/?$', 'index.php?product_cat=' . $term_slug . '&paged=$matches[1]', 'top' );
            add_rewrite_rule( $baseterm . '(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?product_cat=' . $term_slug . '&feed=$matches[1]', 'top' );

        }
    }
    if ( $flash == true )
        flush_rewrite_rules( false );
}

// Change cart coupon
add_filter( 'woocommerce_cart_totals_coupon_label', 'adem_cart_totals_coupon_label', 10, 2 );
function adem_cart_totals_coupon_label( $label, $coupon ) {
	if ( $coupon->get_code() ) {
        // New label
        $label = sprintf( 'Активирован купон: <span>' . $coupon->get_code() . '</span>' );
    }

    return $label;
}

// Change remove coupon link
add_filter( 'woocommerce_cart_totals_coupon_html', 'custom_cart_totals_coupon_html', 30, 3 );
function custom_cart_totals_coupon_html( $coupon_html, $coupon, $discount_amount_html ) {

	$discount_amount_html = '<span class="cart__coupon-summ">' . apply_filters( 'woocommerce_coupon_discount_amount_html', $discount_amount_html, $coupon ) . '</span>';

	$coupon_html = $discount_amount_html . ' <a href="' . esc_url( add_query_arg( 'remove_coupon', urlencode( $coupon->get_code() ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="woocommerce-remove-coupon cart__coupon-remove" data-coupon="' . esc_attr( $coupon->get_code() ) . '">[Сбросить]</a>';

    return $coupon_html;
}

// Custom form fields args
add_filter( 'woocommerce_form_field_args', 'adem_form_field_args', 10, 3 );
function adem_form_field_args( $args, $key, $value = null ) {

	switch ( $args['type'] ) {

		case "select" :  /* Targets all select input type elements, except the country and state select input types */
			$args['class'][] = 'shop-field';
			$args['input_class'] = array( 'shop-field__input' );
			//$args['custom_attributes']['data-plugin'] = 'select2';
			$args['label_class'] = array( 'shop-label' );
			$args['custom_attributes'] = array(
				'data-plugin' => 'select2',
				'data-allow-clear' => 'true',
				'aria-hidden' => 'true'
			);
		break;

		case 'country' : /* By default WooCommerce will populate a select with the country names - $args defined for this specific input type targets only the country select element */
			$args['class'][] = 'shop-field';
			$args['label_class'] = array( 'shop-label' );
		break;

		case "state" :
			$args['class'][] = 'shop-field';
			$args['input_class'] = array( 'shop-field__input' );
			//$args['custom_attributes']['data-plugin'] = 'select2';
			$args['label_class'] = array( 'shop-label' );
			$args['custom_attributes'] = array(
				'data-plugin' => 'select2',
				'data-allow-clear' => 'true',
				'aria-hidden' => 'true',
			);
		break;


		case "password" :
		case "text" :
		case "email" :
		case "tel" :
		case "number" :
			$args['class'][] = 'shop-field';
			$args['input_class'] = array( 'shop-field__input' );
			$args['label_class'] = array( 'shop-label' );
		break;

		case 'textarea' :
			$args['input_class'] = array( 'shop-field__input' );
			$args['label_class'] = array( 'shop-label' );
		break;

		case 'checkbox' :
		break;

		case 'radio' :
		break;

		default :
			$args['class'][] = 'shop-field';
			$args['input_class'] = array( 'shop-field__input' );
			$args['label_class'] = array( 'shop-label' );
		break;
	}

	return $args;
}

// Disable account links
add_filter( 'woocommerce_account_menu_items', 'adem_account_menu_items', 25 );
function adem_account_menu_items( $menu_links ) {
	unset( $menu_links[ 'downloads' ] );
	unset( $menu_links[ 'payment-methods' ] );

	return $menu_links;
}

// Add small banner to catalog-filters sidebar
add_filter( 'dynamic_sidebar_params', 'add_custom_content_to_sidebar' );
function add_custom_content_to_sidebar( $params ) {
	static $is_custom_content_added = false;

	$small_banner = get_field( 'small_banner', wc_get_page_id( 'shop' ) );

	if ( $params[0]['id'] === 'catalog_sidebar' && ! $is_custom_content_added && $small_banner ) {
		get_template_part( '/layouts/partials/promos/small-banner', null, array(
			'class' => 'catalog__filters-banner',
			'banner' => $small_banner,
		) );
		$is_custom_content_added = true;
	}

    return $params;
}

// ---------------------------------------------------------------- Functions

// Product quantity in cart by ID
function get_product_quantity_in_cart( $product_id ) {
	$quantity = 0;

	foreach ( WC()->cart->get_cart() as $cart_item ) {
		if ( $product_id == $cart_item[ 'product_id' ] ) {
			$quantity = $cart_item[ 'quantity' ];
			break;
		}
	}

	return $quantity;
}

// Category ending
function category_ending( $num ) {
	$number = substr( $num, -2 );

	if ( $number > 10 and $number < 20 ) {
		$ending = 'й';
	} else {
		$number = substr( $number, -1 );

		if ( $number == 1 ) $ending = 'я';
		if ( $number > 1 ) $ending = 'и';
		if ( $number > 4 || $number == 0 ) $ending = 'й';
	}

	echo $num . ' категори' . $ending;
}

// Product ending
function product_ending( $num ) {
	$number = substr( $num, -2 );

	if ( $number > 10 and $number < 20 ) {
		$ending = 'ов';
	} else {
		$number = substr( $number, -1 );

		if ( $number == 1 ) $ending = '';
		if ( $number > 1 ) $ending = 'а';
		if ( $number > 4 || $number == 0 ) $ending = 'ов';
	}

	echo $num . ' товар' . $ending;
}

// Update cart quantity
add_action( 'wp_footer', 'adem_cart_update_qty_script' );
function adem_cart_update_qty_script() {
	if ( is_cart() ) {
		?>
			<script>
				document.addEventListener('DOMContentLoaded', function () {
					changeInputQuantity('.cart', true);
					let update_cart;
					jQuery('body').delegate('.cart__item .qty', 'change', function () {
						if (update_cart != null) {
							clearTimeout(update_cart);
						}
						update_cart = setTimeout(function () {
							jQuery('[name="update_cart"]').trigger('click')
						}, 1000);
					});
				});
			</script>
		<?php
	}
}

add_action( 'create_term', 'adem_product_cat_same_shop_edit_success', 10, 2 );
function adem_product_cat_same_shop_edit_success( $term_id, $taxonomy ) {
    adem_product_category_base_same_shop_base(true);
}

// Recursive function for header cats
function adem_recursive_header_categories( $parent_id = 0, $level = 0 ) {
	$current_term = get_queried_object();

	$categories = get_terms( [
		'taxonomy' => 'product_cat',
		'parent' => $parent_id,
		'hide_empty' => false, //? Display empty cats
		'orderby' => 'name',
		'exclude' => 15, // Misc cat
	] );

	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		$classes = 'reset-list header__cats-list header__cats-list--level-' . $level;
		if ( $level === 0 ) $classes .= ' js-accordion';

		echo '<ul class="' . $classes . '"' . ( $level === 0 ? ' data-breakpoint="576"' : '' ) . '>';

		foreach ( $categories as $category ) {
			echo '<li class="header__cats-item header__cats-item--level-' . $level . '">';

			if ( $level === 0 ) {
				echo '<button class="header__cats-item-button" type="button">';
			}

			$link_classes = 'header__cats-item-link header__cats-item-link--level-' . $level;
			if ( $current_term->term_id === $category->term_id ) $link_classes .= ' current';

			echo '<a href="' . get_term_link( $category ) . '" class="' . $link_classes . '">';

			if ( $level === 0 ) {
				$cat_img = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
				echo '<div class="header__cats-item-img">';
				echo wp_get_attachment_image( $cat_img ? $cat_img : 24, 'thumbnail', false );
				echo '</div>';
			}

			echo $category->name;

			echo '</a>';

			if ( $level === 0 ) {
				$term_childrens = get_term_children( $category->term_id, 'product_cat' );
				if ( $term_childrens ) {
					echo '<svg width="10" height="10"><use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#icon-arrow-caret"></use></svg>';
				}

				echo '</button>';
			}

			adem_recursive_header_categories( $category->term_id, $level + 1 );

			echo '</li>';
		}

		echo '</ul>';
	}
}

// Custom nav html for catalog filters
add_filter( 'woocommerce_layered_nav_term_html', 'adem_layered_nav_term_html', 10, 4 );
function adem_layered_nav_term_html( $term_html, $term, $link, $count ) {
	$filter_name = 'filter_' . wc_attribute_taxonomy_slug( $term->taxonomy );
	$current_filters = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( wp_unslash( $_GET[ $filter_name ] ) ) ) : array();
	$current = false;
	$color = false;

	foreach ( $current_filters as $item ) {
		if ( $term->slug == $item ) $current = true;
	}

	$term_html = sprintf(
		'<a rel="nofollow" class="square-checkbox" href="%1$s">
			<input type="checkbox" class="hidden square-checkbox__input" %2$s>
			<span class="square-checkbox__switcher"></span>
			<span class="square-checkbox__text">%3$s</span>
		</a>',
		esc_url( $link ),
		$current ? 'checked' : '',
		esc_html( $term->name ),
	);

    return $term_html;
}

//Favorites
add_action( 'template_redirect', 'adem_favorites_redirect' );
function adem_favorites_redirect() {
	if ( is_page( 'favorites' ) && ! is_user_logged_in() ) {
		wp_redirect( home_url() );
		exit();
	}
}

function adem_count_all_favorites() {
	if ( ! is_user_logged_in() ) return;

	$user_favorites = get_user_meta( get_current_user_id(), 'favorites', false );
	if ( ! $user_favorites ) return;

	return count( json_decode( $user_favorites[0], true ) );
}

function adem_check_favorite( $product_id ) {
	if ( ! is_user_logged_in() ) return;

	$user_favorites = get_user_meta( get_current_user_id(), 'favorites', false );
	if ( ! $user_favorites ) return;

	$user_favorites = json_decode( $user_favorites[0], true );
	$user_favorites = array_unique( $user_favorites );
	foreach ( $user_favorites as $item ) {
		if ( $product_id == $item ) {
			return true;
		}
	}

	return false;
}

add_filter( 'body_class', 'adem_add_woocommerce_classes_to_body' );
function adem_add_woocommerce_classes_to_body( $classes ) {
    if ( is_page( 484 ) ) {
        $woocommerce_classes = array(
            'woocommerce',
            'woocommerce-page',
            'woocommerce-js',
        );

        $classes = array_merge( $classes, $woocommerce_classes );
    }

    return $classes;
}

// ---------------------------------------------------------------- Cookie
if ( ! isset( $_COOKIE['woocommerce_catalog_flex'] ) ) {
	setcookie( 'woocommerce_catalog_flex', 0, time() + 3600 * 24 * 30, '/' );
}

remove_action('template_redirect', 'wc_track_product_view', 20);
add_action( 'template_redirect', 'adem_track_product_view', 20 );
function adem_track_product_view() {
	if ( ! is_singular( 'product' ) ) return;

	global $post;

	if ( empty( $_COOKIE['woocommerce_recently_viewed'] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) ); // @codingStandardsIgnoreLine.
	}

	$keys = array_flip( $viewed_products );

	if ( isset( $keys[ $post->ID ] ) ) {
		unset( $viewed_products[ $keys[ $post->ID ] ] );
	}

	$viewed_products[] = $post->ID;

	if ( count( $viewed_products ) > 11 ) {
		array_shift( $viewed_products );
	}

	wc_setcookie( 'woocommerce_recently_viewed', implode( '|', $viewed_products ) );
}
