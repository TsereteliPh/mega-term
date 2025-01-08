<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="account__login">
	<div class="container account__login-container">
		<?php do_action( 'woocommerce_before_customer_login_form' ); //Notices ?>

		<h2 class="account__login-title"><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

		<form class="woocommerce-form woocommerce-form-login account__login-form" method="post">

			<?php do_action( 'woocommerce_login_form_start' ); //Empty ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide shop-field">
				<label class="shop-label" for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text shop-field__input" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide shop-field">
				<label class="shop-label" for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text shop-field__input" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<div class="account__login-box">
				<a class="account__login-lost" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>

				<label class="square-checkbox account__login-rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox square-checkbox__input" name="rememberme" type="checkbox" id="rememberme" value="forever" checked/>
					<span class="square-checkbox__switcher"></span>
					<span class="square-checkbox__text"><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
			</div>

			<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

			<button type="submit" class="btn account__login-submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>

			<?php do_action( 'woocommerce_login_form_end' ); //Empty ?>
		</form>
	</div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
