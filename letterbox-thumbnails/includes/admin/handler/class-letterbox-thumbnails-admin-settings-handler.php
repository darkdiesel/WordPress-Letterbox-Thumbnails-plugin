<?php
/**
 * LetterBox Thumbnails Admin Settings Handler
 *
 * @class    LetterboxThumbnails_Admin_Settings_Handler
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class LetterboxThumbnails_Admin_Settings_Handler
 */
class LetterboxThumbnails_Admin_Settings_Handler {
	static $nonce_action_settings = 'letterbox_thumbnails_settings';

	public static function plugin_settings_ajax_save() {
		if ( ! isset( $_POST['wpnonce'] ) || ! wp_verify_nonce( $_POST['wpnonce'], 'letterbox_thumbnails_menu_settings_wpnonce' ) ) {
			die( _( 'Permission check failed' ) );
		}

		//build setting array
		$settings = array();

		if ( isset( $_POST['form'] ) ) {
			foreach ( $_POST['form'] as $option ) {
				if ( strpos( $option['name'], '[]' ) ) {
					$settings[ substr( $option['name'], 0, strpos( $option['name'], '[]' ) ) ][] = $option['value'];
				} else {
					$settings[ $option['name'] ] = $option['value'];
				}
			}
		}

		//save plugin settings
		update_option(LetterboxThumbnails()->plugin->plugin_settings_option, wp_slash( json_encode( $settings ) ) );

		//create response
		$response = array();

		$response['ajax']    = 'success';
		$response['message'] = sprintf( '<strong>%s</strong>', __( 'Settings successfully saved!' ) );
		$response['fields']  = $settings;

		//return json
		echo json_encode( $response );

		die();
	}


}

add_action( "wp_ajax_letterbox_thumbnails_settings_save", array(
	'LetterboxThumbnails_Admin_Settings_Handler',
	'plugin_settings_ajax_save'
) );