<?php get_header(); ?>

<?php if ( in_category( 22 ) || in_category( 23 ) ) : ?>
	<section class="single-article">
		<div class="container">
			<?php
				$title = array(
					'small-text' => in_category( 22 ) ? 'Новость' : 'Статья',
					'type' => 'h1',
					'text' => get_the_title()
				);

				get_template_part( '/layouts/partials/title', null, array(
					'class' => '',
					'title' => $title
				) );
			?>
		</div>

	</section>
<?php endif; ?>

<?php get_template_part('layouts/partials/blocks'); ?>

<?php get_footer(); ?>
