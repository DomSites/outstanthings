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

if ( ! class_exists( 'Haru_TeeSpace_Icon_Box_Widget' ) ) {
    class Haru_TeeSpace_Icon_Box_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-icon-box';
        }

        public function get_title() {
            return esc_html__( 'Haru Icon Box', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-icon-box';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'icon-box',
                'icon',
                'box',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_icon',
                [
                    'label' => __( 'Icon Box', 'haru-teespace' ),
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Icon Box', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Icon Box you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Pre Icon Box 1', 'haru-teespace' ),
                        'style-2'   => __( 'Pre Icon Box 2', 'haru-teespace' ),
                        'style-3'   => __( 'Pre Icon Box 3', 'haru-teespace' ),
                        'style-4'   => __( 'Pre Icon Box 4', 'haru-teespace' ),
                        'style-5'   => __( 'Pre Icon Box 5', 'haru-teespace' ),
                        'style-6'   => __( 'Pre Icon Box 6', 'haru-teespace' ),
                        'style-7'   => __( 'Pre Icon Box 7', 'haru-teespace' ),
                        'style-8'   => __( 'Pre Icon Box 8', 'haru-teespace' ),
                        'style-9'   => __( 'Pre Icon Box 9', 'haru-teespace' ),
                        'style-10'   => __( 'Pre Icon Box 10 - Image', 'haru-teespace' ),
                        'style-11'   => __( 'Pre Icon Box 11', 'haru-teespace' ),
                        'style-12'   => __( 'Pre Icon Box Landing', 'haru-teespace' ),
                        'style-13'   => __( 'Pre Icon Box 13', 'haru-teespace' ),
                        'style-14'   => __( 'Pre Icon Box 14 - Menu', 'haru-teespace' ),
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
                    'condition' => [
                        'pre_style!' => [ 'style-10' ],
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
                        'pre_style' => [ 'style-10' ],
                    ],
                ]
            );

            $this->add_control(
                'title_text',
                [
                    'label' => __( 'Title & Description', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __( 'This is the heading', 'haru-teespace' ),
                    'placeholder' => __( 'Enter your title', 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'description_text',
                [
                    'label' => '',
                    'type' => Controls_Manager::TEXTAREA,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'haru-teespace' ),
                    'placeholder' => __( 'Enter your description', 'haru-teespace' ),
                    'rows' => 10,
                    'separator' => 'none',
                    'show_label' => false,
                ]
            );

            $this->add_control(
                'sub_title_text',
                [
                    'label' => __( 'Sub Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'This is sub title', 'haru-teespace' ),
                    'placeholder' => __( 'Enter your sub title', 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-10' ],
                    ],
                ]
            );

            $this->add_control(
                'is_featured',
                [
                    'label'         => __( 'Is Featured', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Enable if you want Icon bigger than others.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'condition' => [
                        'pre_style' => [ 'style-10' ],
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

            $this->start_controls_section(
                'section_style_icon',
                [
                    'label' => __( 'Icon', 'haru-teespace' ),
                    'tab'   => Controls_Manager::TAB_STYLE,
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'selected_icon[value]',
                                'operator' => '!=',
                                'value' => '',
                            ],
                        ],
                        'pre_style!' => [ 'style-10' ],
                    ],
                ]
            );

            $this->add_control(
                'primary_color',
                [
                    'label' => __( 'Primary Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => '',
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-icon-box__icon' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .haru-icon-box__icon svg, {{WRAPPER}} .haru-icon-box__icon *' => 'fill: {{VALUE}}; color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'background_color',
                [
                    'label' => __( 'Background Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'global' => [
                        'default' => '',
                    ],
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-icon-box__icon > span' => 'background-color: {{VALUE}};',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-3', 'style-13' ],
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'section_style_content',
                [
                    'label' => __( 'Content', 'haru-teespace' ),
                    'tab'   => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_responsive_control(
                'text_align',
                [
                    'label' => __( 'Alignment', 'haru-teespace' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'haru-teespace' ),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'haru-teespace' ),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'haru-teespace' ),
                            'icon' => 'eicon-text-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'haru-teespace' ),
                            'icon' => 'eicon-text-align-justify',
                        ],
                    ],
                    'default' => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .haru-icon-box' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'icon-box', 'class', 'haru-icon-box' );

            if ( $settings['pre_style']  ) {
                $this->add_render_attribute( 'icon-box', 'class', 'haru-icon-box--' . $settings['pre_style'] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'icon-box', 'class', $settings['el_class'] );
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

            $this->add_render_attribute( 'description_text', 'class', 'haru-icon-box__description' );

            $this->add_inline_editing_attributes( 'title_text', 'none' );
            $this->add_inline_editing_attributes( 'description_text' );
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
                <div <?php echo $this->get_render_attribute_string( 'icon-box' ); ?>>
                    <?php if ( $has_icon ) : ?>
                        <?php if ( in_array( $settings['pre_style'], array( 'style-1', 'style-2', 'style-4', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9', 'style-11', 'style-12', 'style-14' ) ) ) : ?>
                            <div class="haru-icon-box__icon">
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

                            <div class="haru-icon-box__content">
                                <h6 class="haru-icon-box__title">
                                    <?php if ( $settings['link']['url'] ) : ?>
                                        <a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
                                    <?php endif; ?>
                                        <?php echo $settings['title_text']; ?>
                                    <?php if ( $settings['link']['url'] ) : ?>
                                        </a>
                                    <?php endif; ?>
                                </h6>
                                <?php if ( ! Utils::is_empty( $settings['description_text'] ) ) : ?>
                                <p <?php echo $this->get_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ( $has_icon ) : ?>
                        <?php if ( in_array( $settings['pre_style'], array( 'style-3', 'style-13' ) ) ) : ?>
                            <div class="haru-icon-box__icon">
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

                            <h6 class="haru-icon-box__title">
                                <?php if ( $settings['link']['url'] ) : ?>
                                    <a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
                                <?php endif; ?>
                                    <?php echo $settings['title_text']; ?>
                                <?php if ( $settings['link']['url'] ) : ?>
                                    </a>
                                <?php endif; ?>
                            </h6>

                            <div class="haru-icon-box__content">
                                <?php if ( ! Utils::is_empty( $settings['description_text'] ) ) : ?>
                                <p <?php echo $this->get_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ( in_array( $settings['pre_style'], array( 'style-10' ) ) ) : ?>
                        <div class="haru-icon-box__image <?php echo ( 'yes' == $settings['is_featured'] ) ? 'is-featured' : ''; ?>">
                            <?php if ( $settings['link']['url'] ) : ?>
                                <a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
                            <?php endif; ?>
                                <img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( $settings['title_text'] ? $settings['title_text'] : '' ); ?>">
                            <?php if ( $settings['link']['url'] ) : ?>
                                </a>
                            <?php endif; ?>
                            <div class="haru-icon-box__sub-title"><?php echo $settings['sub_title_text']; ?></div>
                        </div>
                        
                        <div class="haru-icon-box__content">
                            <h6 class="haru-icon-box__title">
                                <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?><?php echo $this->get_render_attribute_string( 'title_text' ); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
                            </h6>
                            <?php if ( ! Utils::is_empty( $settings['description_text'] ) ) : ?>
                            <p <?php echo $this->get_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></p>
                            <?php endif; ?>
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
