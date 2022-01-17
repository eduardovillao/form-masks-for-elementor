<?php

namespace FME\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Form Mask Elementor Class
 *
 * Class to initialize the plugin.
 *
 * @since 1.4
 */
final class FME_Plugin {

	/**
	 * Instance
	 *
	 * @since 1.4
	 *
	 * @access private
	 * @static
	 *
	 * @var FME_Plugin The single instance of the class.
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
	 * @return FME_Plugin An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Disable class cloning and throw an error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object. Therefore, we don't want the object to be cloned.
	 *
	 * @access public
	 * @since 1.6
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'form-masks-for-elementor' ), '1.6' );
	}

	/**
	 * Disable unserializing of the class.
	 *
	 * @access public
	 * @since 1.6
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'form-masks-for-elementor' ), '1.6' );
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

        /**
         * Check Elementor Por is actived
         */
		if( ! $this->plugin_is_active( 'elementor-pro/elementor-pro.php' ) ) {

			add_action( 'admin_notices', [ $this, 'notice_elementor_pro_inactive' ] );
			return;
		}

		// action fired when plugin is activated and dependencies/requirements are checked
		do_action( 'fme_init' );

		// required files
		require_once FME_PLUGIN_PATH . '/includes/class-elementor-mask-control.php';
        
        // instanciate mask control class
        new FME_Elementor_Forms_Mask;

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

		$html_message = sprintf( '<div class="notice notice-error"><p>%1$s</p></div>', $message );
        echo wp_kses_post( $html_message );
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

FME_Plugin::instance();