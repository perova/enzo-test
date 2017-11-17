<?php
$topbar_enable = Insight_Helper::get_post_meta( 'top_bar_enable', '2' );
if ( $topbar_enable === '2' ) {
	$topbar_enable = Insight::setting( 'topbar_enable' );
}
?>
<?php if ( $topbar_enable === '1' ) {
	$columns               = Insight::setting( 'topbar_columns' );
	$top_bar_left_element  = Insight::setting( 'topbar_left_element' );
	$top_bar_right_element = Insight::setting( 'topbar_right_element' );
	?>
	<div class="page-top-bar">
		<div class="container">
			<div class="row">
				<?php if ( $columns === '1' ) { ?>
					<div class="col-md-12 col-xs-center">
						<?php if ( ! in_array( $top_bar_left_element, array( 'none' ) ) ) : ?>
							<?php get_template_part( 'components/topbar', $top_bar_left_element ); ?>
						<?php endif; ?>
						<?php if ( $top_bar_left_element === 'widget' ) : ?>
							<?php get_template_part( 'components/topbar', $top_bar_left_element ); ?>
							<?php Insight_Templates::generated_sidebar( 'top_bar_widget_01' ); ?>
						<?php endif; ?>
					</div>
				<?php } elseif ( $columns === '2' ) { ?>
					<div class="col-md-6">
						<div class="top-bar-wrap top-bar-left">
							<?php if ( ! in_array( $top_bar_left_element, array( 'none' ) ) ) : ?>
								<?php get_template_part( 'components/topbar', $top_bar_left_element ); ?>
							<?php endif; ?>
							<?php if ( $top_bar_left_element === 'widget' ) : ?>
								<?php get_template_part( 'components/topbar', $top_bar_left_element ); ?>
								<?php Insight_Templates::generated_sidebar( 'top_bar_widget_01' ); ?>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-md-6 top-bar-right">
						<div class="top-bar-wrap top-bar-right">
							<?php if ( ! in_array( $top_bar_right_element, array( 'none' ) ) ) : ?>
								<?php get_template_part( 'components/topbar', $top_bar_right_element ); ?>
							<?php endif; ?>
							<?php if ( $top_bar_left_element === 'widget' ) : ?>
								<?php get_template_part( 'components/topbar', $top_bar_left_element ); ?>
								<?php Insight_Templates::generated_sidebar( 'top_bar_widget_02' ); ?>
							<?php endif; ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
