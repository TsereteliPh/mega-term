<?php
add_action( 'wp_ajax_search', 'search' );
add_action( 'wp_ajax_nopriv_search', 'search' );
function search() {
	$response = array(
		'status' => 'failure',
		'message' => '',
		'markup' => '',
	);

	if ( ! isset( $_POST['query'] ) || empty( $_POST['query'] ) ) {
		$response['message'] = 'Возникла непредвиденная ошибка. Пожалуйста, повторите попытку позже или обратитесь в поддержку.';
		echo json_encode( $response );
		wp_die();
	}

	$search_query = sanitize_text_field( $_POST['query'] );
	$results = array();

	$args_posts = array(
		'post_type' => array(
			'post',
			'page',
			'product'
		),
		'posts_per_page' => -1,
		's' => $search_query,
		'post_status' => 'publish'
	);
	$query_posts = new WP_Query( $args_posts );

	$args_sku = array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => '_sku',
				'value' => $search_query,
				'compare' => 'LIKE'
			)
		)
	);
	$query_sku = new WP_Query( $args_sku );

	if ( $query_posts->have_posts() || $query_sku->have_posts() ) {
		ob_start();

		while ( $query_posts->have_posts() ) {
			$query_posts->the_post();

			get_template_part( 'layouts/partials/cards/search-card', null );
		}

		while ( $query_sku->have_posts() ) {
			$query_sku->the_post();

			get_template_part( 'layouts/partials/cards/search-card', null );
		}

		$markup = ob_get_clean();

		$response['status'] = 'success';
		$response['markup'] = $markup;
	}

	wp_reset_postdata();

	echo json_encode( $response );
	wp_die();
}
