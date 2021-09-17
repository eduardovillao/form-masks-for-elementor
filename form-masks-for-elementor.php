<?php
/**
 * Plugin Name: Form Masks for Elementor
 * Plugin URI: https://eduardovillao.me/
 * Description: Form Masks for Elementor create a custom control in field advanced tab for your customize your fields with masks. This plugin require the Elementor Pro (Form Widget).
 * Author: EduardoVillao.me
 * Author URI: https://eduardovillao.me/
 * Version: 1.5.1
 * Domain Path: /languages
 * Text Domain: form-masks-for-elementor
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'FME_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'FME_PLUGN_URL', plugin_dir_url( __FILE__ ) );
define( 'FME_VERSION' , '1.5.1' );

/**
 * Form Mask Elementor Class
 *
 * Class to initialize the plugin.
 *
 * @since 1.4
 */
final class FME_Init {

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.4
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Minimum WP Version
	 *
	 * @since 1.4
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_WP_VERSION = '5.3';

	/**
	 * Instance
	 *
	 * @since 1.4
	 *
	 * @access private
	 * @static
	 *
	 * @var FME_Init The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.4
	 *
	 * @access public
	 * @static
	 *
	 * @return FME_Init An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * Private method for prevent instance outsite the class.
	 * 
	 * @since 1.4
	 *
	 * @access private
	 */
	private function __construct() {

		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		if ( version_compare( $GLOBALS['wp_version'], self::MINIMUM_WP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_wp_version' ] );
			return;
		}

		// load plugin text domain
		load_plugin_textdomain( 'form-masks-for-elementor', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		// init if element are initialized
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin and all classes after Elementor and all plugins is loaded.
	 *
	 * @since 1.4
	 *
	 * @access public
	 */
	public function init() {

		if( ! $this->plugin_is_active( 'elementor-pro/elementor-pro.php' ) ) {

			add_action( 'admin_notices', [ $this, 'notice_elementor_pro_inactive' ] );
			return;
		}

		// action fired when plugin is activated and dependencies checked
		do_action( 'fme_init' );

		// required files
		require_once FME_PLUGIN_PATH . '/includes/class-elementor-mask-control.php';

		// register and enqueue scripts
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_plugin_js' ] );
	}

	/**
	 * Enqueue JS
	 *
	 * Register and enqueue JS scripts.
	 *
	 * @since 1.4
	 *
	 * @access public
	 */
	public function enqueue_plugin_js() {

		wp_register_script( 'fme-jquery-mask',  FME_PLUGN_URL . 'assets/lib/jquery.mask.js', array( 'jquery' ), FME_VERSION, true );
		wp_register_script( 'fme-mask', FME_PLUGN_URL . 'assets/js/elementor-mask.js', array( 'jquery' ), FME_VERSION, true );
		wp_enqueue_script( 'fme-jquery-mask' );
		wp_enqueue_script( 'fme-mask' );

		/**
		 * Action for enqueue more scripts or remove current scripts
		 * 
		 * @since 1.5
		 */
		do_action( 'fme_after_enqueue_scripts' );
	}

	/**
	 * Admin notice - Elementor PRO
	 *
	 * Warning when the site doesn't have Elementor PRO activated.
	 *
	 * @since 1.4
	 *
	 * @access public
	 */
	public function notice_elementor_pro_inactive() {

		$message = sprintf(
			esc_html__( '%1$s requires %2$s to be installed and activated.', 'form-masks-for-elementor' ),
			'<strong>Form Masks for Elementor</strong>',
			'<strong>Elementor Pro</strong>'
		);

		printf( '<div class="notice notice-error"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice - PHP
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.4
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			esc_html__( '%1$s requires %2$s version %3$s or greater.', 'form-masks-for-elementor' ),
			'<strong>Form masks for Elementor</strong>',
			'<strong>PHP</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-error"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice - WP
	 *
	 * Warning when the site doesn't have a minimum required WP version.
	 *
	 * @since 1.4
	 *
	 * @access public
	 */
	public function admin_notice_minimum_wp_version() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		
		$message = sprintf(
			esc_html__( '%1$s requires %2$s version %3$s or greater.', 'form-masks-for-elementor' ),
			'<strong>Form masks for Elementor</strong>',
			'<strong>WordPress</strong>',
			 self::MINIMUM_WP_VERSION
		);

		printf( '<div class="notice notice-error"><p>%1$s</p></div>', $message );
	}

	/**
	 * Check plugin is activated
	 * 
	 * @since 1.5
	 * @return boolean
	 * @param string $plugin
	 */
	public function plugin_is_active( $plugin ) {

		return function_exists( 'is_plugin_active' ) ? is_plugin_active( $plugin ) : in_array( $plugin, (array) get_option( 'active_plugins', array() ), true );
	}
}

FME_Init::instance();