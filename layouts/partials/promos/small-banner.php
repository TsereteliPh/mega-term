<?php
	$banner = $args['banner'];
	$background = $banner['img'] ? 'style="background-image: url(' . $banner['img'] . ');"' : '';
?>
<li class="small-banner <?php echo $args['class']; ?>" <?php echo $background; ?>>
	<a href="<?php echo $banner['link']['url']; ?>" class="btn small-banner__link" target="<?php echo $banner['link']['target']; ?>">
		<?php echo $banner['link']['title']; ?>
		<svg width="11" height="11"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
	</a>
</li>
