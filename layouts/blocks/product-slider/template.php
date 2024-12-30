<section class="product-slider">
	<div class="container">
		<?php  get_template_part( '/layouts/partials/title', null, array(
			'class' => 'product-slider__title',
			'title' => get_sub_field( 'title' )
		) ); ?>
	</div>

	<?php
		$slides = get_sub_field( 'slider' );
		if ( $slides ) :
			?>

			<div class="container--slider">
				<div class="product-slider__slider">
					<div class="product-slider__swiper swiper">
						<ul class="reset-list product-slider__list swiper-wrapper">
							<?php
								foreach ( $slides as $post ) {
									setup_postdata( $post );

									wc_get_template( 'content-product.php', array(
										'class' => 'product-slider__item swiper-slide',
										'no-woocommerce' => true
									) );
								}

								wp_reset_postdata();
							?>
						</ul>

						<div class="pagination product-slider__pagination"></div>
					</div>

					<?php get_template_part( 'layouts/partials/controls', null, array(
						'class' => 'product-slider__controls'
					) ); ?>
				</div>
			</div>

			<?php
		endif;
	?>
</section>
