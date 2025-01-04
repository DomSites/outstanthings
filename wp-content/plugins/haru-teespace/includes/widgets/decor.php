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

if ( ! class_exists( 'Haru_TeeSpace_Decor_Widget' ) ) {
	class Haru_TeeSpace_Decor_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-decor';
		}

		public function get_title() {
			return esc_html__( 'Haru Decor', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-wordart';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'decor',
                'circle',
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
					'label' => __( 'Pre Decor', 'haru-teespace' ),
					'description' 	=> __( 'If you choose Pre Decor you will use Style default from our theme.', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Style 1 (Circle Gradient - 2 Colors)', 'haru-teespace' ),
						'style-2' 	=> __( 'Style 2 (Circle Gradient - 3 Colors)', 'haru-teespace' ),
						'style-3' 	=> __( 'Style 3 (Ellipse Blur)', 'haru-teespace' ),
						'style-4' 	=> __( 'Style 4 (Dotted)', 'haru-teespace' ),
						'style-5' 	=> __( 'Style 5 (Circle Layered)', 'haru-teespace' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'bg_color_1',
				[
					'label' => __( 'Background Color 1', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-3', 'style-4', 'style-5' ],
                    ],
                    'selectors' => [
						'{{WRAPPER}} .haru-decor__circle--layered, {{WRAPPER}} .haru-decor__circle--layered::before, {{WRAPPER}} .haru-decor__circle--layered::after' => 'border-color: {{VALUE}}',
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
                        'pre_style' => [ 'style-1', 'style-2' ],
                    ],
				]
			);

			$this->add_control(
				'bg_color_3',
				[
					'label' => __( 'Background Color 3', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
                        'pre_style' => [ 'style-2' ],
                    ],
				]
			);

			$this->add_control(
				'dot_size',
				[
					'label' => __( 'Dot Size', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 10,
						],
					],
					'condition' => [
                        'pre_style' => [ 'style-4' ],
                    ],
				]
			);

			$this->add_control(
				'opacity',
				[
					'label' => esc_html__( 'Opacity', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'min' => 0,
						'max' => 1,
					],
					'selectors' => [
						'{{WRAPPER}} .haru-decor__content' => 'opacity: {{SIZE}};',
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

        	$this->add_render_attribute( 'decor', 'class', 'haru-decor' );

			$this->add_render_attribute( 'decor', 'class', 'haru-decor--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'decor', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'decor' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'decor/decor.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

    		<?php
		}

	}
}
