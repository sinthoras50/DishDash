<?php

namespace Wpcafe_Multivendor\Core\Hooks;

use Wpcafe_Multivendor\Traits\Singleton;

defined( 'ABSPATH' ) || exit;

/**
 * Fire Hooks
 */
class Hooks {

	use Singleton;

	public $query_vars        = array();
	public $custom_store_url  = '';

	/**
	 * Fire Hooks.
	 */
	public function init() {

			// WP Cafe, Dokan & WooCommerce must be enabled
			if ( !class_exists( 'WeDevs_Dokan' ) || !class_exists( 'WooCommerce' ) || !did_action( 'wpcafe/after_load' )) {
					return;
			}

			$this->custom_store_url = dokan_get_option( 'custom_store_url', 'dokan_general', 'store' );

			add_filter( 'dokan_store_tabs', [ $this, 'add_tab_storefront_wpcafe_settings'], 9, 2);

			add_filter( 'template_include', [ $this, 'add_template_storefront_wpcafe_settings' ], 999 );

			// set store front template from vendor saved settings
			add_filter( 'template_include', [ $this, 'store_wpcafe_template' ], 998 );

			// add wrapper to mini cart on vendor dashboard page
			add_action('wpc_before_minicart', [$this, 'add_minicart_wrapper_before_for_dashboard'], 10);
			add_action('wpc_after_minicart', [$this, 'add_minicart_wrapper_after_for_dashboard'], 10);

			add_action('wpc_before_admin_location_settings', [$this, 'wpc_before_admin_location_settings'], 10);
			add_action('wpc_after_admin_location_settings', [$this, 'wpc_after_admin_location_settings'], 10);
			// features for WP Cafe Pro
			if( did_action( 'wpcafe_pro/after_load' ) ) {

						add_action('wpc_pro_before_discount_settings', [$this, 'wpc_pro_before_discount_settings']);
						add_action('wpc_pro_after_discount_settings', [$this, 'wpc_pro_after_discount_settings']);

			}

			add_filter( 'wpcafe_multivendor_seller', [ $this, 'dokan_product_sold_by' ], 998 );

	}

	/**
	 * Location settings.
	 */
	public function wpc_before_admin_location_settings() {
			?>
			<div class="wpcafe-multivendor-admin-location-text">
					<?php echo esc_html__( 'Location settings will be applied from vendor panel. Deactivate multivendor add-on to use this option from admin panel', 'wpcafe-multivendor' )?>
			</div>
			<div class="wpcafe-multivendor disable-admin-location-settings">
			<?php
	}

	/**
	 * Location settings.
	 */
	public function wpc_after_admin_location_settings() {
			?>
			</div>
			<?php
	}

	/**
	 * Location settings.
	 *
	 * @param [type] $product_id get product id.
	 */
	public function get_vendor_id( $product_id ) {
		$seller     = get_post_field( 'post_author', $product_id );
		$author     = get_user_by( 'id', $seller );
		$vendor_id  = ! empty( $author ) ? $author->ID : null;

		return $vendor_id;
	}

	/**
	 * Location settings.
	 *
	 * @param [type] $product_id get product id.
	 */
	public function dokan_product_sold_by( $product_id ) {
		$seller = get_post_field('post_author', $product_id);
		$author = get_user_by('id', $seller);
		$vendor = dokan()->vendor->get($seller);

		$store_info = dokan_get_store_info($author->ID);

		if(!empty($store_info['store_name'])) : ?>
			<div class="store-name">
				<a href="<?php echo esc_url($vendor->get_shop_url()); ?>"> 
					<?php echo esc_html($vendor->get_shop_name()); ?>
				</a>
			</div>
		<?php endif;
	}

	/**
	 * Add Wrapper Before Discount Settings
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function wpc_pro_before_discount_settings() {
			?>
			<div class="wpcafe-multivendor-admin-discount-text">
					<?php echo esc_html__( 'Discount settings will be applied from vendor panel. Deactivate multivendor add-on to use this option from admin panel', 'wpcafe-multivendor' )?>
			</div>
			<div class="wpcafe-multivendor disable-admin-discount-settings">
			<?php
	}

	/**
	 * Add Wrapper After Discount Settings
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function wpc_pro_after_discount_settings() {
			?>
			</div>
			<?php
	}

	/**
	 * Add Wrapper Before Mini-cart.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_minicart_wrapper_before_for_dashboard() {
			if(did_action( 'dokan_dashboard_wrap_start' )){
					?>
					<div class="wpcafe-multivendor-dashboard">
					<?php
			}
	}

	/**
	 * Add Wrapper After Mini cart
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function add_minicart_wrapper_after_for_dashboard() {
		if( did_action( 'dokan_dashboard_wrap_start' ) ) {
				?>
				</div>
				<?php
		}
	}

	/**
	 * Add template.
	 *
	 * @param [type] $data1 get param.
	 * @param [type] $data2 get param.
	 */
	public function add_template_order_details( $data1, $data2 ) {
			return \Wpcafe_Multivendor::templates_dir() . 'orders/order-item-html.php';
	}

