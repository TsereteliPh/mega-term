<section class="discounts">
	<div class="container">
		<?php
			get_template_part( '/layouts/partials/title', null, array(
				'class' => 'discounts__title',
				'title' => get_sub_field( 'title' )
			) );

			$discounts = get_sub_field( 'discounts' );
			if ( $discounts ) :
				?>

				<ul class="reset-list discounts__list">
					<?php
						foreach ( $discounts as $discount ) {
							get_template_part( '/layouts/partials/promos/' . $discount['type'], null, array(
								'class' => 'discounts__item',
								'banner' => $discount['banner'],
							) );
						}
					?>
				</ul>

				<?php
			endif;
		?>
	</div>
</section>
