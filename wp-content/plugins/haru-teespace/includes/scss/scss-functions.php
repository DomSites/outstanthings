<?php
/**
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

require_once( HARU_TEESPACE_CORE_DIR . 'includes/scss/scssphp/scss.inc.php' );
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\Server;
use ScssPhp\ScssPhp\Parser;
use ScssPhp\ScssPhp\Version;

if ( ! defined( 'HARU_DEVELOPE_MODE' ) && ( '1' == haru_get_option( 'haru_scss_compiler', '0' ) ) ) {
    add_action( 'redux/options/haru_teespace_options/saved', 'haru_generate_scss' );
}

if ( ! function_exists( 'haru_generate_scss' ) ) {
    function haru_generate_scss() {
        try {
            if ( ! defined( 'FS_METHOD' ) ) {
                define('FS_METHOD', 'direct');
            }

            $style_dir  = wp_upload_dir()['basedir'];
            $style_uri  = wp_upload_dir()['baseurl'];
            $file_path = $style_dir . "/style-custom.min.css";

            $color_variables  = haru_theme_color_scss_variables();
            $option_variables = haru_theme_options_variables();

            // Create file .min.css (doesn't need .css file)
            $scss = new Compiler();
            
            // Preset Variables
            $scss->setImportPaths( get_template_directory() . '/assets/scss/' );
            $scss->setVariables( $color_variables );
            
            // Output Formatting: Compressed, Nested,...
            $scss->setFormatter("ScssPhp\ScssPhp\Formatter\Compressed");

            // Compile
            $css = $scss->compile('@import "style.scss";');
            $css .= $scss->compile($option_variables);

            require_once ABSPATH . 'wp-admin/includes/file.php';
            WP_Filesystem();
            global $wp_filesystem;

            if ( !$wp_filesystem->put_contents( $file_path, $css, FS_CHMOD_FILE) ) {
                return array(
                    'status'  => 'error',
                    'message' => esc_html__( 'Could not save file! Please check your Server Permissions.', 'haru-teespace' )
                );
            }
        } catch( Exception $e ) {
            $error_message = $e->getMessage();

            return array(
                'status'  => 'error',
                'message' => $error_message
            );
        }
    }
}

/* Generate scss to css */
if ( ! function_exists( 'haru_theme_color_scss_variables' ) ) {
    function haru_theme_color_scss_variables() {
        // Process Color variables
        $primary_color = haru_get_option( 'haru_primary_color', '#c72538' );
        $secondary_color = haru_get_option( 'haru_secondary_color', '#b479d9' );
        $text_color = haru_get_option( 'haru_text_color', '#696969' );
        $text_color_secondary = haru_get_option( 'haru_text_color_secondary', '#ababab' );
        $text_color_tertiary = haru_get_option( 'haru_text_color_tertiary', '#9b9b9b' );
        $heading_color = haru_get_option( 'haru_heading_color', '#000' );

        $link_color_attr = haru_get_option( 'haru_link_color', array() );
        if ( isset($link_color_attr) && !empty($link_color_attr) && !empty($link_color_attr['regular']) ) {
            $link_color = haru_get_option( 'haru_link_color' )['regular'];
        } else {
            $link_color         = '#696969';
        }

        if ( isset($link_color_attr) && !empty($link_color_attr) && !empty($link_color_attr['hover']) ) {
            $link_color_hover =  haru_get_option( 'haru_link_color' )['hover'];
        } else {
            $link_color_hover   = '#c72538';
        }

        if ( isset($link_color_attr) && !empty($link_color_attr) && !empty($link_color_attr['active']) ) {
            $link_color_active = haru_get_option( 'haru_link_color' )['active'];
        } else {
            $link_color_active  = '#c72538';
        }
        
        // Gradient Color variables
        $gradient_color_1 = haru_get_option( 'haru_gradient_color_1', '#ff869f' );
        $gradient_color_2 = haru_get_option( 'haru_gradient_color_2', '#fa988a' );
        $gradient_color_3 = haru_get_option( 'haru_gradient_color_3', '#f19a73' );
        $gradient_color_4 = haru_get_option( 'haru_gradient_color_4', '#ffd0b1' );
        $gradient_color_8 = haru_get_option( 'haru_gradient_color_8', '#fbab83' );
        $gradient_heading_1 = haru_get_option( 'haru_gradient_heading_1', '#b1f1b3' );
        $gradient_heading_2 = haru_get_option( 'haru_gradient_heading_2', '#f3eec2' );

        // Process typography
        // Body Font, Heading font and page title font processed in theme options - small of nubmer element use (output, compiler)
        $fonts = (object)array();

        // Body Font
        $body_font = haru_get_option( 'haru_body_font', array() );
        if ( isset( $body_font ) && ! empty( $body_font ) && ! empty( $body_font['font-family'] ) ) {
            $fonts->body_font_family = haru_get_option( 'haru_body_font' )['font-family'];
            $fonts->body_font_weight = haru_get_option( 'haru_body_font' )['font-weight'];
            $fonts->body_font_size   = haru_get_option( 'haru_body_font' )['font-size'];
        } else {
            $fonts->body_font_family = 'DM Sans';
            $fonts->body_font_weight = '400';
            $fonts->body_font_size   = '14px';
        }

        // Secondary Font
        $secondary_font = haru_get_option( 'haru_secondary_font', array() );
        if ( isset( $secondary_font ) && ! empty( $secondary_font ) && ! empty( $secondary_font['font-family'] ) ) {
            $fonts->secondary_font_family = haru_get_option( 'haru_secondary_font' )['font-family'];
            $fonts->secondary_font_weight = haru_get_option( 'haru_secondary_font' )['font-weight'];
            $fonts->secondary_font_size   = haru_get_option( 'haru_secondary_font' )['font-size'];
        } else {
            $fonts->secondary_font_family = 'DM Sans';
            $fonts->secondary_font_weight = '400';
            $fonts->secondary_font_size   = '14px';
        }

        // Menu Font (can process in output option menu_font)
        $menu_font = haru_get_option( 'haru_menu_font', array() );
        if ( isset( $menu_font ) && ! empty( $menu_font ) && ! empty( $menu_font['font-family'] ) ) {
            $fonts->menu_font_family = haru_get_option( 'haru_menu_font' )['font-family'];
            $fonts->menu_font_weight = haru_get_option( 'haru_menu_font' )['font-weight'];
            $fonts->menu_font_size   = haru_get_option( 'haru_menu_font' )['font-size'];
        } else {
            $fonts->menu_font_family = 'DM Sans';
            $fonts->menu_font_weight = '700';
            $fonts->menu_font_size   = '14px';
        }

        // Font weight
        $font_weight_light = haru_get_option( 'haru_font_weight_light', '300' );
        $font_weight_normal = haru_get_option( 'haru_font_weight_normal', '400' );
        $font_weight_medium = haru_get_option( 'haru_font_weight_medium', '500' );
        $font_weight_semi_bold = haru_get_option( 'haru_font_weight_semi_bold', '600' );
        $font_weight_bold = haru_get_option( 'haru_font_weight_bold', '700' );
        $font_weight_extra_bold = haru_get_option( 'haru_font_weight_extra_bold', '800' );

        // Border radius Elements
        $border_radius_e = haru_get_option( 'haru_border_radius_e', '12' );
        $border_radius_e_tiny = haru_get_option( 'haru_border_radius_e_tiny', '12' );
        $border_radius_e_small = haru_get_option( 'haru_border_radius_e_small', '3' );
        $border_radius_e_medium = haru_get_option( 'haru_border_radius_e_medium', '12' );
        $border_radius_e_large = haru_get_option( 'haru_border_radius_e_large', '12' );
        $border_radius_e_extra_large = haru_get_option( 'haru_border_radius_e_extra_large', '40' );

        // Border radius Layout
        $border_radius = haru_get_option( 'haru_border_radius', '12' );
        $border_radius_tiny = haru_get_option( 'haru_border_radius_tiny', '3' );
        $border_radius_small = haru_get_option( 'haru_border_radius_small', '3' );
        $border_radius_medium = haru_get_option( 'haru_border_radius_medium', '5' );
        $border_radius_large = haru_get_option( 'haru_border_radius_large', '10' );
        $border_radius_extra_large = haru_get_option( 'haru_border_radius_extra_large', '40' );

        // Scss variables to generate css
        $scss_variables                          = array();
        $scss_variables['cl-primary']            = $primary_color;
        $scss_variables['cl-secondary']          = $secondary_color;
        $scss_variables['cl-text']               = $text_color;
        $scss_variables['cl-text-2']             = $text_color_secondary;
        $scss_variables['cl-text-3']             = $text_color_tertiary;
        $scss_variables['cl-heading']            = $heading_color;
        $scss_variables['cl-link']               = $link_color;
        $scss_variables['cl-link-hover']         = $link_color_hover;
        $scss_variables['cl-link-active']        = $link_color_active;

        // Gradient
        $scss_variables['cl-gr-1']            = $gradient_color_1;
        $scss_variables['cl-gr-2']            = $gradient_color_2;
        $scss_variables['cl-gr-3']            = $gradient_color_3;
        $scss_variables['cl-gr-4']            = $gradient_color_4;
        $scss_variables['cl-gr-8']            = $gradient_color_8;
        $scss_variables['cl-hd-1']            = $gradient_heading_1;
        $scss_variables['cl-hd-2']            = $gradient_heading_2;

        $scss_variables['font-primary']          = $fonts->body_font_family;
        $scss_variables['font-primary-weight']   = $fonts->body_font_weight;
        $scss_variables['fs-base']               = $fonts->body_font_size;
        $scss_variables['font-secondary']        = $fonts->secondary_font_family;
        $scss_variables['font-secondary-weight'] = $fonts->secondary_font_weight;
        $scss_variables['font-secondary-size']   = $fonts->secondary_font_size;
        $scss_variables['font-menu']             = $fonts->menu_font_family;
        $scss_variables['font-menu-weight']      = $fonts->menu_font_weight;
        $scss_variables['fs-menu']               = $fonts->menu_font_size;
        // $scss_variables['theme-url']             = get_template_directory_uri() . '/';
        
        if ( is_multisite() ) {
            if ( is_main_site() ) {
                $scss_variables['theme-url']             = '../themes/teespace/';
            } else {
                $scss_variables['theme-url']             = '../../../themes/teespace/';
            }
        } else {
            $scss_variables['theme-url']             = '../themes/teespace/';
        }

        // Font Weight
        $scss_variables['fw-light']           = $font_weight_light;
        $scss_variables['fw-normal']          = $font_weight_normal;
        $scss_variables['fw-medium']          = $font_weight_medium;
        $scss_variables['fw-semi-bold']       = $font_weight_semi_bold;
        $scss_variables['fw-bold']            = $font_weight_bold;
        $scss_variables['fw-extra-bold']      = $font_weight_extra_bold;

        // Border Radius Elements
        $scss_variables['border-radius-e']             = $border_radius_e . 'px';
        $scss_variables['border-radius-e-tiny']        = $border_radius_e_tiny . 'px';
        $scss_variables['border-radius-e-small']       = $border_radius_e_small . 'px';
        $scss_variables['border-radius-e-medium']      = $border_radius_e_medium . 'px';
        $scss_variables['border-radius-e-large']       = $border_radius_e_large . 'px';
        $scss_variables['border-radius-e-extra-large'] = $border_radius_e_extra_large . 'px';

        // Border Radius Layout
        $scss_variables['border-radius']             = $border_radius . 'px';
        $scss_variables['border-radius-tiny']        = $border_radius_tiny . 'px';
        $scss_variables['border-radius-small']       = $border_radius_small . 'px';
        $scss_variables['border-radius-medium']      = $border_radius_medium . 'px';
        $scss_variables['border-radius-large']       = $border_radius_large . 'px';
        $scss_variables['border-radius-extra-large'] = $border_radius_extra_large . 'px';

        return $scss_variables;
    }
}

