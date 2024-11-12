<section class="reviews">
	<div class="container">
		<?php get_template_part( '/layouts/partials/title', null, array(
			'class' => 'reviews__title',
			'title' => get_sub_field( 'title' )
		) ); ?>

		<ul class="reset-list reviews__list js-show-more-container">
			<?php
				$query = new WP_Query( [
					'post_type' => 'reviews',
					'posts_per_page' => 8,
					'paged' => 1,
				] );

				$posts = $query->posts;

				if ( $query->have_posts() ) {
					if ( is_archive() ) {
						foreach ( $posts as $post ) {
							get_template_part('/layouts/partials/cards/review-card', null, array(
								'class' => 'reviews__item',
								'cat' => true
							) );
						}
					} else {
						while ( $query->have_posts() ) {
							$query->the_post();

							get_template_part('/layouts/partials/cards/review-card', null, array(
								'class' => 'reviews__item',
								'cat' => true
							) );
						}

						wp_reset_postdata();
					}
				}
			?>
		</ul>

		<button class="btn btn--thin reviews__btn js-show-more<?php echo ( $query->max_num_pages > 1) ? '' : ' hidden'; ?>" type="button" data-slug="reviews">
			Показать еще
			<svg width="9" height="9"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
		</button>

		<script>
			window.reviews_posts = '<?php echo json_encode($query->query_vars); ?>';
			window.reviews_current_page = <?php echo ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; ?>;
			window.reviews_max_pages = <?php echo $query->max_num_pages; ?>;
		</script>
	</div>
</section>
