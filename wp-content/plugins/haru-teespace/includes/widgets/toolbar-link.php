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
use \Elementor\Icons_Manager;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Toolbar_Link_Widget' ) ) {
    class Haru_TeeSpace_Toolbar_Link_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-toolbar-link';
        }

        public function get_title() {
            return esc_html__( 'Haru Toolbar Link', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-icon-box';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'toolbar-link',
                'toolbar',
                'link',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_icon',
                [
                    'label' => __( 'Toolbar Link', 'haru-teespace' ),
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Toolbar Link', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Toolbar Link you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Pre Toolbar Link 1', 'haru-teespace' ),
                    ]
                ]
            );

            $this->add_control(
                'selected_icon',
                [
                    'label' => __( 'Icon', 'haru-teespace' ),
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'default' => [
                        'value' => 'fas fa-star',
                        'library' => 'fa-solid',
                    ],
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
                    'condition' => [
                        'pre_style' => [ 'style-2' ],
                    ],
                ]
            );

            $this->add_control(
                'link_title',
                [
                    'label' => esc_html__( 'Link Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Home' , 'haru-teespace' ),
                    'label_block' => true,
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
                    'separator' => 'before',
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

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'toolbar-link', 'class', 'haru-toolbar-link' );

            if ( $settings['pre_style']  ) {
                $this->add_render_attribute( 'toolbar-link', 'class', 'haru-toolbar-link--' . $settings['pre_style'] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'toolbar-link', 'class', $settings['el_class'] );
            }

            $icon_tag = 'span';

            if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                // add old default
                $settings['icon'] = 'fa fa-star';
            }

            $has_icon = ! empty( $settings['icon'] );

            if ( ! empty( $settings['link']['url'] ) ) {
                $icon_tag = 'a';

                $this->add_link_attributes( 'link', $settings['link'] );
            }

            if ( $has_icon ) {
                $this->add_render_attribute( 'i', 'class', $settings['icon'] );
                $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
            }

            $icon_attributes = $this->get_render_attribute_string( 'icon' );
            $link_attributes = $this->get_render_attribute_string( 'link' );

            if ( ! $has_icon && ! empty( $settings['selected_icon']['value'] ) ) {
                $has_icon = true;
            }
            $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
            $is_new = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

            $target = $settings['link']['is_external'] ? ' target="_blank"' : '';
            $nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'toolbar-link' ); ?>>
                    <?php if ( $has_icon ) : ?>
                        <?php if ( in_array( $settings['pre_style'], array( 'style-1' ) ) ) : ?>
                            <div class="haru-toolbar-link__icon">
                                <<?php echo implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] ); ?>>
                                <?php
                                if ( $is_new || $migrated ) {
                                    Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                                } elseif ( ! empty( $settings['icon'] ) ) {
                                    ?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
                                }
                                ?>
                                </<?php echo $icon_tag; ?>>
                            </div>

                            <div class="bottom-bar-title"><?php echo $settings['link_title']; ?></div>
                            <?php if ( $settings['link']['url'] ) : ?>
                                <a class="bottom-bar-link" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ( in_array( $settings['pre_style'], array( 'style-2' ) ) ) : ?>
                        <div class="haru-toolbar-link__image">
                            <?php if ( $settings['link']['url'] ) : ?>
                                <a class="bottom-bar-link" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
                            <?php endif; ?>
                                <img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['link_title'] ? $settings['link_title'] : '' ); ?>">
                            <?php if ( $settings['link']['url'] ) : ?>
                                </a>
                            <?php endif; ?>
                            <div class="haru-toolbar-link__title"><?php echo $settings['link_title']; ?></div>
                        </div>
                    
                    <?php endif; ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
