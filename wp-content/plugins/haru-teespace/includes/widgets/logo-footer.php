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
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Logo_Footer_Widget' ) ) {
	class Haru_TeeSpace_Logo_Footer_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-logo-footer';
		}

		public function get_title() {
			return esc_html__( 'Haru Footer Logo', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-image';
		}

		public function get_categories() {
			return [ 'haru-footer-elements' ];
		}

		public function get_keywords() {
            return [
                'logo retina',
                'logo',
                'retina',
                'footer'
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

		protected function register_controls() {

			$this->start_controls_section(
	            'section_settings',
	            [
	                'label' 	=> esc_html__( 'Logo Settings', 'haru-teespace' ),
	                'tab' 		=> Controls_Manager::TAB_CONTENT,
	            ]
	        );

	        $this->add_control(
	            'logo',
	            [
	                'label' 	=> esc_html__( 'Choose Logo', 'haru-teespace' ),
	                'type' 		=> Controls_Manager::MEDIA,
	                'dynamic' 	=> [
	                    'active' 	=> true,
	                ],
	                'default' 	=> [
	                    'url'		=> Utils::get_placeholder_image_src(),
	                ],
	            ]
	        );

	        $this->add_control(
	            'logo_retina',
	            [
	                'label' 	=> esc_html__( 'Choose Logo Retina', 'haru-teespace' ),
	                'type' 		=> Controls_Manager::MEDIA,
	                'dynamic' 	=> [
	                    'active' 	=> true,
	                ],
	                'default' 	=> [
	                    'url' 		=> Utils::get_placeholder_image_src(),
	                ],
	            ]
	        );

	        $this->add_control(
	            'logo_dark',
	            [
	                'label' 	=> esc_html__( 'Choose Logo Dark Mode', 'haru-teespace' ),
	                'type' 		=> Controls_Manager::MEDIA,
	                'dynamic' 	=> [
	                    'active' 	=> true,
	                ],
	                'default' 	=> [
	                    'url'		=> Utils::get_placeholder_image_src(),
	                ],
	            ]
	        );

	        $this->add_control(
	            'logo_dark_retina',
	            [
	                'label' 	=> esc_html__( 'Choose Logo Retina Dark Mode', 'haru-teespace' ),
	                'type' 		=> Controls_Manager::MEDIA,
	                'dynamic' 	=> [
	                    'active' 	=> true,
	                ],
	                'default' 	=> [
	                    'url' 		=> Utils::get_placeholder_image_src(),
	                ],
	            ]
	        );

	        $this->add_responsive_control(
				'max_height',
				[
					'label' 	=> __( 'Logo Max Height (px)', 'haru-teespace' ),
					'type' 		=> Controls_Manager::NUMBER,
					'min' 		=> 1,
					'max' 		=> 200,
					'step' 		=> 1,
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'    => 40,
                    'tablet_default'    => '',
                    'mobile_default'    => '',
                    'selectors' => [
						'{{WRAPPER}} .haru-logo-footer img' => 'max-height: {{SIZE}}px',
					],
				]
			);

			$this->add_responsive_control(
				'logo_align',
				[
					'label' 	=> __( 'Logo Align', 'haru-teespace' ),
					'type' => Controls_Manager::CHOOSE,
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'    => '',
                    'tablet_default'    => '',
                    'mobile_default'    => '',
					'options' => [
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
						'left' 		=> 'justify-content: flex-start',
						'center' 	=> 'justify-content: center',
						'right' 	=> 'justify-content: flex-end',
					],
					'selectors' => [
						'{{WRAPPER}} .haru-logo-footer a' => '{{VALUE}}',
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

		}

		protected function render() {
			$settings = $this->get_settings_for_display();

        	$this->add_render_attribute( 'logo-footer', 'class', 'haru-logo-footer' );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'logo-footer', 'class', $settings['el_class'] );
			}
        	?>

        	<div <?php echo $this->get_render_attribute_string( 'logo-footer' ); ?>>
    			<?php echo Haru_Template::haru_get_template( 'logo/logo-footer.php', $settings ); ?>
    		</div>

    		<?php
		}

	}
}
