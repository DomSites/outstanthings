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
use \Elementor\Plugin;
use \Haru_TeeSpace\Classes\Helper as ControlsHelper;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Woo_Ajax_Category_Widget' ) ) {
    class Haru_TeeSpace_Woo_Ajax_Category_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-woo-ajax-category';
        }

        public function get_title() {
            return esc_html__( 'Haru Woo Ajax Category', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-products';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'products',
                'ajax category',
                'categories',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        protected function register_controls() {

            $post_types = array();
            $post_types['product'] = __( 'Products', 'haru-teespace' );
            $post_types['by_id'] = __( 'Manual Selection', 'haru-teespace' );

            $taxonomies = get_taxonomies( [ 'object_type' => [ 'product' ] ], 'objects' );

            $this->start_controls_section(
                'content_section',
                [
                    'label'     => esc_html__( 'Content', 'haru-teespace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'layout',
                [
                  'label' => __( 'Layout', 'haru-teespace' ),
                  'type' => Controls_Manager::SELECT,
                  'default' => 'grid',
                  'options' => [
                    'grid'        => __( 'Grid', 'haru-teespace' ),
                    'masonry'     => __( 'Masonry', 'haru-teespace' ),
                  ]
                ]
            );

            $this->add_control(
                'post_type',
                [
                    'label' => __( 'Source', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => $post_types,
                    'default' => key($post_types),
                ]
            );

            $this->add_control(
                'product_ids',
                [
                    'label' => __( 'Search & Select', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => ControlsHelper::get_post_list('product'),
                    'label_block' => true,
                    'multiple' => true,
                    'condition' => [
                        'post_type' => 'by_id',
                    ],
                ]
            );

            foreach ($taxonomies as $taxonomy => $object) {
                if ( ( ! isset( $object->object_type[0] ) ) || ( ! in_array( $object->object_type[0], array_keys($post_types) ) ) ) {
                    continue;
                }

                $this->add_control(
                    $taxonomy . '_ids',
                    [
                        'label' => $object->label,
                        'type' => Controls_Manager::SELECT2,
                        'label_block' => true,
                        'multiple' => true,
                        'object_type' => $taxonomy,
                        'options' => wp_list_pluck( get_terms( $taxonomy ), 'name', 'term_id' ),
                        'condition' => [
                            'post_type' => $object->object_type,
                        ],
                    ]
                );
            }

            $this->add_control(
                'post__not_in',
                [
                    'label' => __( 'Exclude', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => ControlsHelper::get_post_list('product'),
                    'label_block' => true,
                    'post_type' => '',
                    'multiple' => true,
                    'condition' => [
                        'post_type!' => ['by_id'],
                    ],
                ]
            );

            $this->add_control(
                'posts_per_page',
                [
                    'label' => __( 'Posts Per Page', 'haru-teespace' ),
                    'description'   => __( 'You can set -1 to show all.', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => '4',
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label' => __( 'Order By', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => ControlsHelper::get_product_orderby_options(),
                    'default' => 'date',

                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => __( 'Order', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'asc' => 'Ascending',
                        'desc' => 'Descending',
                    ],
                    'default' => 'desc',

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

            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '3',
                    'tablet_default'    => '2',
                    'mobile_default'    => '1',
                    'options' => [
                        '1'     => __( '1', 'haru-teespace' ),
                        '2'     => __( '2', 'haru-teespace' ),
                        '3'     => __( '3', 'haru-teespace' ),
                        '4'     => __( '4', 'haru-teespace' ),
                        '5'     => __( '5', 'haru-teespace' ),
                        '6'     => __( '6', 'haru-teespace' ),
                    ], 
                    'prefix_class' => 'grid-columns-%s',
                ]
            );

            $this->add_control(
                'product_style',
                [
                  'label' => __( 'Product Style', 'haru-teespace' ),
                  'type' => Controls_Manager::SELECT,
                  'default' => 'style-1',
                  'options' => [
                    'style-1'     => __( 'Style 1', 'haru-teespace' ),
                    'style-2'     => __( 'Style 2', 'haru-teespace' ),
                  ]
                ]
            );

            $this->add_control(
                'product_padding',
                [
                  'label' => __( 'Product Padding', 'haru-teespace' ),
                  'type' => Controls_Manager::SELECT,
                  'default' => 'no-padding',
                  'options' => [
                    'no-padding'     => __( 'No Padding', 'haru-teespace' ),
                    'padding'     => __( 'Has Padding', 'haru-teespace' ),
                  ]
                ]
            );

            $this->add_control(
                'product_filter',
                [
                  'label' => __( 'Product Filter', 'haru-teespace' ),
                  'type' => Controls_Manager::SELECT,
                  'default' => 'hide',
                  'options' => [
                    'hide'     => __( 'Hide', 'haru-teespace' ),
                    'style-1'     => __( 'Style 1', 'haru-teespace' ),
                    'style-2'     => __( 'Style 2', 'haru-teespace' ),
                  ]
                ]
            );

            $this->add_control(
                'product_filter_all',
                [
                    'label' => __( 'Product Filter All', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'show',
                    'options' => [
                        'show'     => __( 'Show', 'haru-teespace' ),
                        'hide'     => __( 'Hide', 'haru-teespace' ),
                    ],
                    'condition' => [
                        'product_filter!' => [ '' ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_filter_align',
                [
                    'label' => __( 'Product Filter Align', 'haru-teespace' ),
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
                        '{{WRAPPER}} .product-filter' => 'text-align: {{VALUE}};',
                    ],
                    'condition' => [
                        'product_filter!' => [ '' ],
                    ],
                ]
            );

            $this->add_control(
                'view_more',
                [
                  'label' => __( 'View More', 'haru-teespace' ),
                  'type' => Controls_Manager::SELECT,
                  'default' => 'none',
                  'options' => [
                    'none'     => __( 'None', 'haru-teespace' ),
                    'arrow'     => __( 'Arrow', 'haru-teespace' ),
                    'button'     => __( 'Button', 'haru-teespace' ),
                  ]
                ]
            );

            $this->end_controls_section();

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $this->add_render_attribute( 'woo-ajax-category', 'class', 'haru-woo-ajax-category' );

            $this->add_render_attribute( 'woo-ajax-category', 'class', 'haru-woo-ajax-category--' . $settings['layout'] );

            $this->add_render_attribute( 'woo-ajax-category', 'class', 'haru-woo-ajax-category--' . $settings['product_padding'] );

            $this->add_render_attribute( 'woo-ajax-category', 'id', 'haru-woo-ajax-category' . $this->get_id() );

            $this->add_render_attribute( 'woo-ajax-category', 'data-settings', htmlentities( json_encode( $settings ) ) );

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'woo-ajax-category', 'class', $settings['el_class'] );
            }

            ?>
            <?php if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) : ?>
                <div class="haru-notice"><?php echo esc_html__( 'Please note layout or action may doesn\'t works on Preview Mode or Editor Mode but works fine on Frontend Mode.', 'haru-teespace' ); ?></div>
            <?php endif; ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'woo-ajax-category' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'woo-ajax-category/woo-ajax-category.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

            <?php
        }

    }
}
