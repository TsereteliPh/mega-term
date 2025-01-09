<?php
add_action( 'wp_ajax_add_to_favorite', 'add_to_favorite' );
add_action( 'wp_ajax_nopriv_add_to_favorite', 'add_to_favorite' );
function add_to_favorite() {
	$response = array(
		'status' => 'failure'
	);

	if ( ! is_numeric( $_POST['id'] ) || ! is_numeric( $_POST['user'] ) ) {
		echo json_encode( $response );
		wp_die();
	}

	$user_favorites = get_user_meta( $_POST['user'], 'favorites', false );
	$user_favorites =  json_decode( $user_favorites[0], true );

	if ( ! $user_favorites ) $user_favorites = array();

	$user_favorites[] = $_POST['id'];
	$user_favorites = array_unique( $user_favorites );
	update_user_meta( $_POST['user'], 'favorites', json_encode( $user_favorites ) );

	$response = array(
		'status' => 'success',
		'count' => adem_count_all_favorites()
	);

	echo json_encode( $response );
	wp_die();
}
