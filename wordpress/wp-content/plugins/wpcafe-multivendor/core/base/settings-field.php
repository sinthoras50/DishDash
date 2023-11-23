<?php

namespace Wpcafe_Multivendor\Core\Base;

defined( "ABSPATH" ) || exit;

use WpCafe\Traits\Wpc_Singleton;

	/**
	 * Settings action.
	 */
class Settings_Field {

	use Wpc_Singleton;

	/**
	 * Submit action of settings.
	 */
	public function form_handler() {

			$post_data  = wp_unslash( $_POST );

			$nonce      = isset( $post_data['_wpnonce'] ) ? $post_data['_wpnonce'] : '';
			$user_id    = dokan_get_current_user_id();

			if ( !wp_verify_nonce( $nonce, 'dokan_cafe_settings_settings_nonce' ) ) {
					return;
			}

			$allow_vendor_product_add_ons = !empty( $post_data['allow_vendor_product_add_ons'] ) ? sanitize_text_field( $post_data['allow_vendor_product_add_ons'] ) : "";
			$allow_vendor_food_location = !empty( $post_data['allow_vendor_food_location'] ) ? sanitize_text_field( $post_data['allow_vendor_food_location'] ) : "";
			$food_style                 = !empty( $post_data['storefront_template'] ) ? sanitize_text_field( $post_data['storefront_template'] ) : "";
			$delivery_location          = !empty( $post_data['delivery_location'] ) ?  array_map( 'sanitize_text_field', $post_data['delivery_location'] ) : [] ;

			// food discount settings.
			$discount_percentage        = !empty( $post_data['wpc_pro_discount_percentage'] ) ? sanitize_text_field( $post_data['wpc_pro_discount_percentage'] ) : "";
			$standarad_off_amount       = !empty( $post_data['wpc_pro_order_standarad_off_amount'] ) ? sanitize_text_field( $post_data['wpc_pro_order_standarad_off_amount'] ) : "";
			$standarad_off              = !empty( $post_data['wpc_pro_discount_standarad_off'] ) ? sanitize_text_field( $post_data['wpc_pro_discount_standarad_off'] ) : "";
			$standarad_off_message      = !empty( $post_data['standarad_off_message'] ) ? sanitize_text_field( $post_data['standarad_off_message'] ) : "";
			$include_menu               = !empty( $post_data['wpc_pro_include_menu'] ) ?  array_map( 'sanitize_text_field', $post_data['wpc_pro_include_menu'] ) : [] ;
			$include_cat                = !empty( $post_data['wpc_pro_include_cat'] ) ?  array_map( 'sanitize_text_field', $post_data['wpc_pro_include_cat'] ) : [] ;

			$input_arr = array(
					'allow_vendor_product_add_ons'  => $allow_vendor_product_add_ons,
					'allow_vendor_food_location'    => $allow_vendor_food_location,
					'storefront_template'           => $food_style,
					'delivery_location'             => $delivery_location ,
					'wpc_pro_discount_percentage'   => $discount_percentage ,
					'wpc_pro_include_menu'          => $include_menu ,
					'wpc_pro_include_cat'           => $include_cat ,
					'wpc_pro_order_standarad_off_amount'    => $standarad_off_amount ,
					'wpc_pro_discount_standarad_off'        => $standarad_off ,
					'standarad_off_message'         => $standarad_off_message ,
			);

			update_user_meta( $user_id, 'dokan_wpcafe_settings', $input_arr );

			wp_send_json_success( array(
					'msg' => esc_html__( 'Your information has been saved successfully', 'wpcafe-multivendor' ),
			) );
	}

}
