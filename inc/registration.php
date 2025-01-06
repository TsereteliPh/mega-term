<?php
add_action( 'wp_ajax_registration', 'registration' );
add_action( 'wp_ajax_nopriv_registration', 'registration' );
function registration() {
	$response = array(
		'status' => 'failure',
		'message' => ''
	);

	if ( ! isset( $_POST['modal-registration-nonce'] ) || ! wp_verify_nonce( $_POST['modal-registration-nonce'], 'registration' ) ) {
		echo json_encode( $response );
		wp_die();
	}

	if ( ! $_POST['username'] || ! $_POST['password'] || ! $_POST['confirm-password'] || ! $_POST['first-name'] || ! $_POST['last-name'] || ! $_POST['phone'] ) {
		$response['message'] = 'Заполните необходимые поля';
		echo json_encode( $response );
		wp_die();
	}

	$first_name = sanitize_text_field( trim( $_POST['first-name'] ) );
	$last_name = sanitize_text_field( trim( $_POST['last-name'] ) );
	$username = sanitize_email( trim( $_POST['username'] ) );
	$phone = sanitize_text_field( trim( $_POST['phone'] ) );
	$password = sanitize_text_field( trim( $_POST['password'] ) );
	$confirm_password = sanitize_text_field( trim( $_POST['confirm-password'] ) );

	if ( $password !== $confirm_password ) {
		$response['message'] = 'Пароли не совпадают';
		echo json_encode( $response );
		wp_die();
	}

	$userdata = array(
		'user_login' => $username,
		'user_pass' => $password,
		'user_email' => $username,
		'first_name' => $first_name,
		'last_name' => $last_name,
		'description' => 'Телефон: ' . $phone,
	);

	$credentials = array(
		'user_login' => $username,
		'user_password' => $password,
		'remember' => true
	);

	$user_id = wp_insert_user( $userdata );

	if ( ! is_wp_error( $user_id ) ) {
		$response['status'] = 'success';
		$wp_user = wp_signon( $credentials );
	} else {
		$response['message'] = sanitize_text_field( $user_id->get_error_message() );
		echo json_encode( $response );
		wp_die();
	}

	echo json_encode( $response );
	wp_die();
}
