<?php
/**
 * Single variation display
 *
 * This is a javascript-based template for single variations (see https://codex.wordpress.org/Javascript_Reference/wp.template).
 * The values will be dynamically replaced after selecting attributes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

?>
<script type="text/template" id="tmpl-variation-template">
	<div class="woocommerce__price product__single-variation-price">
		<# if (data.variation.price_html) { #>
			{{{ data.variation.price_html }}}
		<# } else { #>
			<ins>
				{{{ data.variation.display_regular_price }}}
				<?php echo get_woocommerce_currency_symbol(); ?>
			</ins>
		<# } #>
	</div>

	<# if (data.variation.sku) { #>
		<div class="product__sku product__single-variation-sku">
			Артикул:
			<span>{{{ data.variation.sku }}}</span>
		</div>
	<# } #>

	<# if (data.variation.availability_html) { #>
		<div class="product__single-variation-availability">{{{ data.variation.availability_html }}}</div>
	<# } #>
</script>
<script type="text/template" id="tmpl-unavailable-variation-template">
	<p><?php esc_html_e( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' ); ?></p>
</script>

