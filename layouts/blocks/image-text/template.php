<?php
	$position = get_sub_field( 'position' );
	$img = get_sub_field( 'img' );
	$title = get_sub_field( 'title' );
	$text = get_sub_field( 'text' );
?>
<section class="image-text">
	<div class="
		container
		image-text__container
		image-text__container--<?php echo $position; ?>
		<?php echo $img ? '' : ' image-text__container--no-img'; ?>
	">
		<?php if ( $img ) : ?>
			<div class="image-text__img">
				<?php echo wp_get_attachment_image( $img, 'large', false ); ?>
			</div>
		<?php endif; ?>

		<div class="image-text__content">
			<?php
				if ( $title['text'] ) {
					echo sprintf(
						'<%1$s class="image-text__title">%2$s</%1$s>',
						$title['type'],
						$title['text']
					);
				}
			?>

			<?php if ( $text ) : ?>
				<div class="image-text__text"><?php echo $text; ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>
