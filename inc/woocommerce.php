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

// Product ending
function wc_product_ending( $num ) {
	$number = substr( $num, -2 );

	if ( $number > 10 and $number < 20 ) {
		$ending = 'товаров';
	} else {
		$number = substr( $number, -1 );

		if ( $number == 1 ) $ending = 'товар';
		if ( $number > 1 ) $ending = 'товара';
		if ( $number > 4 || $number == 0 ) $ending = 'товаров';
	}

	echo $ending;
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
