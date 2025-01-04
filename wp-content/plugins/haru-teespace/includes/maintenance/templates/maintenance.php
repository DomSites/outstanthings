<?php 
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$time_id = uniqid();

date_default_timezone_set( haru_get_option( 'timezone', 'Asia/Ho_Chi_Minh' ));
$current_time           = date( 'Y/m/d H:i:s' );
$online_time            = haru_get_option( 'online_time', '' );
$time_to_reload         = strtotime( $online_time ) - strtotime( $current_time );

$maintenance_background = haru_get_option( 'maintenance_background', '' );
if ( $maintenance_background == '' ) {
    $maintenance_background = get_template_directory_uri() . '/framework/admin-assets/images/maintenance.jpg';
}

?>
<!DOCTYPE html>
<!-- Open HTML -->
<html <?php language_attributes(); ?>>
    <!-- Open Head -->
    <head>
        <?php 
            wp_head();
        ?>
        <meta charset="<?php bloginfo( 'charset' ); ?>"/>
        <?php
            $viewport_content = apply_filters('haru_viewport_content','width=device-width, initial-scale=1, maximum-scale=1');
        ?>
        <meta name="viewport" content="<?php echo esc_attr($viewport_content); ?>">
        <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) : ?>
            <?php if ( NULL !== haru_get_option('haru_custom_favicon')['url'] && ! empty( haru_get_option('haru_custom_favicon')['url'] ) ) : ?>
                <link rel="shortcut icon" href="<?php echo esc_url( haru_get_option( 'haru_custom_favicon' )['url'] ); ?>" />
            <?php else : ?>
                <link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() . '/framework/admin-assets/images/theme-options/favicon.ico' ); ?>" />
            <?php endif; ?>
        <?php endif; ?>

        <link href="<?php echo get_template_directory_uri() . '/style.css'; ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri(). '/assets/libraries/fontawesome/css/all.min.css'; ?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo plugins_url() . '/haru-teespace/assets/lib/redcountdown/jquery.knob.min.js'; ?>"></script>
        <script src="<?php echo plugins_url() . '/haru-teespace/assets/lib/redcountdown/jquery.ba-throttle-debounce.min.js'; ?>"></script>
        <script src="<?php echo plugins_url() . '/haru-teespace/assets/lib/redcountdown/jquery.redcountdown.js'; ?>"></script>
    </head>
    <body class="maintenance-mode" style="background-image: url('<?php echo esc_url( $maintenance_background['url'] ); ?>');">
        <div class="haru-main">
            <div class="maintanence-page">
                <div class="container">
                    <h2 class="maintenance-title"><?php echo esc_html( haru_get_option( 'maintenance_title', '' ) ); ?></h2>
                    <div class="countdown-wrapper">
                        <div id="countdown-content-<?php echo esc_attr( $time_id ); ?>" class="countdown-content" data-date="<?php echo esc_attr( $online_time );?>"></div>
                    </div>
                    <div class="maintenance-social">
                        <?php include( plugin_dir_path(__FILE__) . '/maintenance-social.php' ); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php wp_footer(); ?>
    </body>
    <script type="text/javascript">
        !function($) {
            $(document).ready(function() {
                $('#countdown-content-<?php echo $time_id;?>').redCountdown({
                    end: $.now() + parseInt(<?php echo $time_to_reload; ?>),
                    labels: true,
                    style: {
                        element: "",
                        textResponsive: .5,
                        daysElement: {
                            gauge: {
                                thickness: .03,
                                bgColor: "rgba(0,0,0,0.05)",
                                fgColor: "#333"
                            },
                            textCSS: 'font-family:\'Muli\'; font-size:25px; font-weight:300; color:#000;'
                        },
                        hoursElement: {
                            gauge: {
                                thickness: .03,
                                bgColor: "rgba(0,0,0,0.05)",
                                fgColor: "#333"
                            },
                            textCSS: 'font-family:\'Muli\'; font-size:25px; font-weight:300; color:#000;'
                        },
                        minutesElement: {
                            gauge: {
                                thickness: .03,
                                bgColor: "rgba(0,0,0,0.05)",
                                fgColor: "#333"
                            },
                            textCSS: 'font-family:\'Muli\'; font-size:25px; font-weight:300; color:#000;'
                        },
                        secondsElement: {
                            gauge: {
                                thickness: .03,
                                bgColor: "rgba(0,0,0,0.05)",
                                fgColor: "#333"
                            },
                            textCSS: 'font-family:\'Muli\'; font-size:25px; font-weight:300; color:#000;'
                        }
                        
                    },
                    onEndCallback: function() {
                        console.log("Time out!");
                        window.location.reload(true);
                    }
                });
            });
        }(jQuery);
    </script>
</html>