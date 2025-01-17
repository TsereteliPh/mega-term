<?php
$title = $args['title'] ?? null;
$small_text = ! empty( $title['small_text'] ) ? $title['small_text'] : '';
$type = ! empty( $title['type'] ) ? $title['type'] : '';
$text = ! empty( $title['text'] ) ? $title['text'] : '';
$indent = ! empty( $title['indent'] ) ? $title['indent'] : '';
$link_url = ! empty( $title['link']['url'] ) ? $title['link']['url'] : '';
$link_target = ! empty( $title['link']['target'] ) ? $title['link']['target'] : '_self';
$link_title = ! empty( $title['link']['title'] ) ? $title['link']['title'] : 'Подробнее';

$classes = 'title';
if ( $small_text ) $classes .= ' title--small-text';

if ( $title ) :
	?>

	<div class="<?php echo $classes . ( ! empty( $args['class'] ) ? ' ' . $args['class'] : '' ); ?>">
		<?php if ( $small_text ) : ?>
			<div class="title__small-text"><?php echo $small_text; ?></div>
		<?php endif; ?>

		<?php
			echo sprintf(
				'<%1$s class="title__text">
					%2$s
					<span>%3$s</span>
				</%1$s>',
				$type,
				$text,
				$indent
			);
		?>

		<?php if ( $link_url ) : ?>
			<a href="<?php echo $link_url; ?>" class="btn btn--thin title__link" target="<?php echo $link_target; ?>">
				<?php echo $link_title; ?>
				<svg width="8" height="8"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
			</a>
		<?php endif; ?>
	</div>

	<?php
endif;
