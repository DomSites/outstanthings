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
use \Elementor\Repeater;
use \Haru_TeeSpace\Classes\Helper as ControlsHelper;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Timeline_Widget' ) ) {
	class Haru_TeeSpace_Timeline_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-timeline';
		}

		public function get_title() {
			return esc_html__( 'Haru Timeline', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-social-icons';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'list',
                'content',
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['slick'];
            }

            return ['slick'];

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
					'label' => __( 'Pre Timeline', 'haru-teespace' ),
					'description' 	=> __( 'If you choose Pre Timeline you will use Style default from our theme.', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Pre Timeline 1 (Slick)', 'haru-teespace' ),
						'style-2' 	=> __( 'Pre Timeline 2', 'haru-teespace' ),
						'style-3' 	=> __( 'Pre Timeline 3', 'haru-teespace' ),
					]
				]
			);

	        $repeater = new Repeater();

	        $repeater->add_control(
				'list_time', [
					'label' => esc_html__( 'Time', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( '2030' , 'haru-teespace' ),
					'label_block' => true,
				]
			);

	        $repeater->add_control(
				'list_title', [
					'label' => esc_html__( 'Title', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'List Title' , 'haru-teespace' ),
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'list_description', [
					'label' => esc_html__( 'Description', 'haru-teespace' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'List Description' , 'haru-teespace' ),
					'label_block' => true,
				]
			);

			$repeater->add_control(
	            'list_image',
	            [
	                'label' 	=> esc_html__( 'Choose Image', 'haru-teespace' ),
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

			$repeater->add_control(
                'list_video',
                [
                    'label' => __( 'Select Video', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => ControlsHelper::get_post_list('haru_video'),
                    'label_block' => true,
                    'multiple' => false
                ]
            );

			$repeater->add_control(
	            'list_award',
	            [
	                'label' 	=> esc_html__( 'Choose Awards', 'haru-teespace' ),
	                'type' 		=> Controls_Manager::GALLERY,
	                'default' 	=> [],
	            ]
	        );

			$this->add_control(
				'list',
				[
					'label' => esc_html__( 'Timeline List', 'haru-teespace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_time' => esc_html__( 'Time #1', 'haru-teespace' ),
							'list_title' => esc_html__( 'Title #1', 'haru-teespace' ),
							'list_description' => esc_html__( 'Description', 'haru-teespace' ),
							// 'list_link' => esc_html__( 'Set Link.', 'haru-teespace' ),
						],
						[
							'list_time' => esc_html__( 'Time #2', 'haru-teespace' ),
							'list_title' => esc_html__( 'Title #2', 'haru-teespace' ),
							'list_description' => esc_html__( 'Description', 'haru-teespace' ),
							// 'list_content' => esc_html__( 'Set Link.', 'haru-teespace' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
					'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
				]
			);


			$repeater_list = new Repeater();

	        $repeater_list->add_control(
				'list_time', [
					'label' => esc_html__( 'Time', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( '2030' , 'haru-teespace' ),
					'label_block' => true,
				]
			);

	        $repeater_list->add_control(
				'list_title', [
					'label' => esc_html__( 'Title', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'List Title' , 'haru-teespace' ),
					'label_block' => true,
				]
			);

			$repeater_list->add_control(
				'list_description', [
					'label' => esc_html__( 'Description', 'haru-teespace' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'List Description' , 'haru-teespace' ),
					'label_block' => true,
				]
			);

			$repeater_list->add_control(
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

			$repeater_list->add_control(
				'list_link_text', [
					'label' => esc_html__( 'Link Text', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Detail' , 'haru-teespace' ),
					'label_block' => true,
				]
			);

			$repeater_list->add_control(
                'list_video',
                [
                    'label' => __( 'Select Video', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => ControlsHelper::get_post_list('haru_video'),
                    'label_block' => true,
                    'multiple' => false
                ]
            );

			$this->add_control(
				'list_timeline',
				[
					'label' => esc_html__( 'Timeline List', 'haru-teespace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater_list->get_controls(),
					'default' => [
						[
							'list_time' => esc_html__( 'Time #1', 'haru-teespace' ),
							'list_title' => esc_html__( 'Title #1', 'haru-teespace' ),
							'list_description' => esc_html__( 'Description', 'haru-teespace' ),
							'list_link' => esc_html__( 'Set Link.', 'haru-teespace' ),
						],
						[
							'list_time' => esc_html__( 'Time #2', 'haru-teespace' ),
							'list_title' => esc_html__( 'Title #2', 'haru-teespace' ),
							'list_description' => esc_html__( 'Description', 'haru-teespace' ),
							'list_content' => esc_html__( 'Set Link.', 'haru-teespace' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
					'condition' => [
                        'pre_style' => [ 'style-2', 'style-3' ],
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

			$this->start_controls_section(
                'slide_section',
                [
                    'label' => esc_html__( 'Slide Options', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
                ]
            );

            $this->add_control(
                'section_title_slide_description',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'You can set Slide Options if you set Pre Timeline is Slick layout.', 'haru-teespace' ) . '</strong><br>',
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
                        'pre_style' => [ 'style-1' ],
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
                        'pre_style' => [ 'style-1' ],
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
                        'pre_style' => [ 'style-1' ],
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
                        'pre_style' => [ 'style-1' ],
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

		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( '' === $settings['list'] ) {
				return;
			}

        	$this->add_render_attribute( 'timeline', 'class', 'haru-timeline' );

        	if ( 'none' != $settings['pre_style']  ) {
				$this->add_render_attribute( 'timeline', 'class', 'haru-timeline--' . $settings['pre_style'] );
			}

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'timeline', 'class', $settings['el_class'] );
			}
			
        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
		        	<div <?php echo $this->get_render_attribute_string( 'timeline' ); ?>>
		                <?php echo Haru_Template::haru_get_template( 'timeline/timeline.php', $settings ); ?>
		            </div>
            <?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
