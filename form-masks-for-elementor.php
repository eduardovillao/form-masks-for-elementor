<?php
/**
 * Plugin Name: Form Masks for Elementor
 * Plugin URI: https://eduardovillao.me/
 * Description: Form Masks for Elementor create a custom control in field advanced tab for your customize your fields with masks. This plugin require the Elementor Pro (Form Widget).
 * Author: EduardoVillao.me
 * Author URI: https://eduardovillao.me/
 * Version: 1.6.4
 * Requires at least: 5.5
 * Requires PHP: 7.0
 * Text Domain: form-masks-for-elementor
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/*
Form Masks for Elementor is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Form Masks for Elementor is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Form Masks for Elementor. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FME_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'FME_PLUGN_URL', plugin_dir_url( __FILE__ ) );
define( 'FME_VERSION' , '1.6.4' );
define( 'FME_PHP_MINIMUM_VERSION', '7.0' );
define( 'FME_WP_MINIMUM_VERSION', '5.5' );

/**
 * Check PHP and WP version before include plugin class
 *
 * @since 1.6
 */
if( ! version_compare( PHP_VERSION, FME_PHP_MINIMUM_VERSION, '>=' ) ) {
	add_action( 'admin_notices', 'fme_admin_notice_php_version_fail' );

} elseif( ! version_compare( get_bloginfo( 'version' ), FME_WP_MINIMUM_VERSION, '>=' ) ) {
	add_action( 'admin_notices', 'fme_admin_notice_wp_version_fail' );

} else {
	include_once FME_PLUGIN_PATH . 'includes/class-fme-plugin.php';
}

/**
 * Admin notice PHP version fail
 *
 * @since 1.6
 * @return void
 */
function fme_admin_notice_php_version_fail() {
	$message = sprintf(
		esc_html__( '%1$s requires PHP version %2$s or greater.', 'form-masks-for-elementor' ),
		'<strong>Form masks for Elementor</strong>',
		FME_PHP_MINIMUM_VERSION
	);

	$html_message = sprintf( '<div class="notice notice-error"><p>%1$s</p></div>', $message );
	echo wp_kses_post( $html_message );
}

/**
 * Admin notice WP version fail
 *
 * @since 1.6
 * @return void
 */
function fme_admin_notice_wp_version_fail() {
	$message = sprintf(
		esc_html__( '%1$s requires WordPress version %2$s or greater.', 'form-masks-for-elementor' ),
		'<strong>Form masks for Elementor</strong>',
		FME_WP_MINIMUM_VERSION
	);

	$html_message = sprintf( '<div class="notice notice-error"><p>%1$s</p></div>', $message );
	echo wp_kses_post( $html_message );
}
