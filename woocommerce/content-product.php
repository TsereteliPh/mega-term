<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}

$product_classes = 'main-border main-border--hover product-card';
$catalog_view = $_COOKIE['woocommerce_catalog_flex'] ?? null;
if ( $catalog_view && ( is_shop() || is_product_category() ) ) $product_classes .= ' product-card--large';
if ( $args['class'] ) $product_classes .= ' ' . $args['class'];

$attributes = $product->get_attributes();
$brands = $attributes['pa_brands'] ?? null;
$attributes = array_filter(
	$attributes,
	function( $key ) {
		return $key != 'pa_brands';
	},
	ARRAY_FILTER_USE_KEY
);
$attributes = array_splice( $attributes, 0, 3 );
$sku = $product->get_sku();
$no_woocommerce = $args['no_woocommerce'] ?? null;
?>
<li <?php wc_product_class( $product_classes, $product ); ?>>
	<?php
		$price = $product->get_regular_price();
		$sale_price = $product->get_sale_price();
		$bestseller = get_field( 'bestseller' );

		if ( ( $price && $sale_price ) || $bestseller ) :
			?>

			<div class="product-card__flashes">
				<?php if ( $price && $sale_price ) : ?>
					<div class="product-card__flash product-card__flash--sale">
						<?php
							$percent = round( ( $price - $sale_price ) * 100 / $price );
							echo '-' . $percent . ' %';
						?>
					</div>
				<?php endif; ?>

				<?php if ( $bestseller ) : ?>
					<div class="product-card__flash product-card__flash--bestseller">ХИТ!</div>
				<?php endif; ?>
			</div>

			<?php
		endif;
	?>

	<?php if ( is_user_logged_in() ) : ?>
		<button
			class="btn-fav product-card__fav<?php echo adem_check_favorite( $product->get_id() ) ? ' active' : ''; ?>"
			type="button"
			aria-label="Добавить в избранное"
			data-id="<?php echo $product->get_id(); ?>"
			data-user="<?php echo get_current_user_id(); ?>"
		>
			<svg width="20" height="18"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-fav"></use></svg>
		</button>
	<?php endif; ?>

	<div class="product-card__img">
		<?php echo $product->get_image( 'large' ); ?>
	</div>

	<div class="product-card__info">
		<?php if ( $brands && $brands['options'] ) : ?>
			<div class="product-card__brands">
				<?php foreach ( $brands['options'] as $key => $brand ) : ?>
					<?php $term = get_term_by( 'id', $brand, 'pa_brands' ); ?>

					<a href="<?php echo get_term_link( $term ); ?>" class="product-card__brand">
						<?php echo $term->name . ( $key + 1 !== count( $brands['options'] ) ? ', ' : '' ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $sku ) : ?>
			<div class="product-card__sku"><?php echo 'Арт. ' . $sku; ?></div>
		<?php endif; ?>

		<a href="<?php the_permalink(); ?>" class="product-card__link"><?php the_title(); ?></a>

		<?php if ( $attributes ) : ?>
			<ul class="reset-list product-card__attributes">
				<?php foreach ( $attributes as $attribute ) : ?>
						<?php
							if ( $attribute['id'] ) {
								$term = wc_get_attribute( $attribute['id'] );
								$name = $term->name;
								$values = array();

								foreach ( $attribute['options'] as $option ) {
									$option_term = get_term_by( 'id', $option, $attribute['name'] );
									array_push( $values, $option_term->name );
								}
							} else {
								$name = $attribute['name'];
								$values = $attribute['options'];
							}
						?>
					<li class="product-card__attribute">
						<div class="product-card__attribute-label"><?php echo $name; ?></div>

						<div class="product-card__attribute-values"><?php echo implode( ', ', $values ); ?></div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

	<div class="product-card__commerce">
		<div class="product-card__price<?php echo $product->is_type( 'variable' ) ? ' product-card__price--variable' : ''; ?>">
			<?php echo $product->get_price_html(); ?>
		</div>

		<div class="product-card__commerce-buttons">
			<?php if ( is_user_logged_in() ) : ?>
				<button
					class="btn-fav product-card__commerce-fav<?php echo adem_check_favorite( $product->get_id() ) ? ' active' : ''; ?>"
					type="button"
					aria-label="Добавить в избранное"
					data-id="<?php echo $product->get_id(); ?>"
					data-user="<?php echo get_current_user_id(); ?>"
				>
					<svg width="20" height="18"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-fav"></use></svg>
				</button>
			<?php endif; ?>
		</div>

		<div class="product-card__buttons">
			<?php if ( $no_woocommerce ) : ?>
				<a href="<?php the_permalink(); ?>" class="btn product-card__add-to-cart product-card__add-to-cart--variable">Подробнее</a>
			<?php else : ?>
				<?php
					/**
					 * Hook: woocommerce_after_shop_loop_item.
					 *
					 * //@hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item' );
				?>
			<?php endif; ?>
		</div>
	</div>

	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * //@hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * //@hooked woocommerce_show_product_loop_sale_flash - 10
	 * //@hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * //@hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * //@hooked woocommerce_template_loop_rating - 5
	 * //@hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );
	?>
</li>
