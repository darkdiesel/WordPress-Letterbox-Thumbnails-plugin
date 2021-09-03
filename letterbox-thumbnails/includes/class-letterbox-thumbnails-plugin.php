<?php
/**
 * LetterBox Thumbnails Plugin
 *
 * @class    LetterboxThumbnails_Plugin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class LetterboxThumbnails_Plugin
 */
class LetterboxThumbnails_Plugin {
	public $plugin_settings_option = 'letterbox-thumbnails-settings';

	public $default_txt_domain = 'letterbox-thumnails';

	public $plugin_data;
	public $plugin_settings;

	function __construct() {

	}

	public function get_settings() {
		return json_decode( stripslashes_deep( get_option( $this->plugin_settings_option ) ), true );
	}

	/**
	 * Function return plugin data
	 *
	 * @param null $var
	 *
	 * @return array|bool|mixed|null
	 */
	public function get_data($var = null) {
		if ( ! $this->plugin_data ) {
			if ( function_exists( 'get_plugin_data' ) ) {
				$this->plugin_data = get_plugin_data( LETTERBOX_THUMBNAILS_PATH . '/letterbox-thumbnails.php' );
			}
		}

		if (is_null($var)){
			return $this->plugin_data;
		}

		if (!is_null($this->plugin_data)){
			if (is_array( $this->plugin_data ) && isset( $this->plugin_data[$var] )){
				return $this->plugin_data[$var];
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	/**
	 * Return plugin text domain
	 *
	 * @return string
	 */
	public function get_txt_domain() {

		$data = $this->get_data('TextDomain');

		if ( $data  ) {
			return $data;
		} else {
			return $this->default_txt_domain;
		}
	}

	/**
	 * Get the template path.
	 * @return string
	 */
	public function template_path() {
		return apply_filters( 'letterbox_thumbnails_template_path', 'letterbox_thumbnails/' );
	}
}
