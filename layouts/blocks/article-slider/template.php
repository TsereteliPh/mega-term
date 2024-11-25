<?php
	$group = get_sub_field( 'group' );
	if ( $group ) :
		?>

		<section class="article-slider">
			<div class="container">
				<div class="title title--small-text article-slider__title">
					<div class="title__small-text">Информация</div>

					<ul class="reset-list title__list js-tabs">
						<?php foreach ( $group as $key => $slider ) : ?>
							<li class="title__item<?php echo $key === 0 ? ' active' : ''; ?>" data-tab="article-slider-<?php echo $key; ?>">
								<h2><?php echo $slider['title']; ?></h2>
							</li>
						<?php endforeach; ?>
					</ul>

					<?php foreach ( $group as $key => $slider ) : ?>
						<a
							href="<?php echo $slider['link']['url']; ?>"
							class="btn btn--thin title__link<?php echo $key === 0 ? ' active' : ''; ?>"
							target="<?php echo $slider['link']['target']; ?>"
							data-id="article-slider-<?php echo $key; ?>"
						>
							<?php echo $slider['link']['title']; ?>
							<svg width="8" height="8"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
						</a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="container--slider">
				<?php foreach ( $group as $key => $slider ) : ?>
					<div class="article-slider__content<?php echo $key === 0 ? ' active' : ''; ?>" id="article-slider-<?php echo $key; ?>">
						<div class="article-slider__slider swiper">
							<ul class="reset-list swiper-wrapper">
								<?php
									foreach ( $slider['slider'] as $post ) {
										setup_postdata( $post );

										get_template_part('/layouts/partials/cards/article-card', null, array(
											'class' => 'article-slider__slide swiper-slide',
										) );
									}

									wp_reset_postdata();
								?>
							</ul>

							<div class="pagination article-slider__pagination"></div>
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

		<?php
	endif;
?>
