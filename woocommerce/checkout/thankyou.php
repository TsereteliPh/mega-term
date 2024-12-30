<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="thankyou thankyou--<?php echo $order->status; ?>">
	<div class="container">
		<div class="thankyou__box">
			<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); //Empty ?>

			<?php if ( $order->has_status( 'failed' ) || ! $order ) : ?>
				<h2 class="thankyou__title">Упс, возникла ошибка!</h2>

				<div class="thankyou__message">К сожалению, ваш заказ не был принят по техническим причинам. Обратитесь в службу поддержки для уточнения деталей. Приносим извинения за неудобства.</div>

				<a href="<?php echo wc_get_page_permalink( 'shop' ); ?>" class="btn thankyou__link">Каталог</a>
			<?php else : ?>
				<h2 class="thankyou__title">Спасибо за заказ!</h2>

				<div class="thankyou__message">Ваш заказ будет обработан автоматически, в случае необходимости с вами свяжется наш менеджер для уточнения деталей заказа</div>

				<div class="thankyou__info">
					<div class="thankyou__info-label">Информация о заказе:</div>

					<div class="thankyou__info-content">
						Номер вашего заказа:

						<span><?php echo $order->get_id(); ?></span>
					</div>

					<div class="thankyou__info-content">
						Сумма заказа:

						<span><?php echo $order->total . get_woocommerce_currency_symbol( $order->currency ); ?></span>
					</div>
				</div>

				<a href="<?php echo is_user_logged_in() ? $order->get_view_order_url() : bloginfo( 'url' ); ?>" class="btn thankyou__link">Подробнее</a>
			<?php endif; ?>
		</div>

		<div class="thankyou__footer">
			<div class="thankyou__title">Понравился наш магазин?</div>

			<div class="thankyou__message">Вступайте в наши сообщества и будьте в курсе последних новостей и скидок</div>

			<?php
				$socials = get_field( 'socials', 'options' );
				if ( $socials ) :
					?>

					<div class="thankyou__socials">
						<?php foreach ( $socials as $social ) : ?>
                            <a href="<?php echo $social['link']; ?>" class="thankyou__social" target="_blank">
                                <svg width="32" height="32"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-<?php echo $social['social'];?>"></use></svg>
                            </a>
                        <?php endforeach;?>
					</div>

					<?php
				endif;
			?>
		</div>
	</div>
</section>
