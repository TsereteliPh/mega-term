<section class="main-text">
	<div class="container">
		<?php get_template_part( '/layouts/partials/title', null, array(
			'class' => 'main-text__title',
			'title' => get_sub_field( 'title' )
		) ); ?>

		<?php
			$logo = get_sub_field( 'logo' );
			$bg_style = get_sub_field( 'bg_style' );
			$bg = get_sub_field( 'bg' );

			if ( $bg ) :
				?>

				<div class="main-text__bg main-text__bg--<?php echo $bg_style; ?>">
					<?php if ( $logo ) : ?>
						<div class="main-text__bg-logo">
							<svg width="225" height="108"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-logo"></use></svg>
						</div>
					<?php endif; ?>

					<div class="main-text__bg-img<?php echo $logo ? ' logo' : ''; ?>">
						<?php echo wp_get_attachment_image( $bg, 'full', false ); ?>
					</div>
				</div>

				<?php
			endif;
		?>

		<div class="main-text__content">
			<?php
				$title = get_sub_field( 'text_title' );
				$text = get_sub_field( 'text' );

				if ( $title ) :
					?>

					<h3 class="main-text__small-title"><?php echo $title; ?></h3>

					<?php
				endif;
			?>

			<?php if ( $text ) : ?>
				<div class="main-text__text">
					<div class="main-text__text-content"><?php echo $text; ?></div>

					<button class="hidden btn btn--thin btn-show-more main-text__text-btn" type="button">
						<span class="main-text__text-btn-more">Читать далее</span>
						<span class="main-text__text-btn-less">Скрыть</span>
						<svg width="11" height="11"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
					</button>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
