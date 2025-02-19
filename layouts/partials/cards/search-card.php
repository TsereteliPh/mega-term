
<a href="<?php echo esc_url( get_permalink() ); ?>" class="search-panel__link" aria-selected="false">
	<div class="search-panel__thumb">
		<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'medium' );
			} else {
				echo wp_get_attachment_image( 24, 'medium', false );
			}
		?>
	</div>

	<?php the_title(); ?>
</a>
