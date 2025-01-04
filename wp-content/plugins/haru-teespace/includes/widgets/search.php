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
use \Elementor\Plugin;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Search_Widget' ) ) {
    class Haru_TeeSpace_Search_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-search';
        }

        public function get_title() {
            return esc_html__( 'Haru Search Form', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-search';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'search',
                'icon',
                'box',
                'toolbar',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return [ 'magnific-popup' ];
            }


            if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'full_screen', 'toolbar' ) ) ) {
                return [ 'magnific-popup' ];
            }

            return [ 'magnific-popup' ];

        }

        public function get_style_depends() {
            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['magnific-popup'];
            }

            if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'full_screen', 'toolbar' ) ) ) {
                return [ 'magnific-popup' ];
            }

            return [ 'magnific-popup' ];
        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_icon',
                [
                    'label' => __( 'Search Form', 'haru-teespace' ),
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Search Form', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'classic',
                    'options' => [
                        'classic'   => __( 'Classic', 'haru-teespace' ),
                        'minimal'   => __( 'Minimal', 'haru-teespace' ),
                        'full_screen'   => __( 'Full Screen', 'haru-teespace' ),
                        'toolbar'   => __( 'Toolbar', 'haru-teespace' ),
                    ]
                ]
            );

            // https://wordpress.stackexchange.com/questions/167461/get-list-of-registered-custom-post-types/225960
            $post_types_search = [
                                    'post'  => __( 'Post', 'haru-teespace' ),
                                    'page' => __( 'Page', 'haru-teespace' ),
                                    'product' => __( 'Product', 'haru-teespace' ),
                                ];

            $this->add_control(
                'post_type',
                [
                    'label' => __( 'Post Type', 'haru-teespace' ),
                    'description'   => __( 'Leave empty if search all Post Types.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => $post_types_search,
                    'default' => [],
                ]
            );

            $this->add_control(
                'search_title',
                [
                    'label' => esc_html__( 'Search Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Search' , 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'toolbar' ],
                    ],
                ]
            );

            $this->add_control(
                'placeholder',
                [
                    'label' => __( 'Placeholder', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'separator' => 'before',
                    'default' => __( 'Search', 'haru-teespace' ) . '...',
                ]
            );

            $this->add_control(
                'heading_button_content',
                [
                    'label' => __( 'Button', 'haru-teespace' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => 'classic',
                    ],
                ]
            );

            $this->add_control(
                'button_type',
                [
                    'label' => __( 'Type', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'icon',
                    'options' => [
                        'icon' => __( 'Icon', 'haru-teespace' ),
                        'text' => __( 'Text', 'haru-teespace' ),
                    ],
                    'prefix_class' => 'elementor-search-form--button-type-',
                    'render_type' => 'template',
                    'condition' => [
                        'pre_style' => 'classic',
                    ],
                ]
            );

            $this->add_control(
                'button_text',
                [
                    'label' => __( 'Text', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Search', 'haru-teespace' ),
                    'separator' => 'after',
                    'condition' => [
                        'button_type' => 'text',
                        'pre_style' => 'classic',
                    ],
                ]
            );

            // Check Accordion shortcode
            $this->add_control(
                'selected_icon',
                [
                    'label' => __( 'Icon', 'haru-teespace' ),
                    'type' => Controls_Manager::ICONS,
                    'separator' => 'before',
                    'fa4compatibility' => 'icon',
                    'default' => [
                        'value' => 'fas fa-search',
                        'library' => 'fa-solid',
                    ],
                ]
            );

            // $this->add_control(
            //     'size',
            //     [
            //         'label' => __( 'Size', 'haru-teespace' ),
            //         'type' => Controls_Manager::SLIDER,
            //         'default' => [
            //             'size' => 50,
            //         ],
            //         'selectors' => [
            //             '{{WRAPPER}} .haru-search__container' => 'min-height: {{SIZE}}{{UNIT}}',
            //             '{{WRAPPER}} .haru-search__submit' => 'min-width: {{SIZE}}{{UNIT}}',
            //             'body:not(.rtl) {{WRAPPER}} .haru-search__icon' => 'padding-left: calc({{SIZE}}{{UNIT}} / 3)',
            //             'body.rtl {{WRAPPER}} .haru-search__icon' => 'padding-right: calc({{SIZE}}{{UNIT}} / 3)',
            //             '{{WRAPPER}} .haru-search__input, {{WRAPPER}}.haru-search--button-type-text .haru-search__submit' => 'padding-left: calc({{SIZE}}{{UNIT}} / 3); padding-right: calc({{SIZE}}{{UNIT}} / 3)',
            //         ],
            //         'condition' => [
            //             'pre_style!' => 'full_screen',
            //         ],
            //     ]
            // );

            $this->add_control(
                'toggle_button_content',
                [
                    'label' => __( 'Toggle', 'haru-teespace' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => 'full_screen',
                    ],
                ]
            );

            $this->add_control(
                'toggle_align',
                [
                    'label' => __( 'Alignment', 'haru-teespace' ),
                    'type' => Controls_Manager::CHOOSE,
                    'default' => 'center',
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
                        '{{WRAPPER}} .haru-search' => 'justify-content: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => 'full_screen',
                    ],
                ]
            );

            // $this->add_control(
            //     'toggle_size',
            //     [
            //         'label' => __( 'Size', 'haru-teespace' ),
            //         'type' => Controls_Manager::SLIDER,
            //         'default' => [
            //             'size' => 33,
            //         ],
            //         'selectors' => [
            //             '{{WRAPPER}} .haru-search__toggle i' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
            //         ],
            //         'condition' => [
            //             'pre_style' => 'full_screen',
            //         ],
            //     ]
            // );

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
                'icon_color',
                [
                    'label' => __( 'Icon Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-search__toggle i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .haru-search__submit i' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .haru-search__icon i' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'classic', 'minimal', 'full_screen', 'toolbar' ],
                    ],
                ]
            );

            $this->add_control(
                'button_bg_color',
                [
                    'label' => __( 'Button Background Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-search__submit' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'classic' ],
                    ],
                ]
            );

            $this->add_control(
                'form_bg_color',
                [
                    'label' => __( 'Form Background Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-search__input' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'classic', 'minimal' ],
                    ],
                ]
            );

            $this->add_control(
                'form_border_color',
                [
                    'label' => __( 'Form Border Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-search__input' => 'border-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'classic', 'minimal' ],
                    ],
                ]
            );

            $this->add_control(
                'form_text_color',
                [
                    'label' => __( 'Form Text Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-search__input' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'classic', 'minimal' ],
                    ],
                ]
            );

            $this->add_control(
                'form_placeholder_color',
                [
                    'label' => __( 'Form Placeholder Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-search__input::-webkit-input-placeholder' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .haru-search__input:-ms-input-placeholder' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .haru-search__input::placeholder' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'classic', 'minimal' ],
                    ],
                ]
            );

            $this->add_control(
                'search_title_color',
                [
                    'label' => __( 'Search Title Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .bottom-bar-title' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'toolbar' ],
                    ],
                ]
            );

            $this->end_controls_section();

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'search', 'class', 'haru-search' );

            if ( $settings['pre_style']  ) {
                $this->add_render_attribute( 'search', 'class', 'haru-search--' . $settings['pre_style'] );
            }

            $this->add_render_attribute( 'search-form', 'class', 'haru-search__form' );
            $this->add_render_attribute( 'search-form', 'role', 'search' );
            $this->add_render_attribute( 'search-form', 'action', home_url() );
            $this->add_render_attribute( 'search-form', 'method', 'get' );
            
            if ( ( in_array( $settings['pre_style'], array( 'full_screen', 'toolbar' ) ) ) ) {
                $this->add_render_attribute( 'search-form', 'class', 'white-popup-block mfp-hide mfp-with-anim' );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'search', 'class', $settings['el_class'] );
            }

            $this->add_render_attribute(
                'input', [
                    'placeholder' => $settings['placeholder'],
                    'class' => 'haru-search__input',
                    'type' => 'search',
                    'name' => 's',
                    'title' => __( 'Search', 'haru-teespace' ),
                    'value' => get_search_query(),
                ]
            );

            // Set the selected icon.
            $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );

            if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                // @todo: remove when deprecated
                // added as bc in 2.6
                // add old default
                $settings['icon'] = 'fa fa-search';
            }

            $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
            $has_icon = ( ! $is_new || ! empty( $settings['selected_icon']['value'] ) );
            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'search' ); ?>>
                    <?php if ( in_array( $settings['pre_style'], array( 'full_screen', 'toolbar' ) ) ) : ?>
                    <div class="haru-search__toggle" data-effect="mfp-zoom-in2">
                        <?php if ( $has_icon ) : ?>
                            <?php if ( $is_new || $migrated ) : ?>
                                <?php Icons_Manager::render_icon( $settings['selected_icon'] ); ?>
                            <?php else : ?>
                                <i class="<?php echo esc_attr( $settings['icon'] ); ?>"></i>
                            <?php endif; ?>
                        <?php endif; ?>
                        <span class="elementor-screen-only"><?php esc_html_e( 'Search', 'haru-teespace' ); ?></span>
                        <?php if ( $settings['pre_style'] == 'toolbar' ) : ?>
                            <div class="bottom-bar-title"><?php echo esc_html( $settings['search_title'] ); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <form <?php echo $this->get_render_attribute_string( 'search-form' ); ?>>
                        <div class="haru-search__container">
                            <?php if ( 'minimal' === $settings['pre_style'] ) : ?>
                                <div class="haru-search__icon">
                                    <?php if ( $has_icon ) : ?>
                                        <?php if ( $is_new || $migrated ) : ?>
                                            <?php Icons_Manager::render_icon( $settings['selected_icon'] ); ?>
                                        <?php else : ?>
                                            <i class="<?php echo esc_attr( $settings['icon'] ); ?>"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <span class="elementor-screen-only"><?php esc_html_e( 'Search', 'haru-teespace' ); ?></span>
                                </div>
                            <?php endif; ?>
                            <input <?php echo $this->get_render_attribute_string( 'input' ); ?>>
                            <?php if ( $settings['post_type'] ) : ?>
                                <?php if ( count($settings['post_type']) > 1 ) : ?>
                                    <?php foreach( $settings['post_type'] as $post_type ) : ?>
                                        <input type="hidden" name="post_type[]" value="<?php echo esc_attr( $post_type ); ?>">
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <?php foreach( $settings['post_type'] as $post_type ) : ?>
                                        <input type="hidden" name="post_type" value="<?php echo esc_attr( $post_type ); ?>">
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ( 'classic' === $settings['pre_style'] ) : ?>
                                <button class="haru-search__submit" type="submit" title="<?php esc_attr_e( 'Search', 'haru-teespace' ); ?>" aria-label="<?php esc_attr_e( 'Search', 'haru-teespace' ); ?>">
                                    <?php if ( 'icon' === $settings['button_type'] ) : ?>
                                        <?php if ( $has_icon ) : ?>
                                            <?php if ( $is_new || $migrated ) : ?>
                                                <?php Icons_Manager::render_icon( $settings['selected_icon'] ); ?>
                                            <?php else : ?>
                                                <i class="<?php echo esc_attr( $settings['icon'] ); ?>"></i>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <span class="elementor-screen-only"><?php esc_html_e( 'Search', 'haru-teespace' ); ?></span>
                                    <?php elseif ( ! empty( $settings['button_text'] ) ) : ?>
                                        <?php echo $settings['button_text']; ?>
                                    <?php endif; ?>
                                </button>
                            <?php endif; ?>
                            
                        </div>
                    </form>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
