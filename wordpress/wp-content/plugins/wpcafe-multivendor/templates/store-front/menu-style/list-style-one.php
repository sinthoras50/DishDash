
<?php include Wpcafe_Multivendor::templates_dir() . '/store-front/store-header.php'; ?>

<?php
if ( have_posts() ) {?>

    <div class="seller-items">

        <?php woocommerce_product_loop_start();?>
        
        <?php 
        $unique_id     = md5( md5( microtime() ) );
        $no_desc_class = 'wpc-no-desc';
        $show_thumbnail       = 'yes';
        $wpc_cart_button      = "yes";
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

        $cafe_settings      =  \WpCafe\Core\Base\Wpc_Settings_Field::instance()->get_settings_option();
        $cart_icon          = !empty($cafe_settings['wpc_cart_icon']) ? $cafe_settings['wpc_cart_icon'] : 'wpcafe-cart_icon';
        $customization_icon = !empty($cafe_settings['wpc_customization_icon']) ? $cafe_settings['wpc_customization_icon'] : 'wpcafe-customize';

        $args = array(
            'show_thumbnail'    => $show_thumbnail,
            'unique_id'         => $unique_id,
            'class'             => $class,
            'show_item_status'  => $show_item_status,
            'wpc_show_desc'     => $wpc_show_desc,
            'col'               => $col,
            'wpc_desc_limit'    => $wpc_desc_limit,
            'no_desc_class'     => $no_desc_class,
            'wpc_cart_button'   => $wpc_cart_button,
            'title_link_show'   => $title_link_show,
            'wpc_menu_cat'      => $wpc_menu_cat,
            'wpc_menu_count'    => $wpc_menu_count,
            'wpc_price_show'    => $wpc_price_show,
            'cart_icon'         => $cart_icon,
            'customization_icon'=> $customization_icon,
        );
        ?>
        <div class="wpc-nav-shortcode main_wrapper_<?php echo esc_attr($unique_id .' '. $no_desc_class)?>" data-id="<?php echo esc_attr($unique_id)?>">
            <div class="list_template_<?php echo esc_attr($unique_id) ?> wpc-nav-shortcode wpc-widget-wrapper">
            
            <?php
            while ( have_posts() ): 
                the_post();
                global $product;
                $permalink          = get_permalink( $product->get_id() );
                $args['product']    = $product;
                $args['permalink']  = $permalink;

                \WpCafe\Core\Shortcodes\Template_Functions::wpc_food_menu_list_template( $args );
            
            endwhile; 
            ?>
            
            </div>
        </div>

        <?php woocommerce_product_loop_end();?>

    </div>

    <?php dokan_content_nav( 'nav-below' );?>

<?php } else {?>

    <p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'wpcafe-multivendor' );?></p>

<?php } ?>

<?php include Wpcafe_Multivendor::templates_dir() . '/store-front/store-footer.php'; ?>

