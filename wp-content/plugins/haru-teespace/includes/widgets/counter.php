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
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Counter_Widget' ) ) {
	class Haru_TeeSpace_Counter_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-counter';
		}

		public function get_title() {
			return esc_html__( 'Haru Counter', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-number-field';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'counter',
                'count',
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {
			return [ 'appear', 'jquery-numerator'  ];
		}

		protected function register_controls() {

			$this->start_controls_section(
				'section_counter',
				[
					'label' => __( 'Counter', 'haru-teespace' ),
				]
			);

			$this->add_control(
                'pre_style',
                [
                    'label' => __( 'Pre Counter', 'haru-teespace' ),
                    'description'   => __( 'If you choose Pre Counter you will use Style default from our theme.', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'style-1',
                    'options' => [
                        'style-1'   => __( 'Style 1', 'haru-teespace' ),
                        'style-2'   => __( 'Style 2', 'haru-teespace' ),
                        'style-3'   => __( 'Style 3', 'haru-teespace' ),
                        'style-4'   => __( 'Style 4', 'haru-teespace' ),
                        'style-5'   => __( 'Style 5', 'haru-teespace' ),
                    ]
                ]
            );

			$this->add_control(
				'starting_number',
				[
					'label' => __( 'Starting Number', 'haru-teespace' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 0,
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'ending_number',
				[
					'label' => __( 'Ending Number', 'haru-teespace' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 100,
					'dynamic' => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'prefix',
				[
					'label' => __( 'Number Prefix', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => '',
					'placeholder' => 1,
				]
			);

			$this->add_control(
				'suffix',
				[
					'label' => __( 'Number Suffix', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => '',
					'placeholder' => __( 'Plus', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'duration',
				[
					'label' => __( 'Animation Duration', 'haru-teespace' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 2000,
					'min' => 100,
					'step' => 100,
				]
			);

			$this->add_control(
				'thousand_separator',
				[
					'label' => __( 'Thousand Separator', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'label_on' => __( 'Show', 'haru-teespace' ),
					'label_off' => __( 'Hide', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'thousand_separator_char',
				[
					'label' => __( 'Separator', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'condition' => [
						'thousand_separator' => 'yes',
					],
					'options' => [
						'' => 'Default',
						'.' => 'Dot',
						' ' => 'Space',
					],
				]
			);

			$this->add_control(
				'title',
				[
					'label' => __( 'Title', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic' => [
						'active' => true,
					],
					'default' => __( 'Cool Number', 'haru-teespace' ),
					'placeholder' => __( 'Cool Number', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'description',
				[
					'label' => __( 'Description', 'haru-teespace' ),
					'type' => Controls_Manager::TEXTAREA,
					'label_block' => true,
					'dynamic' => [
						'active' => true,
					],
					'default' => __( 'Description', 'haru-teespace' ),
					'placeholder' => __( 'Description', 'haru-teespace' ),
					'condition' => [
						'pre_style' => [ 'style-3' ],
					],
				]
			);

			$this->add_responsive_control(
                'content_align',
                [
                    'label' 	=> __( 'Content Align', 'haru-teespace' ),
                    'type' 		=> \Elementor\Controls_Manager::CHOOSE,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'    => 'left',
                    'tablet_default'    => 'left',
                    'mobile_default'    => 'left',
                    'options' 	=> [
						'left' => [
							'title' 	=> __( 'Left', 'haru-teespace' ),
							'icon' 		=> 'eicon-h-align-left',
						],
						'center' => [
							'title' 	=> __( 'Center', 'haru-teespace' ),
							'icon' 		=> 'eicon-h-align-center',
						],
						'right' => [
							'title' 	=> __( 'Right', 'haru-teespace' ),
							'icon' 		=> 'eicon-h-align-right',
						],
					],
                    'selectors_dictionary' => [
						'left' 		=> 'justify-content: flex-start; text-align: left',
						'center' 	=> 'justify-content: center; text-align: center',
						'right' 	=> 'justify-content: flex-end; text-align: right',
					],
					'selectors' => [
						'{{WRAPPER}} .haru-counter__number-wrap' => '{{VALUE}}',
						'{{WRAPPER}} .haru-counter__title' => '{{VALUE}}',
						'{{WRAPPER}} .haru-counter__description' => '{{VALUE}}',
					]
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
				'list_icon', [
					'label' => esc_html__( 'Icon', 'haru-teespace' ),
					'type' => Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-star',
						'library' => 'solid',
					],
					'label_block' => true,
					'condition' => [
						'pre_style' => [ 'style-6' ],
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

            $this->add_control(
                'disable_appear',
                [
                    'label'         => __( 'Disable Appear', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Disable start Counter when appear.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

            $this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

        	$this->add_render_attribute( 'counter', 'class', 'haru-counter' );

			$this->add_render_attribute( 'counter', 'class', 'haru-counter--' . $settings['pre_style'] );

			$this->add_render_attribute( 'counter', 'class', 'haru-counter--appear-disable-' . $settings['disable_appear'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'counter', 'class', $settings['el_class'] );
			}
			
        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'counter' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'counter/counter.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

    		<?php
		}

	}
}
