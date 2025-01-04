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
use \Elementor\Plugin;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Icon_List_Widget' ) ) {
	class Haru_TeeSpace_Icon_List_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-icon-list';
		}

		public function get_title() {
			return esc_html__( 'Haru Icon List', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-text';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'heading',
                'list',
                'text',
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
					'label' => __( 'Pre Icon List', 'haru-teespace' ),
					'description' 	=> __( 'If you choose Pre Icon List you will use Style default from our theme.', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Pre Icon List 1 (Image)', 'haru-teespace' ),
					]
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
				'list_sub_title', [
					'label' => esc_html__( 'Sub Title', 'haru-teespace' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'List Sub Title' , 'haru-teespace' ),
					'label_block' => true,
					'condition' => [
                        'pre_style' => [ 'style-2' ],
                    ],
				]
			);

			$repeater->add_control(
	            'list_image',
	            [
	                'label' 	=> esc_html__( 'Choose Image', 'haru-teespace' ),
	                'description' 	=> __( 'Use for style use Image.', 'haru-teespace' ),
	                'type' 		=> Controls_Manager::MEDIA,
	                'dynamic' 	=> [
	                    'active' 	=> true,
	                ],
	                'default' 	=> [
	                    'url'		=> Utils::get_placeholder_image_src(),
	                ],
	            ]
	        );

	        $repeater->add_control(
                'list_link', [
                    'label' => esc_html__( 'Link', 'haru-teespace' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', 'haru-teespace' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
            );

			$this->add_control(
				'list',
				[
					'label' => esc_html__( 'Icon List', 'haru-teespace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-teespace' ),
							'list_sub_title' => esc_html__( 'Sub Title.', 'haru-teespace' ),
							'list_image' => esc_html__( 'Select Image', 'haru-teespace' ),
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-teespace' ),
							'list_sub_title' => esc_html__( 'Sub Title.', 'haru-teespace' ),
							'list_image' => esc_html__( 'Select Image', 'haru-teespace' ),
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

	        $this->start_controls_section(
				'section_layout_title',
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
                'grid_section',
                [
                    'label' => esc_html__( 'Grid Options', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [
                            [
                                'name' => 'pre_style',
                                'operator' => '==',
                                'value' => 'style-1',
                            ],
                        ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_grid_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Grid Options if you set Pre Banner List is Grid layout.', 'haru-teespace' ) . '</strong><br>',
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
                        'pre_style' => [ 'style-1' ],
                    ],
                    'prefix_class' => 'grid-columns-%s',
                ]
            );

            $this->end_controls_section();

		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( '' === $settings['list'] ) {
				return;
			}

        	$this->add_render_attribute( 'icon-list', 'id', 'haru-icon-list-' . $this->get_id() );

        	$this->add_render_attribute( 'icon-list', 'class', 'haru-icon-list' );

			$this->add_render_attribute( 'icon-list', 'class', 'haru-icon-list--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'icon-list', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'icon-list' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'icon-list/icon-list.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
