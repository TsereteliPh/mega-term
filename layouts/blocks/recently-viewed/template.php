<?php
	$recently_viewed = $_COOKIE['woocommerce_recently_viewed'];
	if ( ! empty( $recently_viewed ) ) {
		$title = ! empty( $args['title'] ) ? $args['title'] : get_sub_field( 'title' );
		$products = explode( '|', $recently_viewed );

		get_template_part( '/layouts/blocks/product-slider/template', null, array(
			'title' => $title,
			'slides' => $products
		) );
	}
?>
