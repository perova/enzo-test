<?php
$header_button_text        = Insight::setting( 'header_button_text' );
$header_button_link        = Insight::setting( 'header_button_link' );
$header_button_link_target = Insight::setting( 'header_button_link_target' );
?>
<?php if ( $header_button_link !== '' && $header_button_text !== '' ) : ?>
	<div class="header-button">
		<a class="tm-button style-flat tm-button-primary tm-button-sm"
		   href="<?php echo esc_url( $header_button_link ); ?>"
			<?php if ( $header_button_link_target === '1' ) : ?>
				target="_blank"
			<?php endif; ?>
		>
			<?php echo esc_html( $header_button_text ); ?>
		</a>
	</div>
<?php endif; ?>
