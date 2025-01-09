<?php
add_action( 'wp_ajax_remove_from_favorite', 'remove_from_favorite' );
add_action( 'wp_ajax_nopriv_remove_from_favorite', 'remove_from_favorite' );
function remove_from_favorite() {
	$response = array(
		'status' => 'failure'
	);

	if ( ! is_numeric( $_POST['id'] ) || ! is_numeric( $_POST['user'] ) ) {
		echo json_encode( $response );
		wp_die();
	}

	$user_favorites = get_user_meta( $_POST['user'], 'favorites', false );
	$user_favorites =  json_decode( $user_favorites[0], true );

	if ( adem_check_favorite( $_POST['id'] ) ) {
		$user_favorites = array_diff( $user_favorites, array( $_POST['id'] ) );
	}

	update_user_meta( $_POST['user'], 'favorites', json_encode( $user_favorites ) );

	$response = array(
		'status' => 'success',
		'count' => adem_count_all_favorites()
	);

	echo json_encode( $response );
	wp_die();
}
