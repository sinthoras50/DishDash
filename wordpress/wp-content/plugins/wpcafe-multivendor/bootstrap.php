<?php

namespace Wpcafe_Multivendor;

defined( 'ABSPATH' ) || die();
/**
 * Plugin Main activities
 */
class Bootstrap {

	private static $instance;

	/**
	 * Create singleton
	 */
	public static function instance() {

		if ( !self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Check dependency
	 *
	 * @return void
	 */
	public function init() {

			// action plugin instance class
			if ( !did_action( 'wpcafe/after_load' ) ) {
					$this->handle_wpcafe_dependency();
					return;
			}

			if ( !class_exists( 'WeDevs_Dokan' ) ) {
					$this->handle_dokan_dependency();
					return;
			}

			// fire in every plugin load action.
			$this->init_plugin();
	}

	/**
	 * Handle wpcafe_multivendor admin notice depending on settings
	 *
	 * @return void
	 */
	public function init_plugin() {

			\Wpcafe_Multivendor\Core\Enqueue\Enqueue::instance()->init();

			\Wpcafe_Multivendor\Core\Core::instance()->init();

			( new \Wpcafe_Multivendor\Core\Hooks\Hooks() )->init();

			// Frontend actions.
			\Wpcafe_Multivendor\Core\Core::instance()->cafe_vendor_modules();
	}

	/**
	 * Handle wpcafe_multivendor admin notice depending on settings
	 *
	 * @return void
	 */
	public function handle_wpcafe_dependency() {
			add_action( 'admin_head', [$this, 'admin_notice_wpcafe_not_active'] );
			return;
	}

	/**
	 * Show notice if wpcafe not active
	 */
	public function admin_notice_wpcafe_not_active() {

			if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
			}

			$btn = [
					'default_class' => 'button',
					'class'         => 'button-primary ',
			];

			if ( file_exists( WP_PLUGIN_DIR . '/wp-cafe/wpcafe.php' ) ) {
					$btn['text'] = esc_html__( 'Activate WPCafe', 'wpcafe-multivendor' );
					$btn['url']  = wp_nonce_url( 'plugins.php?action=activate&plugin=wp-cafe/wpcafe.php&plugin_status=all&paged=1', 'activate-plugin_wp-cafe/wpcafe.php' );
			} else {
					$btn['text'] = esc_html__( 'Install WPCafe', 'wpcafe-multivendor' );
					$btn['url']  = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=wp-cafe' ), 'install-plugin_wp-cafe' );
			}

			\Oxaim\Libs\Notice::instance( 'wpcafe-multivendor', 'unsupported-wpcafe-version' )
					->set_class( 'error' )
					->set_dismiss( 'global', ( 3600 * 24 * 30 ) )
					->set_message( sprintf( esc_html__( 'WPCafe Multivendor requires WpCafe to get all features, which is currently NOT RUNNING.', 'wpcafe-multivendor' ) ) )
					->set_button( $btn )
					->call();
	}

	/**
	 * Handle dokan admin notice depending on settings
	 *
	 * @return void
	 */
	public function handle_dokan_dependency() {
			add_action( 'admin_head', [$this, 'admin_notice_dokan_not_active'] );
			return;
	}

	/**
	 * Show notice if wpcafe not active
	 */
	public function admin_notice_dokan_not_active() {

			if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
			}

			$btn = [
					'default_class' => 'button',
					'class'         => 'button-primary ',
			];

			if ( file_exists( WP_PLUGIN_DIR . '/dokan-lite/dokan.php' ) ) {
					$btn['text'] = esc_html__( 'Activate Dokan', 'wpcafe-multivendor' );
					$btn['url']  = wp_nonce_url( 'plugins.php?action=activate&plugin=dokan-lite/dokan.php&plugin_status=all&paged=1', 'activate-plugin_dokan-lite/dokan.php' );
			} else {
					$btn['text'] = esc_html__( 'Install Dokan', 'wpcafe-multivendor' );
					$btn['url']  = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=dokan-lite' ), 'install-plugin_dokan-lite' );
			}

			\Oxaim\Libs\Notice::instance( 'wpcafe-multivendor', 'unsupported-dokan-version' )
					->set_class( 'error' )
					->set_dismiss( 'global', ( 3600 * 24 * 30 ) )
					->set_message( sprintf( esc_html__( 'WPCafe Multivendor requires Dokan to get all features, which is currently NOT RUNNING.', 'wpcafe-multivendor' ) ) )
					->set_button( $btn )
					->call();
	}

}
