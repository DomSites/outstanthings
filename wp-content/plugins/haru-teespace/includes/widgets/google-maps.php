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
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Settings;
use \Elementor\Utils;
use \Elementor\Plugin;
use \Elementor\Modules\DynamicTags\Module as TagsModule;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Google_Maps_Widget' ) ) {
    class Haru_TeeSpace_Google_Maps_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-google-maps';
        }

        public function get_title() {
            return esc_html__( 'Haru Google Maps', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-google-maps';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'google-maps',
                'google',
                'map',
                'address',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_settings',
                [
                    'label'     => esc_html__( 'Google Maps Settings', 'haru-teespace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            if ( Plugin::$instance->editor->is_edit_mode() ) {
                $api_key = get_option( 'elementor_google_maps_api_key' );

                if ( ! $api_key ) {
                    $this->add_control(
                        'api_key_notification',
                        [
                            'type' => Controls_Manager::RAW_HTML,
                            'raw' => sprintf(
                                __( 'Set your Google Maps API Key in Elementor\'s <a href="%1$s" target="_blank">Integrations Settings</a> page. Create your key <a href="%2$s" target="_blank">here.', 'haru-teespace' ),
                                Settings::get_url() . '#tab-integrations',
                                'https://developers.google.com/maps/documentation/embed/get-api-key'
                            ),
                            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                        ]
                    );
                }
            }

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Google Maps', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Google Maps you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'   => __( 'None (Default)', 'haru-teespace' ),
                        'style-1'   => __( 'Pre Google Maps 1 (Filter Gray)', 'haru-teespace' ),
                        'style-2'   => __( 'Pre Google Maps 2 (Filter Pink)', 'haru-teespace' ),
                    ]
                ]
            );

            $default_address = __( 'London Eye, London, United Kingdom', 'haru-teespace' );
            $this->add_control(
                'address',
                [
                    'label' => __( 'Location', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                        'categories' => [
                            TagsModule::POST_META_CATEGORY,
                        ],
                    ],
                    'placeholder' => $default_address,
                    'default' => $default_address,
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'zoom',
                [
                    'label' => __( 'Zoom', 'haru-teespace' ),
                    'type' => Controls_Manager::SLIDER,
                    'default' => [
                        'size' => 10,
                    ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 20,
                        ],
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'height',
                [
                    'label' => __( 'Height', 'haru-teespace' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 40,
                            'max' => 1440,
                        ],
                        'vh' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'size_units' => [ 'px', 'vh' ],
                    'selectors' => [
                        '{{WRAPPER}} iframe' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'view',
                [
                    'label' => __( 'View', 'haru-teespace' ),
                    'type' => Controls_Manager::HIDDEN,
                    'default' => 'traditional',
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
                'section_title_style',
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
                'section_map_style',
                [
                    'label' => __( 'Map', 'haru-teespace' ),
                    'tab'   => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'none' ],
                    ],
                ]
            );

            $this->start_controls_tabs( 'map_filter' );

            $this->start_controls_tab( 'normal',
                [
                    'label' => __( 'Normal', 'haru-teespace' ),
                ]
            );

            $this->add_group_control(
                Group_Control_Css_Filter::get_type(),
                [
                    'name' => 'css_filters',
                    'selector' => '{{WRAPPER}} iframe',
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab( 'hover',
                [
                    'label' => __( 'Hover', 'haru-teespace' ),
                ]
            );

            $this->add_group_control(
                Group_Control_Css_Filter::get_type(),
                [
                    'name' => 'css_filters_hover',
                    'selector' => '{{WRAPPER}}:hover iframe',
                ]
            );

            $this->add_control(
                'hover_transition',
                [
                    'label' => __( 'Transition Duration', 'haru-teespace' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 3,
                            'step' => 0.1,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} iframe' => 'transition-duration: {{SIZE}}s',
                    ],
                ]
            );

            $this->end_controls_tab();

            $this->end_controls_tabs();

            $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'google-maps', 'class', 'haru-google-maps' );

            if ( $settings['pre_style']  ) {
                $this->add_render_attribute( 'google-maps', 'class', 'haru-google-maps--' . $settings['pre_style'] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'google-maps', 'class', $settings['el_class'] );
            }

            if ( empty( $settings['address'] ) ) {
                return;
            }

            if ( 0 === absint( $settings['zoom']['size'] ) ) {
                $settings['zoom']['size'] = 10;
            }

            $api_key = esc_html( get_option( 'elementor_google_maps_api_key' ) );

            $params = [
                rawurlencode( $settings['address'] ),
                absint( $settings['zoom']['size'] ),
                esc_attr( $settings['address'] ),
            ];

            if ( $api_key ) {
                $params[] = $api_key;

                $url = 'https://www.google.com/maps/embed/v1/place?key=%4$s&q=%1$s&amp;zoom=%2$d';
            } else {
                $url = 'https://maps.google.com/maps?q=%1$s&amp;t=m&amp;z=%2$d&amp;output=embed&amp;iwloc=near';
            }

            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'google-maps' ); ?>>
                    <?php //echo Haru_Template::haru_get_template( 'google-maps/google-maps.php', $settings ); ?>
                    <div class="haru-custom-embed">
                        <iframe src="<?php echo vsprintf( $url, $params ); ?>" title="%3$s" aria-label="%3$s"></iframe>
                    </div>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
