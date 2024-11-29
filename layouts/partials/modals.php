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
