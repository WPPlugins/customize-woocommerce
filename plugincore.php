<?php
/*
 * @package   Woocommerce_Styler
*/
/*
Plugin Name: Customize Woocommerce
Plugin URI:  http://www.wpgel.com
Description: The Customize Woocommerce Plugin enables eCommerce shop owners to easily enhance their product pages and create animated custom category pages enhancing * user experience and increasing key statistics like conversion rates and returning customers.
Version:     1.0
Author:      WP Gel
Author URI:  http://www.wpgel.com
Text Domain: wpgel-customize-woocommerce
License:     GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$anisliderVersion = "1.0";

$currentFile = __FILE__;

$currentFolder = dirname($currentFile);

$woo_grid_table = 'wps_woo_grid';

require_once $currentFolder . '/inc/comman_class.php';
require_once $currentFolder . '/inc/admin_class.php';
require_once $currentFolder . '/inc/slider-tinymce.php';
require_once $currentFolder . '/inc/all_function.php';
require_once $currentFolder . '/inc/woo-grid-shortcode.php';

if (!class_exists('wpgel_woo_grid')) {

class wpgel_woo_grid extends swoo_class_grid {

	const doc_link = 'http://plugin.saragna.com/vc-addon';

	var $exclude_img = array();

	function __construct() {
		parent::__construct();
		add_action('admin_menu', array( $this, 'add_animate_setting_page'));
		add_shortcode('wpgel_woo_grid','wpgel_woo_grid_shortcode');
		add_shortcode('wpgel_woo_layout','wpgel_woo_layout_shortcode');
	}

	public function add_animate_setting_page() {
		add_menu_page( 'Customize Woocommerce', 'Customize Woocommerce', 'manage_options', 'swoo-grid', array( $this, 'my_wpgel_woo_grid_page'), self::animate_plugin_url( '../assets/image/icon.png' ));

	}
	public function my_wpgel_woo_grid_page(){
	global $wpdb,$anisliderVersion;
		include('admin/setting.php');
	}
}
$wpgel_woo_grid = new wpgel_woo_grid();
}



add_action('init', 'do_output_buffer');

if(!function_exists('do_output_buffer')){

	function do_output_buffer() {

		ob_start();

	}

}

require_once( plugin_dir_path( __FILE__ ) . 'wpgel-custom-woocommerce.php' );

require_once( plugin_dir_path( __FILE__ ) . '/includes/settings.php' );

// Register hooks that are fired when the plugin is activated or deactivated.
// When the plugin is deleted, the uninstall.php file is loaded.
register_activation_hook( __FILE__, array( 'Woocommerce_Styler', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Woocommerce_Styler', 'deactivate' ) );

// Load instance
add_action( 'plugins_loaded', array( 'Woocommerce_Styler', 'get_instance' ) );
//Woocommerce_Styler::get_instance();
?>