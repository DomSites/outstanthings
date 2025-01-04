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
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Plugin;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Footer_Text_Widget' ) ) {
	class Haru_TeeSpace_Footer_Text_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-footer-text';
		}

		public function get_title() {
			return esc_html__( 'Haru Footer Text', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-text';
		}

		public function get_categories() {
			return [ 'haru-footer-elements' ];
		}

		public function get_keywords() {
            return [
                'footer',
                'text',
                'editor',
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
					'label' => __( 'Pre Footer Text', 'haru-teespace' ),
					'description' 	=> __( 'If you choose Pre Footer Text you will use Style default from our theme.', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none' 		=> __( 'None', 'haru-teespace' ),
						'style-1' 	=> __( 'Pre Footer Text 1', 'haru-teespace' ),
					]
				]
			);

			$this->add_control(
				'editor',
				[
					'label' => '',
					'type' => Controls_Manager::WYSIWYG,
					'default' => '<p>' . __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'haru-teespace' ) . '</p>',
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
				'style_section_title',
				[
					'label' => __( 'Style', 'haru-teespace' ),
					'tab' => Controls_Manager::TAB_STYLE,
					'condition' => [
						'pre_style' => 'none',
					],
				]
			);

			$this->add_control(
				'section_title_style_description',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . __( 'You can set style if you set Pre Footer Text is None.', 'haru-teespace' ) . '</strong><br>',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);

			$this->add_responsive_control(
				'align',
				[
					'label' => __( 'Alignment', 'haru-teespace' ),
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
					'selectors' => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'text_color',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}}' => 'color: {{VALUE}};',
					],
					'global' => [
						'default' => '',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography',
					'global' => [
						'default' => '',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'text_shadow',
					'selector' => '{{WRAPPER}}',
				]
			);

			$this->end_controls_section();

		}

		protected function render() {
			$settings = $this->get_settings_for_display();

        	$this->add_render_attribute( 'footer-text', 'class', 'haru-footer-text' );

        	if ( 'none' != $settings['pre_style']  ) {
				$this->add_render_attribute( 'footer-text', 'class', 'haru-footer-text--' . $settings['pre_style'] );
			}

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'footer-text', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'footer-text' ); ?>>
	        		<?php 
	        		$editor_content = $this->get_settings_for_display( 'editor' );

					$editor_content = $this->parse_text_editor( $editor_content );

					if ( ! Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' ) ) {
						$this->add_render_attribute( 'editor', 'class', [ 'elementor-text-editor', 'elementor-clearfix' ] );
					}

					$this->add_inline_editing_attributes( 'editor', 'advanced' );
					?>
					<?php if ( ! Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' ) ) { ?>
						<div <?php echo $this->get_render_attribute_string( 'editor' ); ?>>
					<?php } ?>
						<?php echo $editor_content; ?>
					<?php if ( ! Plugin::$instance->experiments->is_feature_active( 'e_dom_optimization' ) ) { ?>
						</div>
					<?php } ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
