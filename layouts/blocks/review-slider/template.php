<?php $reviewGroup = get_sub_field( 'reviews-group' ); ?>
<section class="review-slider">
	<div class="container">
		<?php get_template_part( '/layouts/partials/title', null, array(
			'class' => 'review-slider__title',
			'title' => get_sub_field( 'title' )
		) ); ?>

		<?php if ( count( $reviewGroup ) > 1 ) : ?>
			<ul class="reset-list review-slider__cats js-tabs">
				<?php foreach ( $reviewGroup as $key => $cat ) : ?>
					<li class="btn btn--thin review-slider__cat<?php echo $key === 0 ? ' active' : ''; ?>" data-tab="review-cat-<?php echo $cat['tax']->slug; ?>">
						<?php echo $cat['tax']->name; ?>
					</li>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="container--slider">
		<?php foreach ( $reviewGroup as $key => $reviews ) : ?>
			<div class="review-slider__slider<?php echo $key === 0 ? ' active' : ''; ?>" id="review-cat-<?php echo $reviews['tax']->slug; ?>">
				<div class="review-slider__swiper swiper">
					<ul class="reset-list review-slider__list swiper-wrapper">
						<?php
							foreach ( $reviews['reviews'] as $post ) {
								setup_postdata( $post );

								get_template_part('/layouts/partials/cards/review-card', null, array(
									'class' => 'review-slider__item swiper-slide',
									'cat' => false
								) );
							}

							wp_reset_postdata();
						?>
					</ul>

					<div class="pagination review-slider__pagination"></div>
				</div>

				<div class="review-slider__controls controls">
					<div class="controls__prev">
						<svg width="9" height="5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-caret"></use></svg>
					</div>

					<div class="controls__next">
						<svg width="9" height="5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-caret"></use></svg>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
