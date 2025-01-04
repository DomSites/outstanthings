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

if ( ! class_exists( 'Haru_TeeSpace_Image_Blob_Widget' ) ) {
	class Haru_TeeSpace_Image_Blob_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-image-blob';
		}

		public function get_title() {
			return esc_html__( 'Haru Image Blob', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-image';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'image',
                'images',
                'gallery',
                'blob',
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

		public function get_style_depends() {

			if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
		        return [ 'blobz' ];
		    }

		    return [ 'blobz' ];

		}

		protected function register_controls() {

			$this->start_controls_section(
	            'content_section',
	            [
	                'label' => esc_html__( 'Content', 'haru-teespace' ),
	                // 'tab' => Controls_Manager::TAB_CONTENT,
	            ]
	        );

	        $this->add_control(
				'pre_style',
				[
					'label' => __( 'Pre Image Blob', 'haru-teespace' ),
					'description' 	=> __( 'If you choose Pre Image Blob you will use Style default from our theme.', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Style 1', 'haru-teespace' ),
					]
				]
			);

			$this->add_control(
	            'image',
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
                'image_padding',
                [
                  'label' => __( 'Image Padding', 'haru-teespace' ),
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
                    'description'   => __( 'Choose Image Hover style.', 'haru-teespace' ),
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
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

        	$this->add_render_attribute( 'image-blob', 'class', 'haru-image-blob' );

			$this->add_render_attribute( 'image-blob', 'class', 'haru-image-blob--' . $settings['pre_style'] );

			$this->add_render_attribute( 'image-blob', 'class', 'haru-image-blob--' . $settings['image_padding'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'image-blob', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                <div class="background-dark">
            <?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'image-blob' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'image-blob/image-blob.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
                </div>
            <?php endif; ?>

    		<?php
		}

	}
}
