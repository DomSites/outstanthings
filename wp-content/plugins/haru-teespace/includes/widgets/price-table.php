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
use \Elementor\Icons_Manager;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Price_Table_Widget' ) ) {
    class Haru_TeeSpace_Price_Table_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-price-table';
        }

        public function get_title() {
            return esc_html__( 'Haru Price Table', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-price-table';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'price-table',
                'price',
                'table',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        protected function register_controls() {

            $this->start_controls_section(
                'section_icon',
                [
                    'label' => __( 'Price Table', 'haru-teespace' ),
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Price Table', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Price Table you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Pre Price Table 1', 'haru-teespace' ),
                    ]
                ]
            );

            $this->add_control(
                'featured',
                [
                    'label'         => __( 'Featured', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
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
                        'pre_style' => [ 'style-2' ],
                    ],
                ],
            );

            $this->add_control(
                'featured_text',
                [
                    'label' => __( 'Featured Text', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Featured', 'haru-teespace' ),
                    'placeholder' => __( 'Enter your featured text', 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'featured' => [ 'yes' ],
                    ],
                ]
            );

            $this->add_control(
                'title_text',
                [
                    'label' => __( 'Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'This is the title', 'haru-teespace' ),
                    'placeholder' => __( 'Enter your title', 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'price_unit',
                [
                    'label' => __( 'Price Unit', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( '/Month', 'haru-teespace' ),
                    'placeholder' => __( '/Month', 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'description_text',
                [
                    'label' => __( 'Description', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Label text.', 'haru-teespace' ),
                    'placeholder' => __( 'Enter your label', 'haru-teespace' ),
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
                'link_text',
                [
                    'label' => __( 'Link Text', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Purchase Now', 'haru-teespace' ),
                    'placeholder' => __( 'Link text', 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'list_title', [
                    'label' => esc_html__( 'Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'List Title' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'list_disable',
                [
                    'label'         => __( 'Disable', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Disable this content.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->add_control(
                'list',
                [
                    'label' => esc_html__( 'Content List', 'haru-teespace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'list_title' => esc_html__( 'Title #1', 'haru-teespace' ),
                            'list_disable' => 'no',
                        ],
                        [
                            'list_title' => esc_html__( 'Title #2', 'haru-teespace' ),
                            'list_disable' => 'no',
                        ],
                    ],
                    'title_field' => '{{{ list_title }}}',
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
                        '{{WRAPPER}} .haru-price-table__icon' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .haru-price-table__icon svg, {{WRAPPER}} .haru-price-table__icon *' => 'fill: {{VALUE}}; color: {{VALUE}};',
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
                        '{{WRAPPER}} .haru-price-table' => 'text-align: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_section();
        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'price-table', 'class', 'haru-price-table' );

            if ( $settings['pre_style']  ) {
                $this->add_render_attribute( 'price-table', 'class', 'haru-price-table--' . $settings['pre_style'] );
            }

            if ( 'yes' == $settings['featured']  ) {
                 $this->add_render_attribute( 'price-table', 'class', 'plan-featured' );
            }
            

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'price-table', 'class', $settings['el_class'] );
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

            $this->add_render_attribute( 'description_text', 'class', 'haru-price-table__description' );

            $this->add_inline_editing_attributes( 'title_text', 'none' );
            $this->add_inline_editing_attributes( 'description_text' );
            if ( ! $has_icon && ! empty( $settings['selected_icon']['value'] ) ) {
                $has_icon = true;
            }
            $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
            $is_new = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'price-table' ); ?>>

                    <div class="haru-price-table__top">
                        <?php if ( $has_icon ) : ?>
                        <div class="haru-price-table__icon">
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
                        <?php endif; ?>

                        <?php if ( $settings['featured_text'] ) : ?>
                            <div class="haru-price-table__featured"><?php echo $settings['featured_text']; ?></div>
                        <?php endif; ?>

                        <?php if ( ! Utils::is_empty( $settings['description_text'] ) ) : ?>
                        <div <?php echo $this->get_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></div>
                        <?php endif; ?>

                        <h6 class="haru-price-table__title">
                            <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?><?php echo $this->get_render_attribute_string( 'title_text' ); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
                            <span class="haru-price-table__unit"><?php echo esc_html( $settings['price_unit'] ); ?></span>
                        </h6>
                    </div>

                    <?php if ( $settings['list'] ) : ?>
                        <div class="haru-price-table__content">
                            <ul class="haru-price-table__list">
                            <?php
                                foreach ( $settings['list'] as $item ) :
                            ?>
                                <li class="haru-price-table__item <?php echo ( 'yes' == $item['list_disable'] ) ? 'content-disable' : ''; ?>">
                                <?php if ( $item['list_title'] ) : ?>
                                    <span class="content-title"><?php echo $item['list_title']; ?></span>
                                <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $settings['link']['url'] && $settings['link_text'] ) ) : ?>
                        <?php if ( 'yes' != $settings['featured']  ) : ?>
                            <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="haru-button haru-button--style-1 haru-button--size-large haru-button--round-normal"><?php echo esc_html( $settings['link_text'] ); ?></a>
                        <?php else : ?>
                            <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="haru-button haru-button--style-1 haru-button--bg-primary haru-button--size-large haru-button--round-normal"><?php echo esc_html( $settings['link_text'] ); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
