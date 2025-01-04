<?php
/**
 * @package    HaruTheme/Haru Formota
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! function_exists( 'haru_maintenance_mode' ) ) {
    function haru_maintenance_mode() {
        if ( current_user_can( 'edit_themes' ) || is_user_logged_in() ) {
            return;
        }

        if ( function_exists( 'haru_get_option' ) ) {
            $plugin_path        = untrailingslashit( plugin_dir_path(__FILE__) );
            $enable_maintenance = haru_get_option( 'enable_maintenance', '0' );
            if ( $enable_maintenance == '1' ) {
                date_default_timezone_set( haru_get_option( 'timezone' ) );
                $current_time = date('Y/m/d H:i:s');
                $online_time  = haru_get_option( 'online_time', '' );

                if ( $online_time > $current_time ) {
                    include( $plugin_path . '/templates/maintenance.php' );

                    exit();
                }
            }
        }
    }

    add_action( 'get_header', 'haru_maintenance_mode' );
}