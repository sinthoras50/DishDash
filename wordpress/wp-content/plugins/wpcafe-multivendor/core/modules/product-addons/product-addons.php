<?php
namespace Wpcafe_Multivendor\Core\Modules\Product_Addons;

defined( "ABSPATH" ) || exit;

use Wpcafe_Multivendor\Traits\Singleton;

/**
 * Product addnos module.
 */
class Product_Addons {

	use Singleton;
	/**
	 * Call hooks
	 */
	public function init() {
		add_filter( 'cafe_multi_vendor/addons', array( $this, 'load_addons_menu' ), 10 , 1);
		add_action('init', array( $this , 'save_vendor_addons' ) );
	}

	/**
	 * Load Settings Menu for Pro
	 *
	 * @since 2.4
	 *
	 * @param  array $urls get urls.
	 *
	 * @return array
	 */
	public function load_addons_menu( $urls ) {
		if ( class_exists('Wpcafe_Pro') ) {
			$urls['wpcafe_addons'] = array(
				'title' => esc_html__( 'WPCafe Product Addons', 'wpcafe-multivendor'),
				'icon'  => '<i class="wpcafe-logo_icon"></i>',
				'url'   => dokan_get_navigation_url( 'wpcafe/addons' ),
				'pos'   => 52
			);
		}

		return $urls;
	}

	/**
	 * Save vendor data
	 */
	public function save_vendor_addons() {
		// Product addons.
		if ( ! is_admin() && isset( $_POST['wpcafe_product_addons'] ) ) {

				$request = filter_input_array( INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS );

				if ( ! check_admin_referer( 'wpcafe-product-addons', 'wpcafe-product-addons' ) ) {
						return;
				}

				update_option('wpcafe_product_addons_'. get_current_user_id() , $request );
		}
	}

}
