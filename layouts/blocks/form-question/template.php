<?php
	$title = get_sub_field( 'title' );
	$text = get_sub_field( 'text' );
?>
<section class="form-question no-margin">
	<div class="container form-question__container">
		<div class="form-question__content">
			<?php
				if ( $title ) {
					echo sprintf(
						'<%1$s class="form-question__title">%2$s</%1$s>',
						$title['type'],
						$title['text']
					);
				}
			?>

			<?php if ( $text ) : ?>
				<div class="form-question__text"><?php echo $text; ?></div>
			<?php endif; ?>

			<form method="POST" class="form-question__form" name="Вопрос">
				<input type="text" class="input form-question__input" name="client_name" placeholder="ФИО" required>

				<input type="email" class="input form-question__input" name="client_email" placeholder="E - mail" required>

				<textarea class="input form-question__textarea" name="client_message" placeholder="Текст сообщения" required></textarea>

				<label class="checkbox form-question__policy">
					<input type="checkbox" name="policy" class="checkbox__input" required checked>
					<span class="checkbox__switcher"></span>
					<span class="checkbox__text">Даю согласие на обработку моих персональных данных в соответствии с <a href="<?php echo get_privacy_policy_url(); ?>">Политикой конфиденциальности</a></span>
				</label>

				<button class="btn btn--thic form-question__submit" type="submit">
					Отправить<br>
					запрос

					<svg width="8" height="8"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
				</button>

				<input type="text" class="hidden" name="page_request" value="<?php echo is_archive() ? get_the_archive_title() : get_the_title(); ?>">

				<?php wp_nonce_field( 'Вопрос', 'form-question-nonce' ); ?>
			</form>
		</div>

		<div class="form-question__img">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/form-question-img.jpg" alt="Изображение сантехнических инструментов" width="585" height="585">
		</div>
	</div>
</section>
