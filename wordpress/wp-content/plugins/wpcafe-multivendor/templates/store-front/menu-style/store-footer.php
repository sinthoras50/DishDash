</div>

</div><!-- .dokan-single-store -->

<?php
if ( 'right' === $layout ) {?>
        <?php dokan_get_template_part( 'store', 'sidebar', [ 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ] );?>
    <?php }
?>

</div><!-- .dokan-store-wrap -->

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>