<section class="catalog-cats">
	<div class="container">
		<?php
			get_template_part( '/layouts/partials/title', null, array(
				'class' => 'catalog-cats__title',
				'title' => get_sub_field( 'title' )
			) );

			$cats = get_terms( [
				'taxonomy' => 'product_cat',
				'parent' => 0,
				'hide_empty' => false, //? Display empty cats
				'exclude' => 15 // Misc cat
			] );

			if ( $cats ) :
				?>

				<ul class="reset-list catalog-cats__list">
					<?php foreach ( $cats as $cat ) : ?>
						<li class="catalog-cats__item">
							<div class="catalog-cats__item-label"><?php echo $cat->name; ?></div>

							<div class="catalog-cats__item-img">
								<?php
									$thumb = get_term_meta( $cat->term_id, 'thumbnail_id' );
									if ( $thumb ) {
										echo wp_get_attachment_image( $thumb[0], 'medium', false );
									}
								?>
							</div>

							<div class="catalog-cats__item-panel">
								<div class="catalog-cats__item-info">
									<?php
										$term_children = get_terms( [
											'taxonomy' => 'product_cat',
											'parent' => $cat->term_id,
										] );
										$count_children = count( $term_children );

										if ( $count_children ) {
											category_ending( $count_children );
										} else {
											product_ending( $cat->count );
										}
									?>
								</div>

								<a href="<?php echo get_term_link( $cat, 'product_cat' ); ?>" class="btn catalog-cats__item-link">
									В каталог
									<svg width="8" height="8"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
									<svg class="catalog-cats__item-link-caret" width="9" height="5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-caret"></use></svg>
								</a>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>

				<?php
			endif;
		?>
	</div>

	<div class="container--slider">
		<?php get_template_part( '/layouts/partials/brands-slider', null, array(
			'class' => 'catalog-cats__brands',
		) ); ?>
	</div>
</section>
