<?php
	$title = get_sub_field( 'title' );
	$bg = get_sub_field( 'bg' );
	$text = get_sub_field( 'text' );
	$achievements = get_sub_field( 'achievements' );
	$bigLink = get_sub_field( 'big-link' );
	$link = get_sub_field( 'link' );
?>
<section class="about">
	<div class="container about__container"<?php echo $bg ? ' style="background-image: url(' . $bg . ');"' : ''; ?>>
		<div class="about__content">
			<?php
				echo sprintf( '<%1$s class="about__title">%2$s</%1$s>',
					$title['type'],
					$title['text']
				);
			?>

			<?php if ( $text ) : ?>
				<div class="about__text"><?php echo $text; ?></div>
			<?php endif; ?>

			<?php if ( $achievements ) : ?>
				<ul class="reset-list about__list">
					<?php foreach ( $achievements as $achievement ) : ?>
                        <li class="about__item">
							<span><?php echo $achievement['number']; ?></span>

							<?php echo $achievement['text']; ?>
						</li>
                    <?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<div class="about__extra">
			<svg class="about__logo" width="225" height="108"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-logo"></use></svg>

			<?php if ( $bigLink ) : ?>
				<a href="<?php echo $bigLink['url']; ?>" class="btn btn--thin about__link about__link--big" target="<?php echo $bigLink['target']; ?>">
					<?php echo $bigLink['title']; ?>

					<svg width="19" height="19"><use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#icon-arrow-small"></use></svg>
				</a>
			<?php endif; ?>

			<?php if ( $link ) : ?>
				<a href="<?php echo $link['url']; ?>" class="btn btn--thin about__link" target="<?php echo $link['target']; ?>">
					<?php echo $link['title']; ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</section>
