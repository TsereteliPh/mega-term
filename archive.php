<?php get_header(); ?>

<?php $current = get_queried_object(); ?>

<?php if ( in_category( 22 ) || in_category( 23 ) ) : ?>
	<section class="archive-block">
		<div class="container">
			<?php
				$small_text = in_category( 22 ) ? 'Наши новости' : 'Может быть полезно';
				if ( is_tag() ) $small_text = '#' . $current->name;

				$title = array(
					'small-text' => $small_text,
					'type' => 'h1',
					'text' => in_category( 22 ) ? 'Новости' : 'Статьи'
				);

				get_template_part( '/layouts/partials/title', null, array(
					'class' => 'archive-block__title',
					'title' => $title
				) );
			?>

			<ul class="reset-list archive-block__list js-show-more-container">
				<?php
					$query = new WP_Query( [
						'post_type' => 'post',
						'cat' => in_category( 22 ) ? 22 : 23,
						'tag' => is_tag() ? $current->slug : null,
						'orderby' => 'post_date',
						'posts_per_page' => 8,
						'paged' => 1
					] );

					$posts = $query->posts;

					if ( $query->have_posts() ) {
						if ( is_archive() ) {
							foreach ( $posts as $post ) {
								get_template_part('/layouts/partials/cards/article-card', null, array(
									'class' => 'archive-block__item',
								) );
							}
						} else {
							while ( $query->have_posts() ) {
								$query->the_post();

								get_template_part('/layouts/partials/cards/article-card', null, array(
									'class' => 'archive-block__item',
								) );
							}

							wp_reset_postdata();
						}
					}
				?>
			</ul>

			<button class="btn btn--thin btn-show-more archive-block__btn js-show-more<?php echo ( $query->max_num_pages > 1) ? '' : ' hidden'; ?>" type="button" data-slug="articles">
				Показать еще
			</button>

			<script>
				window.articles_posts = '<?php echo json_encode($query->query_vars); ?>';
				window.articles_current_page = <?php echo ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; ?>;
				window.articles_max_pages = <?php echo $query->max_num_pages; ?>;
			</script>
		</div>
	</section>
<?php endif; ?>

<?php
	get_template_part( 'layouts/partials/blocks', null, array(
		'id' => $current->cat_ID
	) );
?>

<?php get_footer(); ?>
