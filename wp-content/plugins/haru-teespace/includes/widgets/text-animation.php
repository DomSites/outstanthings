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

if ( ! class_exists( 'Haru_TeeSpace_Text_Animation_Widget' ) ) {
	class Haru_TeeSpace_Text_Animation_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-text-animation';
		}

		public function get_title() {
			return esc_html__( 'Haru Text Animation', 'haru-teespace' );
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
                'text rotate',
                'rotate',
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
					'label' => __( 'Pre Text Animation', 'haru-teespace' ),
					'description' 	=> __( 'If you choose Pre Text Animation you will use Style default from our theme.', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Pre Text Animation 1 (64px)', 'haru-teespace' ),
						'style-2' 	=> __( 'Pre Text Animation 2 (76px)', 'haru-teespace' ),
						'style-3' 	=> __( 'Pre Text Animation 3 (72px)', 'haru-teespace' ),
					]
				]
			);

			$this->add_control(
				'pre_title', [
					'label' => esc_html__( 'Pre Title', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Pre Title' , 'haru-teespace' ),
					'label_block' => true,
				]
			);

	        $repeater = new Repeater();

			$repeater->add_control(
				'list_text', [
					'label' => esc_html__( 'Rotate Title', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Rotate Title' , 'haru-teespace' ),
					'label_block' => true
				]
			);

			$this->add_control(
				'list',
				[
					'label' => esc_html__( 'Text Animation', 'haru-teespace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_text' => esc_html__( 'Animation Title #1', 'haru-teespace' ),
						],
						[
							'list_text' => esc_html__( 'Animation Title #2', 'haru-teespace' ),
						],
					],
					'title_field' => '{{{ list_text }}}',
				]
			);

			$this->add_control(
				'sub_title', [
					'label' => esc_html__( 'Sub Title', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Sub Title' , 'haru-teespace' ),
					'label_block' => true,
				]
			);

			$this->add_control(
				'period', [
					'label' => esc_html__( 'Period (ms)', 'haru-teespace' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 2000,
					'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-3' ],
                    ],
				]
			);

			$this->add_responsive_control(
				'align',
				[
					'label' => __( 'Alignment', 'haru-teespace' ),
					'type' => Controls_Manager::CHOOSE,
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
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
					'default' => '',
					'selectors' => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
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
                'section_title_style',
                [
                    'label' => __( 'Style', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'pre_title_color',
                [
                    'label' => __( 'Pre Title Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-text-animation__pre' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-3' ],
                    ],
                ]
            );

            $this->add_control(
                'text_animation_color',
                [
                    'label' => __( 'Text Animation Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-text-animation__typewrite' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-3' ],
                    ],
                ]
            );

            $this->add_control(
                'sub_title_color',
                [
                    'label' => __( 'Sub Title Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-text-animation__sub' => 'color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-3' ],
                    ],
                ]
            );

            $this->add_control(
				'hr',
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);

			$this->add_responsive_control(
				'pre_title_font_size',
				[
					'label' => __( 'Pre Title Font Size', 'haru-teespace' ),
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 150,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-text-animation__pre' => 'font-size: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_responsive_control(
				'text_animation_font_size',
				[
					'label' => __( 'Text Animation Font Size', 'haru-teespace' ),
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 150,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-text-animation__typewrite' => 'font-size: {{SIZE}}{{UNIT}}; min-height: calc({{SIZE}}{{UNIT}} * 1.2);',
					],
				]
			);

			$this->add_responsive_control(
				'sub_title_font_size',
				[
					'label' => __( 'Sub Title Font Size', 'haru-teespace' ),
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 150,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-text-animation__sub' => 'font-size: {{SIZE}}{{UNIT}}',
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

        	$this->add_render_attribute( 'text-animation', 'id', 'haru-text-animation-' . $this->get_id() );

        	$this->add_render_attribute( 'text-animation', 'class', 'haru-text-animation' );

			$this->add_render_attribute( 'text-animation', 'class', 'haru-text-animation--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'text-animation', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'text-animation' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'text-animation/text-animation.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
