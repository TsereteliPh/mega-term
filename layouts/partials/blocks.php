<?php
$id = $args['id'] ?? false;
if ( have_rows( 'blocks', $id ) ) {
	$counters = array();
	while ( have_rows( 'blocks', $id ) ) {
		the_row();
		$layout = get_row_layout();
		if ( ! isset( $counters[$layout] ) ) {
			// initialize counter
			$counters[$layout] = 1;
		} else {
			// increase existing counter
			$counters[$layout]++;
		}

		get_template_part('layouts/blocks/' . $layout . '/template', null, array(
			'block_id' => $counters[$layout]
		));
	}
}
