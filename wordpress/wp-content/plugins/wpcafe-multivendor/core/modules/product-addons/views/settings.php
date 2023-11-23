<?php
/**
 *  Wpcafe settings menu in Dokan Vendor Dashboard Template
 */

use WpCafe\Utils\Wpc_Utilities;
?>
<?php do_action( 'dokan_dashboard_wrap_start' ); ?>

<div class="dokan-dashboard-wrap">
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

				if ( class_exists('Wpcafe_Pro') && file_exists(\Wpcafe_Pro::core_dir() . "modules/product-addons/admin/templates/settings/settings.php") ) {
					include_once \Wpcafe_Pro::core_dir() . "modules/product-addons/admin/templates/settings/settings.php";
				}

				?>

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