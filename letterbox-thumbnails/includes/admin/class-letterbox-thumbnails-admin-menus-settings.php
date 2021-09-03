<?php
/**
 * LetterBox Thumbnails Admin Menu Settings
 *
 * @class    LetterboxThumbnails_Admin_Menus_Settings
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class LetterboxThumbnails_Admin_Menus_Settings
 */
class LetterboxThumbnails_Admin_Menus_Settings {
	public static function output() {
		global $_wp_additional_image_sizes;

		$settings = LetterboxThumbnails()->plugin->get_settings();

		$image_sizes = get_intermediate_image_sizes();

		LetterboxThumbnails()->functions->get_template(
			'admin/settings.php',
			array(
				'settings' => $settings,
				'image_sizes' => $image_sizes,
				'_wp_additional_image_sizes' => $_wp_additional_image_sizes
			)
		);
	}

	public static function admin_menu_scripts() {
		wp_enqueue_style( 'wp-color-picker' );

		wp_deregister_script( 'letterbox-thumbnails-menu-settings-script' );
		wp_register_script( 'letterbox-thumbnails-menu-settings-script', LETTERBOX_THUMBNAILS_URL . '/assets/js/admin_menu_settings.js', array( 'jquery', 'wp-color-picker' ), LetterboxThumbnails()->get_version() );
		wp_enqueue_script( 'letterbox-thumbnails-menu-settings-script' );

		//data_sync_settings
		wp_deregister_style( 'letterbox-thumbnails-menu-settings-style' );
		wp_register_style( 'letterbox-thumbnails-menu-settings-style', LETTERBOX_THUMBNAILS_URL . '/assets/css/admin_menu_settings.css', array(), LetterboxThumbnails()->get_version() );
		wp_enqueue_style( 'letterbox-thumbnails-menu-settings-style' );

		wp_localize_script(
			'letterbox-thumbnails-menu-settings-script', 'letterbox_thumbnails_menu_settings_vars',
			array(
				'wpnonce_settings' => wp_create_nonce( 'letterbox_thumbnails_menu_settings_wpnonce' ),
			)
		);
	}
}