	/**
	 * Vendor store template
	 *
	 * @param [type] $template
	 *
	 * @since 1.0.0
	 *
	 * @return template
	 */
	public function store_wpcafe_template( $template ){

		if( get_query_var( $this->custom_store_url ) && !get_query_var( 'toc' ) && !get_query_var( 'store_review' ) ){

			$store_name = get_query_var( $this->custom_store_url );

			if ( ! $this->is_woo_installed() ) {
					return $template;
			}

			if ( ! empty( $store_name ) ) {
					$store_user = get_user_by( 'slug', $store_name );

					if ( ! $store_user ) {
							return get_404_template();
					}

					// Bell out for Vendor Stuff extensions
					if ( ! is_super_admin( $store_user->ID ) && user_can( $store_user->ID, 'vendor_staff' ) ) {
							return get_404_template();
					}

					// no user found
					if ( ! $store_user ) {
							return get_404_template();
					}

					// check if the user is seller
					if ( ! dokan_is_user_seller( $store_user->ID ) ) {
							return get_404_template();
					}

					$store_wpcafe_settings          = get_user_meta( $store_user->ID, 'dokan_wpcafe_settings', true );
					$allow_vendor_food_location     = !empty( $store_wpcafe_settings['allow_vendor_food_location'] )  ? "on" : "";
					if ( $allow_vendor_food_location == "on" ) {
							$wpc_location_arr       = !empty( $store_wpcafe_settings['delivery_location'] ) ? $store_wpcafe_settings['delivery_location'] : [];
							$location_array         = wpcafe_multivendor_prepare_location_array($wpc_location_arr);
							\WpCafe\Core\Shortcodes\Template_Functions::modal_markup( $location_array, $store_user->ID );
					}
					?>
					<div class="wpcafe_modal">
							<?php
							if( empty( $store_wpcafe_settings['storefront_template'] ) || 'default' == $store_wpcafe_settings['storefront_template'] ){
									return dokan_locate_template( 'store.php' );
							} else {
									$template_name = $store_wpcafe_settings['storefront_template'];
									$storefront_settings_template_dir = trailingslashit( \Wpcafe_Multivendor::templates_dir() . 'store-front/menu-style' );
									return dokan_locate_template( "$template_name.php", $storefront_settings_template_dir, $storefront_settings_template_dir );
							}
							?>
					</div>
					<?php
			}
		}

		return $template;
	}

	/**
	 * Add Store Details Settings To Vendor Store Front
	 *
	 * @param [type] $tabs  get tab.
	 * @param [type] $store_id get store id.
	 * @since 1.0.0
	 */
	public function add_tab_storefront_wpcafe_settings( $tabs, $store_id) {
			$tabs['vendor_wpcafe_settings'] = [
					'title' => esc_html__('Restaurant Settings', 'wpcafe-multivendor'),
					'url'   => wpcafe_multivendor_get_vendor_settings( $store_id ),
			];
			return $tabs;
	}

	/**
	 * Returns the terms_and_conditions template
	 *
	 * @param string $template
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function add_template_storefront_wpcafe_settings( $template ) {

			if ( !function_exists( 'WC' ) ) {
					return $template;
			}
			
			if ( !empty( $_GET['store_front'] ) && 'wpc_store_settings' == $_GET['store_front'] ) {

					$storefront_settings_template_dir = trailingslashit( \Wpcafe_Multivendor::templates_dir() . 'store-front/wpcafe-settings' );
					return dokan_locate_template( 'store-settings.php', $storefront_settings_template_dir, $storefront_settings_template_dir );
			}

			return $template;
	}

	/**
	 * Check if WooCommerce installed or not
	 *
	 * @since 1.0.0
	 * 
	 * @return boolean
	 */
	public function is_woo_installed() {
			return function_exists( 'WC' );
	}

}
