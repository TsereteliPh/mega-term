<li class="main-border main-border--half main-border--hover article-card <?php echo $args['class']; ?>">
	<div class="article-card__img">
		<?php
			if ( get_post_thumbnail_id() ) {
				the_post_thumbnail( 'large' );
			} else {
				echo wp_get_attachment_image( 24, 'large', false );
			}
		?>
	</div>

	<div class="article-card__content">
		<a href="<?php the_permalink(); ?>" class="article-card__link"><?php the_title(); ?></a>

		<?php
			$tags = get_the_tags();
			if ( $tags ) :
				?>

				<ul class="reset-list article-card__tags">
					<?php foreach ( $tags as $tag ) : ?>
						<li class="article-card__tag">
							<a href="<?php echo get_tag_link( $tag->term_id ); ?>" class="article-card__tag-link"><?php echo '#' . $tag->name; ?></a>
						</li>
					<?php endforeach; ?>
				</ul>

				<?php
			endif;
		?>

		<?php if ( in_category( 23 ) ) : ?>
			<div class="article-card__date">
				<svg width="14" height="14"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-calendar"></use></svg>
				<?php echo get_the_date( 'd.m.Y' ); ?>
			</div>
		<?php endif; ?>
	</div>
</li>
