<?php
/**
 * LetterBox Thumbnails Add Image Editor
 *
 * @class    LetterboxThumbnails_Image_Editor
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class LetterboxThumbnails_Image_Editor
 */
class LetterboxThumbnails_Image_Editor {
	public static function image_editor( $editors ) {
		if ( ! class_exists( 'LetterboxThumbnails_Image_Editor_GD_LT' ) ) {
			include_once LETTERBOX_THUMBNAILS_PATH . 'includes/image-editor/class-letterbox-thumbnails-image-editor-gdlt.php';
		}

		if ( ! in_array( 'LetterboxThumbnails_Image_Editor_GD_LT', $editors ) ) {
			array_unshift( $editors, 'LetterboxThumbnails_Image_Editor_GD_LT' );
		}

		return $editors;
	}

}

add_filter( 'wp_image_editors', array( 'LetterboxThumbnails_Image_Editor', 'image_editor' ) );