if ( ! function_exists( 'haru_theme_options_variables' ) ) {
    function haru_theme_options_variables() {
        $custom_css           = '';
        $background_image_css = '';

        $body_background_mode = haru_get_option( 'body_background_mode', 'background' );
        
        if ( $body_background_mode == 'background' ) {
            $body_background      = haru_get_option( 'body_background', '' );
            $background_image_url = isset( $body_background['background-image'] ) ? $body_background['background-image'] : '';
            $background_color     = isset( $body_background['background-color'] ) ? $body_background['background-color'] : '';

            if ( ! empty( $background_color ) ) {
                $background_image_css .= 'background-color:' . $background_color . ';';
            }

            if ( ! empty( $background_image_url ) ) {
                $background_repeat     = isset( $body_background['background-repeat'] ) ? $body_background['background-repeat'] : '';
                $background_position   = isset( $body_background['background-position'] ) ? $body_background['background-position'] : '';
                $background_size       = isset( $body_background['background-size'] ) ? $body_background['background-size'] : '';
                $background_attachment = isset( $body_background['background-attachment'] ) ? $body_background['background-attachment'] : '';
                
                $background_image_css .= 'background-image: url("' . $background_image_url . '");';

                if ( ! empty( $background_repeat ) ) {
                    $background_image_css .= 'background-repeat: ' . $background_repeat . ';';
                }

                if ( ! empty( $background_position ) ) {
                    $background_image_css .= 'background-position: ' . $background_position . ';';
                }

                if ( ! empty( $background_size ) ) {
                    $background_image_css .= 'background-size: ' . $background_size . ';';
                }

                if ( ! empty( $background_attachment ) ) {
                    $background_image_css .= 'background-attachment: ' . $background_attachment . ';';
                }
            }

        }

        if ( $body_background_mode == 'pattern' ) {
            $background_image_url =  get_template_directory_uri() . '/framework/admin-assets/images/theme-options/' . haru_get_option( 'body_background_pattern', '' );
            $background_image_css .= 'background-image: url("'. $background_image_url .'");';
            $background_image_css .= 'background-repeat: repeat;';
            $background_image_css .= 'background-position: center center;';
            $background_image_css .= 'background-size: auto;';
            $background_image_css .= 'background-attachment: scroll;';
        }

        if ( ! empty( $background_image_css ) ) {
            $custom_css .= 'body {' . $background_image_css . ' }';
        }

        // Site max width layout boxed
        $layout_site_max_width = haru_get_option( 'layout_site_max_width', '1200' );
        $custom_css            .= 'body.layout-boxed #haru-main { max-width: ' . $layout_site_max_width . 'px; }';

        return $custom_css;
    }
}
