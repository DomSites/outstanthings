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

if ( ! class_exists( 'Haru_TeeSpace_Close_Row_Widget' ) ) {
    class Haru_TeeSpace_Close_Row_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-close-row';
        }

        public function get_title() {
            return esc_html__( 'Haru Close Row', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-button';
        }

        public function get_categories() {
            return [ 'haru-header-elements' ];
        }

        public function get_keywords() {
            return [
                'close',
                'section row',
                'container',
                'header',
                'top bar',
                'button',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_settings',
                [
                    'label'     => esc_html__( 'Close Row Settings', 'haru-teespace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'section_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => __( 'Please note this widget use to close Row on the Header. Example: Top Bar.', 'haru-teespace' ),
                    'separator' => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
            

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Close Row', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Close Row you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Pre Close Row 1', 'haru-teespace' ),
                        'style-2'   => __( 'Pre Close Row 2', 'haru-teespace' ),
                    ]
                ]
            );

            // $this->add_control(
            //     'auto_close',
            //     [
            //         'label'         => esc_html__( 'Auto Close', 'haru-teespace' ),
            //         'type'          => Controls_Manager::SWITCHER,
            //         'label_on'      => esc_html__( 'On', 'haru-teespace' ),
            //         'label_off'     => esc_html__( 'Off', 'haru-teespace' ),
            //         'return_value'  => 'yes',
            //         'default'       => 'yes',
            //     ]
            // );

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
                        '{{WRAPPER}} .haru-close-row' => 'justify-content: {{VALUE}}',
                    ]
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

            $this->add_render_attribute( 'close-row', 'class', 'haru-close-row' );

            $this->add_render_attribute( 'close-row', 'class', 'haru-close-row--' . $settings['pre_style'] );

            if ( ! empty( $settings['align'] ) ) {
                $this->add_render_attribute( 'close-row', 'class', 'haru-close-row--' . $settings['align'] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'close-row', 'class', $settings['el_class'] );
            }
            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'close-row' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'close-row/close-row.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
