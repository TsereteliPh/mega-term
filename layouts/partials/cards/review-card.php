<?php
	$profile = get_field( 'profile-img' );
	$rating = get_field( 'rating' );
	$date = get_field( 'date' );
	$terms = get_the_terms( $post, 'review-category' );
?>
<li class="main-border review-card <?php echo $args['class']; ?>">
	<?php if ( $args['cat'] ) : ?>
		<div class="review-card__cat"><?php echo $terms[0]->name; ?></div>
	<?php endif; ?>

	<div class="review-card__info">
		<div class="review-card__info-profile">
			<?php echo wp_get_attachment_image( $profile ? $profile : 23, 'thumbnail', false ); ?>
		</div>

		<div class="review-card__info-rating">
			<?php for ( $i = 0; $i < 5; $i++ ) : ?>
				<svg class="review-card__info-star<?php echo $i < $rating ? ' review-card__info-star--colored' : ''; ?>" width="12" height="12"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-star"></use></svg>
			<?php endfor; ?>
		</div>

		<div class="review-card__info-title"><?php the_title(); ?></div>

		<?php if ( $date ) : ?>
			<div class="review-card__info-date"><?php echo $date; ?></div>
		<?php endif; ?>
	</div>

	<?php if ( has_term( 20, 'review-category' ) ) : ?>
		<?php
			$text = get_field( 'text' );
			if ( $text ) :
				?>

				<?php if ( mb_strlen( $text, 'utf-8' ) > 250 ) : ?>
					<div class="review-card__text"><?php echo mb_substr( $text, 0, 250 ) . '...'; ?></div>

					<button class="review-card__link" type="button" data-fancybox data-src="#review-text-<?php the_ID(); ?>">Читать далее</button>

					<div class="review-card__modal" id="review-text-<?php the_ID(); ?>">
						<div class="review-card__modal-text"><?php echo $text; ?></div>
					</div>
				<?php else : ?>
					<div class="review-card__text"><?php echo $text; ?></div>
				<?php endif; ?>

				<?php
			endif;
		?>
	<?php endif; ?>

	<?php if ( has_term( 21, 'review-category' ) ) : ?>
		<?php
			$photo = get_field( 'photo' );
			if ( $photo ) :
				?>

				<a href="<?php echo $photo['url']; ?>" class="review-card__letter" data-fancybox="review-letter-<?php the_ID(); ?>">
					<?php echo wp_get_attachment_image( $photo['id'], 'large', false ); ?>
				</a>

				<?php
			endif;
		?>
	<?php endif; ?>
</li>
