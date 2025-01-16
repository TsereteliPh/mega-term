<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

?>

<section class="cart">
	<div class="container">
		<?php do_action( 'woocommerce_before_cart' ); ?>

		<form class="woocommerce-cart-form cart__form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); //Empty ?>

			<div class="cart__wrapper woocommerce-cart-form__contents">
				<ul class="reset-list cart__list">
					<?php do_action( 'woocommerce_before_cart_contents' ); //Empty ?>

					<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
							/**
							 * Filter the product name.
							 *
							 * @since 2.1.0
							 * @param string $product_name Name of the product in the cart.
							 * @param array $cart_item The product in the cart.
							 * @param string $cart_item_key Key for the product in the cart.
							 */
							$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								?>
									<li class="main-border main-border--brackets woocommerce-cart-form__cart-item cart__item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

										<?php
											echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												'woocommerce_cart_item_remove_link',
												sprintf(
													'<a href="%s" class="cart__item-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg width="20" height="20"><use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#icon-trash"></use></svg></a>',
													esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
													/* translators: %s is the product name */
													esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
													esc_attr( $product_id ),
													esc_attr( $_product->get_sku() )
												),
												$cart_item_key
											);
										?>

										<a href="<?php echo $_product->get_permalink(); ?>" class="cart__item-thumbnail">
											<?php
												$thumbnail_id = $_product->get_image_id();
												echo wp_get_attachment_image( $thumbnail_id ? $thumbnail_id : 84, 'large', false );
											?>
										</a>

										<div class="cart__item-info">
											<div class="cart__item-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
												<?php
													if ( ! $product_permalink ) {
														echo wp_kses_post( $product_name . '&nbsp;' );
													} else {
														/**
														 * This filter is documented above.
														 *
														 * @since 2.1.0
														 */
														echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
													}

													do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
												?>
											</div>

											<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
										</div>

										<div class="cart__item-panel">
											<div class="cart__item-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
												<?php echo $_product->get_price_html(); ?>
											</div>

											<div class="cart__item-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
												<?php
													if ( $_product->is_sold_individually() ) {
														$min_quantity = 1;
														$max_quantity = 1;
													} else {
														$min_quantity = 0;
														$max_quantity = $_product->get_max_purchase_quantity();
													}

													$product_quantity = woocommerce_quantity_input(
														array(
															'input_name'   => "cart[{$cart_item_key}][qty]",
															'input_value'  => $cart_item['quantity'],
															'max_value'    => $max_quantity,
															'min_value'    => $min_quantity,
															'product_name' => $product_name,
															'stock' => true,
															'sold_individually' => $_product->is_sold_individually()
														),
														$_product,
														false
													);

													echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
												?>
											</div>

											<?php if ( ! $_product->is_sold_individually() ) : ?>
												<div class="cart__item-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
													<?php
														echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
													?>
												</div>
											<?php endif; ?>
										</div>
									</li>
								<?php
							endif;
						endforeach;
					?>
				</ul>

				<?php do_action( 'woocommerce_cart_contents' ); //Empty ?>

				<button type="submit" class="hidden" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

				<?php do_action( 'woocommerce_cart_actions' ); //Empty ?>

				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

				<?php do_action( 'woocommerce_after_cart_contents' ); //Empty ?>
			</div>

			<?php do_action( 'woocommerce_after_cart_table' ); //Empty ?>

			<?php do_action( 'woocommerce_before_cart_collaterals' ); //Empty ?>

			<?php
				/**
				 * Cart collaterals hook.
				 *
				 * //@hooked woocommerce_cross_sell_display
				 * @hooked woocommerce_cart_totals - 10
				 */
				do_action( 'woocommerce_cart_collaterals' );
			?>
		</form>

		<?php do_action( 'woocommerce_after_cart' ); //Empty ?>
	</div>
</section>
