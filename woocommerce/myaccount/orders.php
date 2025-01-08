<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>
	<div class="account__order">
		<?php
			foreach ( $customer_orders->orders as $customer_order ) :
			$order = wc_get_order( $customer_order );
		?>
			<a href="<?php echo $order->get_view_order_url(); ?>" class="account__order-order">
				<div class="account__order-num">
					Заказ №
					<span><?php echo $order->get_id(); ?></span>
				</div>

				<time class="account__order-date" date-time="<?php echo $order->get_date_created()->date( 'Y-m-j' ); ?>"><?php echo $order->get_date_created()->date( 'd.m.Y' ); ?></time>
			</a>
		<?php endforeach; ?>
	</div>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); //Empty ?>
<?php else : ?>
	<div class="account__order--no-order">
		<div class="account__order-text">Заказов пока нет</div>

		<a class="btn account__order-shop-link" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>">Каталог</a>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
