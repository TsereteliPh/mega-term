<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$product_type = $product->get_type();
$guarantee = get_field( 'product_guarantee', $product->get_id() );
$excerpt = get_field( 'product_excerpt', $product->get_id() );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<section id="product-<?php the_ID(); ?>" <?php wc_product_class( 'product--' . $product_type, $product ); ?>>
	<div class="container product__container">
		<?php
			/**
			 * Hook: woocommerce_before_single_product.
			 *
			 * @hooked woocommerce_output_all_notices - 10
			 */
			do_action( 'woocommerce_before_single_product' );
		?>

		<h1 class="product__title"><?php the_title(); ?></h1>

		<div class="product__header">
			<div class="product__header-buttons">
				<button class="product__header-button product__header-button--fav" type="button" aria-label="Добавить в избранное">
					<?php //TODO: fav ?>
					Добавить в избранное
					<svg width="20" height="17"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-fav"></use></svg>
				</button>
			</div>

			<?php
				$availability = $product->get_availability();
				if ( $product_type == 'simple' && $availability['availability'] ) :
					?>

					<div class="product__header-availability product__header-availability--<?php echo $availability['class']; ?>">
						<?php echo $availability['availability']; ?>
					</div>

					<?php
				endif;
			?>
		</div>

		<div class="product__content">
			<?php
				/**
				 * Hook: woocommerce_before_single_product_summary.
				 *
				 * //@hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );
			?>

			<div class="product__content-info">
				<?php if ( $guarantee ) : ?>
					<div class="product__content-guarantee">
						<svg width="14" height="15"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-protect"></use></svg>
						<?php echo $guarantee; ?>
					</div>
				<?php endif; ?>

				<?php if ( $excerpt ) : ?>
					<div class="product__content-excerpt"><?php echo $excerpt; ?></div>
				<?php endif; ?>
			</div>

			<div class="product__summary">
				<?php
					/**
					 * Hook: woocommerce_single_product_summary.
					 *
					 * //@hooked woocommerce_template_single_title - 5
					 * //@hooked woocommerce_template_single_rating - 10
					 * //@hooked woocommerce_template_single_price - 10
					 * //@hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * //@hooked woocommerce_template_single_meta - 40
					 * //@hooked woocommerce_template_single_sharing - 50
					 * @hooked WC_Structured_Data::generate_product_data() - 60
					 */
					do_action( 'woocommerce_single_product_summary' );
				?>
			</div>
		</div>

		<?php
			/**
			 * Hook: woocommerce_after_single_product_summary.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * //@hooked woocommerce_upsell_display - 15
			 * //@hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div>
</section>

<?php do_action( 'woocommerce_after_single_product' ); ?>
