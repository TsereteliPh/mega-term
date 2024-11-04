<?php
if ( ! empty( $args['title']['text'] ) ) {
	echo sprintf( '<%1$s class="title %2$s">%3$s</%1$s>',
		$args['title']['type'],
		$args['class'],
		$args['title']['text']
	);
}
