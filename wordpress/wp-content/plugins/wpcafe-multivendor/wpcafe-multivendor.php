<?php

defined( 'ABSPATH' ) || exit;

/**
 *  @package wpcafe-multivendor
 */

/*
 * Plugin Name:        WPCafe MultiVendor
 * Plugin URI:         https://product.themewinter.com/wpcafe-multivendor
 * Description:        WordPress Restaurant solution plugin multivendor addon.
 * Version:            1.0.8
 * Author:             Themewinter
 * Author URI:         http://themewinter.com/
 * License:            GPL-2.0+
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:        wpcafe-multivendor
 * Domain Path:       /languages
 */

final class Wpcafe_Multivendor {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	static function version() {
			return '1.0.8';
	}

	/**
	 * Instance of self
	 *
	 * @var Wpcafe_Multivendor
	 */
	private static $instance = null;

	/**
	 * Initializes the Wpcafe_Multivendor() class
	 *
	 * Checks for an existing Wpcafe_Multivendor() instance
	 * and if it doesn't find one, creates it.
	 */
	public static function init() {

		if ( self::$instance === null ) {
				self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instance of Wpcafe Multivendor
	 */
	private function __construct() {

		// Load translation
		add_action( 'init', [$this, 'i18n'] );

		// Instantiate Base Class after plugins loaded.
		add_action( 'plugins_loaded', [$this, 'initialize_modules'], 99999 );

	}

	/**
	 * Initialize Modules
	 *
	 * @since 1.0.0
	 */
	public function initialize_modules() {
			do_action( 'wpcafe_multivendor/before_load' );

			require_once self::plugin_dir() . 'helpers/functions.php';
			require_once self::plugin_dir() . 'bootstrap.php';
			require_once self::plugin_dir() . 'autoloader.php';
			require_once self::plugin_dir() . 'helpers/notice/notice.php';

			\Wpcafe_Multivendor\Autoloader::run();
			\Oxaim\Libs\Notice::init();
			\Wpcafe_Multivendor\Bootstrap::instance()->init();

			do_action( 'wpcafe_multivendor/after_load' );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'wpcafe-multivendor', false, dirname( self::plugins_basename() ) . '/languages/' );
	}

	/**
	 * Plugins Basename
	 *
	 * @since 1.0.0
	 * @var string plugin's basename
	 */
	static function plugins_basename() {
		return plugin_basename( self::plugin_file() );
	}

	/**
	 * Assets Url
	 *
	 * @since 1.0.0
	 * @var string asset folders root url
	 */
	static function templates_url() {
		return trailingslashit( self::plugin_url() . 'templates' );
	}

	/**
	 * Assets Directory
	 *
	 * @since 1.0.0
	 * @var string asset folders root directory
	 */
	static function templates_dir() {
		return trailingslashit( self::plugin_dir() . 'templates' );
	}

	/**
	 * Assets Url
	 *
	 * @since 1.0.0
	 * @var string asset folders root url
	 */
	static function assets_url() {
		return trailingslashit( self::plugin_url() . 'assets' );
	}

	/**
	 * Assets Directory
	 *
	 * @since 1.0.0
	 * @var string asset folders root directory
	 */
	static function assets_dir() {
		return trailingslashit( self::plugin_dir() . 'assets' );
	}

	/**
	 * Core Url
	 *
	 * @since 1.0.0
	 * @var string core folder's root url.
	 */
	static function core_url() {
		return trailingslashit( self::plugin_url() . 'core' );
	}

	/**
	 * Core Directory
	 *
	 * @since 1.0.0
	 * @var string core folder's root directory.
	 */
	static function core_dir() {
		return trailingslashit( self::plugin_dir() . 'core' );
	}

	/**
	 * Plugin Url
	 *
	 * @since 1.0.0
	 * @var string plugin's root directory url
	 */
	static function plugin_url() {
		return trailingslashit( plugin_dir_url( self::plugin_file() ) );
	}

	/**
	 * Plugin Directory
	 *
	 * @since 1.0.0
	 * @var string plugin's root directory path
	 */
	static function plugin_dir() {
		return trailingslashit( plugin_dir_path( self::plugin_file() ) );
	}

	/**
	 * Plugin file
	 *
	 * @since 1.0.0
	 * @var string plugin's root file
	 */
	static function plugin_file() {
		return __FILE__;
	}

}

/**
 * Load Wpcafe Multivendor Addon when all plugins are loaded
 *
 * @return Wpcafe_Multivendor
 */
function wpcafe_multivendor() {
  return Wpcafe_Multivendor::init();
}

// Let's Go...
wpcafe_multivendor();
