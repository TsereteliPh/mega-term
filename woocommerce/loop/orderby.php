<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="catalog__orderby">
	<div class="catalog__orderby-text">Сортировать по:</div>

	<form class="woocommerce-ordering catalog__orderby-form" method="get">
		<select name="orderby" class="hidden orderby catalog__orberby-select" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
			<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
				<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
		</select>
		<input type="hidden" name="paged" value="1" />
		<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>

		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<button
				class="catalog__orderby-btn<?php echo $id === $orderby ? ' active' : ''; ?>"
				data-value="<?php echo esc_attr( $id ); ?>"
				type="button"
			>
				<?php echo esc_attr( $name ); ?>
			</button>
		<?php endforeach; ?>
	</form>
</div>
