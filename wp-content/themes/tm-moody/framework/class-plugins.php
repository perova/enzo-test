<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin installation and activation for WordPress themes
 */
if ( ! class_exists( 'Insight_Register_Plugins' ) ) {
	class Insight_Register_Plugins {

		public function __construct() {
			add_filter( 'insight_core_tgm_plugins', array( $this, 'register_required_plugins' ) );
		}

		public function register_required_plugins() {
			/*
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */
			$plugins = array(
				array(
					'name'     => esc_html__( 'Insight Core', 'tm-moody' ),
					'slug'     => 'insight-core',
					'source'   => 'https://www.dropbox.com/s/1ccrv64ezm3t9b1/insight-core-1.5.0.zip?dl=1',
					'version'  => '1.5.0',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'Revolution Slider', 'tm-moody' ),
					'slug'     => 'revslider',
					'source'   => 'https://www.dropbox.com/s/ivfxy4zv63s3upe/revslider-5.4.6.2.zip?dl=1',
					'version'  => '5.4.6.2',
					'required' => true,
				),
				array(
					'name'     => esc_html__( 'Visual Composer', 'tm-moody' ),
					'slug'     => 'js_composer',
					'source'   => 'https://www.dropbox.com/s/ip3fpvv2z5akt0l/js_composer-5.4.2.zip?dl=1',
					'version'  => '5.4.2',
					'required' => true,
				),
				array(
					'name'    => esc_html__( 'Visual Composer Clipboard', 'tm-moody' ),
					'slug'    => 'vc_clipboard',
					'source'  => 'https://www.dropbox.com/s/zz90vvaluc5jq71/vc_clipboard-3.25.zip?dl=1',
					'version' => '3.25',
				),
				array(
					'name' => esc_html__( 'Contact Form 7', 'tm-moody' ),
					'slug' => 'contact-form-7',
				),
				array(
					'name' => esc_html__( 'MailChimp for WordPress', 'tm-moody' ),
					'slug' => 'mailchimp-for-wp',
				),
				array(
					'name' => esc_html__( 'WooCommerce', 'tm-moody' ),
					'slug' => 'woocommerce',
				),
				array(
					'name' => esc_html__( 'WP-PostViews', 'tm-moody' ),
					'slug' => 'wp-postviews',
				),
			);

			return $plugins;
		}

	}

	new Insight_Register_Plugins();
}
