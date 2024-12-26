<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-item-data.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<ul class="reset-list attributes cart__item-variations">
	<?php foreach ( $item_data as $data ) : ?>
		<li class="attributes__item">
			<div class="attributes__item-label"><?php echo wp_kses_post( $data['key'] ); ?>:</div>
			<div class="attributes__item-value"><?php echo wp_kses_post( $data['display'] ); ?></div>
		</li>
	<?php endforeach; ?>
</ul>
