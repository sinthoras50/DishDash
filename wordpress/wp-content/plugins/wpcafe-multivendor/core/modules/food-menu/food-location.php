<?php
namespace Wpcafe_Multivendor\Core\Modules\Food_Menu;

defined( "ABSPATH" ) || exit;

use Wpcafe_Multivendor\Traits\Singleton;
	/**
	 * Food location hooks
	 */
class Food_Location {
		use Singleton;

	/**
	 * Call hooks
	 */
	public function init() {
		//add food location tag in dokan add new product form
		add_action('dokan_product_edit_after_product_tags', [ $this , 'show_on_edit_page' ],99,2);

		// add and update product food location of dokan product
		add_action( 'dokan_new_product_added', [ $this , 'save_add_product_meta'], 10, 2 );

		add_action( 'dokan_product_updated', [ $this , 'save_add_product_meta'], 10, 2 );
		
		//food location in order details page
		add_action( 'dokan_order_details_after_customer_info', [ $this , 'food_order_location' ] );
		

		// if multivendor addon activated, then remove hooks related to single vendor 
		remove_action('woocommerce_checkout_before_customer_details', [ \WpCafe\Core\Shortcodes\Hook::instance(), 'wpc_location_checkout_form' ], 10);
		remove_action('woocommerce_checkout_process', [ \WpCafe\Core\Shortcodes\Hook::instance(), 'wpc_validate_location'], 10);
		remove_action('woocommerce_checkout_create_order', [ \WpCafe\Core\Shortcodes\Hook::instance(), 'wpc_location_update_meta'], 10, 2);
		
		// then add hooks for multivendor
		add_action('woocommerce_checkout_before_customer_details', [ $this, 'wpc_location_checkout_form' ], 10);
		add_action('woocommerce_checkout_process', [$this, 'wpc_validate_location']);
		add_action('woocommerce_checkout_create_order', [$this, 'wpc_location_update_meta'], 10, 1);

		// features for WP Cafe Pro
		if( did_action( 'wpcafe_pro/after_load' ) ){

				// override thankyou page vendor order location
				add_filter('wpcafe_pro/render/thankyou_order_location', [$this, 'thankyou_order_location_text'], 9, 2);
		}
	}

	/**
	 * Show food location in vendor order details page
	 *
	 * @param [type] $order get order object.
	 * @return void
	 */
	public function food_order_location( $order ) {
		if ( !empty( $order ) ) {
				$order_meta = get_post_meta($order->get_id());

				if ( !empty( $order_meta['wpc_location_name'] ) && !empty( $order_meta['wpc_location_name'][0] ) ) {
						$data = $order_meta['wpc_location_name'];
						foreach ($data as $key => $value) {
								$get_data = unserialize( $value  ); 
								?>
								<li>
										<span><?php esc_html_e( 'Food Delivery Location : ','wpcafe-multivendor')?></span>
										<?php echo esc_html( ucwords($get_data[dokan_get_current_user_id()]) ) ?>
								</li>
								<?php
						}
				}
		}
	}

	/**
	 * Validate Vendor Location
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function wpc_validate_location() {

			if( isset( $_POST['wpc_location_vendor_id'] ) && is_array( $_POST['wpc_location_vendor_id'] ) ){

					$post_arr       = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
					$total_length   = count( $post_arr['wpc_location_vendor_id'] );

					for( $i = 0; $i < $total_length; $i++ ){
							if( empty( $_POST['wpc_location_location_id'][$i] ) ){
									$vendor_name = get_the_author_meta( 'display_name', $post_arr['wpc_location_vendor_id'][$i] );
									wc_add_notice(esc_html__("Please select location for {$vendor_name}", 'wpcafe-multivendor'), 'error');
							}
					}
			}
	}

	/**
	 * Update location select option
	 *
	 * @param [type] $order get order.
	 *
	 * @since 1.0.0
	 */
	public function wpc_location_update_meta( $order ) {
			if( isset( $_POST['wpc_location_vendor_id'] ) && is_array( $_POST['wpc_location_vendor_id'] ) ){
					
					$post_arr       = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
					$total_length   = count( $post_arr['wpc_location_vendor_id'] );
					$location_array = [];
					for( $i = 0; $i < $total_length; $i++ ){

							if( !empty( $_POST['wpc_location_location_id'][$i] ) ){
									
									$vendor_id                  = $post_arr['wpc_location_vendor_id'][$i];
									$vendor_location            = $post_arr['wpc_location_location_id'][$i];
									$location_array[$vendor_id] = $vendor_location;
							}
					}
					$order->update_meta_data('wpc_location_name', $location_array);
			}
	}

	/**
	 * Location On Checkout Form
	 *
	 * @since 1.0.0
	 *
	 * @var html markup for location form
	 */
	public function wpc_location_checkout_form() {
			$checkout = WC()->checkout;
			$cart = WC()->cart;
			$vendors = [];
			?>
			<div class="wpcafe-multivendor checkout-location-container">
					<?php
					foreach( $cart->cart_contents as $single_cart_item ){
	
							$author_id = get_post_field( 'post_author', $single_cart_item['product_id'] );
							$vendor_location_enabled = !empty(get_user_meta( $author_id, 'dokan_wpcafe_settings', true )['allow_vendor_food_location']) ? true : false;
							
							if( !in_array( $author_id, $vendors ) && $vendor_location_enabled ){
									
									array_push( $vendors, $author_id );
									// get vendor location
									$store_wpcafe_settings  = get_user_meta( $author_id, 'dokan_wpcafe_settings', true );
									$wpc_location_arr       = !empty( $store_wpcafe_settings['delivery_location'] ) ? $store_wpcafe_settings['delivery_location'] : [];
									$location_array         = wpcafe_multivendor_prepare_location_array($wpc_location_arr);
									?>
									<div class="wpc_vendor_location_field">
											<?php
											woocommerce_form_field("wpc_location_vendor_id[]", [
													'type'        => 'hidden',
													'class'       => ['wpc-location form-row-wide'],
													'required'    => true,
													'default'       => $author_id,
											], $checkout->get_value("wpc_location_vendor_id[]"));
	
											woocommerce_form_field("wpc_location_location_id[]", [
													'type'        => 'select',
													'class'       => ['wpc-location form-row-wide'],
													'label'       => esc_html__('Order location: ', 'wpcafe-multivendor'). get_the_author_meta( 'display_name', $author_id ),
													'required'    => true,
													'options'     => $location_array,
											], $checkout->get_value("wpc_location_location_id[]"));
											?>
									</div>
									<?php
							}
					}
					?>
			</div>
			<?php
	}

