<?php get_header(); ?>

<section class="search">
	<div class="container search__container">
		<?php if ( have_posts() ) : ?>
			<h1 class="search__title">
				Результаты поиска по запросу:
				<span>&#171;<?php the_search_query(); ?>&#187;</span>
			</h1>

			<?php
				$products = [];
				$news = [];
				$blog = [];

				foreach ( $posts as $post ) {
					if ( $post->post_type == 'product' ) {
						$products[] = $post;
					} else if ( $post->post_type == 'post' ) {
						if ( in_category( 22, $post ) ) {
							$news[] = $post;
						} else if ( in_category( 23, $post ) ) {
							$blog[] = $post;
						}
					}
				}
			?>

			<?php if ( $products ) : ?>
				<div class="search__box search__box--catalog">
					<h2 class="search__title search__title--counter">
						Товары:
						<span><?php echo count( $products ); ?></span>
					</h2>

					<ul class="reset-list search__catalog-list">
						<?php
							foreach ( $products as $post ) {
								setup_postdata( $post );

								get_template_part( '/woocommerce/content-product', null, array(
									'class' => 'search__catalog-item',
									'no-woocommerce' => true
								) );

								wp_reset_postdata();
							}
						?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( $news ) : ?>
				<div class="search__box search__box--news">
					<h2 class="search__title search__title--counter">
						Новости:
						<span><?php echo count( $news ); ?></span>
					</h2>

					<ul class="reset-list search__news-list">
						<?php
							foreach ( $news as $post ) {
								setup_postdata( $post );

								get_template_part( 'layouts/partials/cards/article-card', null, array(
									'class' => 'search__news-item'
								));

								wp_reset_postdata();
							}
						?>
					</ul>
				</div>
			<?php endif; ?>

			<?php if ( $blog ) : ?>
				<div class="search__box search__box--blog">
					<h2 class="search__title search__title--counter">
						Статьи:
						<span><?php echo count( $blog ); ?></span>
					</h2>

					<ul class="reset-list search__blog-list">
						<?php
							foreach ( $blog as $post ) {
								setup_postdata( $post );

								get_template_part( 'layouts/partials/cards/article-card', null, array(
									'class' => 'search__blog-item'
								));

								wp_reset_postdata();
							}
						?>
					</ul>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<div class="search__empty">
				<h1 class="search__title search__title--no-result">
					По вашему запросу результатов
					<span>не найдено</span>
				</h1>

				<a href="<?php echo bloginfo( 'url' ); ?>" class="btn search__link">На главную</a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
