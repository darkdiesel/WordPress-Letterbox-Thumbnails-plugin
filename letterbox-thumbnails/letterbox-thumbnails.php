<?php
/**
 * Plugin Name: Letterbox Thumbnails
 * Plugin URI: https://wordpress.org/plugins/letterbox-thumnails/
 * Description: This plugin add new editor for generating thumbnails with letterbox style. Background color for letterbox style sets in settings.
 * Author: Igor Peshkov
 * Author URI: https://www.facebook.com/igor.peshkov.27.07.1988
 * Version: 2.0.1
 * Text Domain: letterbox-thumnails
 * Domain Path: /languages/
 * Requires at least: 4.5
 * Tested up to: 5.2
 * Requires PHP: 5.6
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) || exit;

// Define LETTERBOX_THUMBNAILS_PLUGIN_FILE.
if ( ! defined( 'LETTERBOX_THUMBNAILS_PLUGIN_FILE' ) ) {
	define( 'LETTERBOX_THUMBNAILS_PLUGIN_FILE', __FILE__ );
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LETTERBOX_THUMBNAILS_VERSION', '2.0.1' );

if ( ! class_exists( 'LetterboxThumbnails' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-letterbox-thumbnails.php';
}

/**
 * Returns the main instance of LetterboxThumbnails to prevent the need to use globals.
 *
 * @return LetterboxThumbnails
 * @since  2.0.0
 */
function LetterboxThumbnails() {
	return LetterboxThumbnails::instance();
}

// Global for backwards compatibility.
$GLOBALS['letterbox-thumbnails'] = LetterboxThumbnails();