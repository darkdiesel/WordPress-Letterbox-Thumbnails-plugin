<?php
/**
 * LetterBox Thumbnails Image Editor based on GD Image Editor
 *
 * @class    LetterboxThumbnails_Image_Editor_GD_LT
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class LetterboxThumbnails_Image_Editor_GD_LT
 */
class LetterboxThumbnails_Image_Editor_GD_LT extends WP_Image_Editor_GD {

	/**
	 * Resizes current image.
	 * Wraps _resize, since _resize returns a GD Resource.
	 *
	 * At minimum, either a height or width must be provided.
	 * If one of the two is set to null, the resize will
	 * maintain aspect ratio according to the provided dimension.
	 *
	 * @param int|null $max_w Image width.
	 * @param int|null $max_h Image height.
	 * @param bool $crop
	 *
	 * @return true|WP_Error
	 *
	 */
	public function resize( $max_w, $max_h, $crop = false ) {
		if ( ( $this->size['width'] == $max_w ) && ( $this->size['height'] == $max_h ) ) {
			return true;
		}

		$resized = $this->_resize( $max_w, $max_h, $crop );

		if ( is_resource( $resized ) ) {
			imagedestroy( $this->image );
			$this->image = $resized;

			return true;

		} elseif ( is_wp_error( $resized ) ) {
			return $resized;
		}

		return new WP_Error( 'image_resize_error', __( 'Image resize failed.' ), $this->file );
	}

	/**
	 * @param int $max_w
	 * @param int $max_h
	 * @param bool|array $crop
	 *
	 * @return resource|WP_Error
	 */
	protected function _resize( $max_w, $max_h, $crop = false ) {
		$dims = image_resize_dimensions( $this->size['width'], $this->size['height'], $max_w, $max_h, $crop );
		if ( ! $dims ) {
			return new WP_Error( 'error_getting_dimensions', __( 'Could not calculate resized image dimensions' ), $this->file );
		}
		list( $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h ) = $dims;

		if ($max_w == '9999') {
			$max_w = $dst_w;
		} elseif ($max_h == '9999') {
			$max_h = $dst_h;
		}

		$settings = LetterboxThumbnails()->plugin->get_settings();

		$lt_color_r = isset($settings['rgb-r']) ? $settings['rgb-r'] : 255;
		$lt_color_g = isset($settings['rgb-g']) ? $settings['rgb-g'] : 255;
		$lt_color_b = isset($settings['rgb-b']) ? $settings['rgb-b'] : 255;

		//$resized = wp_imagecreatetruecolor( $dst_w, $dst_h );
		$resized = wp_imagecreatetruecolor($max_w, $max_h);
		$color = imagecolorallocate($resized, $lt_color_r, $lt_color_g, $lt_color_b);
		imagefill($resized, 0, 0, $color);

		//Calculate where the image should start so its centered
		if ($dst_w == $max_w) {
			$dst_x = 0;
		} else {
			$dst_x = round(($max_w - $dst_w) / 2);
		}
		if ($dst_h == $max_h) {
			$dst_y = 0;
		} else {
			$dst_y = round(($max_h - $dst_h) / 2);
		}

		imagecopyresampled( $resized, $this->image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h );

		if ( is_resource( $resized ) ) {
			$this->update_size( $max_w, $max_h );

			return $resized;
		}

		return new WP_Error( 'image_resize_error', __( 'Image resize failed.' ), $this->file );
	}

	/**
	 * Resize multiple images from a single source.
	 *
	 * @param array $sizes {
	 *     An array of image size arrays. Default sizes are 'small', 'medium', 'medium_large', 'large'.
	 *
	 *     Either a height or width must be provided.
	 *     If one of the two is set to null, the resize will
	 *     maintain aspect ratio according to the provided dimension.
	 *
	 *     @type array $size {
	 *         Array of height, width values, and whether to crop.
	 *
	 *         @type int  $width  Image width. Optional if `$height` is specified.
	 *         @type int  $height Image height. Optional if `$width` is specified.
	 *         @type bool $crop   Optional. Whether to crop the image. Default false.
	 *     }
	 * }
	 * @return array An array of resized images' metadata by size.
	 */
	public function multi_resize( $sizes ) {
		$metadata  = array();
		$orig_size = $this->size;

		$settings = LetterboxThumbnails()->plugin->get_settings();

		foreach ( $sizes as $size => $size_data ) {
			if ( ! isset( $size_data['width'] ) && ! isset( $size_data['height'] ) ) {
				continue;
			}

			if ( ! isset( $size_data['width'] ) ) {
				$size_data['width'] = null;
			}
			if ( ! isset( $size_data['height'] ) ) {
				$size_data['height'] = null;
			}

			if ( ! isset( $size_data['crop'] ) ) {
				$size_data['crop'] = false;
			}

			if (in_array($size, $settings['image_sizes'])) {
				$image     = $this->_resize( $size_data['width'], $size_data['height'], FALSE );
			} else{
				$image     = parent::_resize( $size_data['width'], $size_data['height'], $size_data['crop'] );
			}

			$duplicate = ( ( $orig_size['width'] == $size_data['width'] ) && ( $orig_size['height'] == $size_data['height'] ) );

			if ( ! is_wp_error( $image ) && ! $duplicate ) {
				$resized = $this->_save( $image );

				imagedestroy( $image );

				if ( ! is_wp_error( $resized ) && $resized ) {
					unset( $resized['path'] );
					$metadata[ $size ] = $resized;
				}
			}

			$this->size = $orig_size;
		}

		return $metadata;
	}
}