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
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Divider_Widget' ) ) {
	class Haru_TeeSpace_Divider_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-divider';
		}

		public function get_title() {
			return esc_html__( 'Haru Divider', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-divider';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'divider',
                'wave',
                'svg',
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
					'label' => __( 'Pre Divider', 'haru-teespace' ),
					'description' 	=> __( 'If you choose Pre Divider you will use Style default from our theme.', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Style 1 (Wave Double)', 'haru-teespace' ),
						'style-2' 	=> __( 'Style 2 (Trapezoid)', 'haru-teespace' ),
						'style-3' 	=> __( 'Style 3 (Triangle)', 'haru-teespace' ),
						'style-4' 	=> __( 'Style 4 (Wave Single)', 'haru-teespace' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'wave_color_1',
				[
					'label' => __( 'Wave Color 1', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
                        'pre_style' => [ 'style-1', 'style-4' ],
                    ],
				]
			);

			$this->add_control(
				'wave_color_2',
				[
					'label' => __( 'Wave Color 2', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
                        'pre_style' => [ 'style-1' ],
                    ],
				]
			);

			$this->add_control(
				'bg_color_1',
				[
					'label' => __( 'Background Color 1', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
                        'pre_style' => [ 'style-2', 'style-3' ],
                    ],
				]
			);

			$this->add_control(
				'bg_color_2',
				[
					'label' => __( 'Background Color 2', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
                        'pre_style' => [ 'style-2', 'style-3' ],
                    ],
				]
			);

			$this->add_responsive_control(
				'height',
				[
					'label' => esc_html__( 'Height', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vh' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1440,
						],
						'vh' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'description' => sprintf(
						esc_html__( 'To achieve full height Divider use %s.', 'haru-teespace' ),
						'100vh'
					),
					'selectors' => [
						'{{WRAPPER}} .haru-waves' => 'height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .haru-divider__content' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'min_height',
				[
					'label' => esc_html__( 'Min Height', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vh' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1440,
						],
						'vh' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'description' => sprintf(
						esc_html__( 'To achieve full height Divider use %s.', 'haru-teespace' ),
						'100vh'
					),
					'selectors' => [
						'{{WRAPPER}} .haru-waves' => 'min-height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .haru-divider__content' => 'min-height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'max_height',
				[
					'label' => esc_html__( 'Max Height', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'vh' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1440,
						],
						'vh' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'description' => sprintf(
						esc_html__( 'To achieve full height Divider use %s.', 'haru-teespace' ),
						'100vh'
					),
					'selectors' => [
						'{{WRAPPER}} .haru-waves' => 'max-height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .haru-divider__content' => 'max-height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
                'reverse_shape',
                [
                    'label'         => __( 'Reverse Shape', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Enable if you want reverse Shape.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
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
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

        	$this->add_render_attribute( 'divider', 'class', 'haru-divider' );

			$this->add_render_attribute( 'divider', 'class', 'haru-divider--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'divider', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'divider' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'divider/divider.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

    		<?php
		}

	}
}
