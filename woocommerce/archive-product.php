<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * //@hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * //@hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
?>
<section class="catalog">
	<?php
		/**
		 * Hook: woocommerce_shop_loop_header.
		 *
		 * @since 8.6.0
		 *
		 * @hooked woocommerce_product_taxonomy_archive_header - 10
		 */
		do_action( 'woocommerce_shop_loop_header' );
	?>

	<div class="container catalog__container">
		<div class="catalog__content">
			<?php dynamic_sidebar( 'catalog_sidebar' ); // Added filter dynamic_sidebar_params in woocommerce.php ?>

			<div class="catalog__products">
				<?php if ( woocommerce_product_loop() ) : ?>
					<div class="catalog__panel">
						<?php
							/**
							 * Hook: woocommerce_before_shop_loop.
							 *
							 * @hooked woocommerce_output_all_notices - 10
							 * //@hooked woocommerce_result_count - 20
							 * @hooked woocommerce_catalog_ordering - 30
							 */
							do_action( 'woocommerce_before_shop_loop' );
						?>

						<form class="catalog__view" method="POST">
							<?php $catalog_view = $_COOKIE['woocommerce_catalog_flex'] ?? null; ?>

							<label class="catalog__view-option">
								<input type="radio" name="catalog-view" value="grid"<?php echo $catalog_view ? '' : ' checked' ;?>>
								<svg width="20" height="20"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-view-grid"></use></svg>
							</label>

							<label class="catalog__view-option">
								<input type="radio" name="catalog-view" value="flex"<?php echo $catalog_view ? ' checked' : '' ;?>>
								<svg width="20" height="20"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-view-flex"></use></svg>
							</label>

							<button class="hidden" type="submit"></button>
						</form>

						<button class="catalog__button-filter" type="button" data-fancybox data-src="#filters">
							<svg width="16" height="18"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-filter"></use></svg>
							<span>Фильтры</span>
						</button>
					</div>

					<?php
						woocommerce_product_loop_start();

						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();

								/**
								 * Hook: woocommerce_shop_loop.
								 */
								do_action( 'woocommerce_shop_loop' );

								wc_get_template( 'content-product.php', array(
									'class' => 'catalog__item'
								) );
							}
						}

						woocommerce_product_loop_end();

						/**
						 * Hook: woocommerce_after_shop_loop.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					?>
				<?php else : ?>
					<?php
						/**
						 * Hook: woocommerce_no_products_found.
						 *
						 * @hooked wc_no_products_found - 10
						 */
						do_action( 'woocommerce_no_products_found' );
					?>
				<?php endif; ?>

				<?php
					/**
					 * Hook: woocommerce_after_main_content.
					 *
					 * //@hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );
				?>
			</div>
		</div>
	</div>
</section>

<?php
get_footer( 'shop' );
