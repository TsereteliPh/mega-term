<?php
	$privacy_url = get_privacy_policy_url();

	if ( is_archive() ) {
		$page_title = get_the_archive_title();
	} else {
		$page_title = get_the_title();
	}
?>

<div class="modal modal--success" id="success">
	<div class="modal__info">
		<div class="modal__title">Спасибо!</div>

		<div class="modal__text">Мы получили вашу заявку и успешно её обработали! Наши специалисты свяжутся с вами в ближайшее время.</div>
	</div>
</div>

<div class="modal modal--failure" id="failure">
	<div class="modal__info">
		<div class="modal__title">Ошибка!</div>

		<div class="modal__text">Пожалуйста, попробуйте снова. Если проблема повторится, обратитесь в поддержку.</div>
	</div>
</div>

<div class="modal modal--callback" id="callback">
	<div class="modal__info">
		<div class="modal__title">Заказать обратный звонок</div>
	</div>

	<form method="POST" class="modal__form" name="Звонок">
		<input type="text" class="input modal__input" name="client_name" placeholder="ФИО" required>

		<input type="tel" class="input modal__input" name="client_tel" placeholder="+7 ( ___ ) - ___ - __ - __" required>

		<label class="square-checkbox modal__policy">
			<input type="checkbox" class="hidden square-checkbox__input" checked required>

			<span class="square-checkbox__switcher"></span>

			<span class="square-checkbox__text">Отправляя форму, вы даете согласие на обработку персональных данных, указанных вами в заявке, в соответствии с требованиями Федерального закона № 152-ФЗ от 27.07.2006 “О персональных данных”.</span>
		</label>

		<button class="btn modal__submit" type="submit">Отправить запрос</button>

		<?php wp_nonce_field( 'Звонок', 'modal-callback-nonce' ); ?>
	</form>
</div>

<div class="modal modal--question" id="question">
	<div class="modal__info">
		<div class="modal__title">Задать вопрос</div>
	</div>

	<form method="POST" class="modal__form" name="Вопрос">
		<input type="text" class="input modal__input" name="client_name" placeholder="ФИО" required>

		<input type="email" class="input modal__input" name="client_email" placeholder="Email" required>

		<textarea class="input modal__textarea" name="client_message" placeholder="Ваш вопрос" required></textarea>

		<label class="square-checkbox modal__policy">
			<input type="checkbox" class="hidden square-checkbox__input" checked required>

			<span class="square-checkbox__switcher"></span>

			<span class="square-checkbox__text">Отправляя форму, вы даете согласие на обработку персональных данных, указанных вами в заявке, в соответствии с требованиями Федерального закона № 152-ФЗ от 27.07.2006 “О персональных данных”.</span>
		</label>

		<button class="btn modal__submit" type="submit">Отправить вопрос</button>

		<?php wp_nonce_field( 'Вопрос', 'modal-question-nonce' ); ?>
	</form>
</div>

<?php if ( ! is_user_logged_in() ) : ?>
	<div class="modal modal--login" id="login">
		<div class="modal__info">
			<div class="modal__title">Вход</div>
		</div>

		<form method="POST" class="modal__form" id="form-login" name="login">
			<div class="modal__form-error js-error"></div>

			<input type="text" class="input modal__input" id="login-username" name="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" autocomplete="username" placeholder="Email" required>

			<input type="password" class="input modal__input" id="login-password" name="password" autocomplete="current-password" placeholder="Введите пароль" required>

			<label class="square-checkbox modal__rememberme">
				<input type="checkbox" class="hidden square-checkbox__input" name="rememberme" checked>

				<span class="square-checkbox__switcher"></span>

				<span class="square-checkbox__text">Оставаться в системе</span>
			</label>

			<label class="square-checkbox modal__policy">
				<input type="checkbox" class="hidden square-checkbox__input" checked required>

				<span class="square-checkbox__switcher"></span>

				<span class="square-checkbox__text">Отправляя форму, вы даете согласие на обработку персональных данных, указанных вами в заявке, в соответствии с требованиями Федерального закона № 152-ФЗ от 27.07.2006 “О персональных данных”.</span>
			</label>

			<button type="submit" class="btn modal__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">Войти в личный кабинет</button>

			<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="modal__lost">Забыли пароль?</a>

			<?php wp_nonce_field( 'login', 'login-nonce' ); ?>
		</form>
	</div>

	<div class="modal modal--registration" id="registration">
		<div class="modal__info">
			<div class="modal__title">Регистрация</div>
		</div>

		<form method="POST" class="modal__form" id="form-registration" name="registration" autocomplete="off">
			<div class="modal__form-error js-error"></div>

			<input type="text" class="input modal__input" id="registration-first-name" name="first-name" placeholder="Имя" required>

			<input type="text" class="input modal__input" id="registration-last-name" name="last-name" placeholder="Фамилия" required>

			<input type="email" class="input modal__input" id="registration-username" name="username" placeholder="Email" required>

			<input type="tel" class="input modal__input" id="registration-phone" name="phone" placeholder="+7 ( ___ ) - ___ - __ - __" required>

			<input type="password" class="input modal__input" id="registration-password" name="password" placeholder="Создайте пароль" required>

			<input type="password" class="input modal__input" id="registration-confirm-password" name="confirm-password" placeholder="Повторите пароль" required>

			<label class="square-checkbox modal__policy">
				<input type="checkbox" class="hidden square-checkbox__input" checked required>

				<span class="square-checkbox__switcher"></span>

				<span class="square-checkbox__text">Отправляя форму, вы даете согласие на обработку персональных данных, указанных вами в заявке, в соответствии с требованиями Федерального закона № 152-ФЗ от 27.07.2006 “О персональных данных”.</span>
			</label>

			<button type="submit" class="btn modal__submit" name="registration" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>">Зарегистрироваться</button>

			<?php wp_nonce_field( 'registration', 'modal-registration-nonce' ); ?>
		</form>
	</div>
<?php endif; ?>
