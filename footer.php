</main>

<?php
	$slogan = get_field( 'slogan', 'options' );
	$mailing_text = get_field( 'footer_mailing', 'options' );
	$opening_hours = get_field( 'opening_hours', 'options' );
	$tel = get_field( 'tel', 'options' );
	$email = get_field( 'email', 'options' );
	$socials = get_field( 'socials', 'options' );
	$payment_cards = get_field( 'payment_cards', 'options' );
	$menus = array();
	if ( is_nav_menu( 17 ) ) {
		$menus[] = array(
			'id' => 'cats_menu',
			'title' => wp_get_nav_menu_name( 'cats_menu' )
		);
	}
	if ( is_nav_menu( 18 ) ) {
		$menus[] = array(
			'id' => 'about_menu',
			'title' => wp_get_nav_menu_name( 'about_menu' )
		);
	}
	if ( is_nav_menu( 19 ) ) {
		$menus[] = array(
			'id' => 'clients_menu',
			'title' => wp_get_nav_menu_name( 'clients_menu' )
		);
	}
?>
<footer class="footer">
	<div class="container footer__container">
		<div class="footer__box">
			<div class="footer__brand">
				<a href="<?php echo bloginfo( 'url' ); ?>" class="footer__brand-logo" aria-label="На главную">
					<svg width="225" height="108"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-logo"></use></svg>
				</a>

				<?php if ( $slogan ) : ?>
					<div class="footer__brand-text"><?php echo $slogan; ?></div>
				<?php endif; ?>
			</div>

			<div class="footer__mailing">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-mailing.jpg" class="footer__mailing-img" alt="Иконка письма" width="127" height="115">

				<?php if ( $mailing_text ) : ?>
					<div class="footer__mailing-text"><?php echo $mailing_text; ?></div>
				<?php endif; ?>

				<form method="POST" class="footer__mailing-form" name="Рассылка">
					<input type="email" class="input footer__mailing-input" name="client_email" placeholder="E-mail" required>

					<input type="text" name="page_request" class="hidden" value="<?php echo is_archive() ? get_the_archive_title() : get_the_title(); ?>">

                    <button type="submit" class="btn footer__mailing-submit" aria-label="Подписаться">
						<span>Подписаться</span>
						<svg width="12" height="12"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
					</button>

					<?php wp_nonce_field( 'Рассылка', 'form-mailing-nonce' ); ?>
				</form>
			</div>
		</div>

		<div class="footer__content">
			<div class="footer__menus">
				<ul class="reset-list footer__tabs js-tabs">
					<?php foreach ( $menus as $key => $menu ) : ?>
						<li class="btn footer__tab<?php echo $key === 0 ? ' active' : ''; ?>" data-tab="<?php echo $menu['id']; ?>"><?php echo $menu['title']; ?></li>
					<?php endforeach; ?>
				</ul>

				<?php foreach ( $menus as $key => $menu ) : ?>
					<div class="footer__content-wrapper<?php echo $key === 0 ? ' active' : ''; ?>" id="<?php echo $menu['id']; ?>">
						<div class="footer__content-label footer__content-menu-label"><?php echo $menu['title']; ?></div>

						<?php wp_nav_menu( array(
							'theme_location' => $menu['id'],
							'container' => '',
							'menu_id' => 'footer_' . $menu['id'],
							'menu_class' => 'reset-list footer__menu'
						) ); ?>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $opening_hours ) : ?>
				<div class="footer__content-wrapper">
					<div class="footer__content-label">Время работы</div>

					<?php foreach ( $opening_hours as $department ) : ?>
						<div class="footer__content-department">
							<div class="footer__content-department-label"><?php echo $department['department']; ?></div>

							<div class="footer__content-department-text"><?php echo $department['content']; ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="footer__content-wrapper">
				<div class="footer__content-label">Обратная связь</div>

				<?php if ( $tel ) : ?>
					<div class="footer__content-phones">
						<a href="tel:<?php echo preg_replace( '/[^0-9,+]/', '', $tel ); ?>" class="footer__content-tel"><?php echo $tel; ?></a>

						<button class="footer__content-callback" type="button" data-fancybox data-src="#callback">Обратный звонок</button>
					</div>
				<?php endif; ?>

				<?php if ( $email ) : ?>
					<a href="mailto:<?php echo $email; ?>" class="footer__email">
						<svg width="23" height="17"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-email"></use></svg>
						<?php echo $email; ?>
					</a>
				<?php endif; ?>

				<?php if ( $socials ) : ?>
					<div class="footer__socials">
						<?php foreach ( $socials as $social ) : ?>
                            <a href="<?php echo $social['link']; ?>" class="footer__social" target="_blank">
                                <svg width="32" height="32"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-<?php echo $social['social'];?>"></use></svg>
                            </a>
                        <?php endforeach;?>
					</div>
				<?php endif; ?>

				<?php if ( $payment_cards ) : ?>
					<div class="footer__content-payment">
						<?php echo wp_get_attachment_image( $payment_cards, 'large', false ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="footer__info">
			<div class="footer__info-copyright">
				2016-<?php echo date( 'Y' ); ?>
				© Aqua-profi.ru интернет-магазин инженерной сантехники
			</div>

			<a href="<?php echo get_privacy_policy_url(); ?>" class="footer__info-policy">Политика конфиденциальности</a>
		</div>
	</div>
</footer>

<?php get_template_part('layouts/partials/modals'); ?>

<?php wp_footer(); ?>

</body>
</html>
