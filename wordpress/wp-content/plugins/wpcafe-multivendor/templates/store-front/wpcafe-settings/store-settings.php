<?php
/**
 * The Template for displaying all wpcafe settings.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$vendor       = dokan()->vendor->get( get_query_var( 'author' ) );
$vendor_info  = $vendor->get_shop_info();
$map_location = $vendor->get_location();
$store_user   = get_userdata( get_query_var( 'author' ) );
$store_info   = dokan_get_store_info( $store_user->ID );
$layout       = get_theme_mod( 'store_layout', 'left' );

$store_wpcafe_settings = get_user_meta( $vendor->id, 'dokan_wpcafe_settings', true );
get_header( 'shop' );
?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<div class="dokan-store-wrap layout-<?php echo esc_attr( $layout ); ?>">

    <?php if ( 'left' === $layout ) { ?>
        <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
    <?php } ?>

    <div id="primary" class="content-area dokan-single-store dokan-w8">
        <div id="dokan-content" class="site-content store-review-wrap woocommerce" role="main">

            <?php dokan_get_template_part( 'store-header' ); ?>

            <div id="store-wpcafe-wrapper">
                <div id="store-wpcafe">
                    <h2 class="headline"><?php esc_html_e( 'Restaurant Settings', 'wpcafe-multivendor' ); ?></h2>
                    <hr>
                    <?php 
                        if(!empty($store_wpcafe_settings) && is_array( $store_wpcafe_settings['delivery_location'] )){
                            ?>
                            <div>
                                <span><?php echo esc_html__('Service available in these areas: ', 'wpcafe-multivendor');?></span>
                                <ul>
                                <?php
                                foreach( $store_wpcafe_settings['delivery_location'] as $location ){
                                        ?>
                                        <li class="wpcafe-multivendor-settings-location"><?php echo esc_html( ucfirst($location) ); ?></li>
                                        <?php
                                }
                                ?>
                                </ul>
                            </div>
                            <?php
                        }
                    ?>
                </div><!-- #store-wpcafe -->
            </div><!-- #store-wpcafe-wrap -->

        </div><!-- #content .site-content -->
    </div><!-- #primary .content-area -->

    <div class="dokan-clearfix"></div>

    <?php if ( 'right' === $layout ) { ?>
        <?php dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); ?>
    <?php } ?>

</div><!-- .dokan-store-wrap -->


<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer(); ?>
