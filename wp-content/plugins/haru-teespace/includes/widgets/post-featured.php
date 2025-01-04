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
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Plugin;
use \Haru_TeeSpace\Classes\Helper as ControlsHelper;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Post_Featured_Widget' ) ) {
	class Haru_TeeSpace_Post_Featured_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-post-featured';
		}

		public function get_title() {
			return esc_html__( 'Haru Post Featured', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-slides';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
	        return [
	            'post',
	            'posts',
	            'grid',
	            'post grid',
	            'posts grid',
	            'blog post',
	            'article',
	            'custom posts',
	            'masonry',
	            'content views',
	            'blog view',
	            'content marketing',
	            'blogger',
	        ];
	    }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['slick'];
            }

            if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'slick', 'slick-2', 'slick-3' ) ) ) {
                return [ 'slick' ];
            } else if ( in_array( $this->get_settings_for_display( 'pre_style' ), array( 'grid' ) ) ) {
                return [] ;
            }

            return [ 'slick' ];

        }

        public function get_style_depends() {
            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['slick', 'other_conditional_script'];
            }

            return [ 'slick' ];
        }

		protected function register_controls() {

			$post_types = array();
			$post_types['post'] = __( 'Posts', 'haru-teespace' );
        	$post_types['by_id'] = __( 'Manual Selection', 'haru-teespace' );

        	$taxonomies = get_taxonomies([], 'objects');

			$this->start_controls_section(
	            'content_section',
	            [
	                'label' 	=> esc_html__( 'Content', 'haru-teespace' ),
	                'tab' 		=> Controls_Manager::TAB_CONTENT,
	            ]
	        );

	        $this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Post', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Post you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'slick',
                    'options' => [
                        'slick'     => __( 'Slick Normal', 'haru-teespace' ),
                        'slick-2'     => __( 'Slick Overflow Right', 'haru-teespace' ),
                        'slick-3'     => __( 'Slick Normal Nav Opacity', 'haru-teespace' ),
                        'grid'      => __( 'Grid', 'haru-teespace' ),
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
	            'posts_ids',
	            [
	                'label' => __( 'Search & Select', 'haru-teespace' ),
	                'type' => Controls_Manager::SELECT2,
	                'options' => ControlsHelper::get_post_list('post'),
	                'label_block' => true,
	                'multiple' => true,
	                'condition' => [
	                    'post_type' => 'by_id',
	                ],
	            ]
	        );

	        $this->add_control(
	            'authors', [
	                'label' => __( 'Author', 'haru-teespace' ),
	                'label_block' => true,
	                'type' => Controls_Manager::SELECT2,
	                'multiple' => true,
	                'default' => [],
	                'options' => ControlsHelper::get_authors_list(),
	                'options' => array(),
	                'condition' => [
	                    'post_type!' => ['by_id'],
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
	                'options' => ControlsHelper::get_post_list(),
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
	                'type' => Controls_Manager::NUMBER,
	                'default' => '4',
	            ]
	        );

	        $this->add_control(
	            'offset',
	            [
	                'label' => __( 'Offset', 'haru-teespace' ),
	                'type' => Controls_Manager::NUMBER,
	                'default' => '0',
	            ]
	        );

	        $this->add_control(
	            'orderby',
	            [
	                'label' => __( 'Order By', 'haru-teespace' ),
	                'type' => Controls_Manager::SELECT,
	                'options' => ControlsHelper::get_post_orderby_options(),
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

            $this->add_control(
                'post_style',
                [
                    'label' => __( 'Post Style', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'     => __( 'Style 1', 'haru-teespace' ),
                        'style-2'     => __( 'Style 2', 'haru-teespace' ),
                        'style-3'     => __( 'Style 3', 'haru-teespace' ),
                    ],
                    'condition' => [
                        // 'pre_style!' => [ 'slick', 'grid' ],
                    ],
                ]
            );

            $this->add_control(
                'post_padding',
                [
                  'label' => __( 'Post Padding', 'haru-teespace' ),
                  'type' => Controls_Manager::SELECT,
                  'default' => 'no-padding',
                  'options' => [
                    'no-padding'     => __( 'No Padding', 'haru-teespace' ),
                    'padding'     => __( 'Has Padding', 'haru-teespace' ),
                  ]
                ]
            );

            $this->add_control(
                'hover',
                [
                    'label' => __( 'Hover Style', 'haru-teespace' ),
                    'description'   => __( 'Choose Post Hover style.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'      => __( 'None', 'haru-teespace' ),
                        'overlay'   => __( 'Overlay', 'haru-teespace' ),
                        'scale'     => __( 'Scale', 'haru-teespace' ),
                        'over-scale'     => __( 'Overlay + Scale', 'haru-teespace' ),
                    ]
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'slide_section',
                [
                    'label' => esc_html__( 'Slide Options', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_slide_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Slide Options if you set Pre Featured Post is Slick layout.', 'haru-teespace' ) . '</strong><br>',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );

            $this->add_control(
                'arrows', [
                    'label' => __( 'Arrows', 'haru-teespace' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'haru-teespace' ),
                    'label_off' => __( 'Hide', 'haru-teespace' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3' ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'slidesToShow',
                [
                    'label' => __( 'Slide To Show', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '3',
                    'tablet_default'    => '2',
                    'mobile_default'    => '1',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3' ],
                    ],
                ]
            );

            $this->add_responsive_control(
                'slidesToScroll',
                [
                    'label' => __( 'Slide To Scroll', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '1',
                    'tablet_default'    => '1',
                    'mobile_default'    => '1',
                    'condition' => [
                        'pre_style' => [ 'slick', 'slick-2', 'slick-3' ],
                    ],
                ]
            );

            $this->add_control(
                'autoPlay',
                [
                    'label'         => __( 'AutoPlay', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'condition' => [
                        'pre_style' => [ 'slick' ],
                    ],
                ]
            );

            $this->add_control(
                'autoPlaySpeed',
                [
                    'label' => __( 'AutoPlay Speed (ms)', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1000,
                    'max' => 10000,
                    'step' => 100,
                    'default' => 3000,
                    'condition' => [
                        'autoPlay' => [ 'yes' ],
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'grid_section',
                [
                    'label' => esc_html__( 'Grid Options', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'grid' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_grid_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Grid Options if you set Pre Post is Grid layout.', 'haru-teespace' ) . '</strong><br>',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );

            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'   => '3',
                    'tablet_default'    => '2',
                    'mobile_default'    => '1',
                    'condition' => [
                        'pre_style' => [ 'grid' ],
                    ],
                    'prefix_class' => 'grid-columns-%s',
                ]
            );

            $this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

        	$this->add_render_attribute( 'post', 'class', 'haru-post-featured' );

        	$this->add_render_attribute( 'post', 'class', 'haru-post-featured--' . $settings['pre_style'] );

            $this->add_render_attribute( 'post', 'class', 'haru-post-featured--' . $settings['post_padding'] );

            $this->add_render_attribute( 'post', 'id', 'haru-post-featured' . rand() );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'post', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) : ?>
                <div class="haru-notice"><?php echo esc_html__( 'Please note layout or action may doesn\'t works on Preview Mode or Editor Mode but works fine on Frontend Mode.', 'haru-teespace' ); ?></div>
            <?php endif; ?>

            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
                <div <?php echo $this->get_render_attribute_string( 'post' ); ?>>
                    <?php echo Haru_Template::haru_get_template( 'post-featured/post-featured.php', $settings ); ?>
                </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

    		<?php
		}

	}
}
