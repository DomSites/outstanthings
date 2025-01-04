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
use \Haru_TeeSpace\Classes\Helper as ControlsHelper;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Woo_Account_Widget' ) ) {
    class Haru_TeeSpace_Woo_Account_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-woo-account';
        }

        public function get_title() {
            return esc_html__( 'Haru Woo Account', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-my-account';
        }

        public function get_categories() {
            return [ 'haru-header-elements' ];
        }

        public function get_keywords() {
            return [
                'account',
                'checkout',
                'cart',
                'dashboard',
                'log in',
                'log out',
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
                    'label'     => esc_html__( 'Account Settings', 'haru-teespace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Account', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Account you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Pre Account 1 (Icon)', 'haru-teespace' ),
                        'style-2'   => __( 'Pre Account 2 (Button Small)', 'haru-teespace' ),
                        'style-3'   => __( 'Pre Account 3 (Button)', 'haru-teespace' ),
                        'style-4'   => __( 'Pre Account 4 (Toolbar)', 'haru-teespace' ),
                    ]
                ]
            );

            $this->add_control(
                'account_title',
                [
                    'label' => esc_html__( 'Account Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'My account' , 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-4' ],
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
                        '{{WRAPPER}} .haru-account' => 'justify-content: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style!' => [ 'style-4' ],
                    ],
                ]
            );

            $this->add_control(
                'login_text',
                [
                    'label' => __( 'Login Text', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Login', 'haru-teespace' ),
                    'placeholder' => __( 'Login', 'haru-teespace' ),
                    'condition' => [
                        'pre_style' => array( 'style-2', 'style-3' ),
                    ],
                ]
            );

            // $this->add_control(
            //     'logout_text',
            //     [
            //         'label' => __( 'Logout Text', 'haru-teespace' ),
            //         'type' => Controls_Manager::TEXT,
            //         'default' => __( 'Logout', 'haru-teespace' ),
            //         'placeholder' => __( 'Logout', 'haru-teespace' ),
            //     ]
            // );

            $this->add_control(
                'register_text',
                [
                    'label' => __( 'Register Text', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Register', 'haru-teespace' ),
                    'placeholder' => __( 'Register', 'haru-teespace' ),
                    'condition' => [
                        'pre_style' => array( 'style-2', 'style-3' ),
                    ],
                ]
            );

            $this->add_control(
                'custom_account',
                [
                    'label'         => __( 'Custom Account', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Enable if want to custom account link.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'separator'     => 'before',
                ]
            );

            $this->add_control(
                'custom_login_page',
                [
                    'label' => __( 'Login Page', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => ControlsHelper::get_post_list('page'),
                    'label_block' => true,
                    'post_type' => '',
                    'multiple' => false,
                    'condition' => [
                        'custom_account' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'custom_logout_page',
                [
                    'label' => __( 'Logout Page', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => ControlsHelper::get_post_list('page'),
                    'label_block' => true,
                    'post_type' => '',
                    'multiple' => false,
                    'condition' => [
                        'custom_account' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'custom_register_page',
                [
                    'label' => __( 'Register Page', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => ControlsHelper::get_post_list('page'),
                    'label_block' => true,
                    'post_type' => '',
                    'multiple' => false,
                    'condition' => [
                        'pre_style' => array( 'style-2', 'style-3' ),
                        'custom_account' => 'yes',
                    ],
                ]
            );

            // @TODO: Add custom page to menu

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
                        '{{WRAPPER}} .haru-account .haru-account__link' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-4' ],
                    ],
                ]
            );

            $this->add_control(
                'account_title_color',
                [
                    'label' => __( 'Account Title Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .bottom-bar-title' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-4' ],
                    ],
                ]
            );

            $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'account', 'class', 'haru-account' );

            $this->add_render_attribute( 'account', 'class', 'haru-account--' . $settings['pre_style'] );

            if ( ! empty( $settings['align'] ) ) { 
                $this->add_render_attribute( 'account', 'class', 'haru-account--' . $settings['align'] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'account', 'class', $settings['el_class'] );
            }
            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'account' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'woo-account/woo-account.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
