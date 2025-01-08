<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

	defined( 'ABSPATH' ) || exit;
?>

<div class="account__login">
	<div class="container account__login-container">
		<?php do_action( 'woocommerce_before_lost_password_form' ); //Notices ?>

		<form method="post" class="account__login-form">
			<div class="account__login-text">Забыли свой пароль? Укажите ваш email. Ссылку на создание нового пароля вы получите на электронную почту.</div><?php // @codingStandardsIgnoreLine ?>

			<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first shop-field">
				<label class="shop-label" for="user_login">Email</label>
				<input class="woocommerce-Input woocommerce-Input--text shop-field__input" type="email" name="user_login" id="user_login"/>
			</p>

			<?php do_action( 'woocommerce_lostpassword_form' ); //Empty ?>

			<input type="hidden" name="wc_reset_password" value="true" />

			<button type="submit" class="btn account__login-submit <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>

			<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
		</form>

		<?php do_action( 'woocommerce_after_lost_password_form' ); //Empty ?>
	</div>
</div>
