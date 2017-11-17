<?php

$styling_tab = esc_html__( 'Styling', 'tm-moody' );
$spacing_tab = esc_html__( 'Design Options', 'tm-moody' );

vc_remove_param( 'vc_column_inner', 'css' );

vc_add_params( 'vc_column_inner', array(
	array(
		'group'        => $spacing_tab,
		'heading'      => esc_html__( 'Large Device Spacing', 'tm-moody' ),
		'type'         => 'spacing',
		'param_name'   => 'lg_spacing',
		'spacing_icon' => 'fa-desktop',
	),
	array(
		'group'        => $spacing_tab,
		'heading'      => esc_html__( 'Medium Device Spacing', 'tm-moody' ),
		'type'         => 'spacing',
		'param_name'   => 'md_spacing',
		'spacing_icon' => 'fa-tablet fa-rotate-270',
	),
	array(
		'group'        => $spacing_tab,
		'heading'      => esc_html__( 'Small Device Spacing', 'tm-moody' ),
		'type'         => 'spacing',
		'param_name'   => 'sm_spacing',
		'spacing_icon' => 'fa-tablet',
	),
	array(
		'group'        => $spacing_tab,
		'heading'      => esc_html__( 'Extra Small Spacing', 'tm-moody' ),
		'type'         => 'spacing',
		'param_name'   => 'xs_spacing',
		'spacing_icon' => 'fa-mobile',
	),
	array(
		'group'      => $styling_tab,
		'heading'    => esc_html__( 'Border Color', 'tm-moody' ),
		'type'       => 'dropdown',
		'param_name' => 'border_color',
		'value'      => array(
			esc_html__( 'Primary Color', 'tm-moody' ) => 'primary',
			esc_html__( 'Custom Color', 'tm-moody' )  => 'custom',
		),
		'std'        => 'custom',
	),
	array(
		'group'      => $styling_tab,
		'heading'    => esc_html__( 'Custom Border Color', 'tm-moody' ),
		'type'       => 'colorpicker',
		'param_name' => 'custom_border_color',
		'dependency' => array(
			'element' => 'border_color',
			'value'   => array( 'custom' ),
		),
		'std'        => '#eeeeee',
	),
	array(
		'group'      => $styling_tab,
		'heading'    => esc_html__( 'Border Style', 'tm-moody' ),
		'type'       => 'dropdown',
		'param_name' => 'border_style',
		'value'      => array(
			esc_html__( 'Solid', 'tm-moody' )  => 'solid',
			esc_html__( 'Dashed', 'tm-moody' ) => 'dashed',
			esc_html__( 'Dotted', 'tm-moody' ) => 'dotted',
			esc_html__( 'Double', 'tm-moody' ) => 'double',
			esc_html__( 'Groove', 'tm-moody' ) => 'groove',
			esc_html__( 'Ridge', 'tm-moody' )  => 'ridge',
			esc_html__( 'Inset', 'tm-moody' )  => 'inset',
			esc_html__( 'Outset', 'tm-moody' ) => 'outset',
		),
		'std'        => 'solid',
	),
	array(
		'group'       => $styling_tab,
		'heading'     => esc_html__( 'Border Radius', 'tm-moody' ),
		'description' => esc_html__( 'Ex: 5px or 50%', 'tm-moody' ),
		'type'        => 'textfield',
		'param_name'  => 'border_radius',
	),
	array(
		'group'      => $styling_tab,
		'heading'    => esc_html__( 'Background Color', 'tm-moody' ),
		'type'       => 'dropdown',
		'param_name' => 'background_color',
		'value'      => array(
			esc_html__( 'None', 'tm-moody' )            => '',
			esc_html__( 'Primary Color', 'tm-moody' )   => 'primary',
			esc_html__( 'Secondary Color', 'tm-moody' ) => 'secondary',
			esc_html__( 'Custom Color', 'tm-moody' )    => 'custom',
		),
		'std'        => '',
	),
	array(
		'group'      => $styling_tab,
		'heading'    => esc_html__( 'Custom Background Color', 'tm-moody' ),
		'type'       => 'colorpicker',
		'param_name' => 'custom_background_color',
		'dependency' => array(
			'element' => 'background_color',
			'value'   => array( 'custom' ),
		),
	),
	array(
		'group'      => $styling_tab,
		'heading'    => esc_html__( 'Background Image', 'tm-moody' ),
		'type'       => 'attach_image',
		'param_name' => 'background_image',
	),
	array(
		'group'      => $styling_tab,
		'heading'    => esc_html__( 'Background Repeat', 'tm-moody' ),
		'type'       => 'dropdown',
		'param_name' => 'background_repeat',
		'value'      => array(
			esc_html__( 'No repeat', 'tm-moody' )         => 'no-repeat',
			esc_html__( 'Tile', 'tm-moody' )              => 'repeat',
			esc_html__( 'Tile Horizontally', 'tm-moody' ) => 'repeat-x',
			esc_html__( 'Tile Vertically', 'tm-moody' )   => 'repeat-y',
		),
		'std'        => 'no-repeat',
		'dependency' => array(
			'element'   => 'background_image',
			'not_empty' => true,
		),
	),
	array(
		'group'      => $styling_tab,
		'heading'    => esc_html__( 'Background Size', 'tm-moody' ),
		'type'       => 'dropdown',
		'param_name' => 'background_size',
		'value'      => array(
			esc_html__( 'Auto', 'tm-moody' )    => 'auto',
			esc_html__( 'Cover', 'tm-moody' )   => 'cover',
			esc_html__( 'Contain', 'tm-moody' ) => 'contain',
		),
		'std'        => 'cover',
		'dependency' => array(
			'element'   => 'background_image',
			'not_empty' => true,
		),
	),
	array(
		'group'       => $styling_tab,
		'heading'     => esc_html__( 'Background Position', 'tm-moody' ),
		'description' => esc_html__( 'Ex: left center', 'tm-moody' ),
		'type'        => 'textfield',
		'param_name'  => 'background_position',
		'dependency'  => array(
			'element'   => 'background_image',
			'not_empty' => true,
		),
	),
	array(
		'group'       => $styling_tab,
		'heading'     => esc_html__( 'Background Overlay', 'tm-moody' ),
		'description' => esc_html__( 'Choose an overlay background color.', 'tm-moody' ),
		'type'        => 'dropdown',
		'param_name'  => 'overlay_background',
		'value'       => array(
			esc_html__( 'None', 'tm-moody' )            => '',
			esc_html__( 'Primary Color', 'tm-moody' )   => 'primary',
			esc_html__( 'Secondary Color', 'tm-moody' ) => 'secondary',
			esc_html__( 'Custom Color', 'tm-moody' )    => 'overlay_custom_background',
		),
	),
	array(
		'group'       => $styling_tab,
		'heading'     => esc_html__( 'Custom Background Overlay', 'tm-moody' ),
		'description' => esc_html__( 'Choose an custom background color overlay.', 'tm-moody' ),
		'type'        => 'colorpicker',
		'param_name'  => 'overlay_custom_background',
		'std'         => '#000000',
		'dependency'  => array( 'element' => 'overlay_background', 'value' => array( 'overlay_custom_background' ) ),
	),
	array(
		'group'      => $styling_tab,
		'heading'    => esc_html__( 'Opacity', 'tm-moody' ),
		'type'       => 'number',
		'param_name' => 'overlay_opacity',
		'value'      => 100,
		'min'        => 0,
		'max'        => 100,
		'step'       => 1,
		'suffix'     => '%',
		'std'        => 80,
		'dependency' => array(
			'element'   => 'overlay_background',
			'not_empty' => true,
		),
	),
	array(
		'heading'     => esc_html__( 'Max Width', 'tm-moody' ),
		'description' => esc_html__( 'Controls the max width of the column on large device. For Ex: 570px.', 'tm-moody' ),
		'type'        => 'textfield',
		'param_name'  => 'max_width',
	),
) );
