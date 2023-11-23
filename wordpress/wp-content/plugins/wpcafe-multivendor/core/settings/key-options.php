<?php
namespace Wpcafe_Multivendor\Core\Settings;

defined( "ABSPATH" ) || exit;
/**
* Get Menu.
*/
class Key_Options {

	use \Wpcafe_Multivendor\Traits\Singleton;

	public $settings_field;

	/**
	 * Settings field
	 *
	 * @return void
	 */
	public function init() {
			add_filter( 'dokan_get_dashboard_nav', [$this,'wpcafe_multivendor_add_vendor_cafe_menu'] );
			add_filter( 'dokan_query_var_filter', [$this , 'wpcafe_multivendor_load_vendor_cafe_menu'] );

			// load settings template.
			add_action( 'dokan_load_custom_template', [$this,'wpcafe_multivendor_vendor_load_template'] );

	}

	/**
	 * Add query variable.
	 *
	 * @param [type] $query_vars get param.
	 */
	public function wpcafe_multivendor_load_vendor_cafe_menu( $query_vars ) {
			$query_vars['wpcafe']           = 'wpcafe';

			return $query_vars;
	}

	/**
	 * Add cafe menu
	 *
	 * @param [type] $urls get param.
	 */
	public function wpcafe_multivendor_add_vendor_cafe_menu( $urls ) {

		$urls['wpcafe'] = array(
				'title' => esc_html__( 'WPCafe Settings', 'wpcafe-multivendor'),
				'icon'  => '<i class="wpcafe-logo_icon"></i>',
				'url'   => dokan_get_navigation_url( 'wpcafe/cafe_settings' ),
				'pos'   => 51
		);

		$urls = apply_filters( 'cafe_multi_vendor/addons' , $urls );

		return $urls;
	}

	/**
	 * Load cafe  template in dokan vendor settings.
	 *
	 * @param [type] $query_vars get param.
	 * @return void
	 */
	public function wpcafe_multivendor_vendor_load_template( $query_vars ){
			$user_id        = get_current_user_id();

			if ( isset( $query_vars['wpcafe'] ) && 'cafe_settings' === $query_vars['wpcafe'] ) {
					if ( ! current_user_can( 'dokan_view_store_settings_menu' ) ) {
							dokan_get_template_part ('global/dokan-error', '', [
									'deleted' => false,
									'message' => __( 'You have no permission to view this page', 'wpcafe-multivendor' )
							] );
					} else {
							require_once \Wpcafe_Multivendor::core_dir(). 'settings/part/settings.php';
					}
			}

			if ( isset( $query_vars['wpcafe'] ) && 'addons' === $query_vars['wpcafe'] ) {
				if ( ! current_user_can( 'dokan_view_store_settings_menu' ) ) {
						dokan_get_template_part ('global/dokan-error', '', [
								'deleted' => false,
								'message' => __( 'You have no permission to view this page', 'wpcafe-multivendor' )
						] );
				} else {
						require_once \Wpcafe_Multivendor::core_dir(). 'modules/product-addons/views/settings.php';
				}
		}

	}


}

