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
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Woo_Wishlist_Widget' ) ) {
    class Haru_TeeSpace_Woo_Wishlist_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-woo-wishlist';
        }

        public function get_title() {
            return esc_html__( 'Haru Woo Wishlist', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-favorite';
        }

        public function get_categories() {
            return [ 'haru-header-elements' ];
        }

        public function get_keywords() {
            return [
                'wishlist',
                'favorite',
                'header',
                'toolbar',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_settings',
                [
                    'label'     => esc_html__( 'Wishlist Settings', 'haru-teespace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Wishlist', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Wishlist you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Pre Wishlist 1', 'haru-teespace' ),
                        'style-2'   => __( 'Pre Wishlist 2 (Toolbar)', 'haru-teespace' ),
                    ]
                ]
            );

            $this->add_control(
                'wishlist_title',
                [
                    'label' => esc_html__( 'Wishlist Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Wishlist' , 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-2' ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'align',
                [
                    'label' => __( 'Alignment', 'haru-teespace' ),
                    'type' => Controls_Manager::CHOOSE,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'    => '',
                    'tablet_default'    => '',
                    'mobile_default'    => '',
                    'options' => [
                        'flex-start' => [
                            'title' => __( 'Left', 'haru-teespace' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'haru-teespace' ),
                            'icon' => 'eicon-h-align-center',
                        ],
                        'flex-end' => [
                            'title' => __( 'Right', 'haru-teespace' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .haru-wishlist' => 'justify-content: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style!' => [ 'style-2' ],
                    ],
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

            $this->start_controls_section(
                'section_title_style',
                [
                    'label' => __( 'Style', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'icon_color',
                [
                    'label' => __( 'Icon Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-wishlist .my-wishlist-wrap .haru-wishlist-link' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'wishlist_title_color',
                [
                    'label' => __( 'Wishlist Title Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .bottom-bar-title' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-2' ],
                    ],
                ]
            );

            $this->end_controls_section();
        }

        protected function render() {
            if ( ! class_exists('YITH_WCWL') ) {
                return;
            }

            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'wishlist', 'class', 'haru-wishlist' );

            $this->add_render_attribute( 'wishlist', 'class', 'haru-wishlist--' . $settings['pre_style'] );

            if ( ! empty( $settings['align'] ) ) { 
                $this->add_render_attribute( 'wishlist', 'class', 'haru-wishlist--' . $settings['align'] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'wishlist', 'class', $settings['el_class'] );
            }
            ?>

            <div <?php echo $this->get_render_attribute_string( 'wishlist' ); ?>>
                <?php echo Haru_Template::haru_get_template( 'woo-wishlist/woo-wishlist.php', $settings ); ?>
            </div>

            <?php
        }

    }
}
