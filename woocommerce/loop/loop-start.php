<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$catalog_view = $_COOKIE['woocommerce_catalog_flex'] ?? null;

$product_count = wp_count_posts( 'product' )->publish;
$catalog_banner = get_field( 'big_banner', wc_get_page_id( 'shop' ) );
$banner_class = 'catalog__item catalog__item--banner catalog__item--banner-' . $catalog_banner['type'];
$banner_class .= $product_count < 12 ? ' catalog__item--banner-last' : ' catalog__item--banner-middle';
?>
<ul class="reset-list catalog__list<?php echo $catalog_view ? ' catalog__list--flex' : ''; ?>">
	<?php get_template_part( '/layouts/partials/promos/' . $catalog_banner['type'], null, array(
		'class' => $banner_class,
		'banner' => $catalog_banner['banner'],
	) ); ?>
