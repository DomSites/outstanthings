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
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Footer_Link_Widget' ) ) {
	class Haru_TeeSpace_Footer_Link_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-footer-link';
		}

		public function get_title() {
			return esc_html__( 'Haru Footer Link', 'haru-teespace' );
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
                'link',
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
					'label' => __( 'Pre Footer Link', 'haru-teespace' ),
					'description' 	=> __( 'If you choose Pre Footer Link you will use Style default from our theme.', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none' 		=> __( 'None', 'haru-teespace' ),
						'style-1' 	=> __( 'Pre Footer Link 1 (15px)', 'haru-teespace' ),
						'style-2' 	=> __( 'Pre Footer Link 2', 'haru-teespace' ),
						'style-3' 	=> __( 'Pre Footer Link 3', 'haru-teespace' ),
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
				'list_content', [
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
					'label' => esc_html__( 'Link List', 'haru-teespace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-teespace' ),
							'list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'haru-teespace' ),
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-teespace' ),
							'list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'haru-teespace' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
				]
			);

			$this->add_responsive_control(
				'link_align',
				[
					'label' 	=> __( 'Link Align', 'haru-teespace' ),
					'type' => Controls_Manager::CHOOSE,
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'options' => [
						'left'    => [
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
					'desktop_default'    => '',
                    'tablet_default'    => '',
                    'mobile_default'    => '',
                    'selectors' => [
						'{{WRAPPER}} .haru-footer-link ul' => 'text-align: {{VALUE}};',
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
					'raw' => '<strong>' . __( 'You can set style if you set Pre Footer Link is None.', 'haru-teespace' ) . '</strong><br>',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);

	        $this->start_controls_tabs( 
	        	'footer_link_item_style',
	        	[
	        		'condition' => [
						'pre_style' => [ 'none' ],
					],
	        	]
	        );

			$this->start_controls_tab(
				'footer_link_item_normal',
				[
					'label' => __( 'Normal', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'title_color',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => '',
					],
					'condition' => [
						'pre_style' => [ 'none' ],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-footer-link a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'footer_link_item_hover',
				[
					'label' => __( 'Hover', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'title_color_hover',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => '',
					],
					'condition' => [
						'pre_style' => [ 'none' ],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-footer-link a:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'footer_link_item_active',
				[
					'label' => __( 'Active', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'title_color_active',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => '',
					],
					'condition' => [
						'pre_style' => [ 'none' ],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-footer-link a:active' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->end_controls_section();

		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( '' === $settings['list'] ) {
				return;
			}

        	$this->add_render_attribute( 'footer-link', 'class', 'haru-footer-link' );

        	if ( 'none' != $settings['pre_style']  ) {
				$this->add_render_attribute( 'footer-link', 'class', 'haru-footer-link--' . $settings['pre_style'] );
			}

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'footer-link', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'footer-link' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'footer-link/footer-link.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
