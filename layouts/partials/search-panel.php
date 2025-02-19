<div class="search-panel <?php echo $args['class']; ?>" id="search">
	<form role="search" method="get" class="search-panel__form" action="<?php bloginfo( 'url' ); ?>" id="search_form">
		<input type="search" id="search" class="input search-panel__input" value="<?php echo get_search_query(); ?>" name="s" placeholder="Поиск по сайту" minlength="3" required>

		<button type="submit" class="search-panel__btn" aria-label="Поиск">
			<svg width="20" height="21"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-search"></use></svg>
		</button>
	</form>

	<div class="search-panel__result"></div>
</div>
