<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Insight_Instagram' ) ) {

	class Insight_Instagram {

		public function __construct() {

		}

		/**
		 * Quick-and-dirty Instagram web scrape
		 * based on https://gist.github.com/cosmocatalano/4544576
		 *
		 * @param     $username
		 * @param int $slice
		 *
		 * @return array|WP_Error
		 */
		public static function scrape_instagram( $username, $slice, $square_media ) {

			$username = strtolower( $username );

			if ( false === ( $instagram = get_transient( 'instagram-media-new-' . sanitize_title_with_dashes( $username . '-' . $square_media ) ) ) ) {

				$remote = wp_remote_get( 'http://instagram.com/' . trim( $username ) );

				if ( is_wp_error( $remote ) ) {
					return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'tm-moody' ) );
				}

				if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
					return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'tm-moody' ) );
				}

				$shards      = explode( 'window._sharedData = ', $remote['body'] );
				$insta_json  = explode( ';</script>', $shards[1] );
				$insta_array = json_decode( $insta_json[0], true );

				if ( ! $insta_array ) {
					return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'tm-moody' ) );
				}

				// old style.
				if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
					$media_arr = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
					$type      = 'old';
					// new style.
				} elseif ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
					$media_arr = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
					$type      = 'new';
				} else {
					return new WP_Error( 'bad_josn_2', esc_html__( 'Instagram has returned invalid data.', 'tm-moody' ) );
				}

				if ( ! is_array( $media_arr ) ) {
					return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'tm-moody' ) );
				}

				switch ( $type ) {
					case 'old':
						$instagram = self::get_media_old_style( $username, $media_arr );
						break;
					default:
						$instagram = self::get_media_new_style( $media_arr, $square_media );
						break;
				}

				// do not set an empty transient - should help catch private or empty accounts.
				if ( ! empty( $instagram ) ) {
					$instagram = insight_core_base_encode( serialize( $instagram ) );
					set_transient( 'instagram-media-new-' . sanitize_title_with_dashes( $username . '-' . $square_media ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
				}
			}

			if ( ! empty( $instagram ) ) {

				$instagram = unserialize( insight_core_base_decode( $instagram ) );

				return array_slice( $instagram, 0, $slice );;

			} else {

				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'tm-moody' ) );

			}
		}

		/**
		 * @param $username
		 * @param $media_arr
		 *
		 * @return array
		 */
		public static function get_media_old_style( $username, $media_arr ) {

			$instagram = array();

			foreach ( $media_arr as $media ) {

				if ( $media['user']['username'] == $username ) {

					$media['link']                          = preg_replace( "/^http:/i", "", $media['link'] );
					$media['images']['thumbnail']           = preg_replace( "/^http:/i", "", $media['images']['thumbnail'] );
					$media['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $media['images']['standard_resolution'] );
					$media['images']['low_resolution']      = preg_replace( "/^http:/i", "", $media['images']['low_resolution'] );

					$instagram[] = array(
						'description' => $media['caption']['text'],
						'link'        => $media['link'],
						'time'        => $media['created_time'],
						'comments'    => self::roundNumber( $media['comments']['count'] ),
						'likes'       => self::roundNumber( $media['likes']['count'] ),
						'thumbnail'   => $media['images']['thumbnail']['url'],
						'large'       => $media['images']['standard_resolution']['url'],
						'small'       => $media['images']['low_resolution']['url'],
						'type'        => $media['type'],
					);
				}
			}

			return $instagram;
		}

		/**
		 * @param $media_arr
		 *
		 * @return array
		 */
		public static function get_media_new_style( $media_arr, $square_media ) {

			$instagram = array();

			foreach ( $media_arr as $media ) {

				$image_src = ( 'on' == $square_media ) ? 'thumbnail_src' : 'display_src';

				$media[ $image_src ] = preg_replace( "/^http:/i", "", $media[ $image_src ] );

				if ( $media['is_video'] == true ) {
					$type = 'video';
				} else {
					$type = 'image';
				}

				$instagram[] = array(
					'description' => $media['caption'],
					'link'        => '//instagram.com/p/' . $media['code'],
					'time'        => $media['date'],
					'comments'    => self::roundNumber( $media['comments']['count'] ),
					'likes'       => self::roundNumber( $media['likes']['count'] ),
					'thumbnail'   => $media[ $image_src ],
					'type'        => $type,
				);
			}

			return $instagram;
		}

		/**
		 * Generate rounded number
		 * Example: 11200 --> 11K
		 *
		 * @param $number
		 *
		 * @return string
		 */
		public static function roundNumber( $number ) {
			if ( $number > 999 && $number <= 999999 ) {
				$result = floor( $number / 1000 ) . ' K';
			} elseif ( $number > 999999 ) {
				$result = floor( $number / 1000000 ) . ' M';
			} else {
				$result = $number;
			}

			return $result;
		}
	}

	new Insight_Instagram();
}
