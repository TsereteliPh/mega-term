<?php
	$brands = get_terms( [
		'taxonomy' => 'pa_brands',
		'hide_empty' => false //? Display empty cats
	] );

	if ( ! empty( $brands ) ) :
		?>

		<div class="brands-slider <?php echo $args['class']; ?>">
			<div class="brands-slider__slider swiper">
				<ul class="reset-list brands-slider__list swiper-wrapper">
					<?php foreach ( $brands as $brand ) : ?>
						<li class="brands-slider__item swiper-slide">
							<a href="<?php echo get_term_link( $brand ); ?>" class="brands-slider__item-link">
								<?php
									$meta = get_term_meta( $brand->term_id );
									$img = $meta['brand_icon'][0];
									if ( $img ) {
										echo wp_get_attachment_image( $img, 'medium', false );
									} else {
										echo $brand->name;
									}
								?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="brands-slider__controls controls">
				<div class="controls__prev">
					<svg width="9" height="5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-caret"></use></svg>
				</div>

				<div class="controls__next">
					<svg width="9" height="5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-caret"></use></svg>
				</div>
			</div>
		</div>

		<?php
	endif;
?>
