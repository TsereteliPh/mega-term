<?php
/**
 * Single variation cart button
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="product__add-to-cart">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); //Empty ?>

	<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' ); //Empty

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
				'stock' => $product->is_in_stock(),
				'sold_individually' => $product->is_sold_individually()
			)
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' ); //Empty
	?>

	<button class="btn product__add-to-cart-btn" type="submit">
		<svg width="13" height="13"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-cart"></use></svg>
		Добавить в корзину
	</button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); //Empty ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
