'use strict';

(function ($) {

    $(document).ready(function () {
        //get local storage value for vendor location
        var local_storage_value = localStorage.getItem('wpc_location');

        //find each vendor location dropdown and set selected from local storage
        $('.wpc_vendor_location_field').each(function (index, item) {
            var __this = $(this);
            var current_vendor_id = $(item).find("input[name*='wpc_location_vendor_id[]']").val();

            if (local_storage_value !== null) {
                var location_array = JSON.parse(local_storage_value);
                $(location_array).each(function (i, object) {
                    if (object.hasOwnProperty("vendor_id") && object["vendor_id"] === current_vendor_id) {
                        $(__this).find("option[value='" + object["location"] + "']").attr("selected", true);
                    }
                });
            }
        });

        //save location data from location pop-up
        $(".wpc_modal").on('click', '.wpc-select-location', function () {
            var wpc_location = $('.wpc-location option:selected').val();
            var local_storage_value = localStorage.getItem('wpc_location');

            //save location for multivendor module
            if ($(this).siblings(".wpc-location-store").length) {
                var vendor_id = $(this).siblings(".wpc-location-store").first().val();
                var location_data = {
                    vendor_id: vendor_id,
                    location: wpc_location,
                }

                if (local_storage_value === null) {
                    var location_array = [];
                    location_array.push(location_data);
                    localStorage.setItem('wpc_location', JSON.stringify(location_array));
                } else {
                    var location_array = JSON.parse(local_storage_value);
                    var existing_location_found = false;
                    $(location_array).each(function (index, object) {
                        if (object.hasOwnProperty("vendor_id") && object["vendor_id"] === vendor_id) {
                            existing_location_found = true;
                            object["location"] = wpc_location;
                        }
                    });
                    if (existing_location_found === false) {
                        location_array.push(location_data);
                    }
                    localStorage.setItem('wpc_location', JSON.stringify(location_array));
                }
            }

            $(".wpc_modal").fadeOut();
            $('body').removeClass('wpc_location_popup');

        });

        //added active class in the wpcafe menu in dokan leftmenu
        if ( wpcafe_active_menu ) {
            var class_name = '';
            if('addons' === wpcafe_active_menu){
                class_name = 'wpcafe_addons';
            } else if('cafe_settings' === wpcafe_active_menu){
                class_name = 'wpcafe';
            }

            $('.dokan-dashboard-menu').find('li.'+class_name).addClass('active');
        }

    });

})(jQuery);