<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

	defined( 'ABSPATH' ) || exit;
?>

<div class="account__order-view">
	Статус заказа № <?php echo $order->get_id(); ?> &mdash;
	<span><?php echo wc_get_order_status_name( $order->get_status() ); ?></span>
</div>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>
