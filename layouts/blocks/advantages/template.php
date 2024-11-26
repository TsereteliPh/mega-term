<section class="advantages">
	<div class="container">
		<?php get_template_part( '/layouts/partials/title', null, array(
			'class' => 'advantages__title',
			'title' => get_sub_field( 'title' )
		) ); ?>

		<?php
			$advantages = get_sub_field( 'advantages' );
			if ( $advantages ) :
				?>

				<ul class="reset-list advantages__list">
					<?php foreach ( $advantages as $advantage ) : ?>
						<li class="advantages__item">
							<div class="advantages__icon">
								<?php echo wp_get_attachment_image( $advantage['icon'], 'thumbnail', false ); ?>
							</div>

							<div class="advantages__label"><?php echo $advantage['title']; ?></div>

							<div class="advantages__text"><?php echo $advantage['text']; ?></div>
						</li>
					<?php endforeach; ?>
				</ul>

				<?php
			endif;
		?>
	</div>
</section>
