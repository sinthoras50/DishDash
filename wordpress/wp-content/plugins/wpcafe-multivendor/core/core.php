<?php
namespace Wpcafe_Multivendor\Core;

defined( "ABSPATH" ) || exit;

/**
 * Load all admin class
 */
class Core {

	use \WpCafe\Traits\Wpc_Singleton;

	/**
	 *  Call admin function
	 */
	public function init() {
		// Register all menu.
		\Wpcafe_Multivendor\Core\Settings\Key_Options::instance()->init();

		// Settings field.
		$settings_field = \Wpcafe_Multivendor\Core\Base\Settings_Field::instance();
		$this->dispatch_actions( $settings_field );
	}

	/**
	 * Save settings
	 */
	public function dispatch_actions( $settings_field ) {
		add_action( 'wp_ajax_dokan_settings', [ $settings_field , 'form_handler' ] , 5  );
	}

	/**
	 *  Call frontend init function
	 */
	public function cafe_vendor_modules() {
		// Food location hooks.
		\Wpcafe_Multivendor\Core\Modules\Food_Menu\Food_Location::instance()->init();

		$user_id = dokan_get_current_user_id();
		$vendor_settings = get_user_meta( $user_id, 'dokan_wpcafe_settings', true );
		$allow_vendor_product_add_ons = !empty( $vendor_settings['allow_vendor_product_add_ons'] ) &&  $vendor_settings['allow_vendor_product_add_ons'] =="on" ? "checked" : "";
		if( ('checked' === $allow_vendor_product_add_ons) && class_exists( 'Wpcafe_Pro' ) ){
			// Product addons.
			\Wpcafe_Multivendor\Core\Modules\Product_Addons\Product_Addons::instance()->init();
		}
	}

}
