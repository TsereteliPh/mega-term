<?php
add_action( 'wp_ajax_login', 'login' );
add_action( 'wp_ajax_nopriv_login', 'login' );
function login() {
	$response = array(
		'status' => 'failure',
		'message' => ''
	);

	if ( ! isset( $_POST['login-nonce'] ) || ! wp_verify_nonce( $_POST['login-nonce'], 'login' ) ) {
		echo json_encode( $response );
		wp_die();
	}

	if ( ! $_POST['username'] || ! $_POST['password'] ) {
		$response['message'] = 'Заполните поля "Email" и "Пароль"';
		echo json_encode( $response );
		wp_die();
	}

	$username = sanitize_user( trim( $_POST['username'] ) );
	$password = sanitize_text_field( trim( $_POST['password'] ) );
	$rememberme = sanitize_text_field( trim( $_POST['rememberme'] ) );
	$credentials = array(
		'user_login' => $username,
		'user_password' => $password,
		'remember' => $rememberme ? true : false
	);

	$wp_user = wp_signon( $credentials );
	if ( ! is_wp_error( $wp_user ) ) {
		$response['status'] = 'success';
	} else {
		$response['message'] = sanitize_text_field( $wp_user->get_error_message() );
	}

	echo json_encode( $response );
	wp_die();
}
