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

if ( ! class_exists( 'Haru_TeeSpace_Price_Calculator_Widget' ) ) {
    class Haru_TeeSpace_Price_Calculator_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-price-calculator';
        }

        public function get_title() {
            return esc_html__( 'Haru Price Calculator', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-price-table';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'price-calculator',
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
                    'label' => __( 'Price Calculator', 'haru-teespace' ),
                ]
            );

            $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Price Calculator', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Price Calculator you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Pre Calculator 1', 'haru-teespace' ),
                        'style-2'   => __( 'Pre Calculator 2', 'haru-teespace' ),
                    ]
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
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
                ]
            );

            $repeater_table = new Repeater();

            $repeater_table->add_control(
                'list_title', [
                    'label' => esc_html__( 'Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => esc_html__( 'List Title' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater_table->add_control(
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
                'list_table',
                [
                    'label' => esc_html__( 'Content List', 'haru-teespace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater_table->get_controls(),
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
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
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
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
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
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
                ]
            );

            $this->add_control(
                'currency_text',
                [
                    'label' => __( 'Currency Symbol', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( '$', 'haru-teespace' ),
                    'placeholder' => __( 'Enter currency symbol.', 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-2' ],
                    ],
                ]
            );

            $this->add_control(
                'base_title_text',
                [
                    'label' => __( 'Base Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'This is the title', 'haru-teespace' ),
                    'placeholder' => __( 'Enter your title', 'haru-teespace' ),
                    'label_block' => true,
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
                ]
            );

            $this->add_control(
                'base_description_text',
                [
                    'label' => __( 'Base Description', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'This is the description.', 'haru-teespace' ),
                    'placeholder' => __( 'Enter your description', 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'base_title', [
                    'label' => esc_html__( 'Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'List Title' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'base_price', [
                    'label' => esc_html__( 'Price', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 0,
                    'default' => 10,
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'default_active',
                [
                    'label'         => __( 'Default Active', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->add_control(
                'list',
                [
                    'label' => esc_html__( 'Base Price List', 'haru-teespace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'base_title' => esc_html__( 'Title #1', 'haru-teespace' ),
                            'base_price' => 10,
                            'default_active' => 'no',
                        ],
                        [
                            'base_title' => esc_html__( 'Title #2', 'haru-teespace' ),
                            'base_price' => 10,
                            'default_active' => 'no',
                        ],
                    ],
                    'title_field' => '{{{ base_title }}}',
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
                ]
            );

            $this->add_control(
                'option_title_text',
                [
                    'label' => __( 'Option Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'This is the title', 'haru-teespace' ),
                    'placeholder' => __( 'Enter your title', 'haru-teespace' ),
                    'label_block' => true,
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
                ]
            );

            $this->add_control(
                'option_description_text',
                [
                    'label' => __( 'Option Description', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Label text.', 'haru-teespace' ),
                    'placeholder' => __( 'Enter your label', 'haru-teespace' ),
                    'label_block' => true,
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'option_title', [
                    'label' => esc_html__( 'Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'List Title' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'option_price', [
                    'label' => esc_html__( 'Price', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 10,
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'default_active',
                [
                    'label'         => __( 'Default Active', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->add_control(
                'list_option',
                [
                    'label' => esc_html__( 'Option Price List', 'haru-teespace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'option_title' => esc_html__( 'Title #1', 'haru-teespace' ),
                            'option_price' => 10,
                            'default_active' => 'no',
                        ],
                        [
                            'option_title' => esc_html__( 'Title #2', 'haru-teespace' ),
                            'option_price' => 10,
                            'default_active' => 'no',
                        ],
                    ],
                    'title_field' => '{{{ option_title }}}',
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
                ]
            );

            // Style 2

            $repeater2 = new Repeater();

            $repeater2->add_control(
                'list_title', [
                    'label' => esc_html__( 'Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'List Title' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater2->add_control(
                'list_description',
                [
                    'label' => __( 'Description', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __( 'List Description.', 'haru-teespace' ),
                    'placeholder' => __( 'Enter your description', 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater2->add_control(
                'list_price', [
                    'label' => esc_html__( 'Price', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 10,
                    'label_block' => true,
                ]
            );

            $repeater2->add_control(
                'list_unit', [
                    'label' => esc_html__( 'Unit', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( '/ month', 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater2->add_control(
                'link',
                [
                    'label' => __( 'Link', 'haru-teespace' ),
                    'type' => Controls_Manager::URL,
                    'dynamic' => [
                        'active' => true,
                    ],
                    'placeholder' => __( 'https://your-link.com', 'haru-teespace' ),
                ]
            );

            $repeater2->add_control(
                'link_text',
                [
                    'label' => __( 'Link Text', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Purchase Now', 'haru-teespace' ),
                    'placeholder' => __( 'Link text', 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $repeater2->add_control(
                'default_active',
                [
                    'label'         => __( 'Default Active', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->add_control(
                'list_price',
                [
                    'label' => esc_html__( 'Option Price List', 'haru-teespace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater2->get_controls(),
                    'default' => [
                        [
                            'list_title' => esc_html__( 'Title #1', 'haru-teespace' ),
                            'list_price' => 10,
                            'default_active' => 'no',
                        ],
                        [
                            'list_title' => esc_html__( 'Title #2', 'haru-teespace' ),
                            'list_price' => 10,
                            'default_active' => 'no',
                        ],
                    ],
                    'title_field' => '{{{ list_title }}}',
                    'separator' => 'before',
                    'condition' => [
                        'pre_style' => [ 'style-2' ],
                    ],
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

            $this->add_render_attribute( 'price-calculator', 'class', 'haru-price-calculator' );

            if ( $settings['pre_style'] ) {
                $this->add_render_attribute( 'price-calculator', 'class', 'haru-price-calculator--' . $settings['pre_style'] );
            }

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'price-calculator', 'class', $settings['el_class'] );
            }
            
            ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'price-calculator' ); ?>>

                    <?php if ( $settings['pre_style'] == 'style-1' ) : ?>
                    <div class="haru-price-calculator__main">
                        <h6 class="haru-price-calculator__main-title"><?php echo $settings['title_text']; ?></h6>
                        <ul class="haru-price-calculator__main-list">
                            <?php
                                foreach ( $settings['list_table'] as $item ) :
                            ?>
                                <li class="haru-price-calculator__main-item <?php echo ( 'yes' == $item['list_disable'] ) ? 'content-disable' : ''; ?>">
                                <?php if ( $item['list_title'] ) : ?>
                                    <span class="content-title"><?php echo $item['list_title']; ?></span>
                                <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if ( ! empty( $settings['link']['url'] && $settings['link_text'] ) ) : ?>
                            <a href="<?php echo esc_url( $settings['link']['url'] ); ?>" class="haru-button haru-button--style-1 haru-button--bg-primary haru-button--size-large haru-button--round-normal"><?php echo esc_html( $settings['link_text'] ); ?></a>
                        <?php endif; ?>
                    </div>

                    <div class="haru-price-calculator__content">
                        <div class="haru-price-calculator__top">
                            <h6 class="haru-price-calculator__title">
                                <?php echo $settings['base_title_text']; ?>
                            </h6>
                            <div class="haru-price-calculator__description"><?php echo $settings['base_description_text']; ?></div>
                        </div>

                        <?php if ( $settings['list'] ) : ?>
                            <div class="haru-price-calculator__base">
                                <ul class="haru-price-calculator__list">
                                <?php
                                    foreach ( $settings['list'] as $key => $item ) :
                                ?>
                                    <li class="haru-price-calculator__item <?php echo ( $item['default_active'] == 'yes' ) ? esc_attr( 'active' ) : ''; ?>" data-price="<?php echo esc_attr( $item['base_price'] ); ?>">
                                    <?php if ( $item['base_title'] ) : ?>
                                        <span class="content-title" ><?php echo $item['base_title']; ?></span>
                                    <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="haru-price-calculator__top">
                            <h6 class="haru-price-calculator__title">
                                <?php echo $settings['option_title_text']; ?>
                            </h6>
                            <div class="haru-price-calculator__description"><?php echo $settings['option_description_text']; ?></div>
                        </div>

                        <?php if ( $settings['list_option'] ) : ?>
                            <div class="haru-price-calculator__options">
                                <ul class="haru-price-calculator__list">
                                <?php
                                    foreach ( $settings['list_option'] as $item ) :
                                ?>
                                    <?php if ( $item['option_title'] ) : ?>
                                    <li class="haru-price-calculator__option <?php echo ( $item['default_active'] == 'yes' ) ? esc_attr( 'active' ) : ''; ?>" data-price="<?php echo esc_attr( $item['option_price'] ); ?>">
                                        <span class="content-title" ><?php echo $item['option_title']; ?></span>
                                    </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="haru-price-calculator__calculated">
                            <div class="haru-price-calculator__price-calculated"><?php echo ( $settings['currency_text'] ); ?><span class="haru-price-calculator__price-calculated-value"></span></div>
                            <div class="haru-price-calculator__price-base"><?php echo ( $settings['currency_text'] ); ?><span class="haru-price-calculator__price-base-value"></span></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ( $settings['pre_style'] == 'style-2' ) : ?>
                        <div class="haru-price-calculator__main">
                            <ul class="haru-price-calculator__list">
                                <?php
                                    foreach ( $settings['list_price'] as $item ) :
                                ?>
                                    <li class="haru-price-calculator__item <?php echo ( $item['default_active'] == 'yes' ) ? esc_attr( 'active' ) : ''; ?>" data-url="<?php echo esc_attr( json_encode( $item['link'] ) ); ?>" data-url_text="<?php echo esc_attr( $item['link_text'] ); ?>">
                                        <div class="haru-price-calculator__info">
                                            <h6 class="haru-price-calculator__title">
                                                <span class="haru-price-calculator__check"></span>
                                                <?php echo $item['list_title']; ?>
                                            </h6>
                                            <div class="haru-price-calculator__description"><?php echo $item['list_description']; ?></div>
                                        </div>
                                        <div class="haru-price-calculator__price">
                                            <span class="haru-price-calculator__price-number"><?php echo esc_html( $settings['currency_text'] ); ?><?php echo esc_html( $item['list_price'] ); ?></span>
                                            <span class="haru-price-calculator__price-unit"><?php echo esc_html( $item['list_unit'] ); ?></span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="haru-price-calculator__button"></div>
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
