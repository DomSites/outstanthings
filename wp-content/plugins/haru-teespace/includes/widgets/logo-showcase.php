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
use \Elementor\Repeater;
use \Elementor\Plugin;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Logo_Showcase_Widget' ) ) {
    class Haru_TeeSpace_Logo_Showcase_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-logo-showcase';
        }

        public function get_title() {
            return esc_html__( 'Haru Logo Showcase', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-slider-album';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'logo',
                'client',
                'showcase',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['slick', 'other_conditional_script'];
            }

            if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'slick', 'slick-2' ) ) ) {
                return [ 'slick' ];
         //    } else if ( $this->get_settings_for_display( 'condition' ) === 'yes' ) {
         //        return [ 'other_conditional_script' ];
            }

            return [ 'slick' ];

        }

        public function get_style_depends() {
            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['slick', 'other_conditional_script'];
            }

            if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'slick', 'slick-2' ) ) ) {
                return [ 'slick' ];
            }

            return [ 'slick' ];
        }

        protected function register_controls() {

            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__( 'Content', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Logo Showcase', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Logo Showcase you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'slick',
                    'options' => [
                        'slick'     => __( 'Slick Carousel', 'haru-teespace' ),
                        'slick-2'   => __( 'Slick 2 Creative', 'haru-teespace' ),
                        'grid'      => __( 'Grid', 'haru-teespace' ),
                    ]
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'list_title', [
                    'label' => esc_html__( 'Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'List Title' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_description', [
                    'label' => esc_html__( 'Description', 'haru-teespace' ),
                    'description'   => __( 'Use for Slick 2 Creative layout.', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'List Description' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_logo',
                [
                    'label'     => esc_html__( 'Choose Logo', 'haru-teespace' ),
                    'type'      => Controls_Manager::MEDIA,
                    'dynamic'   => [
                        'active'    => true,
                    ],
                    'default'   => [
                        'url'       => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $repeater->add_control(
                'list_link', [
                    'label' => esc_html__( 'Link', 'haru-teespace' ),
                    'description'   => __( 'Do not use for Slick 2 Creative layout.', 'haru-teespace' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', 'haru-teespace' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
            );

            $this->add_control(
                'list',
                [
                    'label' => esc_html__( 'Link List', 'haru-teespace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'list_title' => esc_html__( 'Title #1', 'haru-teespace' ),
                            'list_description' => esc_html__( 'Description #1', 'haru-teespace' ),
                            'list_logo' => esc_html__( 'Select Image', 'haru-teespace' ),
                            'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-teespace' ),
                        ],
                        [
                            'list_title' => esc_html__( 'Title #2', 'haru-teespace' ),
                            'list_description' => esc_html__( 'Description #2', 'haru-teespace' ),
                            'list_logo' => esc_html__( 'Select Image', 'haru-teespace' ),
                            'list_link' => esc_html__( 'Item Link. Click the edit button to change this text.', 'haru-teespace' ),
                        ],
                    ],
                    'title_field' => '{{{ list_title }}}',
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

            $this->add_control(
                'hover',
                [
                    'label' => __( 'Hover Style', 'haru-teespace' ),
                    'description'   => __( 'Choose Logo Hover style.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'      => __( 'None', 'haru-teespace' ),
                        'opacity'   => __( 'Opacity', 'haru-teespace' ),
                        'opacity-2' => __( 'Opacity 2', 'haru-teespace' ),
                        'grayscale' => __( 'GrayScale', 'haru-teespace' ),
                        'scale'     => __( 'Scale', 'haru-teespace' ),
                        'shadow'    => __( 'Shadow', 'haru-teespace' ),
                    ],
                    'condition' => [
                        'pre_style!' => [ 'slick-2' ],
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'grid_section',
                [
                    'label' => esc_html__( 'Grid Options', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'pre_style',
                                'operator' => '==',
                                'value' => 'grid',
                            ],
                        ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_grid_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Grid Options if you set Pre Logo Showcase is Grid layout.', 'haru-teespace' ) . '</strong><br>',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );

            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '3',
                    'tablet_default'    => '2',
                    'mobile_default'    => '1',
                    'condition' => [
                        'pre_style' => [ 'grid' ],
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'slide_section',
                [
                    'label' => esc_html__( 'Slide Options', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_slide_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Slide Options if you set Pre Logo Showcase is Slick layout.', 'haru-teespace' ) . '</strong><br>',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );

            $this->add_control(
                'arrows', [
                    'label' => __( 'Arrows', 'haru-teespace' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'haru-teespace' ),
                    'label_off' => __( 'Hide', 'haru-teespace' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2' ],
                    ],
                ]
            );

            $this->add_control(
                'rows',
                [
                    'label' => __( 'Number of Rows', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 3,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'pre_style' => [ 'slick' ],
                    ],
                ]
            );


            $this->add_responsive_control(
                'slidesToShow',
                [
                    'label' => __( 'Slide To Show', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '3',
                    'tablet_default'    => '2',
                    'mobile_default'    => '1',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2' ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'slidesToScroll',
                [
                    'label' => __( 'Slide To Scroll', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '1',
                    'tablet_default'    => '1',
                    'mobile_default'    => '1',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2' ],
                    ],
                ]
            );

            $this->add_control(
                'autoPlay',
                [
                    'label'         => __( 'AutoPlay', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2' ],
                    ],
                ]
            );

            $this->add_control(
                'autoPlaySpeed',
                [
                    'label' => __( 'AutoPlay Speed (ms)', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1000,
                    'max' => 10000,
                    'step' => 100,
                    'default' => 3000,
                    'condition' => [
                        'autoPlay' => [ 'yes' ],
                    ],
                ]
            );

            $this->add_control(
                'loop',
                [
                    'label'         => __( 'Loop', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2' ],
                    ],
                ]
            );

            $this->end_controls_section();

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            if ( '' === $settings['list'] ) {
                return;
            }

            $this->add_render_attribute( 'logo-showcase', 'class', 'haru-logo-showcase' );

            $this->add_render_attribute( 'logo-showcase', 'class', 'haru-logo-showcase--' . $settings['pre_style'] );

            $this->add_render_attribute( 'logo-showcase', 'class', 'haru-logo-showcase--' . $settings['hover'] );

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'logo-showcase', 'class', $settings['el_class'] );
            }

            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'logo-showcase' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'logo-showcase/logo-showcase.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