	/**
	 * Show food location dropdown list
	 *
	 * @param object $post post object.
	 * @param int    $post_id post id.
	 */
	public function show_on_edit_page( $post, $post_id ) {
			$user_id        = get_current_user_id();
			$vendor_settings= get_user_meta( $user_id, 'dokan_wpcafe_settings', true );
			$wpc_locations  = !empty( $vendor_settings['delivery_location'] ) ?  $vendor_settings['delivery_location']  : [];
			$food_location  = get_post_meta( $post_id, 'food_location', true );
			$preparing_time = get_post_meta( $post_id, 'wpc_pro_preparing_time', true ) ;
			$delivery_time  = get_post_meta( $post_id, 'wpc_pro_delivery_time', true );

			// Pro - show food preparing and delivery time.
			if ( class_exists('WpCafe_Pro') ) {
					$result = \WpCafe_Pro\Core\Template\Food_Menu::instance();
					$result->dokan_food_time_markup( $preparing_time , $delivery_time );
			}
			?>
			<div class="dokan-form-group">
					<label for="food_location" class="form-label"><?php esc_html_e( 'Food location', 'wpcafe-multivendor' ); ?></label>
					<select multiple="multiple" name="food_location[]"  id="food_location" class="dokan-form-control dokan-select2"
							data-placeholder="<?php esc_attr_e( 'Select location', 'wpcafe-multivendor' ); ?>">
							<?php
							// get wpcafe locations
							foreach ( $wpc_locations as $key => $value) {
									$selected = is_array($food_location) && in_array(  $key , $food_location ) ? ' selected="selected" ' : ''; 
									?> <option value="<?php echo esc_html( $key ) ?>" <?php echo esc_attr( $selected );?> ><?php echo esc_html( ucfirst( $value ) ) ?></option>  
							<?php }
							?>
					</select>
			</div>
			<?php 
	}

	/**
	 * Add / Save of product
	 *
	 * @param int    $product_id get product id.
	 * @param object $postdata get post data.
	 */
	public function save_add_product_meta( $product_id, $postdata ) {
			if ( ! dokan_is_user_seller( get_current_user_id() ) ) {
					return;
			}

			$food_location  = ! empty( $postdata['food_location'] ) ? $postdata['food_location'] : [];
			$preparing_time = ! empty( $postdata['wpc_pro_preparing_time'] ) ? $postdata['wpc_pro_preparing_time']  : "";
			$delivery_time  = ! empty( $postdata['wpc_pro_delivery_time'] ) ? $postdata['wpc_pro_delivery_time'] : "";

			$post_data = [
					'food_location'             => $food_location,
					'wpc_pro_preparing_time'    => $preparing_time,
					'wpc_pro_delivery_time'     => $delivery_time,
			];

			// Save food location from product form
			foreach ( $post_data as $key => $value) :
					update_post_meta( $product_id, $key , $value );
			endforeach;
	}

	/**
	 * Thankyou Page Order Location Text
	 *
	 * @param [type] $order_food_location get object.
	 * @param [type] $order_id get order id.
	 */
	public function thankyou_order_location_text( $order_food_location, $order_id ) {

			if( is_array($order_food_location) && !empty( $order_food_location ) ){

					$order_location = '';

					// data is in array format, multivendor module is enabled
					foreach( $order_food_location as $vendor_id => $location_slug ){
							$vendor_name    = get_the_author_meta( 'display_name', $vendor_id );
							$location_name  = get_term_by('slug', $location_slug, 'wpcafe_location')->name;
							$location_text  = nl2br( esc_html__("Order Location For {$vendor_name}: {$location_name}", 'wpcafe-multivendor') . " \r\n" );
							$order_location .= $location_text;
					}

					return $order_location;
			} 

			if( ( '' === $order_food_location ) && !empty(wp_get_post_parent_id($order_id)) ){

					// location came blank and has post parent. It might be a vendor sub-order
					$parent_order_id        = wp_get_post_parent_id($order_id);
					$parent_order           = wc_get_order( $parent_order_id );
					$parent_order_location  = $parent_order->get_meta('wpc_location_name');
					$vendor_id              = dokan_get_seller_id_by_order( $order_id );
					$vendor_name            = get_the_author_meta( 'display_name', $vendor_id );
					if( is_array($parent_order_location) && !empty( $parent_order_location[$vendor_id] ) ){
							$location_name  = get_term_by('slug', $parent_order_location[$vendor_id], 'wpcafe_location')->name;
							$location_text  = esc_html__("Order Location For {$vendor_name}: {$location_name}", 'wpcafe-multivendor');
							return $location_text;
					}
			}
			return $order_food_location;
	}

}
