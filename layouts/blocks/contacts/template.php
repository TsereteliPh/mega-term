<?php
	$img = get_sub_field( 'img' );
	$contacts = get_field( 'contacts', 'options' );
	$offices = $contacts['officies'];
	$socials = get_field( 'socials', 'options' );
	$map = $contacts['map'];
?>
<section class="contacts">
	<div class="container">
		<?php get_template_part( '/layouts/partials/title', null, array(
			'class' => 'contacts__title',
			'title' => get_sub_field( 'title' )
		) ); ?>

		<?php if ( $img ) : ?>
			<div class="contacts__img"><?php echo wp_get_attachment_image( $img, 'full', false ); ?></div>
		<?php endif; ?>

		<?php if ( $offices ) : ?>
			<ul class="reset-list contacts__list">
				<?php foreach ( $offices as $office ) : ?>
                    <li class="contacts__item">
						<div class="contacts__item-label"><?php echo $office['label']; ?></div>

						<?php if ( $office['tel'] ) : ?>
							<a href="tel:<?php echo preg_replace( '/[^0-9,+]/', '', $office['tel'] ); ?>" class="contacts__item-tel"><?php echo $office['tel']; ?></a>
						<?php endif; ?>

						<button class="contacts__item-callback" type="button" data-fancybox data-src="#callback">Обратный звонок</button>

						<?php if ( $office['email'] ) : ?>
							<a href="mailto:<?php echo $office['email']; ?>" class="contacts__item-email">
								<svg width="23" height="17"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-email"></use></svg>
								<?php echo $office['email']; ?>
							</a>
						<?php endif; ?>

						<?php if ( $office['socials'] && $socials ) : ?>
							<div class="contacts__item-socials">
								<?php foreach ( $socials as $social ) : ?>
									<a href="<?php echo $social['link']; ?>" class="contacts__social" target="_blank">
										<svg width="32" height="32"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-<?php echo $social['social'];?>"></use></svg>
									</a>
								<?php endforeach;?>
							</div>
						<?php endif; ?>

						<?php if ( $office['working_hours'] ) : ?>
							<div class="contacts__item-hours">
								Контактный-центр:
								<span><?php echo $office['working_hours']; ?></span>
							</div>
						<?php endif; ?>

						<?php if ( $office['address'] ) : ?>
							<address class="contacts__item-address"><?php echo $office['address']; ?></address>
						<?php endif; ?>
                    </li>
                <?php endforeach;?>
			</ul>
		<?php endif; ?>
	</div>

	<?php if ( $map ) : ?>
		<div class="contacts__map" id="map"></div>
	<?php endif; ?>
</section>

<?php if ( $map ) : ?>
	<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function (e) {
			function init(){
				<?php $map = json_decode( $map, true ); ?>
				const map = new ymaps.Map('map', {
					center: [<?php echo $map['center_lat'] ?>,<?php echo $map['center_lng'] ?>],
					zoom: <?php echo $map['zoom']; ?>
				});

				<?php foreach ( $map['marks'] as $mark ) : ?>
					map.geoObjects.add(
						new ymaps.Placemark([<?php echo $mark['coords'][0]; ?>, <?php echo $mark['coords'][1]; ?>], {
								balloonContent: '<?php echo $mark['content']; ?>'
							},
							{
								iconLayout: 'default#image',
								iconImageHref: '<?php echo get_template_directory_uri(); ?>/assets/images/icon-marker.svg',
								iconImageSize: [63, 63],
								iconImageOffset: [-30, -63]
							})
					);
				<?php endforeach; ?>

				map.controls.remove('geolocationControl'); // удаляем геолокацию
				map.controls.remove('searchControl'); // удаляем поиск
				map.controls.remove('trafficControl'); // удаляем контроль трафика
				map.controls.remove('typeSelector'); // удаляем тип
				map.controls.remove('fullscreenControl'); // удаляем кнопку перехода в полноэкранный режим
				// map.controls.remove('zoomControl'); // удаляем контрол зуммирования
				map.controls.remove('rulerControl'); // удаляем контрол правил
				map.behaviors.disable(['scrollZoom']); // отключаем скролл карты (опционально)
			}

			ymaps.ready(init);
		});
	</script>
<?php endif; ?>
