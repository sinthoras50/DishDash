<?php
namespace Wpcafe_Multivendor\Traits;

defined( 'ABSPATH' ) || exit;

/**
 * Instance of class
 */
trait Singleton {
    
    private static $instance;

    /**
     * Returns single instance
     *
     */
    public static function instance() {
        if ( !self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}
