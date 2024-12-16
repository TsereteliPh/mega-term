<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

$quantityInCart = get_product_quantity_in_cart( $product->get_id() );

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); // Empty ?>

	<form class="product__form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<div class="product__form-info">
			<div class="woocommerce__price product__price"><?php echo $product->get_price_html(); ?></div>

			<?php if ( $product->get_sku() ) : ?>
				<div class="product__sku">
					Артикул:
					<span><?php echo $product->get_sku(); ?></span>
				</div>
			<?php endif; ?>
		</div>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); // Empty ?>

		<div class="product__add-to-cart">
			<?php if ( $quantityInCart > 0 ) : ?>
				<div class="product__count">
					В корзине <?php echo $quantityInCart; ?>
					<?php echo wc_product_ending( $quantityInCart ); ?>
				</div>

				<a href="<?php echo wc_get_cart_url(); ?>" class="btn product__go-to-cart-btn">
					<svg width="13" height="13"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-cart"></use></svg>
					Перейти в корзину
				</a>
			<?php else : ?>
				<?php
					do_action( 'woocommerce_before_add_to_cart_quantity' ); // Empty

					woocommerce_quantity_input(
						array(
							'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
							'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
							'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
							'stock' => $product->is_in_stock(),
							'sold_individually' => $product->is_sold_individually()
						)
					);

					do_action( 'woocommerce_after_add_to_cart_quantity' ); // Empty
				?>

				<button
					class="btn product__add-to-cart-btn"
					type="submit"
					name="add-to-cart"
					value="<?php echo esc_attr( $product->get_id() ); ?>"
				>
					<svg width="13" height="13"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-cart"></use></svg>
					Добавить в корзину
				</button>
			<?php endif; ?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); // Empty ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); // Empty ?>

<?php endif; ?>
