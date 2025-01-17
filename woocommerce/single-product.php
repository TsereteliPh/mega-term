<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

get_header( 'shop' ); ?>

<?php
	/**
	 * woocommerce_before_main_content hook.
	 *
	 * //@hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * //@hooked woocommerce_breadcrumb - 20
	 */
	do_action( 'woocommerce_before_main_content' );
?>

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<?php wc_get_template_part( 'content', 'single-product' ); ?>

	<?php endwhile; // end of the loop. ?>

<?php
	/**
	 * woocommerce_after_main_content hook.
	 *
	 * //@hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );
?>

<?php
	/**
	 * woocommerce_sidebar hook.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action( 'woocommerce_sidebar' );
?>

<?php
$upsells = $product->get_upsell_ids();
if ( $upsells ) {
	$upsells = array_map( function( $id ) {
        $product = wc_get_product( $id );
        if ( $product && $product->is_type( 'variation' ) ) {
            return $product->get_parent_id();
        }
        return $id;
    }, $upsells );
	$upsells = array_unique( $upsells );

	get_template_part( '/layouts/blocks/product-slider/template', null, array(
		'title' => array(
			'small_text' => '',
			'type' => 'h2',
			'text' => 'СОПУТСТВУЮЩИЕ ТОВАРЫ',
			'link' => array(
				'url' => wc_get_page_permalink( 'shop' ),
				'title' => 'Смотреть все'
			)
		),
		'slides' => $upsells
	) );
}

get_template_part( '/layouts/blocks/recently-viewed/template', null, array(
	'title' => array(
		'small_text' => '',
		'type' => 'h2',
		'text' => 'ВЫ НЕДАВНО',
		'indent' => 'СМОТРЕЛИ',
		'link' => array(
			'url' => wc_get_page_permalink( 'shop' ),
			'title' => 'Смотреть все'
		)
	)
) );

get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
