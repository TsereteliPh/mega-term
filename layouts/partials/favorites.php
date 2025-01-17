<section class="favorites">
	<div class="container favorites__container">
		<?php
			$title = array(
				'small-text' => '',
				'type' => 'h1',
				'text' => 'Избранные товары',
			);

			get_template_part( '/layouts/partials/title', null, array(
				'class' => 'favorites__title',
				'title' => $title
			) );

			$user_favorites = get_user_meta( get_current_user_id(), 'favorites', false );
			$user_favorites = json_decode( $user_favorites ? $user_favorites[0] : '', true );

			if ( $user_favorites ) :
		?>
			<ul class="reset-list favorites__list">
				<?php
					$args = array(
						'post_type' => 'product',
						'post__in' => $user_favorites,
						'orderby' => 'post__in'
					);

					$query = new WP_Query( $args );
					$posts = $query->posts;

					if ( $query->have_posts() ) {
						if ( is_archive() ) {
							foreach ( $posts as $post ) {
								get_template_part( '/woocommerce/content-product', null, array(
									'class' => 'favorites__item',
									'no-woocommerce' => true
								) );
							}
						} else {
							while ( $query->have_posts() ) {
								$query->the_post();

								get_template_part( '/woocommerce/content-product', null, array(
									'class' => 'favorites__item',
									'no-woocommerce' => true
								) );
							}

							wp_reset_postdata();
						}
					}
				?>
			</ul>
		<?php else : ?>
			<div class="favorites__empty">
				<div class="favorites__text">
					К сожалению, в данный момент у вас нет избранных товаров.</br>
					<br>
					Чтобы добавить товары в избранное, нажмите на значок сердца рядом с понравившимся товаром. Все избранные товары будут отображаться здесь, и вы сможете быстро к ним вернуться в любое время.
				</div>

				<a class="btn favorites__link" href="<?php echo wc_get_page_permalink( 'shop' ); ?>">Каталог</a>
			</div>
		<?php endif; ?>
	</div>
</section>
