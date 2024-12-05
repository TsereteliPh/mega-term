<?php
remove_action( 'woocommerce_before_main_content','woocommerce_output_content_wrapper', 10, 0 );
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_before_main_content','woocommerce_output_content_wrapper_end', 10, 0 );

// ---------------------------------------------------------------- Filters

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
add_action('wp_footer', 'adem_cart_update_qty_script');
function adem_cart_update_qty_script() {
	if ( is_cart() ) {
		?>
			<script>
				document.addEventListener('DOMContentLoaded', function () {
					changeInputQuantity('.cart', true);
					let update_cart;
					jQuery('body').delegate(".cart__item .qty", "change", function () {
						if (update_cart != null) {
							clearTimeout(update_cart);
						}
						update_cart = setTimeout(function () {
							jQuery("[name='update_cart']").trigger("click")
						}, 1000);
					});
				});
			</script>
		<?php
	}
}

// Adem rewrite product-category / Fix 404 error
function adem_product_category_base_same_shop_base( $flash = false ){
    $terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'post_type' => 'product',
        'hide_empty' => false,
    ));
    if ($terms && !is_wp_error($terms)) {
        $siteurl = esc_url(home_url('/'));
        foreach ($terms as $term) {
            $term_slug = $term->slug;
            $baseterm = str_replace($siteurl, '', get_term_link($term->term_id, 'product_cat'));

            add_rewrite_rule($baseterm . '?$','index.php?product_cat=' . $term_slug,'top');
            add_rewrite_rule($baseterm . '/page/([0-9]{1,})/?$', 'index.php?product_cat=' . $term_slug . '&paged=$matches[1]','top');
            add_rewrite_rule($baseterm . '(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?product_cat=' . $term_slug . '&feed=$matches[1]','top');

        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
}
add_filter( 'init', 'adem_product_category_base_same_shop_base');

add_action( 'create_term', 'adem_product_cat_same_shop_edit_success', 10, 2 );
function adem_product_cat_same_shop_edit_success( $term_id, $taxonomy ) {
    adem_product_category_base_same_shop_base(true);
}
