<?php
$search_systems = ['google', 'yandex', 'mail.ru', 'rambler', 'bing'];
$important_source = false;
$source_array = [
	'source' => null,
	'medium' => null,
	'campaign' => null,
	'term' => null,
	'content' => null
];

if ( isset( $_GET['utm_medium'] ) ) {
	$important_source = true;
	$source_array['medium'] = $_GET['utm_medium'];
	$source_array['source'] = isset( $_GET['utm_source'] ) ? $_GET['utm_source'] : null;
	$source_array['campaign'] = isset ( $_GET['utm_campaign'] ) ? $_GET['utm_campaign'] : null;
	$source_array['term'] = isset ( $_GET['utm_term'] ) ? $_GET['utm_term'] : null;
	$source_array['content'] = isset( $_GET['utm_content'] ) ? $_GET['utm_content'] : null;
} else if ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
	preg_match( '/(?:https?:\/\/)?(.*?)(?:\/|$)/', $_SERVER['HTTP_REFERER'], $referrer );
	$referrer = preg_match( '/\.(.*\.\w*)/', $referrer[1], $new_referrer ) ? $new_referrer[1] : $referrer[1];

	preg_match( '/(?:https?:\/\/)?(.*?)(?:\/|$)/', $_SERVER['HTTP_HOST'], $host );
	$host = preg_match( '/\.(.*\.\w*)/', $host[1], $new_host ) ? $new_host[1] : $host[1];

	if ( $host != $referrer ) {
		$important_source = true;
		$source_array['source'] = $referrer;
		$source_array['medium'] = 'referral';
		foreach ( $search_systems as $search_system ) {
			if ( strpos( $referrer, $search_system ) > -1 ) {
				$organic = true;
				$source_array['source'] = $search_system;
				$source_array['medium'] = 'organic';
				break;
			}
		}
	} else {
		$source_array['source'] = 'none';
		$source_array['medium'] = 'direct';
	}
} else {
	$source_array['source'] = 'none';
	$source_array['medium'] = 'direct';
}

if ( ! $important_source && isset( $_COOKIE['source_cookie'] ) ) {
	$source_cookie = unserialize( stripslashes( $_COOKIE['source_cookie'] ) );
	if ( $source_cookie && ! empty( $source_cookie['medium'] ) ) {
		$source_array = $source_cookie;
	}
}

setcookie( "source_cookie", serialize( $source_array ), time() + 3600 * 24 * 30, "/" );

$html = "Источник - $source_array[source], Канал - $source_array[medium]";
$html .= $source_array['campaign'] ? ", Кампания - $source_array[campaign]" : null;
$html .= $source_array['term'] ? ", Объявление - $source_array[term]" : null;
$html .= $source_array['content'] ? ", Ключевое слово - $source_array[content]" : null;

setcookie( "traffic_source", $html, time() + 3600 * 24 * 30, "/" );

$_SESSION['traffic_source'] = $html;
