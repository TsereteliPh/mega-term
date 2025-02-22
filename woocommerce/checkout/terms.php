<?php
/**
 * Checkout terms and conditions area.
 *
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) :
?>

	<div class="check__terms">
		<?php do_action( 'woocommerce_checkout_before_terms_and_conditions' ); //Empty ?>

		Подтверждая заказ, вы соглашаетесь на использование ваших персональных данных в соответствии с нашей <a href="<?php echo get_privacy_policy_url(); ?>">политикой&nbsp;конфиденциальности</a>.

		<?php
			/**
			 * Terms and conditions hook used to inject content.
			 *
			 * @since 3.4.0.
			 * //@hooked wc_checkout_privacy_policy_text() Shows custom privacy policy text. Priority 20.
			 * //@hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
			 */
			do_action( 'woocommerce_checkout_terms_and_conditions' );
		?>
	</div>

	<?php

	do_action( 'woocommerce_checkout_after_terms_and_conditions' ); //Empty
endif;
