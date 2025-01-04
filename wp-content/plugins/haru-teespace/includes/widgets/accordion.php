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
use \Elementor\Icons_Manager;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Plugin;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Accordion_Widget' ) ) {
    class Haru_TeeSpace_Accordion_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-accordion';
        }

        public function get_title() {
            return esc_html__( 'Haru Accordion', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-slider-album';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'accordion',
                'tab',
                'toggle',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
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
                    'label' => __( 'Pre Accordion', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Accordion you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'     => __( 'Style 1', 'haru-teespace' ),
                        'style-2'     => __( 'Style 2', 'haru-teespace' ),
                        'style-3'     => __( 'Style 3', 'haru-teespace' ),
                        'style-4'     => __( 'Style 4', 'haru-teespace' ),
                    ]
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'tab_title',
                [
                    'label' => __( 'Title & Description', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Accordion Title', 'haru-teespace' ),
                    'dynamic' => [
                        'active' => true,
                    ],
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'tab_content',
                [
                    'label' => __( 'Content', 'haru-teespace' ),
                    'type' => Controls_Manager::WYSIWYG,
                    'default' => __( 'Accordion Content', 'haru-teespace' ),
                    'show_label' => false,
                ]
            );

            $repeater->add_control(
                'tab_image',
                [
                    'label'     => esc_html__( 'Choose Image', 'haru-teespace' ),
                    'description'   => __( 'This image use for Accordion Style 2 only.', 'haru-teespace' ),
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
                'tabs',
                [
                    'label' => __( 'Accordion Items', 'haru-teespace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'tab_title' => __( 'Accordion #1', 'haru-teespace' ),
                            'tab_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'haru-teespace' ),
                            'tab_image' => esc_html__( 'Select Image', 'haru-teespace' ),
                        ],
                        [
                            'tab_title' => __( 'Accordion #2', 'haru-teespace' ),
                            'tab_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'haru-teespace' ),
                            'tab_image' => esc_html__( 'Select Image', 'haru-teespace' ),
                        ],
                    ],
                    'title_field' => '{{{ tab_title }}}',
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
                'selected_icon',
                [
                    'label' => __( 'Icon', 'haru-teespace' ),
                    'type' => Controls_Manager::ICONS,
                    'separator' => 'before',
                    'fa4compatibility' => 'icon',
                    'default' => [
                        'value' => 'fas fa-plus',
                        'library' => 'fa-solid',
                    ],
                    'recommended' => [
                        'fa-solid' => [
                            'chevron-down',
                            'angle-down',
                            'angle-double-down',
                            'caret-down',
                            'caret-square-down',
                        ],
                        'fa-regular' => [
                            'caret-square-down',
                        ],
                    ],
                    'skin' => 'inline',
                    'label_block' => false,
                ]
            );

            $this->add_control(
                'selected_active_icon',
                [
                    'label' => __( 'Active Icon', 'haru-teespace' ),
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon_active',
                    'default' => [
                        'value' => 'fas fa-minus',
                        'library' => 'fa-solid',
                    ],
                    'recommended' => [
                        'fa-solid' => [
                            'chevron-up',
                            'angle-up',
                            'angle-double-up',
                            'caret-up',
                            'caret-square-up',
                        ],
                        'fa-regular' => [
                            'caret-square-up',
                        ],
                    ],
                    'skin' => 'inline',
                    'label_block' => false,
                    'condition' => [
                        'selected_icon[value]!' => '',
                    ],
                ]
            );

            $this->add_control(
                'title_html_tag',
                [
                    'label' => __( 'Title HTML Tag', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                        'div' => 'div',
                    ],
                    'default' => 'div',
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'active_index',
                [
                    'label' => __( 'Active Default', 'haru-teespace' ),
                    'description'   => __( 'Set default active index start from 0.', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'max' => 5,
                    'step' => 1,
                    'default' => 0,
                ]
            );

            $this->add_control(
                'faq_schema',
                [
                    'label' => __( 'FAQ Schema', 'haru-teespace' ),
                    'type' => Controls_Manager::SWITCHER,
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
                'section_toggle_style_icon',
                [
                    'label' => __( 'Icon', 'elementor' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'selected_icon[value]!' => '',
                    ],
                ]
            );

            $this->add_control(
                'icon_align',
                [
                    'label' => __( 'Alignment', 'haru-teespace' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Start', 'haru-teespace' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => __( 'End', 'haru-teespace' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default' => is_rtl() ? 'right' : 'left',
                    'toggle' => false,
                ]
            );

            $this->add_responsive_control(
                'icon_space',
                [
                    'label' => __( 'Spacing', 'haru-teespace' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .haru-accordion-icon.haru-accordion-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .haru-accordion-icon.haru-accordion-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            if ( '' === $settings['tabs'] ) {
                return;
            }

            $this->add_render_attribute( 'accordion', 'class', 'haru-accordion' );

            $this->add_render_attribute( 'accordion', 'class', 'haru-accordion--' . $settings['pre_style'] );

            $this->add_render_attribute( 'accordion', 'role', 'tablist' );

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'accordion', 'class', $settings['el_class'] );
            }

            $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );

            if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                // @todo: remove when deprecated
                // added as bc in 2.6
                // add old default
                $settings['icon'] = 'fa fa-plus';
                $settings['icon_active'] = 'fa fa-minus';
                $settings['icon_align'] = $this->get_settings( 'icon_align' );
            }

            $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
            $has_icon = ( ! $is_new || ! empty( $settings['selected_icon']['value'] ) );
            $id_int = substr( $this->get_id_int(), 0, 3 );

            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
              <!--   <div <?php echo $this->get_render_attribute_string( 'accordion' ); ?>>
                    <?php // echo Haru_Template::haru_get_template( 'accordion/accordion.php', $settings ); ?>
                </div> -->
                <div <?php echo $this->get_render_attribute_string( 'accordion' ); ?>>
                    <?php if ( $settings['pre_style'] == 'style-2' ) : ?>
                        <div class="haru-accordion-list">
                    <?php endif; ?>

                    <?php
                    foreach ( $settings['tabs'] as $index => $item ) :
                        $tab_count = $index + 1;

                        $tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

                        $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

                        $this->add_render_attribute( $tab_title_setting_key, [
                            'id' => 'haru-tab-title-' . $id_int . $tab_count,
                            'class' => [ 'haru-tab-title' ],
                            'data-tab' => $tab_count,
                            'role' => 'tab',
                            'aria-controls' => 'haru-tab-content-' . $id_int . $tab_count,
                            // 'aria-expanded' => 'false',
                        ] );

                        if ( $index == $settings['active_index'] ) {
                            $this->add_render_attribute( $tab_title_setting_key, [
                                'class' => [ 'active' ],
                            ] );
                        }

                        $this->add_render_attribute( $tab_content_setting_key, [
                            'id' => 'haru-tab-content-' . $id_int . $tab_count,
                            'class' => [ 'haru-tab-content', 'haru-clearfix' ],
                            'data-tab' => $tab_count,
                            // 'role' => 'tabpanel',
                            'aria-labelledby' => 'haru-tab-title-' . $id_int . $tab_count,
                        ] );

                        if ( $index == $settings['active_index'] ) {
                            $this->add_render_attribute( $tab_content_setting_key, [
                                'class' => [ 'active' ],
                            ] );
                        }

                        $this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
                        ?>
                        <div class="haru-accordion-item <?php echo ( $index == $settings['active_index'] ) ? 'active' : ''; ?>">
                            <<?php echo Utils::validate_html_tag( $settings['title_html_tag'] ); ?> <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
                                <?php if ( $has_icon ) : ?>
                                    <span class="haru-accordion-icon haru-accordion-icon-<?php echo esc_attr( $settings['icon_align'] ); ?>" aria-hidden="true">
                                    <?php
                                    if ( $is_new || $migrated ) { ?>
                                        <span class="haru-accordion-icon-closed"><?php Icons_Manager::render_icon( $settings['selected_icon'] ); ?></span>
                                        <span class="haru-accordion-icon-opened"><?php Icons_Manager::render_icon( $settings['selected_active_icon'] ); ?></span>
                                    <?php } else { ?>
                                        <i class="haru-accordion-icon-closed <?php echo esc_attr( $settings['icon'] ); ?>"></i>
                                        <i class="haru-accordion-icon-opened <?php echo esc_attr( $settings['icon_active'] ); ?>"></i>
                                    <?php } ?>
                                    </span>
                                <?php endif; ?>
                                <a class="haru-accordion-title" href=""><?php echo $item['tab_title']; ?></a>
                            </<?php echo Utils::validate_html_tag( $settings['title_html_tag'] ); ?>>
                            <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>><?php echo $this->parse_text_editor( $item['tab_content'] ); ?></div>
                        </div>
                    <?php endforeach; ?>

                    <?php if ( $settings['pre_style'] == 'style-2' ) : ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $settings['pre_style'] == 'style-2' ) : ?>
                        <div class="haru-accordion-images">
                            <?php
                                foreach ( $settings['tabs'] as $index => $item ) : 
                                $tab_count = $index + 1;
                            ?>
                            <div class="haru-accordion-image <?php echo ( $index == $settings['active_index'] ) ? 'active' : ''; ?>" data-tab="<?php echo esc_attr( $tab_count ); ?>">
                                <img src="<?php echo esc_url( $item['tab_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['tab_title'] ); ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    if ( isset( $settings['faq_schema'] ) && 'yes' === $settings['faq_schema'] ) {
                        $json = [
                            '@context' => 'https://schema.org',
                            '@type' => 'FAQPage',
                            'mainEntity' => [],
                        ];

                        foreach ( $settings['tabs'] as $index => $item ) {
                            $json['mainEntity'][] = [
                                '@type' => 'Question',
                                'name' => wp_strip_all_tags( $item['tab_title'] ),
                                'acceptedAnswer' => [
                                    '@type' => 'Answer',
                                    'text' => $this->parse_text_editor( $item['tab_content'] ),
                                ],
                            ];
                        }
                        ?>
                        <script type="application/ld+json"><?php echo wp_json_encode( $json ); ?></script>
                    <?php } ?>
                </div>
                
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
