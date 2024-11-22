<?php
add_action( 'wp_ajax_load_more', 'load_more' );
add_action( 'wp_ajax_nopriv_load_more', 'load_more' );
function load_more() {
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1;

	$query = new WP_Query( $args );

	$return_html = '';
	if( $query->have_posts() ) {
		while( $query->have_posts() ) {
			$query->the_post();
			if ( $args['post_type'] == 'reviews' ) {
				$return_html .= get_template_part( 'layouts/partials/cards/review-card', null, array(
					'class' => 'reviews__item',
					'cat' => true
				));
			} else if ( in_category( 22 ) || in_category( 23 ) ) {
				$return_html .= get_template_part( 'layouts/partials/cards/article-card', null, array(
					'class' => 'archive-block__item',
				));
			}
		}

		wp_reset_postdata();
	}

	echo $return_html;
	wp_die();
}
