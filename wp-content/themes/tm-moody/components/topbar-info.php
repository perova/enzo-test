<?php
$topbar_info = Insight::setting( 'topbar_info_list' );

if ( $topbar_info && ! empty( $topbar_info ) ) {
	?>
	<ul class="top-bar-info">
		<?php
		foreach ( $topbar_info as $info ) {
			$url  = isset( $info['link_url'] ) ? $info['link_url'] : '';
			$icon = isset( $info['icon_class'] ) ? $info['icon_class'] : '';
			$text = isset( $info['text'] ) ? $info['text'] : '';
			?>
			<li class="info-item">
				<?php if ( $url !== '' ) : ?>
				<a href="<?php echo esc_url( $url ); ?>" class="info-link">
					<?php endif; ?>

					<?php if ( $icon !== '' ) : ?>
						<i class="info-icon fa <?php echo esc_attr( $icon ); ?>"></i>
					<?php endif; ?>

					<?php echo esc_html( $text ); ?>

					<?php if ( $url !== '' ) : ?>
				</a>
			<?php endif; ?>
			</li>
		<?php } ?>
	</ul>
	<?php
}
