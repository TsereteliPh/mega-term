<?php get_header(); ?>

<section class="not-found">
	<div class="container not-found__container">
		<div class="not-found__content">
			<h1 class="not-found__title">СТРАНИЦА НЕ НАЙДЕНА</h1>

			<div class="not-found__text">Страница, которую вы ищете, возможно, была удалена или переехала на  другой адрес. Чтобы найти то, что вы искали, воспользуйтесь поиском или переходите в нужную категорию.</div>

			<a href="<?php echo bloginfo( 'url' ); ?>" class="btn btn--thic not-found__link">
				Вернуться<br>
				на главную

				<svg width="8" height="8"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
			</a>
		</div>

		<img class="not-found__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/not-found-img.jpg" alt="Изображение закрытого крана" width="380" height="470">

		<svg width="582" height="190" class="not-found__code"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-404"></use></svg>
	</div>
</section>

<?php get_footer(); ?>
