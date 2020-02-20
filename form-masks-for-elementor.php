<?php
/**
 * Plugin Name: Form Masks for Elementor
 * Plugin URI: http://www.evcode.com.br
 * Description: Form Masks for Elementor create a custom control in field advanced tab for your customize your fields with masks. This plugin require the Elementor Pro (Form Widget).
 * Author: EVCODE
 * Author URI: http://evcode.com.br
 * Version: 1.1
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**Include Required Files**/
require dirname(__FILE__).'/includes/class-elementor-mask-control.php';

function evcode_include_js () {
    wp_enqueue_script( 'plugin_jquery_mask', plugin_dir_url( __FILE__ ) . 'assets/jquery.mask.js', array( 'jquery' ) );
	wp_enqueue_script( 'jquery_mask',  plugin_dir_url( __FILE__ ) . 'assets/elementor_mask.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'evcode_include_js' );

/**Check Elementor Pro Plugin Installed**/
function evcode_check_elementor_active(){
if ( ! is_plugin_active( 'elementor-pro/elementor-pro.php' ) ) {
  	echo "<div class='error'><p><strong>Form Masks for Elementor</strong> requires <strong> Elementor Pro plugin</strong> </p></div>";
	}
}
add_action('admin_notices', 'evcode_check_elementor_active');