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
use \Elementor\Icons_Manager;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Button_Widget' ) ) {
	class Haru_TeeSpace_Button_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-button';
		}

		public function get_title() {
			return esc_html__( 'Haru Button', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-button';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'button',
                'link',
                'action',
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

		public static function get_button_sizes() {
			return [
				'xs' => __( 'Extra Small', 'haru-teespace' ),
				'sm' => __( 'Small', 'haru-teespace' ),
				'md' => __( 'Medium', 'haru-teespace' ),
				'lg' => __( 'Large', 'haru-teespace' ),
				'xl' => __( 'Extra Large', 'haru-teespace' ),
			];
		}

		protected function register_controls() {

			$this->start_controls_section(
	            'content_section',
	            [
	                'label' 	=> esc_html__( 'Button Settings', 'haru-teespace' ),
	                'tab' 		=> Controls_Manager::TAB_CONTENT,
	            ]
	        );

	        $this->add_control(
				'pre_style',
				[
					'label' => __( 'Pre Button', 'haru-teespace' ),
					'description' 	=> __( 'If you choose Pre Button you will use Style default from our theme.', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Pre Button 1 (Primary Color - Medium)', 'haru-teespace' ),
						'style-2' 	=> __( 'Pre Button 2 (Black Color - Medium)', 'haru-teespace' ),
						'style-3' 	=> __( 'Pre Button 3 (Outline - Medium)', 'haru-teespace' ),
						'style-4' 	=> __( 'Pre Button 4 (Text - Black)', 'haru-teespace' ),
						'style-5' 	=> __( 'Pre Button 5 (Primary Color - Large)', 'haru-teespace' ),
						'style-6' 	=> __( 'Pre Button 6 (White Color - Medium)', 'haru-teespace' ),
						'style-7' 	=> __( 'Pre Button 7 (Text - Black - Underline)', 'haru-teespace' ),
						'style-8' 	=> __( 'Pre Button 8 (Text - Primary Color)', 'haru-teespace' ),
					]
				]
			);

	        $this->add_control(
				'text',
				[
					'label' => __( 'Text', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => __( 'Click here', 'haru-teespace' ),
					'placeholder' => __( 'Click here', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'link',
				[
					'label' => __( 'Link', 'haru-teespace' ),
					'type' => Controls_Manager::URL,
					'dynamic' => [
						'active' => true,
					],
					'placeholder' => __( 'https://your-link.com', 'haru-teespace' ),
					'default' => [
						'url' => '#',
					],
				]
			);

			$this->add_responsive_control(
				'align',
				[
					'label' => __( 'Alignment', 'haru-teespace' ),
					'type' => Controls_Manager::CHOOSE,
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'    => '',
                    'tablet_default'    => '',
                    'mobile_default'    => '',
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
					'prefix_class' => 'haru-align-%s',
				]
			);

			$this->add_responsive_control(
                'text_transform',
                [
                    'label' 	=> __( 'Text Transform', 'haru-teespace' ),
                    // 'devices' => [ 'tablet', 'mobile' ],
                    'desktop_default'    => 'default',
                    'tablet_default'    => 'default',
                    'mobile_default'    => 'default',
                    'type' 		=> \Elementor\Controls_Manager::SELECT,
                    'options' 	=> [
						'default' =>__( 'Default', 'haru-teespace' ),
						'none' => __( 'None', 'haru-teespace' ),
						'capitalize' => __( 'Capitalize', 'haru-teespace' ),
						'uppercase' => __( 'Uppercase', 'haru-teespace' ),
						'lowercase' => __( 'Lowercase', 'haru-teespace' ),
					],
                    'selectors_dictionary' => [
						'default' 		=> '',
						'none' 			=> 'text-transform: none',
						'capitalize' 	=> 'text-transform: capitalize',
						'uppercase' 	=> 'text-transform: uppercase; letter-spacing: 0.05rem',
						'lowercase' 	=> 'text-transform: lowercase',
					],
					'selectors' => [
						'{{WRAPPER}} .haru-button-text' => '{{VALUE}}',
					],
                ]
            );

			$this->add_control(
				'size',
				[
					'label' => __( 'Size', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'sm',
					'options' => self::get_button_sizes(),
					'style_transfer' => true,
					'condition' => [
						'pre_style' => [ 'none' ],
					],
				]
			);

			$this->add_control(
				'btn_size',
				[
					'label' => __( 'Size', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'medium',
					'options' => [
						'large' => __( 'Large', 'haru-teespace' ),
						'medium' => __( 'Medium', 'haru-teespace' ),
						'normal' => __( 'Normal', 'haru-teespace' ),
						'small' => __( 'Small', 'haru-teespace' ),
					],
					'style_transfer' => true,
					'condition' => [
						'pre_style!' => [ 'none' ],
					],
				]
			);

			$this->add_control(
				'selected_icon',
				[
					'label' => __( 'Icon', 'haru-teespace' ),
					'type' => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
				]
			);

			$this->add_control(
				'icon_align',
				[
					'label' => __( 'Icon Position', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'left',
					'options' => [
						'left' => __( 'Before', 'haru-teespace' ),
						'right' => __( 'After', 'haru-teespace' ),
					],
					'condition' => [
						'selected_icon[value]!' => '',
					],
				]
			);

			$this->add_control(
				'icon_indent',
				[
					'label' => __( 'Icon Spacing', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-button .haru-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .haru-button .haru-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
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
				'button_css_id',
				[
					'label' => __( 'Button ID', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => '',
					'title' => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'haru-teespace' ),
					'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'haru-teespace' ),
					'separator' => 'before',
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

            $this->add_control(
                'shadow',
                [
                    'label'         => __( 'Shadow', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Enable if want to show shadow of Button.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                    'condition' => [
                        'pre_style' => [ 'style-1', 'style-2', 'style-5', 'style-6' ],
                    ],
                ]
            );
            
            $this->end_controls_section();

            $this->start_controls_section(
	            'section_style_button-color',
	            [
	                'label' => esc_html__( 'Color', 'haru-teespace' ),
	                'tab' => Controls_Manager::TAB_STYLE,
	            ]
	        );

            $this->start_controls_tabs( 'button_style' );

			$this->start_controls_tab(
				'tab_button_style_normal',
				[
					'label' => __( 'Normal', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_button_background',
				[
					'label' => __( 'Background Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-button-wrap .haru-button' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'color_button_text',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-button-wrap .haru-button' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'color_button_border',
				[
					'label' => __( 'Border Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-button-wrap .haru-button' => 'border-color: {{VALUE}}',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_button_style_hover',
				[
					'label' => __( 'Hover', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_button_background_hover',
				[
					'label' => __( 'Background Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-button-wrap .haru-button:hover' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'color_button_text_hover',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-button-wrap .haru-button:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'color_button_border_hover',
				[
					'label' => __( 'Border Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-button-wrap .haru-button:hover' => 'border-color: {{VALUE}}',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_button_style_active',
				[
					'label' => __( 'Active', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_button_background_active',
				[
					'label' => __( 'Background Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-button-wrap .haru-button:focus,
						{{WRAPPER}} .haru-button-wrap .haru-button:active' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'color_button_text_active',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-button-wrap .haru-button:focus,
						{{WRAPPER}} .haru-button-wrap .haru-button:active' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'color_button_border_active',
				[
					'label' => __( 'Border Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-button-wrap .haru-button:focus,
						{{WRAPPER}} .haru-button-wrap .haru-button:active' => 'border-color: {{VALUE}}',
					],
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

            $this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

        	$this->add_render_attribute( 'button-wrap', 'class', 'haru-button-wrap' );

        	if ( 'yes' == $settings['background_dark'] ) {
        		$this->add_render_attribute( 'button-wrap', 'class', 'background-dark' );
        	}

        	if ( 'yes' == $settings['shadow']  ) {
                $this->add_render_attribute( 'button', 'class', 'haru-button--shadow-' . $settings['shadow'] );
            }

            if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) {
            	$this->add_render_attribute( 'button', 'class', 'haru-button--has-icon' );
            }

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'button-wrap', 'class', $settings['el_class'] );
			}

        	$this->add_render_attribute( 'button', 'class', ['haru-button', 'elementor-button1'] );
        	$this->add_render_attribute( 'button', 'role', 'button' );

        	if ( 'style-1' == $settings['pre_style'] ) {
				$this->add_render_attribute( 
					'button',
					'class',
					[
						'haru-button--' . $settings['pre_style'],
						'haru-button--bg-primary',
						'haru-button--size-' . $settings['btn_size'],
						'haru-button--round-normal',
					]
				);
			} else if ( 'style-2' == $settings['pre_style'] ) {
				$this->add_render_attribute( 
					'button',
					'class',
					[
						'haru-button--' . $settings['pre_style'],
						'haru-button--bg-black',
						'haru-button--size-medium',
						'haru-button--round-normal',
					]
				);
			} else if ( 'style-3' == $settings['pre_style'] ) {
				$this->add_render_attribute( 
					'button',
					'class',
					[
						'haru-button--' . $settings['pre_style'],
						'haru-button--outline haru-button--outline-gray',
						'haru-button--size-' . $settings['btn_size'],
						'haru-button--round-normal',
					]
				);
			} else if ( 'style-4' == $settings['pre_style'] ) {
				$this->add_render_attribute( 
					'button',
					'class',
					[
						'haru-button--' . $settings['pre_style'],
						'haru-button--text-black',
						'haru-button--size-medium',
					]
				);
			} else if ( 'style-5' == $settings['pre_style'] ) {
				$this->add_render_attribute( 
					'button',
					'class',
					[
						'haru-button--' . $settings['pre_style'],
						'haru-button--bg-primary',
						'haru-button--size-large',
						'haru-button--round-normal',
					]
				);
			} else if ( 'style-6' == $settings['pre_style'] ) {
				$this->add_render_attribute( 
					'button',
					'class',
					[
						'haru-button--' . $settings['pre_style'],
						'haru-button--bg-white',
						'haru-button--size-' . $settings['btn_size'],
						'haru-button--round-normal',
					]
				);
			} else if ( 'style-7' == $settings['pre_style'] ) {
				$this->add_render_attribute( 
					'button',
					'class',
					[
						'haru-button--' . $settings['pre_style'],
						'haru-button--text-black',
						// 'haru-button--size-medium',
					]
				);
			} else if ( 'style-8' == $settings['pre_style'] ) {
				$this->add_render_attribute( 
					'button',
					'class',
					[
						'haru-button--' . $settings['pre_style'],
						'haru-button--text-primary',
						'haru-button--size-large',
					]
				);
			} else {
				$this->add_render_attribute( 
					'button',
					'class',
					[
						'haru-button--' . $settings['pre_style'],
						'haru-button--bg-black',
						'haru-button--round-small',
					]
				);
			}

			if ( ! empty( $settings['link']['url'] ) ) {
				$this->add_link_attributes( 'button', $settings['link'] );
				$this->add_render_attribute( 'button', 'class', 'elementor-button-link1 haru-button-link' );
			}

			if ( ! empty( $settings['button_css_id'] ) ) {
				$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
			}

			if ( ! empty( $settings['size'] ) ) {
				$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
			}

        	?>

        	<div <?php echo $this->get_render_attribute_string( 'button-wrap' ); ?>>
        		<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
        			<?php $this->render_text(); ?>
    			</a>
    		</div>

    		<?php
		}

		protected function render_text() {
			$settings = $this->get_settings_for_display();

			$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
			$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( ! $is_new && empty( $settings['icon_align'] ) ) {
				// @todo: remove when deprecated
				// added as bc in 2.6
				//old default
				$settings['icon_align'] = $this->get_settings( 'icon_align' );
			}

			$this->add_render_attribute( [
				'content-wrapper' => [
					'class' => 'elementor-button-content-wrapper1 haru-button-content-wrapper',
				],
				'icon-align' => [
					'class' => [
						// 'elementor-button-icon',
						'haru-button-icon',
						// 'elementor-align-icon-' . $settings['icon_align'],
						'haru-align-icon-' . $settings['icon_align'],
					],
				],
				'text' => [
					'class' => 'elementor-button-text1 haru-button-text',
				],
			] );

			$this->add_inline_editing_attributes( 'text', 'none' );
			?>
			<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
				<?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
				<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
					else : ?>
						<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
					<?php endif; ?>
				</span>
				<?php endif; ?>
				<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo $settings['text']; ?></span>
			</span>
			<?php
		}

		public function on_import( $element ) {
			return Icons_Manager::on_import_migration( $element, 'icon', 'selected_icon' );
		}

	}
}
