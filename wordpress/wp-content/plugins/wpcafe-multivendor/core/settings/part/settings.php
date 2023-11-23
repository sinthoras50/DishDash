<?php
/**
 *  Wpcafe settings menu in Dokan Vendor Dashboard Template
 */

use WpCafe\Utils\Wpc_Utilities;
?>
<?php do_action( 'dokan_dashboard_wrap_start' ); ?>

<div class="dokan-dashboard-wrap">
		<header class="dokan-dashboard-header dokan-clearfix"></header>
		<?php
				/**
				 *  dokan_dashboard_content_before hook
				 *
				 *  @hooked get_dashboard_side_navigation
				 *
				 *  @since 2.4
				 */
				do_action( 'dokan_dashboard_content_before' );
		?>
		<div class="dokan-dashboard-content">

				<?php
						/**
						 *  dokan_dashboard_content_before hook
						 *
						 *  @hooked show_seller_dashboard_notice
						 *
						 *  @since 2.4
						 */

				do_action( 'dokan_wpcafe_content_inside_before' );

						// show tab
						$settings_tabs = array(
								'menu_settings' => [esc_html__('Food Menu Setting', 'wpcafe-multivendor')],
						);

						$menu_doc_link  = Wpc_Utilities::wpc_kses( '<a href="https://support.themewinter.com/docs/plugins/wp-cafe/wp-cafe-multivendor-restaurant-addon/" target="_blank" class="doc-link"> '. esc_html__('Documentation', 'wpcafe-multivendor') .'</a> ' );

						$wpc_doc_link = array(
								'menu_settings' => esc_html__('Visit ', 'wpcafe-multivendor') . $menu_doc_link .  esc_html__(' for food menu options of your restaurant.', 'wpcafe-multivendor'),
						);

						$tab_arr    = [ $settings_tabs , $wpc_doc_link ];
						$filterd_tab = apply_filters('wpcafe/key_options/settings_tab_item', $tab_arr );

						if( isset( $filterd_tab['settings_tab']) ){
								$tabs = $filterd_tab['settings_tab'][0];
								$wpc_doc_link = $filterd_tab['settings_tab'][1];
						}else{
								$tabs = $tab_arr[0];
						}

						$recent_tab = get_query_var('settings-tab', 'key_options');


				?>
				<article class="wpc-content-area wpc-food-tab-wrapper">
						<!-- Show response message -->
						<div class="dokan-ajax-response">
								<?php do_action( 'dokan_settings_load_ajax_response' ); ?>
						</div>
						<!-- Settings tab -->
						<ul class="wpc-nav wpc-tab wpc-nav-tab">
								<?php
								$i=0;
								foreach ($tabs as $key => $value){
										$i++;
										?>
										<li>
												<a href="#" class="wpc-tab-a <?php echo esc_attr(( 1 == $i) ? 'wpc-active': '');?>" data-id="tab_<?php echo esc_html($key) ?>">
														<span><?php esc_html_e( $value[0] , 'wpcafe-multivendor'  ); ?></span>
												</a>
												<?php  if ( isset( $wpc_doc_link ) ) : ?>
														<p class="wpc-documentation-link"><?php echo Wpc_Utilities::wpc_kses( $wpc_doc_link['menu_settings'] ); ?></p>
												<?php  endif; ?>
										</li>
										<?php
								}
								?>
						</ul>
						<div class="wpc-tab-content settings-content-wraps">
								<?php

								?>
								<form method='post' class='wpc_pb_two wpc_tab_content' id='store-form' >
										<?php

										wp_nonce_field( 'dokan_cafe_settings_settings_nonce' ); 
										$i=0;
										foreach ( $tabs as $item => $content ) {
												$i++;
												$active_class = (  ( 1 == $i ) ? 'tab-active' : '' );
												if ( in_array( $item, array_keys( $settings_tabs ) ) ) {
														?>
														<div id='<?php echo esc_attr( $item );?>' data-id='tab_<?php echo esc_attr( $item ); ?>' class='wpc-tab tab-pane <?php echo esc_attr( $active_class );?>'>
																<?php
																// Menu settings
																if ( $item == 'menu_settings' && file_exists( \Wpcafe_Multivendor::core_dir() ."settings/part/menu-settings.php")  ) {
																		include_once \Wpcafe_Multivendor::core_dir() ."settings/part/menu-settings.php";
																}
																//hooks
																elseif ( $item == 'hooks' && file_exists( \Wpcafe_Multivendor::core_dir() ."settings/part/hooks.php") ) {
																		include_once \Wpcafe_Multivendor::core_dir() ."settings/part/hooks.php";
																}
																?>
														</div>
												<?php } }
										?>
										<div class="ajax_prev">
												<input type="submit" name="dokan_update_cafe_settings_settings"  class="wpc_mt_two wpc-btn wpc-btn-primary" value="<?php esc_attr_e('Save Changes', 'wpcafe-multivendor' ); ?>">
										</div>
								</form>
						</div>
				</article><!-- .dashboard-content-area -->

				<?php
						/**
						 *  dokan_dashboard_content_inside_after hook
						 *
						 *  @since 2.4
						 */
						do_action( 'dokan_dashboard_content_inside_after' );
				?>


		</div><!-- .dokan-dashboard-content -->

		<?php
				/**
				 *  dokan_dashboard_content_after hook
				 *
				 *  @since 2.4
				 */
				do_action( 'dokan_dashboard_content_after' );
		?>

</div><!-- .dokan-dashboard-wrap -->

<?php do_action( 'dokan_dashboard_wrap_end' ); ?>