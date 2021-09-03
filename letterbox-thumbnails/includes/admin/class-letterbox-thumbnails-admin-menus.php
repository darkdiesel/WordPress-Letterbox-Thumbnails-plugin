<?php
/**
 * LetterBox Thumbnails Admin Menus
 *
 * @class    LetterboxThumbnails_Admin_Menus
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class LetterboxThumbnails_Admin_Menus
 */
class LetterboxThumbnails_Admin_Menus {
	public $settings_page_hook = null;

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		$this->includes();

		// Add menus.
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
	}

	public function includes(){
		include_once dirname( __FILE__ ) . '/class-letterbox-thumbnails-admin-menus-settings.php';
		include_once dirname( __FILE__ ) . '/handler/class-letterbox-thumbnails-admin-settings-handler.php';
	}

	public function admin_menu(){
		$this->settings_page_hook = add_options_page(
			__('LetterBox Thumbnails Settings', LetterboxThumbnails()->plugin->get_txt_domain()),
			__('Letterbox Thumbnails', LetterboxThumbnails()->plugin->get_txt_domain()),
			'manage_options',
			'letterbox-thumbnails-settings',
			array($this, 'letterbox_thumbnails_settings_page')
		);

		add_action('admin_print_styles-' . $this->settings_page_hook, array('LetterboxThumbnails_Admin_Menus_Settings','admin_menu_scripts'));
	}

	public function letterbox_thumbnails_settings_page(){
		LetterboxThumbnails_Admin_Menus_Settings::output();
	}

}

return new LetterboxThumbnails_Admin_Menus();