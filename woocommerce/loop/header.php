<?php
/**
 * Product taxonomy archive header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$currentTerm = get_queried_object();

?>
<div class="catalog__header">
	<div class="container">
		<?php
			get_template_part( '/layouts/partials/title', null, array(
				'class' => 'catalog__title',
				'title' => array(
					'type' => 'h1',
					'small-text' => is_shop() ? false : 'Категория',
					'text' => is_shop() ? 'Каталог' : $currentTerm->name
				)
			) );
		?>
	</div>

	<?php
		if ( is_shop() ) {
			$term_list = get_terms( [
				'taxonomy' => 'product_cat',
				'parent' => 0,
				'hide_empty' => false, //? Display empty cats
				'exclude' => 15 // Misc cat
			] );
		} else {
			$term_list = get_terms( [
				'taxonomy' => 'product_cat',
				'parent' => $currentTerm->term_id,
				'hide_empty' => false, //? Display empty cats
				'exclude' => 15 // Misc cat
			] );
		}
	?>

	<?php if ( $term_list ) : ?>
		<div class="container--slider catalog__cats">
			<div class="catalog__cats-swiper swiper">
				<ul class="reset-list catalog__cats-wrapper swiper-wrapper">
					<?php foreach ( $term_list as $term ) : ?>
						<li class="catalog__cats-item swiper-slide">
							<div class="catalog__cats-item-title"><?php echo $term->name; ?></div>

							<div class="catalog__cats-item-info">
								<?php
									$term_children = get_terms( [
										'taxonomy' => 'product_cat',
										'parent' => $term->term_id,
									] );
									$count_children = count( $term_children );

									if ( $count_children ) {
										category_ending( $count_children );
									} else {
										product_ending( $term->count );
									}
								?>
							</div>

							<div class="catalog__cats-item-img">
								<?php
									$thumb = get_term_meta( $term->term_id, 'thumbnail_id' );
									if ( $thumb ) {
										echo wp_get_attachment_image( $thumb[0], 'medium', false );
									}
								?>
							</div>

							<a href="<?php echo get_term_link( $term ); ?>" class="btn-accordion catalog__cats-item-link">
								<svg width="9" height="5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-caret"></use></svg>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>

				<div class="pagination catalog__cats-pagination"></div>
			</div>

			<?php get_template_part( '/layouts/partials/controls', null, array(
				'class' => 'catalog__cats-controls',
			) ); ?>
		</div>
	<?php endif; ?>

	<?php
		/**
		 * Hook: woocommerce_archive_description.
		 *
		 * @since 1.6.2.
		 * //@hooked woocommerce_taxonomy_archive_description - 10
		 * //@hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
	?>
</div>
