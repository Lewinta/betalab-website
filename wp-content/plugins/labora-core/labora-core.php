<?php
/**
 * Plugin Name: Labora Core
 * Plugin URI: http://aivahthemes.net/
 * Description: A brief description of the plugin.
 * Version: 2.0.0
 * Author: AivahThemes
 * Author URI: URI: http://themeforest.net/user/AivahThemes
 * Text Domain: Optional. Plugin's text domain for localization. Example: mytextdomain
 * Domain Path: Optional. Plugin's relative directory path to .mo files. Example: /locale/
 * Network: Optional. Whether the plugin can only be activated network wide. Example: true
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
* labora Plugin Class.
*/
define( 'LABORA_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'LABORA_CORE_URI', plugin_dir_url( __FILE__ ) );

require_once( LABORA_CORE_DIR . 'labora-posttypes/labora-posttypes.php' );
require_once( LABORA_CORE_DIR . 'labora-shortcodes/labora-shortcodes.php' );
add_action( 'plugins_loaded', 'labora_init_plugins' );
function labora_init_plugins() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
	if ( is_plugin_active( 'js_composer/js_composer.php' ) || class_exists( 'Vc_Manager' ) ) {
		require_once( LABORA_CORE_DIR . 'labora-vcaddons/labora-vcaddons.php' );
	}
}
