<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

$product_desc = get_field( 'product_desc', $product->get_id() );
if ( ! empty( $product_desc ) ) {
	$desc = array(
		'description' => array(
			'title'     => __( 'Description', 'woocommerce' ),
			'priority' => 10,
			'callback'  => 'woocommerce_product_description_tab',
		)
	);

	$product_tabs = $desc + $product_tabs;
}

if ( ! empty( $product_tabs ) ) : ?>
	<div class="product__tabs">
		<ul class="reset-list product__tabs-list js-tabs" role="tablist">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<li
					class="product__tabs-item<?php echo ( array_key_first( $product_tabs ) == $key ) ? ' active' : ''; ?>"
					role="tab"
					aria-controls="tab-<?php echo esc_attr( $key ); ?>"
					data-tab="tab-<?php echo esc_attr( $key ); ?>"
				>
					<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="product__tabs-elements">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<div
					class="product__tabs-element product__tabs-element--<?php echo esc_attr( $key ) . ( ( array_key_first( $product_tabs ) == $key ) ? ' active' : '' ); ?>"
					id="tab-<?php echo esc_attr( $key ); ?>"
					role="tabpanel"
					aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>"
				>
					<?php
						if ( isset( $product_tab['callback'] ) ) {
							call_user_func( $product_tab['callback'], $key, $product_tab );
						}
					?>
				</div>
			<?php endforeach; ?>
		</div>

		<?php do_action( 'woocommerce_product_after_tabs' ); //Empty ?>
	</div>
<?php endif; ?>
