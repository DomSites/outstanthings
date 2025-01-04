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
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Plugin;
use \Elementor\Utils;
use \Elementor\Icons_Manager;
use \Elementor\Repeater;
use \Haru_TeeSpace\Classes\Helper;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Menu_Tabs_Widget' ) ) {
    class Haru_TeeSpace_Menu_Tabs_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-menu-tabs';
        }

        public function get_title() {
            return esc_html__( 'Haru Menu Tabs', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-tabs';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'tab',
                'tabs',
                'panel',
                'navigation',
                'menu',
                'group',
                'tabs content',
                'product tabs',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        protected function register_controls() {

            $this->start_controls_section(
                'settings_section',
                [
                    'label' => esc_html__( 'General Settings', 'haru-teespace'  ),
                ]
            );

            $this->add_control(
                'layout',
                [
                    'label' => esc_html__( 'Layout', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'horizontal',
                    'label_block' => false,
                    'options' => [
                        'horizontal' => esc_html__( 'Horizontal', 'haru-teespace' ),
                        'vertical' => esc_html__( 'Vertical', 'haru-teespace' ),
                    ],
                ]
            );

            $this->add_control(
                'icon_show',
                [
                    'label' => esc_html__( 'Enable Icon', 'haru-teespace' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                    'return_value' => 'yes',
                ]
            );

            $this->add_control(
                'icon_position',
                [
                    'label' => esc_html__( 'Icon Position', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'inline-icon',
                    'label_block' => false,
                    'options' => [
                        'top-icon' => esc_html__( 'Stacked', 'haru-teespace' ),
                        'inline-icon' => esc_html__( 'Inline', 'haru-teespace' ),
                    ],
                    'condition' => [
                        'icon_show' => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Tab', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Tab you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Pre Tab 1 (Classic)', 'haru-teespace' ),
                    ]
                ]
            );

            $this->add_control(
                'hover_action',
                [
                    'label' => __( 'Hover Action', 'haru-teespace' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Yes', 'haru-teespace' ),
                    'label_off' => __( 'No', 'haru-teespace' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__( 'Content', 'haru-teespace' ),
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
                'list_show_as_default', [
                    'label' => __( 'Set as Default', 'haru-teespace' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'inactive',
                    'return_value' => 'active-default',
                ]
            );

            $repeater->add_control(
                'list_icon_type', [
                    'label' => esc_html__( 'Icon', 'haru-teespace' ),
                    'type' => Controls_Manager::CHOOSE,
                    'label_block' => false,
                    'options' => [
                        'none' => [
                            'title' => esc_html__( 'None', 'haru-teespace' ),
                            'icon' => 'fas fa-ban',
                        ],
                        'icon' => [
                            'title' => esc_html__( 'Icon', 'haru-teespace' ),
                            'icon' => 'fas fa-cog',
                        ],
                        'image' => [
                            'title' => esc_html__( 'Image', 'haru-teespace' ),
                            'icon' => 'fas fa-image',
                        ],
                    ],
                    'default' => 'icon',
                ]
            );

            $repeater->add_control(
                'list_title_icon', [
                    'label' => esc_html__( 'Icon', 'haru-teespace' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-star',
                        'library' => 'solid',
                    ],
                    'label_block' => true,
                    'condition' => [
                        'list_icon_type' => 'icon',
                    ],
                ]
            );

            $repeater->add_control(
                'list_title_image', [
                    'label' => esc_html__( 'Image', 'haru-teespace' ),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'list_icon_type' => 'image',
                    ],
                ]
            );

            $repeater->add_control(
                'list_text_type', [
                    'label' => __( 'Content Type', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'content' => __( 'Content', 'haru-teespace' ),
                        'template' => __( 'Content Builders', 'haru-teespace' ),
                    ],
                    'default' => 'content',
                ]
            );

            $repeater->add_control(
                'list_primary_templates', [
                    'label' => __( 'Choose Template', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => Helper::get_content_templates(),
                    'condition' => [
                        'list_text_type' => 'template',
                    ],
                ]
            );

            $repeater->add_control(
                'list_tab_content', [
                    'label' => esc_html__( 'Tab Content', 'haru-teespace' ),
                    'type' => Controls_Manager::WYSIWYG,
                    'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'haru-teespace' ),
                    'dynamic' => [ 'active' => true ],
                    'condition' => [
                        'list_text_type' => 'content',
                    ],
                ]
            );

            $this->add_control(
                'list',
                [
                    'label' => esc_html__( 'Tab List', 'haru-teespace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'list_title' => esc_html__( 'Tab Title 1', 'haru-teespace' ),
                            'list_show_as_default' => 'inactive',
                            'list_icon_type' => 'icon',
                            'list_title_icon' => '',
                            'list_title_image' => '',
                            'list_text_type' => 'content',
                            'list_primary_templates' => '',
                            'list_tab_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'haru-teespace' ),
                        ],
                        [
                            'list_title' => esc_html__( 'Tab Title 2', 'haru-teespace' ),
                            'list_show_as_default' => 'inactive',
                            'list_icon_type' => 'icon',
                            'list_title_icon' => '',
                            'list_title_image' => '',
                            'list_text_type' => 'content',
                            'list_primary_templates' => '',
                            'list_tab_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'haru-teespace' ),
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

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            if ( '' === $settings['list'] ) {
                return;
            }

            $this->add_render_attribute( 'menu-tab', 'class', [ 'haru-menu-tab', 'haru-menu-tab--' . $settings['layout'] ] );

            if ( '' != $settings['pre_style']  ) {
                $this->add_render_attribute( 'menu-tab', 'class', 'haru-menu-tab--' . $settings['pre_style'] );
            }

            if ( 'yes' == $settings['hover_action'] ) {
                $this->add_render_attribute( 'menu-tab', 'class', [ 'haru-menu-tab--hover' ] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'menu-tab', 'class', $settings['el_class'] );
            }

            $this->add_render_attribute( 'menu-tab', 'id', 'haru-menu-tab-' . $this->get_id() );

            $this->add_render_attribute( 'icon_position', 'class', $settings['icon_position'] );

            ?>

            <div <?php echo $this->get_render_attribute_string( 'menu-tab' ); ?>>
                <div class="haru-menu-tab__nav">
                    <?php if ( $settings['list'] ) : ?>
                    <ul <?php echo $this->get_render_attribute_string( 'icon_position' ); ?>>
                        <?php foreach ( $settings['list'] as $tab ) : ?>
                            <li class="<?php echo esc_attr( $tab['list_show_as_default'] ); ?>">
                                <?php if ( $settings['icon_show'] === 'yes' ) : ?>
                                    <?php if ( $tab['list_icon_type'] === 'icon' ) : ?>
                                    <span class="haru-menu-tab__icon"><?php Icons_Manager::render_icon( $tab['list_title_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                                    <?php elseif ( $tab['list_icon_type'] === 'image') : ?>
                                        <img src="<?php echo esc_attr( $tab['list_title_image']['url'] ); ?>" alt="<?php echo esc_attr( get_post_meta( $tab['list_title_image']['id'], '_wp_attachment_image_alt', true ) ); ?>">
                                    <?php endif;?>
                                <?php endif; ?><span class="haru-menu-tab__title"><?php echo $tab['list_title']; ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
                <div class="haru-menu-tab__content">
                    <?php foreach ( $settings['list'] as $tab ) : ?>
                        <div class="clearfix <?php echo esc_attr( $tab['list_show_as_default'] ); ?>">
                            <?php if ( 'content' == $tab['list_text_type'] ) : ?>
                                <?php echo do_shortcode( $tab['list_tab_content'] ); ?>
                            <?php elseif ( 'template' == $tab['list_text_type'] ) : ?>
                                <?php 
                                    if ( ! empty( $tab['list_primary_templates'] ) ) :
                                        echo Plugin::$instance->frontend->get_builder_content( $tab['list_primary_templates'], true );
                                    endif;
                                ?>
                            <?php endif;?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }

    }
}
