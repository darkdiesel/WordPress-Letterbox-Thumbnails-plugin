<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class LetterboxThumbnails_i18n
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 */
class LetterboxThumbnails_i18n {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    2.0.1
	 */
	public static function load_plugin_textdomain() {
		load_plugin_textdomain(
			LetterboxThumbnails()->plugin->get_txt_domain(),
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
