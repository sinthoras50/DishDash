
<?php

use WpCafe\Utils\Wpc_Utilities;
use WeDevs\Dokan\Rewrites as rewrites;


include Wpcafe_Multivendor::templates_dir() . '/store-front/store-header.php'; ?>

<?php
if ( have_posts() ) {?>

    <div class="seller-items">
        <?php 
         $author        = $store_user->data;
         $store_info    = dokan_get_store_info( $author->data->ID );
         $product_ppp   = dokan_get_option( 'store_products_per_page', 'dokan_general', 12 );
         $post_per_page = isset( $store_info['store_ppp'] ) && ! empty( $store_info['store_ppp'] ) ? $store_info['store_ppp'] : $product_ppp;
       

        $vendor_product_categories = [];

        while ( have_posts() ) {

            the_post();
            $current_product_categories = get_the_terms( $product->get_id(), 'product_cat' );

            if ( is_array( $current_product_categories ) && !empty( $current_product_categories ) ) {

                foreach ( $current_product_categories as $category ) {

                    if ( !in_array( $category->term_id, $vendor_product_categories ) ) {
                        array_push( $vendor_product_categories, $category->term_id );
                    }
                }
            }
        }

        $food_menu_tabs = \WpCafe\Utils\Wpc_Utilities::get_tab_array_from_category($vendor_product_categories);
        

        $unique_id            = md5( md5( microtime() ) );
        $no_desc_class        = 'wpc-no-desc';
        $show_thumbnail       = 'yes';
        $wpc_cart_button_show = "yes";
        $wpc_price_show       = "yes";
        $show_item_status     = "yes";
        $title_link_show      = "yes";
        $wpc_show_desc        = "yes";
        $wpc_desc_limit       = 20;
        $wpc_menu_cat         = [];
        $wpc_menu_count       = -1;
        $wpc_menu_order       = 'DESC';
        $col                  = ($show_thumbnail == 'yes') ? 'wpc-col-md-8' : 'wpc-col-md-12';
        $class                = ($title_link_show=='yes')? '' : 'wpc-no-link';
        $wpc_slider_nav_show  = "yes";
        $wpc_cart_button      = "yes";
        $wpc_slider_dot_show  = "yes";
        $wpc_btn_text         = "";
        $customize_btn        = "";
        $wpc_slider_count     = $post_per_page;
        $wpc_delivery_time_show = "yes";
        $style                  = "style-1";
        $wpc_auto_play          = 'no';
        $cafe_settings      =  \WpCafe\Core\Base\Wpc_Settings_Field::instance()->get_settings_option();
        $cart_icon          = !empty($cafe_settings['wpc_cart_icon']) ? $cafe_settings['wpc_cart_icon'] : 'wpcafe-cart_icon';
        $customization_icon = !empty($cafe_settings['wpc_customization_icon']) ? $cafe_settings['wpc_customization_icon'] : 'wpcafe-customize';

        $permalink  = get_permalink( $product->get_id() );
        $wpc_cat = [];
        
        foreach ($food_menu_tabs as $content_key => $value) {
            
            if(isset( $value['post_cats'][0] )){

                $active_class   = (($content_key == array_keys($food_menu_tabs)[0]) ? 'tab-active' : ' ');
                $cat_id         = isset($value['post_cats'][0] ) ? intval( $value['post_cats'][0] ) : 0 ;
                array_push( $wpc_cat , $value['post_cats'][1] );
            }
        }

        $products = wc_get_products( array(
            'status'    => 'publish',
            'limit'     => -1,
            'author'    => $store_user->id,
            'category'  => $wpc_cat ,
        ) );

        $vendor_settings                = get_user_meta( $store_user->id , 'dokan_wpcafe_settings', true );
        $standarad_off_message          = !empty( $vendor_settings['standarad_off_message'] ) ?  $vendor_settings['standarad_off_message']  : "";
        
        if ($standarad_off_message !== '') {
        ?>
            <div class="wpc_pro_standard_offer_message"><?php echo esc_html($standarad_off_message); ?></div>
        <?php
        }
        ?>
        
        <div class="wpc-menu-slider-shortcode">
            
            <?php 
                $author_id = $author->data->ID;

                if (class_exists("Wpcafe_Pro")) {
                    include \Wpcafe_Pro::plugin_dir() . "/widgets/food-menu-slider/style/". $style .".php";
                } 
            ?>
        </div>
            

    </div>


<?php } else {?>

    <p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'wpcafe-multivendor' );?></p>

<?php } ?>

<?php include Wpcafe_Multivendor::templates_dir() . '/store-front/store-footer.php'; ?>

