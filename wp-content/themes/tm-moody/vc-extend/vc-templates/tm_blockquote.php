<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$style = $el_class = $skin = $heading = $text = '';
$atts  = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class  = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'tm-blockquote ' . $el_class, $this->settings['base'], $atts );

$css_class .= " skin-$skin";

?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>">
	<?php

	if ( $text !== '' ) { ?>
		<blockquote>
			<?php if ( $style === '2' ) : ?>
				<?php echo Insight_Helper::get_file_contents( INSIGHT_THEME_DIR . '/assets/images/blockquote.svg' ); ?>
			<?php endif; ?>
			<?php if ( $heading !== '' ) { ?>
				<h6 class="heading"><?php echo esc_html( $heading ); ?></h6>
			<?php } ?>
			<?php echo esc_html( $text ); ?>
		</blockquote>
	<?php } ?>
</div>
