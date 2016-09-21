<?php
/*
  Plugin Name: Letterbox Thumbnails
  Plugin URI: http://epam.com
  Description: Letterbox Thumbnails
  Version: 1.0
  Author: Epam Systems (Ihar Peshkou)
  Author URI: http://vk.com/darkdiesel

  Copyright 2013  Igor Peshkov (email: igor.peshkov@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

class LetterboxThumbnails
{
    // Plugin initialization
    function __construct()
    {
	add_action('admin_menu', array(&$this, 'add_admin_menu'));
	add_filter('wp_image_editors', array(&$this, 'gd_letterbox_editor'));
    }

    function gd_letterbox_editor($editors)
    {
	if (!class_exists('WP_Image_Editor_GDLT'))
	    include_once 'editor/class-wp-image-editor-gdlt.php';

	if (!in_array('WP_Image_Editor_GDLT', $editors))
	    array_unshift($editors, 'WP_Image_Editor_GDLT');

	return $editors;
    }

    function add_admin_menu()
    {
	add_options_page(__('LetterBox Thumbnails Settings', 'default'), __('Letterbox Thumbnails', 'Letterbox Thumbnails'), 'manage_options', 'letterbox_thumbnails.php', array(&$this, 'letterboxing_settings_interface'));
    }

    function letterboxing_settings_interface()
    {
	//add js files
	wp_enqueue_script(
		'letterboxing_colorpicker', plugin_dir_url(__FILE__) . "/colorpicker/js/colorpicker.js", array('jquery')
	);
	wp_enqueue_script(
		'letterboxing_colorpicker_init', plugin_dir_url(__FILE__) . "/js/colorpicker_init.js", array('jquery')
	);

	//add css files
	wp_enqueue_style('letterboxing_style', plugin_dir_url(__FILE__) . "/css/style.css");
	wp_enqueue_style('letterboxing_colorpicker', plugin_dir_url(__FILE__) . "/colorpicker/css/colorpicker.css");
	wp_enqueue_style('letterboxing_layout', plugins_url('/colorpicker/css/layout.css', __FILE__));
	?>

	<h2><?php _e('Letterbox Thumbnails Settings', 'default') ?></h2>

	<?php
	//add options	
	add_option('letterbox_thumbnails_color_r', '255');
	add_option('letterbox_thumbnails_color_g', '255');
	add_option('letterbox_thumbnails_color_b', '255');

	if (isset($_POST['letterbox_thumbnails_settings_submit_btn'])) {
	    if (function_exists('current_user_can') &&
		    !current_user_can('manage_options'))
		die(_e('Hacker?', 'letterboxing'));

	    if (function_exists('check_admin_referer')) {
		check_admin_referer('letterbox_thumbnails_size_settings_form');
	    }

	    $letterbox_thumbnails_color_r = $_POST['letterbox_thumbnails_color_r'];
	    $letterbox_thumbnails_color_g = $_POST['letterbox_thumbnails_color_g'];
	    $letterbox_thumbnails_color_b = $_POST['letterbox_thumbnails_color_b'];

	    update_option('letterbox_thumbnails_color_r', $letterbox_thumbnails_color_r);
	    update_option('letterbox_thumbnails_color_g', $letterbox_thumbnails_color_g);
	    update_option('letterbox_thumbnails_color_b', $letterbox_thumbnails_color_b);
	}
	?>
	<form id="letterbox_thumbnails_size_settings" name="letterbox_thumbnails_size_settings_form" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?page=letterbox_thumbnails.php&amp;updated=true">
	    <?php
	    if (function_exists('wp_nonce_field')) {
		wp_nonce_field('letterbox_thumbnails_size_settings_form');
	    }
	    ?>
	    <?php
	    $r_col = get_option('letterbox_thumbnails_color_r');
	    $g_col = get_option('letterbox_thumbnails_color_g');
	    $b_col = get_option('letterbox_thumbnails_color_b');
	    ?>
	    <div class="lt_element">
		<label class="lt_element_label"><?php _e('Letterbox Color:', 'default') ?></label>
		<div id="colorSelector" class="lt_element_wrapper" data-color="#<?php echo (($r_col != 0) ? dechex($r_col) : "00") . (($g_col != 0) ? dechex($g_col) : "00") . (($b_col != 0) ? dechex($b_col) : "00"); ?>">
		    <div></div>
		</div>
	    </div>
	    <div class="lt_element">
		<div class="lt_element_wrapper">
		    <input type="hidden" id="letterbox_thumbnails_color_r" name="letterbox_thumbnails_color_r" value="<?php echo $r_col ?>">
		    <input type="hidden" id="letterbox_thumbnails_color_g" name="letterbox_thumbnails_color_g" value="<?php echo $g_col ?>">
		    <input type="hidden" id="letterbox_thumbnails_color_b" name="letterbox_thumbnails_color_b" value="<?php echo $b_col ?>">
		</div>
	    </div>
	    <div class="lt_elemen">
		<div class="lt_element_wrapper">
		    <input type="submit" name="letterbox_thumbnails_settings_submit_btn" value="<?php _e('Save settings', 'default') ?>">
		</div>
	    </div>
	</form>
	<?php
    }

}

// Start up this plugin
add_action('init', 'LetterboxThumbnails');

function LetterboxThumbnails()
{
    global $LetterboxThumbnails;
    $LetterboxThumbnails = new LetterboxThumbnails();
}
?>