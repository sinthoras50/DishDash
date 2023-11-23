<?php
namespace Wpcafe_Multivendor\Core\Enqueue;

defined( 'ABSPATH' ) || exit;

use WpCafe\Traits\Wpc_Singleton;
use Wpcafe_Multivendor;

/**
 * Enqueue all css and js file class
 */
class Enqueue {

		use Wpc_Singleton;

	/**
	 * Main calling function.
	 */
	public function init() {
			// backend asset.
			add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_assets'] );
			// frontend asset.
			add_action( 'wp_enqueue_scripts', [$this, 'frontend_enqueue_assets'] );
	}


	/**
	 * All js files function.
	 */
	public function admin_get_scripts() {
			$script_arr =  array(
					'wpcafe-multivendor'     => array(
							'src'     => \Wpcafe_Multivendor::assets_url() . 'js/admin.js',
							'version' => \Wpcafe_Multivendor::version(),
							'deps'    => ['jquery'],
					),
			);

			return $script_arr;
	}

	/**
	 * All css files function.
	 */
	public function admin_get_styles() {
			return array(
					'wpcafe-multivendor' => array(
							'src'     => \Wpcafe_Multivendor::assets_url() . 'css/admin.css',
							'version' => \Wpcafe_Multivendor::version(),
					),
			);
	}

	/**
	 * All js files function.
	 */
	public function frontend_get_scripts() {

			$script_arr = array(
					'wpcafe-multivendor-public'  => array(
							'src'     => \Wpcafe_Multivendor::assets_url() . 'js/public.js',
							'version' => \Wpcafe_Multivendor::version(),
							'deps'    => ['jquery'],
					)
			);

			if(class_exists('Wpcafe_Pro')){
				$script_arr['wpcafe-multivendor-addons'] = array(
						'src'     => \Wpcafe_Pro::core_url() . 'modules/product-addons/assets/js/admin.js',
						'version' => \Wpcafe_Multivendor::version(),
						'deps'    => ['jquery'],
				);
			}

			return $script_arr;

	}

	/**
	 * All css files function.
	 */
	public function frontend_get_styles() {
			$enequeue =  array(
				'wpcafe-multivendor-public' => array(
					'src'     => \Wpcafe_Multivendor::assets_url() . 'css/public.css',
					'version' => \Wpcafe_Multivendor::version(),
				)
			);

			return $enequeue;
	}

	/**
	 * Enqueue admin js and css function
	 *
	 * @param  $var
	 */
	public function admin_enqueue_assets() {
			wp_enqueue_style( 'wpcafe-multivendor', \Wpcafe_Multivendor::assets_url() . 'css/admin.css', [], \Wpcafe_Multivendor::version(), 'all' );

			// js
			$scripts = $this->admin_get_scripts();

			foreach ( $scripts as $key => $value ) {
				$deps       = !empty( $value['deps'] ) ? $value['deps'] : false;
				$version    = !empty( $value['version'] ) ? $value['version'] : false;
				wp_enqueue_script( $key, $value['src'], $deps, $version, true );
			}

			// css
			$styles = $this->admin_get_styles();

			foreach ( $styles as $key => $value ) {
					$deps       = isset( $value['deps'] ) ? $value['deps'] : false;
					$version    = !empty( $value['version'] ) ? $value['version'] : false;
					wp_enqueue_style( $key, $value['src'], $deps, $version, 'all' );
			}
	}

	/**
	 * Enqueue admin js and css function.
	 */
	public function frontend_enqueue_assets() {

		if ( dokan_is_seller_dashboard() ) {
			// css.
			$styles = $this->frontend_get_styles();

			foreach ( $styles as $key => $value ) {
					$deps = isset( $value['deps'] ) ? $value['deps'] : false;
					$version    = !empty( $value['version'] ) ? $value['version'] : false;
					wp_enqueue_style( $key, $value['src'], $deps, $version, 'all' );
			}

			// js.
			$scripts = $this->frontend_get_scripts();

			foreach ( $scripts as $key => $value ) {
					$deps       = isset( $value['deps'] ) ? $value['deps'] : false;
					$version    = !empty( $value['version'] ) ? $value['version'] : false;

					wp_enqueue_script( $key, $value['src'], $deps, $version, true );
			}
			$translation_data = array(
					'ajax_url'              => admin_url( 'admin-ajax.php' ),
					'add_pao_nonce'         => wp_create_nonce( 'add_pao_nonce_value' ),
					'remove_pao_nonce'      => wp_create_nonce( 'remove_pao_nonce_value' ),
					'add_option_nonce'      => wp_create_nonce( 'add_option_nonce_value' ),
					'remove_option_nonce'   => wp_create_nonce( 'remove_option_nonce_value' ),
					'addons'                => array( 'option_name'=> esc_html__('Please fill the option field','wpcafe-multivendor') ,
					'pao_title'=> esc_html__('Please fill the title field','wpcafe-multivendor') ),
					'repeater_text'         => array('opt_name'=> esc_html__('Option name'), 'def_select' => esc_html__('Default selected','wpcafe-pro'),
					'qty_based' => esc_html__('Quantity Based','wpcafe-pro'))
			);

			//Added active class in the wpcafe menu in dokan leftmenu.

			global $wp;
			$active_menu = '';
			if ( isset( $wp->query_vars['wpcafe'] ) ) {
				$active_menu = $wp->query_vars['wpcafe'];
			}
			wp_add_inline_script( 'wpcafe-multivendor-public', 'var wpcafe_active_menu = ' . wp_json_encode( $active_menu ), 'before' );
			wp_localize_script( 'wpcafe-multivendor-addons', 'wpc_pro_pao_obj', $translation_data );

		}
	}

}


