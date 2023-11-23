<?php
use WpCafe\Utils\Wpc_Utilities;

$vendor_settings                = get_user_meta( $user_id, 'dokan_wpcafe_settings', true );
$allow_vendor_product_add_ons     = !empty( $vendor_settings['allow_vendor_product_add_ons'] ) &&  $vendor_settings['allow_vendor_product_add_ons'] =="on" ? "checked" : "";
$allow_vendor_food_location     = !empty( $vendor_settings['allow_vendor_food_location'] ) &&  $vendor_settings['allow_vendor_food_location'] =="on" ? "checked" : "";
$food_style                     = !empty( $vendor_settings['storefront_template'] ) ? $vendor_settings['storefront_template'] : "";
$wpc_locations                  = Wpc_Utilities::get_location_data();
$get_delivery_location          = !empty( $vendor_settings['delivery_location'] ) ?  $vendor_settings['delivery_location']  : [];


$food_menu_style                = [
    'list-style-one' => esc_html__( 'Food menu list', 'wpcafe-multivendor' ),
];

// check if cafe pro active pro active
if ( class_exists( 'WpCafe_Pro' ) ) {
    $food_menu_style['list-style-slider'] = esc_html__( 'Food menu list slider', 'wpcafe-multivendor' );
}
?>

<!-- Food Menu Options Start  -->
<div class="wpc-label-item-wrapper">
    <h3 class="wpc-tab-title"><?php esc_html_e('Food Menu Options', 'wpcafe-multivendor'  ); ?></h3>
    <div class="wpc-label-item">
        <div class="wpc-label">
            <label for="food_location"><?php esc_html_e('Allow location', 'wpcafe-multivendor'  ); ?></label>
            <div class="wpc-desc"> <?php esc_html_e('Show location dropdown on store page and checkout', 'wpcafe-multivendor'  ); ?> </div>
        </div>
        <div class="wpc-meta">
            <input id='food_location' type="checkbox" <?php echo esc_attr( $allow_vendor_food_location ) ; ?> class="wpcafe-admin-control-input"
                name="allow_vendor_food_location" />
            <label for="food_location" class="wpcafe_switch_button_label"></label>
        </div>
    </div>
    <div class="wpc-label-item">
        <div class="wpc-label">
            <label for="delivery_location"><?php esc_html_e('Food Delivery location', 'wpcafe-multivendor'  ); ?></label>
            <div class="wpc-desc"> <?php esc_html_e('Choose food delivery location for store', 'wpcafe-multivendor'); ?> </div>
        </div>
        <div class="wpc-meta">
            <select multiple="multiple" name="delivery_location[]"  id="delivery_location" class="dokan-form-control dokan-select2"
                data-placeholder="<?php esc_attr_e( "Select location", "wpcafe-multivendor" ); ?>">
                <?php
                // get wpcafe locations
                foreach ( $wpc_locations as $key => $value) { 
                    $selected = in_array(  $key , $get_delivery_location ) ? ' selected="selected" ' : ''; ?> 
                    <option value="<?php echo esc_html( $key ) ?>" <?php echo esc_attr( $selected );?> ><?php echo esc_html( $value ) ?></option>  
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="wpc-label-item">
        <div class="wpc-label">
            <label for="food_menu_style"><?php esc_html_e('Food menu style', 'wpcafe-multivendor'  ); ?></label>
            <div class="wpc-desc"> <?php esc_html_e('Override store page food menu template', 'wpcafe-multivendor'); ?></div>
        </div>
        <div class="wpc-meta">
        <select id="food_menu_style" class="wpc-settings-input" name="storefront_template">
            <option value='default'><?php echo esc_html__( 'Default template', 'wpcafe-multivendor' ) ?></option>
            <?php
            foreach ( $food_menu_style as $key => $value ) { ?>
            <option <?php selected( $food_style, $key, true );?> value='<?php echo esc_attr( $key ); ?>'> <?php echo esc_html( $value ); ?> </option>
            <?php } ?>
        </select>
        </div>
    </div>
    <?php if ( class_exists( 'WpCafe_Pro' ) ) { ?>
        <div class="wpc-label-item">
            <div class="wpc-label">
                <label for="allow_vendor_product_add_ons"><?php esc_html_e('Allow Product Add-ons', 'wpcafe-multivendor'  ); ?></label>
                <div class="wpc-desc"> <?php esc_html_e('Show product add-ons under settings tab', 'wpcafe-multivendor'  ); ?> </div>
            </div>
            <div class="wpc-meta">
                <input id='allow_vendor_product_add_ons' type="checkbox" <?php echo esc_attr( $allow_vendor_product_add_ons ) ; ?> class="wpcafe-admin-control-input"
                    name="allow_vendor_product_add_ons" />
                <label for="allow_vendor_product_add_ons" class="wpcafe_switch_button_label"></label>
            </div>
        </div>
    <?php } ?>
</div>

<!-- Food Menu Options End -->

<?php
if(did_action('wpcafe_pro/after_load')){
    ?>
    <!-- Food Menu Discount Options Start -->
    <div class="wpc-label-item-wrapper">
        <h3 class='wpc-tab-title'><?php echo esc_html__('Discount Options', 'wpcafe-multivendor' ); ?></h3>
        <div class='wpc-label-item discount-meta-item'>
            <div class='wpc-label'>
                <label for='wpc_pro_discount_in_menu' class='wpc-settings-label'>
                    <?php echo esc_html__('Discount', 'wpcafe-multivendor' ) ?>
                </label>
                <div class='wpc_pro_discount_heading'>
                    <p class="wpc-desc"><?php echo esc_html__('Percentage discount will be appllied on simple product from include menus and include categories', 'wpcafe-multivendor' ) ?> </p>
                </div>
            </div>
            <div class='wpc-meta'>
                <?php
                    $wpc_pro_order_amount_percent           = !empty($vendor_settings['wpc_pro_discount_percentage']) ? intval($vendor_settings['wpc_pro_discount_percentage']) : '';
                    $wpc_pro_order_standarad_off_amount     = !empty($vendor_settings['wpc_pro_order_standarad_off_amount']) ? intval($vendor_settings['wpc_pro_order_standarad_off_amount']) : '';
                    $wpc_pro_discount_standarad_off         = !empty($vendor_settings['wpc_pro_discount_standarad_off']) ? intval($vendor_settings['wpc_pro_discount_standarad_off']) : '';
                    $standarad_off_message                  = !empty($vendor_settings['standarad_off_message']) ? esc_html($vendor_settings['standarad_off_message']) : '';
                    $wpc_pro_include_cat                    = !empty($vendor_settings['wpc_pro_include_cat']) ? $vendor_settings['wpc_pro_include_cat'] : [];
                ?>
                <div class='wpc_pro_discount_main_block'>
                    <div class='wpc_pro_discount_block'>
                        <span><input type='text' name='wpc_pro_discount_percentage' class='wpc_multivendor_discount_percentage wpc-settings-input attr-form-control' value="<?php echo intval($wpc_pro_order_amount_percent); ?>" /></span>
                        <span><?php echo esc_html__('%', 'wpcafe-multivendor' ) ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (class_exists('Woocommerce')) {
        ?>
        <div class='wpc-label-item'>
            <div class='wpc-label'>
                <label for='wpc_pro_include_menu' class='wpc-settings-label'>
                    <?php echo esc_html__('Include menus', 'wpcafe-multivendor' ) ?>
                </label>
                <p class='wpc-desc'><?php echo  esc_html__('Include following menu items when calculating discounts:', 'wpcafe-multivendor' ) ?></p>
            </div>
            <div class="wpc-meta">
                <?php
                $menu_id  = isset($vendor_settings['wpc_pro_include_menu']) ? $vendor_settings['wpc_pro_include_menu'] : [];
                $args = array(
                    'post_type'   => 'product',
                    'hide_empty'  => 0,
                    'author'      => $user_id

                );
                $products = wc_get_products($args);
                ?>
                <select multiple="multiple" class="dokan-form-control  dokan-select2 wpc_pro_multi_product wpc-settings-input" id="wpc_pro_include_menu" name="wpc_pro_include_menu[]">
                    <?php
                    if (is_array($products)) {
                        foreach ($products as $product) {
                            $selected = in_array($product->get_id(), $menu_id) ? "selected " : '';
                            ?>
                            <option <?php echo esc_html($selected); ?> value='<?php echo intval($product->get_id()); ?>'><?php echo esc_html($product->get_name());  ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php
        }
        ?>
        <div class='wpc-label-item'>
            <div class='wpc-label'>
                <label for='vendor_discount_include_cat' class='wpc-settings-label'>
                    <?php echo esc_html__('Include categories', 'wpcafe-multivendor' ) ?>
                </label>
                <p class='wpc-desc'><?php echo  esc_html__('Include all menu items belonging to following categories when calculating discounts:', 'wpcafe-multivendor' ) ?></p>
            </div>
            <div class="wpc-meta">
                <?php
                $args = array(
                    'hide_empty'  => 0,
                    'taxonomy'    => 'product_cat',
                    'hierarchical' => 1,
                );
                $categories = get_categories($args);
                ?>
                <select multiple="multiple" class="dokan-form-control  dokan-select2  wpcafe_multivendor_settings_cat wpc-settings-input" id="vendor_discount_include_cat" name="wpc_pro_include_cat[]">
                    <?php
                    if ( is_array( $categories ) ) {
                        foreach ($categories as $key => $category) {
                            $selected = in_array($category->term_id, $wpc_pro_include_cat ) ? "selected" : '';
                            ?>
                            <option <?php echo esc_html($selected); ?> value="<?php echo esc_attr($category->term_id); ?>"><?php echo esc_html($category->cat_name); ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <!-- Food Menu Discount Options End -->
    <?php
}
?>