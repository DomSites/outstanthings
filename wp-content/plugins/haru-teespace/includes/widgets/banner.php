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

if ( ! class_exists( 'Haru_TeeSpace_Banner_Widget' ) ) {
    class Haru_TeeSpace_Banner_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-banner';
        }

        public function get_title() {
            return esc_html__( 'Haru Banner', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-image';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'banner',
                'image',
                'advertising',
                'advertise',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_settings',
                [
                    'label'     => esc_html__( 'Banner Settings', 'haru-teespace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Banner', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Banner you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-0',
                    'options' => [
                        'style-0'   => __( 'Pre Banner Default', 'haru-teespace' ),
                        'style-1'   => __( 'Pre Banner 1', 'haru-teespace' ),
                        'style-2'   => __( 'Pre Banner 2', 'haru-teespace' ),
                        'style-3'   => __( 'Pre Banner 3', 'haru-teespace' ),
                        'style-4'   => __( 'Pre Banner 4', 'haru-teespace' ),
                        'style-5'   => __( 'Pre Banner 5', 'haru-teespace' ),
                        'style-6'   => __( 'Pre Banner 6', 'haru-teespace' ),
                        'style-7'   => __( 'Pre Banner 7', 'haru-teespace' ),
                        'style-8'   => __( 'Pre Banner 8', 'haru-teespace' ),
                        'style-9'   => __( 'Pre Banner 9', 'haru-teespace' ),
                        'style-10'  => __( 'Pre Banner 10', 'haru-teespace' ),
                        'style-11'  => __( 'Pre Banner 11', 'haru-teespace' ),
                        'style-12'  => __( 'Pre Banner 12', 'haru-teespace' ),
                        'style-13'  => __( 'Pre Banner 13', 'haru-teespace' ),
                        'style-14'  => __( 'Pre Banner 14', 'haru-teespace' ),
                        'style-15'  => __( 'Pre Banner 15', 'haru-teespace' ),
                        'style-16'  => __( 'Pre Banner 16', 'haru-teespace' ),
                        'style-17'  => __( 'Pre Banner 17', 'haru-teespace' ),
                        'style-18'  => __( 'Pre Banner 18', 'haru-teespace' ),
                        'style-19'  => __( 'Pre Banner 19', 'haru-teespace' ),
                        'style-20'  => __( 'Pre Landing 1- Home', 'haru-teespace' ),
                        'style-21'  => __( 'Pre Landing 2', 'haru-teespace' ),
                        'style-22'  => __( 'Pre Landing 3', 'haru-teespace' ),
                        'style-23'  => __( 'Pre Banner 23', 'haru-teespace' ),
                        'style-24'  => __( 'Pre Banner 24', 'haru-teespace' ),
                        'style-25'  => __( 'Pre Banner 25', 'haru-teespace' ),
                        'style-26'  => __( 'Pre Banner 26', 'haru-teespace' ),
                        'style-27'  => __( 'Pre Banner 27', 'haru-teespace' ),
                        'style-28'  => __( 'Pre Menu Homepage', 'haru-teespace' ),
                    ]
                ]
            );

            $this->add_control(
                'image',
                [
                    'label'     => esc_html__( 'Choose Image', 'haru-teespace' ),
                    'type'      => Controls_Manager::MEDIA,
                    'dynamic'   => [
                        'active'    => true,
                    ],
                    'default'   => [
                        'url'       => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $this->add_control(
                'title',
                [
                    'label' => esc_html__( 'Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Banner Title' , 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-3', 'style-4', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10', 'style-11', 'style-12', 'style-13', 'style-14', 'style-15', 'style-16', 'style-17', 'style-18', 'style-19', 'style-20', 'style-21', 'style-22', 'style-23', 'style-24', 'style-26', 'style-27', 'style-28' ],
                    ],
                ]
            );

            $this->add_control(
                'sub_title',
                [
                    'label' => esc_html__( 'Sub Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Sub Title' , 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-4', 'style-5', 'style-9', 'style-10', 'style-11', 'style-13', 'style-14', 'style-15', 'style-20', 'style-21', 'style-23', 'style-24', 'style-26', 'style-27', 'style-28' ],
                    ],
                ]
            );

            $this->add_control(
                'description',
                [
                    'label' => esc_html__( 'Description', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'Banner Description' , 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-3', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10', 'style-12', 'style-17', 'style-18', 'style-27' ],
                    ],
                ]
            );

            $this->add_control(
                'button_text',
                [
                    'label' => esc_html__( 'Button Text', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Click Here' , 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-3', 'style-5', 'style-6', 'style-8', 'style-9', 'style-10', 'style-11', 'style-16', 'style-17', 'style-18', 'style-19', 'style-23', 'style-24', 'style-25', 'style-27' ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'button_rotate',
                [
                    'label' => __( 'Button Rotate', 'haru-teespace' ),
                    'type' => Controls_Manager::CHOOSE,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'haru-teespace' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'None', 'haru-teespace' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'haru-teespace' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'desktop_default'    => '',
                    'tablet_default'    => '',
                    'mobile_default'    => '',
                    'selectors_dictionary' => [
                        'left'      => 'transform: rotate(3deg)',
                        'center'    => '',
                        'right'     => 'transform: rotate(-3deg)',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .haru-banner__btn' => '{{VALUE}};',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-25' ],
                    ],
                ]
            );

            $this->add_control(
                'link',
                [
                    'label' => __( 'Link', 'haru-teespace' ),
                    'type' => Controls_Manager::URL,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'placeholder' => __( 'https://your-link.com', 'haru-teespace' ),
                    'default' => [
                        'url' => '#',
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
                'section_title_layout',
                [
                    'label' => __( 'Layout', 'haru-teespace' ),
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
                'size',
                [
                    'label' => __( 'Size', 'haru-teespace' ),
                    'description'   => __( 'Set banner size depend on banner Pre style.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'default',
                    'options' => [
                        'default'   => __( 'Default', 'haru-teespace' ),
                        // 'small'   => __( 'Small', 'haru-teespace' ),
                        'medium'   => __( 'Medium', 'haru-teespace' ),
                        // 'large'   => __( 'Large', 'haru-teespace' ),
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-4' ],
                    ],
                ]
            );

            $this->add_control(
                'hover',
                [
                    'label' => __( 'Hover', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'     => __( 'None', 'haru-teespace' ),
                        'scale'     => __( 'Scale', 'haru-teespace' ),
                        'overlay'     => __( 'Overlay', 'haru-teespace' ),
                        'scale-overlay'     => __( 'Scale + Overlay', 'haru-teespace' ),
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-0' ],
                    ],
                ]
            );

            $this->add_control(
                'shadow',
                [
                    'label'         => __( 'Shadow', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Enable if want to show shadow of banner.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'condition' => [
                        'pre_style' => [ 'style-0' ],
                    ],
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Title Color', 'haru-pricom' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-banner__title,
                        {{WRAPPER}} .haru-banner__title a' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-3', 'style-4', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10', 'style-11', 'style-12', 'style-13', 'style-14', 'style-15', 'style-16', 'style-17', 'style-18', 'style-19', 'style-20', 'style-21', 'style-22', 'style-23', 'style-24', 'style-26', 'style-27', 'style-28' ],
                    ],
                ]
            );

            $this->add_control(
                'title_bg_color',
                [
                    'label' => __( 'Title Color', 'haru-pricom' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-banner__title,
                        {{WRAPPER}} .haru-banner__title a' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-26' ],
                    ],
                ]
            );

            $this->add_control(
                'sub_title_color',
                [
                    'label' => __( 'Sub Title Color', 'haru-pricom' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-banner__sub-title,
                        {{WRAPPER}} .haru-banner__sub-title a' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-4', 'style-5', 'style-9', 'style-10', 'style-11', 'style-13', 'style-14', 'style-15', 'style-20', 'style-21', 'style-23', 'style-24', 'style-26', 'style-27', 'style-28' ],
                    ],
                ]
            );

            $this->add_control(
                'sub_title_bg_color',
                [
                    'label' => __( 'Sub Title Background Color', 'haru-pricom' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-banner__sub-title,
                        {{WRAPPER}} .haru-banner__sub-title a' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-5', 'style-9', 'style-10', 'style-20', 'style-23', 'style-26' ],
                    ],
                ]
            );

            $this->add_control(
                'description_color',
                [
                    'label' => __( 'Description Color', 'haru-pricom' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-banner__description,
                        {{WRAPPER}} .haru-banner__description a' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-3', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10', 'style-12', 'style-17', 'style-18', 'style-27' ],
                    ],
                ]
            );

            $this->add_control(
                'description_bg_color',
                [
                    'label' => __( 'Description Background Color', 'haru-pricom' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-banner__description,
                        {{WRAPPER}} .haru-banner__description a' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [],
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'section_title_visibility',
                [
                    'label' => __( 'Visibility', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'style-3', 'style-6', 'style-7', 'style-9', 'style-10', 'style-17', 'style-23' ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'title_display',
                [
                    'label' => __( 'Title Display', 'haru-teespace' ),
                    'type'  => Controls_Manager::SELECT,
                    'desktop_default'    => 'block',
                    'tablet_default'    => 'block',
                    'mobile_default'    => 'block',
                    'condition' => [
                        'pre_style' => [ 'style-3', 'style-6', 'style-7', 'style-9', 'style-10', 'style-17', 'style-23' ],
                    ],
                    'options' => [
                        'none'  => esc_html__( 'None', 'haru-teespace' ),
                        'block' => esc_html__( 'Block', 'haru-teespace' ),
                        'inline-block' => esc_html__( 'Inline Block', 'haru-teespace' ),
                        'flex' => esc_html__( 'Flex', 'haru-teespace' ),
                        'inline-flex' => esc_html__( 'Inline Flex', 'haru-teespace' ),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .haru-banner__title' => 'display: {{VALUE}};',
                    ]
                ]
            );

            $this->add_responsive_control(
                'sub_title_display',
                [
                    'label' => __( 'Sub Title Display', 'haru-teespace' ),
                    'type'  => Controls_Manager::SELECT,
                    'desktop_default'    => 'block',
                    'tablet_default'    => 'block',
                    'mobile_default'    => 'block',
                    'condition' => [
                        'pre_style' => [ 'style-3', 'style-6', 'style-7', 'style-9', 'style-10', 'style-17', 'style-23' ],
                    ],
                    'options' => [
                        'none'  => esc_html__( 'None', 'haru-teespace' ),
                        'block' => esc_html__( 'Block', 'haru-teespace' ),
                        'inline-block' => esc_html__( 'Inline Block', 'haru-teespace' ),
                        'flex' => esc_html__( 'Flex', 'haru-teespace' ),
                        'inline-flex' => esc_html__( 'Inline Flex', 'haru-teespace' ),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .haru-banner__sub-title' => 'display: {{VALUE}};',
                    ]
                ],
            );

            $this->add_responsive_control(
                'description_display',
                [
                    'label' => __( 'Description Display', 'haru-teespace' ),
                    'type'  => Controls_Manager::SELECT,
                    'desktop_default'    => 'block',
                    'tablet_default'    => 'block',
                    'mobile_default'    => 'block',
                    'condition' => [
                        'pre_style' => [ 'style-3', 'style-6', 'style-7', 'style-9', 'style-10', 'style-17' ],
                    ],
                    'options' => [
                        'none'  => esc_html__( 'None', 'haru-teespace' ),
                        'block' => esc_html__( 'Block', 'haru-teespace' ),
                        'inline-block' => esc_html__( 'Inline Block', 'haru-teespace' ),
                        'flex' => esc_html__( 'Flex', 'haru-teespace' ),
                        'inline-flex' => esc_html__( 'Inline Flex', 'haru-teespace' ),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .haru-banner__description' => 'display: {{VALUE}};',
                    ]
                ],
            );
                
            $this->add_responsive_control(
                'button_display',
                [
                    'label' => __( 'Button Display', 'haru-teespace' ),
                    'type'  => Controls_Manager::SELECT,
                    'desktop_default'    => 'inline-flex',
                    'tablet_default'    => 'inline-flex',
                    'mobile_default'    => 'inline-flex',
                    'return_value'  => 'yes',
                    'condition' => [
                        'pre_style' => [ 'style-3', 'style-6', 'style-7', 'style-9', 'style-10', 'style-17', 'style-23' ],
                    ],
                    'options' => [
                        'none'  => esc_html__( 'None', 'haru-teespace' ),
                        'block' => esc_html__( 'Block', 'haru-teespace' ),
                        'inline-block' => esc_html__( 'Inline Block', 'haru-teespace' ),
                        'flex' => esc_html__( 'Flex', 'haru-teespace' ),
                        'inline-flex' => esc_html__( 'Inline Flex', 'haru-teespace' ),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .haru-banner__btn' => 'display: {{VALUE}};',
                    ]
                ]
            );

            $this->end_controls_section();

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'banner', 'class', 'haru-banner' );

            if ( $settings['pre_style']  ) {
                $this->add_render_attribute( 'banner', 'class', 'haru-banner--' . $settings['pre_style'] );
            }

            if ( $settings['size']  ) {
                $this->add_render_attribute( 'banner', 'class', 'haru-banner--size-' . $settings['size'] );
            }

            if ( $settings['hover']  ) {
                $this->add_render_attribute( 'banner', 'class', 'haru-banner--hover-' . $settings['hover'] );
            }

            if ( 'yes' == $settings['shadow']  ) {
                $this->add_render_attribute( 'banner', 'class', 'haru-banner--shadow-' . $settings['shadow'] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'banner', 'class', $settings['el_class'] );
            }
            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'banner' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'banner/banner.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
