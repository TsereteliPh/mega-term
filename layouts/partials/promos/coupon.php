<?php
	$banner = $args['banner'];
	$bg_color = $banner['bg_color'] ? 'style="--coupon-banner-color: ' . $banner['bg_color'] . '"' : '';
?>
<li class="coupon-banner <?php echo $args['class']; ?>" <?php echo $bg_color; ?>>
	<div class="coupon-banner__title"><?php echo $banner['title']; ?></div>

	<div class="coupon-banner__text"><?php echo $banner['text']; ?></div>

	<div class="coupon-banner__code">
		<span><?php echo strtoupper( $banner['code'] ); ?></span>

		<button class="btn coupon-banner__button js-copy" type="button">Скопировать промо-код</button>
	</div>

	<div class="coupon-banner__disclaimer"><?php echo $banner['disclaimer']; ?></div>
</li>
