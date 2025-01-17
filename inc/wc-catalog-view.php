<?php
add_action( 'wp_ajax_wc_catalog_view', 'wc_catalog_view' );
add_action( 'wp_ajax_nopriv_wc_catalog_view', 'wc_catalog_view' );
function wc_catalog_view() {
	$view = $_POST['catalog-view'];
	$response = array(
		'status' => 'success',
		'view' => $view
	);

	if ( $view == 'flex' ) {
		setcookie( 'woocommerce_catalog_flex', 1, time() + 3600 * 24 * 30, '/' );
		echo json_encode( $response );
		wp_die();
	} else if ( $view == 'grid' ) {
		setcookie( 'woocommerce_catalog_flex', 0, time() + 3600 * 24 * 30, '/' );
		echo json_encode( $response );
		wp_die();
	} else {
		wc_add_notice( 'На сайте возникла ошибка. Попробуйте перезагрузить текущую страницу. Если проблема сохраняется, рекомендуем обратиться в службу поддержки.', 'error' );
		wc_print_notices();
		wp_die();
	}
}
