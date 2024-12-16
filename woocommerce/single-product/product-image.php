<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$gallery = $product->get_gallery_image_ids();
$variations = false;
if ( $product->is_type('variable' ) ) $variations = $product->get_available_variations();
?>

<div class="product__gallery">
	<div class="product__gallery-thumb">
		<div class="product__gallery-thumb-swiper swiper">
			<div class="product__gallery-thumb-wrapper swiper-wrapper">
				<?php if ( has_post_thumbnail( $product->get_id() ) ) : ?>
					<div class="product__gallery-thumb-img swiper-slide">
						<?php the_post_thumbnail( 'medium' ); ?>
					</div>
				<?php else : ?>
					<div class="product__gallery-thumb-img swiper-slide">
						<?php echo wp_get_attachment_image( 24, 'medium', false ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $gallery ) : ?>
					<?php foreach ( $gallery as $img ) : ?>
						<div class="product__gallery-thumb-img swiper-slide">
							<?php echo wp_get_attachment_image( $img, 'medium', false ); ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>

				<?php if ( $variations ) : ?>
					<?php foreach ( $variations as $variation ) : ?>
						<?php if ( $variation['image_id'] && ( get_post_thumbnail_id( $product->get_id() ) != $variation['image_id'] ) ) : ?>
							<div class="product__gallery-thumb-img swiper-slide" data-id="<?php echo $variation['variation_id']; ?>">
								<?php echo wp_get_attachment_image( $variation['image_id'], 'medium', false ); ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

		<?php get_template_part( '/layouts/partials/controls', null, array(
			'class' => 'product__gallery-thumb-controls',
		) ); ?>
	</div>


	<div class="product__gallery-big swiper">
		<div class="product__gallery-big-wrapper swiper-wrapper">
			<?php
				$thumb = get_the_post_thumbnail_url( $product->get_id(), 'full' );
				if ( $thumb ) :
			?>
				<a href="<?php the_post_thumbnail_url( $product->get_id(), 'full' ); ?>" class="product__gallery-big-link swiper-slide" data-fancybox="product-gallery">
					<?php the_post_thumbnail( 'large', array(
						'class' => 'product__gallery-big-image'
					) ); ?>
				</a>
			<?php else : ?>
				<div class="product__gallery-big-link swiper-slide">
					<?php echo wp_get_attachment_image( 24, 'large', false, array(
						'class' => 'product__gallery-big-image'
					) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $gallery ) : ?>
				<?php foreach ( $gallery as $img ) : ?>
					<a href="<?php echo wp_get_attachment_image_url( $img, 'full', false ); ?>" class="product__gallery-big-link swiper-slide" data-fancybox="product-gallery">
						<?php echo wp_get_attachment_image( $img, 'large', false, array(
							'class' => 'product__gallery-big-image'
						) ); ?>
					</a>
				<?php endforeach; ?>
			<?php endif; ?>

			<?php if ( $variations ) : ?>
				<?php foreach ( $variations as $variation ) : ?>
					<?php if ( $variation['image_id'] && ( get_post_thumbnail_id( $product->get_id() ) != $variation['image_id'] ) ) : ?>
						<a href="<?php echo wp_get_attachment_image_url( $variation['image_id'], 'full', false ); ?>" class="product__gallery-big-link swiper-slide" data-fancybox="product-gallery">
							<?php echo wp_get_attachment_image( $variation['image_id'], 'large', false, array(
								'class' => 'product__gallery-big-image'
							) ); ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_product_thumbnails' ); // Disabled ?>
</div>
