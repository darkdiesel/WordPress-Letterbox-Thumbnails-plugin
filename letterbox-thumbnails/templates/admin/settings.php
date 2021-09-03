<?php
/**
 * Admin Template: Page - Settings
 *
 * @var $image_sizes array
 * @var $_wp_additional_image_sizes array
 */


defined( 'ABSPATH' ) || exit;
$action = 'save';
?>

<div class="wrap">
    <div class="wrap-header">
        <h1 class="wp-heading-inline"><?php _e('Letterbox Thumbnails Settings', LetterboxThumbnails()->plugin->get_txt_domain()); ?></h1>
    </div>

    <hr class="wp-header-end">

    <form id="letterbox-thumbnails-settings-form" novalidate="novalidate" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="color"><?php _e('Background color:', LetterboxThumbnails()->plugin->get_txt_domain()); ?></label>
                </th>
                <td>
	                <?php $option = isset( $settings['color'] ) ? $settings['color'] : ''; ?>
                    <input type="text" id="color" value="<?php echo $option; ?>" name="color" class="wp-color-picker-field" />
	                <?php $option = isset( $settings['rgb-r'] ) ? $settings['rgb-r'] : ''; ?>
                    <input type="hidden" id="rgb-r" value="<?php echo $option; ?>" name="rgb-r" class="wp-color-picker-field"  />
	                <?php $option = isset( $settings['rgb-g'] ) ? $settings['rgb-g'] : ''; ?>
                    <input type="hidden" id="rgb-g" value="<?php echo $option; ?>" name="rgb-g" />
	                <?php $option = isset( $settings['rgb-b'] ) ? $settings['rgb-b'] : ''; ?>
                    <input type="hidden" id="rgb-b" value="<?php echo $option; ?>" name="rgb-b" />
                    <p class="description"><?php _e('Select color that will be used as background.', LetterboxThumbnails()->plugin->get_txt_domain()); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label><?php _e('Image sizes:', LetterboxThumbnails()->plugin->get_txt_domain()); ?></label>
                </th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text">
                            <span><?php _e('Image sizes', LetterboxThumbnails()->plugin->get_txt_domain()); ?></span>
                        </legend>
	                    <?php $option = isset( $settings['image_sizes'] ) ? $settings['image_sizes'] : ''; ?>

                        <table cellspacing="0" border="1" cellpadding="5">
                            <thead>
                            <tr>
                                <td></td>
                                <td align="center">
                                    <b><?php _e('Name', IPA_Fields_Pack()->plugin->get_txt_domain()); ?></b>
                                </td>
                                <td align="center">
                                    <b><?php _e('Size (width x height)', IPA_Fields_Pack()->plugin->get_txt_domain()); ?></b>
                                </td>
                                <td align="center">
                                    <b><?php _e('Cropping', IPA_Fields_Pack()->plugin->get_txt_domain()); ?></b>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($image_sizes as $size ): ?>
	                            <?php
	                            if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
		                            $size_w = get_option( "{$size}_size_w" );
		                            $size_h = get_option( "{$size}_size_h" );
		                            $size_crop = (bool) get_option( "{$size}_crop" );
	                            } elseif ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
		                            $size_w    = $_wp_additional_image_sizes[ $size ]['width'];
		                            $size_h    = $_wp_additional_image_sizes[ $size ]['height'];
		                            $size_crop = $_wp_additional_image_sizes[ $size ]['crop'];
	                            }
	                            ?>

                                <tr class="<?php echo sprintf('image-size-%s', $size); ?>">
                                    <td align="center">
                                        <input type="checkbox" id="<?php echo sprintf('image-size-%s', $size); ?>" value="<?php echo $size; ?>" name="image_sizes[]" <?php echo in_array($size, $option) ? 'checked': '';?> >
                                    </td>
                                    <td align="center">
                                        <?php echo $size; ?>
                                    </td>
                                    <td align="center">
	                                    <?php print sprintf('<i>%spx x %spx</i>', $size_w, $size_h); ?>
                                    </td>
                                    <td align="center">
	                                    <?php print sprintf('%s', ($size_crop) ? '<span class="dashicons dashicons-yes color-yes"></span>': '<span class="dashicons dashicons-no color-no"></span>'); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                        <p class="description"><?php _e('Select image sizes for that apply letterbox style.', LetterboxThumbnails()->plugin->get_txt_domain()); ?></p>
                        <p class="description"><?php _e('<b class="color-note">NOTE!</b> For selected image sizes cropping option will be ignoring!', LetterboxThumbnails()->plugin->get_txt_domain()); ?></p>
                    </fieldset>
                </td>
            </tr>
            </tbody>
        </table>

        <p class="submit">
            <input
                class="button button-primary button-large button-submit letterbox-thumbnails-settings-submit"
                type="submit"
                name="letterbox_thumbnails_settings[submit]"
                value="<?php _e( 'Save settings', LetterboxThumbnails()->plugin->get_txt_domain() ) ?>"/>

            <span class="ajax-process"><img src="<?php echo admin_url( 'images/spinner.gif' ) ?>" alt=""></span>
        </p>
    </form>
</div>