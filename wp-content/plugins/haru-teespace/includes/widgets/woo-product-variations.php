<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

namespace Haru_TeeSpace\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Utils;
use \Elementor\Plugin;
use \Haru_TeeSpace\Classes\Helper as ControlsHelper;
use \Haru_TeeSpace\Classes\Haru_Template;
use \DNDMFU_WC_PRO_HOOKS;

if ( ! class_exists( 'Haru_TeeSpace_Woo_Product_Variations_Widget' ) ) {
    class Haru_TeeSpace_Woo_Product_Variations_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-woo-product-variations';
        }

        public function get_title() {
            return esc_html__( 'Haru Woo Product Variations', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-products';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'products',
                'product variations',
                'product',
                'category',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return [ 'magnific-popup' ];
            }


            if ( in_array( $this->get_settings_for_display( 'layout' ), array( 'popup' ) ) ) {
                return [ 'magnific-popup' ];
            }

            return [ 'magnific-popup' ];

        }

        public function get_style_depends() {
            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['magnific-popup'];
            }

            if ( in_array( $this->get_settings_for_display( 'layout' ), array( 'popup' ) ) ) {
                return [ 'magnific-popup' ];
            }

            return [ 'magnific-popup' ];
        }

        protected function register_controls() {

            $post_types = array();
            $post_types['product'] = __( 'Products', 'haru-teespace' );
            $post_types['by_id'] = __( 'Manual Selection', 'haru-teespace' );

            $taxonomies = get_taxonomies( [ 'object_type' => [ 'product' ] ], 'objects' );

            $this->start_controls_section(
                'content_section',
                [
                    'label'     => esc_html__( 'Content', 'haru-teespace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'layout',
                [
                  'label' => __( 'Layout', 'haru-teespace' ),
                  'type' => Controls_Manager::SELECT,
                  'default' => 'list',
                  'options' => [
                    'list'        => __( 'List', 'haru-teespace' ),
                    'popup'        => __( 'Popup', 'haru-teespace' ),
                  ]
                ]
            );

            $this->add_control(
                'button_text',
                [
                    'label' => __( 'Button Text', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Print Your Own', 'haru-teespace' ),
                    'condition' => [
                        'layout' => 'popup',
                    ],
                ]
            );

            $this->add_control(
                'button_style',
                [
                    'label' => __( 'Button Style', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1' => __( 'Style 1 (Primary Color - Medium)', 'haru-teespace' ),
                        'style-2' => __( 'Style 2 (Black Color - Medium)', 'haru-teespace' ),
                        'style-3' => __( 'Style 3 (Outline - Medium)', 'haru-teespace' ),
                        'style-4' => __( 'Style 4 (Text - Black)', 'haru-teespace' ),
                    ],
                    'condition' => [
                        'layout' => 'popup',
                    ],
                ]
            );

            $this->add_control(
                'button_shadow',
                [
                    'label'         => __( 'Button Shadow', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Enable if want to show shadow of Button.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'condition' => [
                        'layout' => 'popup',
                        'button_style' => [ 'style-1', 'style-2' ],
                    ],
                ]
            );

            $this->add_control(
                'product_id',
                [
                    'label' => __( 'Search & Select Product', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => ControlsHelper::get_product_variable_list( array( 'variable' ) ),
                    'label_block' => true,
                    'multiple' => false,
                ]
            );

            $this->add_control(
                'el_class',
                [
                    'label' => __( 'CSS Classes', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => '',
                    'title' => __( 'Add your custom class WITHOUT the dot. e.g: my-class', 'haru-teespace' ),
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'layout_section',
                [
                    'label' => esc_html__( 'Layout Options', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'background_dark',
                [
                    'label'         => __( 'Background Dark', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Enable if use for section has background dark.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->end_controls_section();

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'woo-product-variations', 'class', 'haru-woo-product-variations' );

            $this->add_render_attribute( 'woo-product-variations', 'class', 'haru-woo-product-variations--' . $settings['layout'] );

            $this->add_render_attribute( 'woo-product-variations', 'id', 'haru-woo-product-variations' . $this->get_id() );

            $this->add_render_attribute( 'woo-product-variations', 'data-settings', htmlentities( json_encode( $settings ) ) );

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'woo-product-variations', 'class', $settings['el_class'] );
            }

            // Process Upload
            $file_upload = get_option('wcf_show_in_dnd_file_upload_after') ? trim( get_option('wcf_show_in_dnd_file_upload_after') ) : 'woocommerce_before_add_to_cart_button';
            
            if ( class_exists( 'DNDMFU_WC_MAIN' ) ) {
                remove_action( $file_upload, 'dndmfu_wc_display_file_upload', 10 );
                add_action( 'woocommerce_before_variations_form', 'dndmfu_wc_display_file_upload', 10 );
            }

            if ( class_exists( 'DNDMFU_WC_PRO_MAIN' ) ) {
                $codedropz = DNDMFU_WC_PRO_HOOKS::get_instance();

                remove_action( $file_upload, array( $codedropz, 'dndmfu_wc_display_file_upload' ), 500 );
                add_action('woocommerce_before_variations_form', array( $codedropz, 'dndmfu_wc_display_file_upload' ), 500 );
            }

            // 
            remove_action( 'woocommerce_after_add_to_cart_button', 'haru_woocomerce_template_loop_wishlist', 5 );
            remove_action( 'woocommerce_after_add_to_cart_button', 'haru_woocomerce_template_loop_compare', 5 );
            remove_action( 'woocommerce_after_add_to_cart_button', 'wcdp_add_product_single_link_customize' );
            // Move position of Upload to top ( Process Upload )

            // Customize Variable add_to_cart if needed
            remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );

            // Layout template process
            if ( $settings['layout'] == 'popup' ) {
                add_action( 'woocommerce_variable_add_to_cart', 'haru_woocommerce_variable_add_to_cart', 30 );
            } else {
                add_action( 'woocommerce_variable_add_to_cart', 'haru_woocommerce_variable_add_to_cart_list', 30 );
            }

            ?>
            <?php if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) : ?>
                <div class="haru-notice"><?php echo sprintf( __( 'Please read to the <strong><a href="%s" target="_blank">Print Your Own Tutorial</a></strong> to create this feature.', 'haru-teespace' ), 'https://harutheme.com/forums/topic/how-to-build-print-your-own-feature-in-woocommerce/' ); ?></div>
            <?php endif; ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'woo-product-variations' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'woo-product-variations/woo-product-variations.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
            // Process Upload
            if ( class_exists( 'DNDMFU_WC_MAIN' ) ) {
                add_action( $file_upload, 'dndmfu_wc_display_file_upload', 10 );
                remove_action( 'woocommerce_before_variations_form', 'dndmfu_wc_display_file_upload', 10 );
            }

            if ( class_exists( 'DNDMFU_WC_PRO_MAIN' ) ) {
                $codedropz = DNDMFU_WC_PRO_HOOKS::get_instance();

                add_action( $file_upload, array( $codedropz, 'dndmfu_wc_display_file_upload' ), 500 );
                remove_action('woocommerce_before_variations_form', array( $codedropz, 'dndmfu_wc_display_file_upload' ), 500 );
            }

            // Return Original
            add_action( 'woocommerce_after_add_to_cart_button', 'haru_woocomerce_template_loop_wishlist', 5 );
            add_action( 'woocommerce_after_add_to_cart_button', 'haru_woocomerce_template_loop_compare', 5 );
            add_action( 'woocommerce_after_add_to_cart_button', 'wcdp_add_product_single_link_customize' );

            // 
            
            // Return Original
            add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );

            // Layout template process
            if ( $settings['layout'] == 'popup' ) {
                remove_action( 'woocommerce_variable_add_to_cart', 'haru_woocommerce_variable_add_to_cart', 30 );
            } else {
                remove_action( 'woocommerce_variable_add_to_cart', 'haru_woocommerce_variable_add_to_cart_list', 30 );
            }
        }

    }
}
