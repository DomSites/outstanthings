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

if ( ! class_exists( 'Haru_TeeSpace_Testimonial_Widget' ) ) {
    class Haru_TeeSpace_Testimonial_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-testimonial';
        }

        public function get_title() {
            return esc_html__( 'Haru Testimonial', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-testimonial';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'testimonial',
                'client',
                'showcase',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['slick', 'flickity'];
            }

            if ( $this->get_settings_for_display( 'pre_style' ) == 'scroll' ) {
                return ['flickity'];
            }

            return [ 'slick' ];

        }

        public function get_style_depends() {
            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['slick'];
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
                    'label' => __( 'Pre Testimonial', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Testimonial you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'slick',
                    'options' => [
                        'slick'     => __( 'Slick', 'haru-teespace' ),
                        'slick-2'   => __( 'Slick 2', 'haru-teespace' ),
                        'slick-3'   => __( 'Slick 3', 'haru-teespace' ),
                        'slick-4'   => __( 'Slick 4', 'haru-teespace' ),
                        'slick-5'   => __( 'Slick 5', 'haru-teespace' ),
                        'slick-6'   => __( 'Slick 6', 'haru-teespace' ),
                        'slick-7'   => __( 'Slick 7', 'haru-teespace' ),
                        'slick-8'   => __( 'Slick 8', 'haru-teespace' ),
                        'slick-9'   => __( 'Slick 9', 'haru-teespace' ),
                        'grid'      => __( 'Grid', 'haru-teespace' ),
                        'grid-2'    => __( 'Grid 2 (2 Columns)', 'haru-teespace' ),
                        'scroll'    => __( 'Auto Scroll', 'haru-teespace' ),
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
                'list_sub_title', [
                    'label' => esc_html__( 'Sub Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'List Sub Title' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_description_title', [
                    'label' => esc_html__( 'Description Title', 'haru-teespace' ),
                    'description'   => __( 'Use for Pre Testimonial 7.', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Description Title' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_description', [
                    'label' => esc_html__( 'Description', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'List Description' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_image',
                [
                    'label'     => esc_html__( 'Choose Image', 'haru-teespace' ),
                    'description'   => __( 'Use for Pre Testimonial Slick 2 or Slick 5, 7, 8, 9 or Scroll.', 'haru-teespace' ),
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
                'list_rating',
                [
                    'label' => esc_html__( 'Rating', 'haru-teespace' ),
                    'description'   => __( 'Use for Pre Testimonial Slick 2 or 6, 7, 8 or Scroll.', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 5,
                    'step' => 1,
                    'default'   => 5,
                ]
            );

            $repeater->add_control(
                'list_link', [
                    'label' => esc_html__( 'Link', 'haru-teespace' ),
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
                    'label' => esc_html__( 'Testimonial List', 'haru-teespace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'list_title' => esc_html__( 'Title #1', 'haru-teespace' ),
                            'list_sub_title' => esc_html__( 'Sub Title', 'haru-teespace' ),
                            'list_description' => esc_html__( 'Description.', 'haru-teespace' ),
                        ],
                        [
                            'list_title' => esc_html__( 'Title #2', 'haru-teespace' ),
                            'list_sub_title' => esc_html__( 'Sub Title', 'haru-teespace' ),
                            'list_description' => esc_html__( 'Description', 'haru-teespace' ),
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

            $this->end_controls_section();

            $this->start_controls_section(
                'scroll_section',
                [
                    'label' => esc_html__( 'Scroll Options', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'scroll' ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'scroll_columns',
                [
                    'label' => __( 'Columns', 'haru-teespace' ),
                    'description'   => __( 'From 1 to 6.', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '3',
                    'tablet_default'    => '2',
                    'mobile_default'    => '1',
                    'condition' => [
                        'pre_style' => [ 'scroll' ],
                    ],
                ]
            );

            $this->add_control(
                'scroll_time',
                [
                    'label' => __( 'Text Scroll Speed', 'haru-teespace' ),
                    'description'   => __( 'Scroll Speed , 1 is lowest.', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default'   => 1,
                ]
            );

            $this->add_control(
                'rtl',
                [
                    'label'         => __( 'RTL', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Right to Left direction.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'grid_section',
                [
                    'label' => esc_html__( 'Grid Options', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'grid' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_grid_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Grid Options if you set Pre Testimonial is Grid or None layout.', 'haru-teespace' ) . '</strong><br>',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
            
            $this->add_control(
                'heading_desktop_grid_options',
                [
                    'label'     => __( 'Desktop Settings', 'haru-teespace' ),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'none', 'grid' ],
                    ],
                ]
            );

            $this->add_control(
                'columns',
                [
                    'label' => __( 'Columns', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'pre_style' => [ 'none', 'grid' ],
                    ],
                ]
            );
            
            $this->add_control(
                'heading_tablet_grid_options',
                [
                    'label'     => __( 'Tablet Settings', 'haru-teespace' ),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'none', 'grid' ],
                    ],
                ]
            );

            $this->add_control(
                'columns_tablet',
                [
                    'label' => __( 'Columns', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 6,
                    'step' => 1,
                    'default' => 4,
                    'condition' => [
                        'pre_style' => [ 'none', 'grid' ],
                    ],
                ]
            );
            
            $this->add_control(
                'heading_mobile_grid_options',
                [
                    'label'     => __( 'Mobile Settings', 'haru-teespace' ),
                    'type'      => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'none', 'grid' ],
                    ],
                ]
            );

            $this->add_control(
                'columns_mobile',
                [
                    'label' => __( 'Columns', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 4,
                    'step' => 1,
                    'default' => 1,
                    'condition' => [
                        'pre_style' => [ 'none', 'grid' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_slide_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Slide Options if you set Pre Testimonial is Slick layout.', 'haru-teespace' ) . '</strong><br>',
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9' ],
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
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3', 'slick-4', 'slick-5', 'slick-6', 'slick-7', 'slick-8', 'slick-9' ],
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

            $this->end_controls_section();

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            if ( '' === $settings['list'] ) {
                return;
            }

            $this->add_render_attribute( 'testimonial', 'class', 'haru-testimonial' );

            $this->add_render_attribute( 'testimonial', 'class', 'haru-testimonial--' . $settings['pre_style'] );

            if ( in_array( $settings['pre_style'], array( 'scroll' ) ) ) {
                $this->add_render_attribute( 'testimonial', 'id', 'haru-testimonial-' . $this->get_id() );
                $this->add_render_attribute( 'testimonial', 'data-id', 'haru-testimonial-' . $this->get_id() );
                $this->add_render_attribute( 'testimonial', 'data-speed', $settings['scroll_time'] );
                $this->add_render_attribute( 'testimonial', 'data-rtl', $settings['rtl'] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'testimonial', 'class', $settings['el_class'] );
            }

            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'testimonial' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'testimonial/testimonial.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
