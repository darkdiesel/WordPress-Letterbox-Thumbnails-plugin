=== Letterbox Thumbnails ===
Contributors: Igor Peshkov
Donate link:
Tags: thumbnails, letterboxing
Requires at least: 4.5.0
Tested up to: 5.2
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin add new editor for generating thumbnails with letterbox style. Background color for letterbox style sets in settings.

== Description ==

This plugin add new editor for generating thumbnails with letterbox style. Background color for letterbox style sets in settings.


== Installation ==

1. Upload `letterbox-thumbnails` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How to change letterbox color? =
Login as admin and go to admin settings. Click `Letterbox Thumbnails` link under `Settings` section. Set new color at the colorpicker box. Save settings by pressing save button.

= How use letterbox style for some selected image sizes? =
Go `Letterbox Thumbnails` settings page. In Image sizes section select images sizes for that you want use letterbox style. Save settings by pressing save button.

== Screenshots ==
1. Upload new image to media
2. Letterbox thumbnails will be automatically generated with sizes that sets in settings.

== Changelog ==

= Version 2.0 =

Rewrite source code with more pro code style.
Remove colorpicker js library and using wp color picker.
Add settings to apply letterbox style for selected image sizes.
Ignore crop option for selected image sizes.

= Version 1.0 =

Plugin generate thumbnails with letterbox style. Color for letterbox sets in settings.

 == Upgrade Notice ==
Some options for storing rgb color settings from 1.0 version of plugin deprecated and not used. You can remove them manually from your db.

List of unused options:
letterbox_thumbnails_color_r
letterbox_thumbnails_color_g
letterbox_thumbnails_color_b