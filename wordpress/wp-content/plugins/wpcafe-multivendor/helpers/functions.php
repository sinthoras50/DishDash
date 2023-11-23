<?php

/**
 * Get terms and conditions page
 *
 * @since 1.0.0
 *
 * @param $store_id
 * @param $store_info
 *
 * @return string
 */
if( !function_exists('wpcafe_multivendor_get_vendor_settings') ){

    function wpcafe_multivendor_get_vendor_settings( $store_id ) {
        
        if ( ! $store_id ) {
            return '';
        }
        $userstore = dokan_get_store_url( $store_id );
    
        return  $userstore . '?store_front=wpc_store_settings';
    }
}

if( !function_exists('wpcafe_multivendor_prepare_location_array') ){

    function wpcafe_multivendor_prepare_location_array( $locations = [] ) {

        $location_array = [
            '' => esc_html__('Select a delivery location', 'wpcafe-multivendor')
        ];
        foreach( $locations as $location ){
            $location_array[$location] = get_term_by('slug', $location, 'wpcafe_location')->name;
        }
        return $location_array;
    }
}