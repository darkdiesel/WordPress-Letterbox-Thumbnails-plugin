<?php
/**
 * LetterBox Thumbnails Admin
 *
 * @class    LetterboxThumbnails_Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class LetterboxThumbnails_Admin
 */
class LetterboxThumbnails_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once dirname( __FILE__ ) . '/class-letterbox-thumbnails-admin-menus.php';
	}
}

return new LetterboxThumbnails_Admin();
