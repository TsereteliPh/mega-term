<?php
if ( ! empty( $args['title']['text'] ) ) {
	$classes = 'title';
	if ( $args['title']['small-text'] ) $classes .= ' title--small-text';

	$format = '<div class="' . $classes . ' %1$s">';

	if ( $args['title']['small-text'] ) {
		$format .= '<div class="title__small-text">%2$s</div>';
	}

	$format .= '
		<%3$s class="title__text">
			%4$s
			<span>%5$s</span>
		</%3$s>
	';

	if ( $args['title']['link'] ) {
		$format .= '
			<a href="%6$s" class="btn btn--thin title__link" target="%7$s">
				%8$s
				<svg width="8" height="8"><use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#icon-arrow-small"></use></svg>
			</a>
		';
	}

	$format .= '</div>';
	echo sprintf(
		$format,
		$args['class'],
		$args['title']['small-text'] ?? null,
		$args['title']['type'],
		$args['title']['text'],
		$args['title']['indent'],
		$args['title']['link']['url'] ?? null,
		$args['title']['link']['target'] ?? null,
		$args['title']['link']['title'] ?? null,
	);
}
