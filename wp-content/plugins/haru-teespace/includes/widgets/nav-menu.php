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
use \Elementor\Core\Responsive\Responsive;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Plugin;
use \Elementor\Utils;
use \Haru_TeeSpace\Classes\Haru_Template;
use \Haru_Nav_Menu;

if ( ! class_exists( 'Haru_TeeSpace_Nav_Menu_Widget' ) ) {
	class Haru_TeeSpace_Nav_Menu_Widget extends Widget_Base {

		protected $nav_menu_index = 1;

		public function get_name() {
			return 'haru-nav-menu';
		}

		public function get_title() {
			return esc_html__( 'Haru Nav Menu', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-nav-menu';
		}

		public function get_categories() {
			return [ 'haru-header-elements' ];
		}

		public function get_keywords() {
            return [
                'menu',
                'nav',
                'nav menu',
                'mega menu',
                'menu columns',
                'menu tab',
                'menu dropdown'
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {
			// @TODO check load
			// if ( in_array( $this->get_settings_for_display( 'layout' ), array( 'horizontal' ) ) ) {
		 //    	return [ 'one-page-nav' ];
	  //   	} else {
	  //   		return [];
	  //   	}

	    	return [ 'one-page-nav' ];
		}

		public function get_style_depends() {
			return [ 'menu-animate' ]; // Can't enqueue in Header static page https://github.com/elementor/elementor/issues/3670
		}

		protected function get_nav_menu_index() {
			return $this->nav_menu_index++;
		}

		private function get_available_menus() {
			$menus = wp_get_nav_menus();

			$options = [];

			foreach ( $menus as $menu ) {
				$options[ $menu->slug ] = $menu->name;
			}

			return $options;
		}

		protected function register_controls() {

			$this->start_controls_section(
				'section_settings',
				[
					'label' => __( 'Menu Settings', 'haru-teespace' ),
					'tab' 		=> Controls_Manager::TAB_CONTENT,
				]
			);

			$menus = $this->get_available_menus();

			if ( ! empty( $menus ) ) {
				$this->add_control(
					'menu',
					[
						'label' => __( 'Menu', 'haru-teespace' ),
						'type' => Controls_Manager::SELECT,
						'options' => $menus,
						'default' => array_keys( $menus )[0],
						'save_default' => true,
						'separator' => 'after',
						'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'haru-teespace' ), admin_url( 'nav-menus.php' ) ),
					]
				);
			} else {
				$this->add_control(
					'menu',
					[
						'type' => Controls_Manager::RAW_HTML,
						'raw' => '<strong>' . __( 'There are no menus in your site.', 'haru-teespace' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'haru-teespace' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
						'separator' => 'after',
						'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					]
				);
			}

			$this->add_control(
				'layout',
				[
					'label' => __( 'Layout', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'horizontal',
					'options' => [
						'horizontal' => __( 'Horizontal', 'haru-teespace' ),
						'vertical' => __( 'Vertical', 'haru-teespace' ),
						// 'dropdown' => __( 'Dropdown', 'haru-teespace' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'align_items',
				[
					'label' => __( 'Align', 'haru-teespace' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'haru-teespace' ),
							'icon' => 'eicon-h-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'haru-teespace' ),
							'icon' => 'eicon-h-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'haru-teespace' ),
							'icon' => 'eicon-h-align-right',
						],
						'justify' => [
							'title' => __( 'Stretch', 'haru-teespace' ),
							'icon' => 'eicon-h-align-stretch',
						],
					],
					'prefix_class' => 'haru-nav-menu__align-',
					'condition' => [
						'layout!' => 'dropdown',
					],
				]
			);

			$this->add_control(
				'pointer',
				[
					'label' 	=> __( 'Pointer', 'haru-teespace' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'none',
					'options' 	=> [
						'none' 			=> __( 'None', 'haru-teespace' ),
						'underline' 	=> __( 'Underline', 'haru-teespace' ),
						'overline' 		=> __( 'Overline', 'haru-teespace' ),
						'double-line' 	=> __( 'Double Line', 'haru-teespace' ),
						'highlight' 	=> __( 'Highlight', 'haru-teespace' ),
					],
					'style_transfer' => true,
					'condition' => [
						'layout!' 	=> 'dropdown',
					],
				]
			);

			$this->add_control(
				'animation_line',
				[
					'label' 	=> __( 'Animation', 'haru-teespace' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'fade',
					'options' 	=> [
						'fade' 		=> 'Fade',
						'slide' 	=> 'Slide',
						'grow' 		=> 'Grow',
						'drop-in' 	=> 'Drop In',
						'drop-out' 	=> 'Drop Out',
						'none' 		=> 'None',
					],
					'condition' => [
						'layout!' => 'dropdown',
						'pointer' => [ 'underline', 'overline', 'double-line' ],
					],
				]
			);

			$this->add_control(
				'indicator',
				[
					'label' 	=> __( 'Submenu Indicator', 'haru-teespace' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'classic',
					'options' 	=> [
						'none' 		=> __( 'None', 'haru-teespace' ),
						'classic' 	=> __( 'Classic', 'haru-teespace' ),
						'chevron' 	=> __( 'Chevron', 'haru-teespace' ),
						'angle' 	=> __( 'Angle', 'haru-teespace' ),
						'plus'	 	=> __( 'Plus', 'haru-teespace' ),
					],
					'prefix_class' => 'haru-nav-menu--indicator-',
				]
			);

			$this->add_control(
				'indicator_hide',
				[
					'label' 		=> __( 'Hide Level 0 Indicator', 'haru-teespace' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'return_value' 	=> 'none',
					'condition' => [
						'indicator!' => 'none',
					],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main .sub-arrow i' => 'display: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'nav_nowrap',
				[
					'label' 		=> __( 'Nav Nowrap', 'haru-teespace' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'return_value' 	=> 'nowrap',
					'condition' => [
						'layout' => 'horizontal',
					],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--layout-horizontal .haru-nav-menu' => 'flex-wrap: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'heading_vertical_menu',
				[
					'label' 	=> __( 'Vertical Menu', 'haru-teespace' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'layout' => 'vertical',
					],
				]
			);

			$this->add_control(
                'vertical_header',
                [
                    'label' => esc_html__( 'Vertical Header', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Shop By Categories' , 'haru-teespace' ),
                    'label_block' => false,
                    'condition' => [
                        'layout' => 'vertical',
                    ],
                ]
            );

            $this->add_control(
                'vertical_items',
                [
                    'label' => esc_html__( 'Items To Show', 'haru-teespace' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 6,
                    'min' => 1,
                    'label_block' => false,
                    'condition' => [
                        'layout' => 'vertical',
                    ],
                ]
            );

            $this->add_control(
				'vertical_open_text',
				[
					'label' 	=> __( 'View More Text', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'View More' , 'haru-teespace' ),
                    'condition' => [
                        'layout' => 'vertical',
                    ],
				]
			);

			$this->add_control(
				'vertical_close_text',
				[
					'label' 	=> __( 'Close Text', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Close' , 'haru-teespace' ),
                    'condition' => [
                        'layout' => 'vertical',
                    ],
				]
			);

            $this->add_control(
				'vertical_close',
				[
					'label' 		=> __( 'Close On Start', 'haru-teespace' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'default'       => 'no',
                    'return_value'  => 'yes',
                    'condition' => [
                        'layout' => 'vertical',
                    ],
				]
			);

			$this->add_responsive_control(
				'vertical_list_height',
				[
					'label' => __( 'Items List Max Height', 'haru-teespace' ),
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 300,
							'max' => 1200,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu.haru-vertical-menu' => 'max-height: {{SIZE}}{{UNIT}}; overflow-y: auto;',
					],
					'condition' => [
						'layout' => 'vertical',
					],
				]
			);

			$this->add_control(
				'heading_mobile_dropdown',
				[
					'label' 	=> __( 'Mobile Dropdown', 'haru-teespace' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'layout!' => 'dropdown',
					],
				]
			);

			if ( ! empty( $menus ) ) {
				$this->add_control(
					'menu_mobile',
					[
						'label' => __( 'Menu Mobile', 'haru-teespace' ),
						'type' => Controls_Manager::SELECT,
						'options' => $menus,
						'default' => array_keys( $menus )[0],
						'save_default' => true,
						'separator' => 'after',
						'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'haru-teespace' ), admin_url( 'nav-menus.php' ) ),
					]
				);
			} else {
				$this->add_control(
					'menu_mobile',
					[
						'type' => Controls_Manager::RAW_HTML,
						'raw' => '<strong>' . __( 'There are no menus in your site.', 'haru-teespace' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'haru-teespace' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
						'separator' => 'after',
						'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					]
				);
			}

			$breakpoints = Responsive::get_breakpoints();

			$this->add_control(
				'dropdown',
				[
					'label' 	=> __( 'Breakpoint', 'haru-teespace' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'tablet',
					'options' 	=> [
						/* translators: %d: Breakpoint number. */
						'mobile' 	=> sprintf( __( 'Mobile (< %dpx)', 'haru-teespace' ), $breakpoints['md'] ),
						/* translators: %d: Breakpoint number. */
						'tablet' 	=> sprintf( __( 'Tablet (< %dpx)', 'haru-teespace' ), $breakpoints['lg'] ),
						'none' 		=> __( 'None', 'haru-teespace' ),
					],
					'prefix_class' 	=> 'haru-nav-menu--dropdown-',
					'condition' 	=> [
						'layout!' => 'dropdown',
					],
				]
			);

			$this->add_control(
				'full_width',
				[
					'label' 		=> __( 'Full Width', 'haru-teespace' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'description' 	=> __( 'Stretch the dropdown of the menu to full width.', 'haru-teespace' ),
					'prefix_class' 	=> 'haru-nav-menu--',
					'return_value' 	=> 'stretch',
					'frontend_available' => true,
					'condition' => [
						'dropdown!' => 'none',
					],
				]
			);

			$this->add_control(
				'text_align',
				[
					'label' 		=> __( 'Align', 'haru-teespace' ),
					'type' 			=> \Elementor\Controls_Manager::SELECT,
					'default' 		=> 'aside',
					'options' 		=> [
						'aside' 	=> __( 'Aside', 'haru-teespace' ),
						'center' 	=> __( 'Center', 'haru-teespace' ),
					],
					'prefix_class' 	=> 'haru-nav-menu__text-align-',
					'condition' 	=> [
						'dropdown!' => 'none',
					],
				]
			);

			$this->add_control(
				'toggle',
				[
					'label' 	=> __( 'Toggle Button', 'haru-teespace' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'burger',
					'options' 	=> [
						'' 			=> __( 'None', 'haru-teespace' ),
						'burger' 	=> __( 'Hamburger', 'haru-teespace' ),
					],
					'prefix_class' 	=> 'haru-nav-menu--toggle haru-nav-menu--',
					'render_type' 	=> 'template',
					'frontend_available' => true,
					'condition' => [
						'dropdown!' 	=> 'none',
					],
				]
			);

			$this->add_responsive_control(
                'toggle_align',
                [
                    'label' 	=> __( 'Toggle Align', 'haru-teespace' ),
                    // 'devices' => [ 'tablet', 'mobile' ],
                    'tablet_default'    => 'center',
                    'mobile_default'    => 'center',
                    'type' 		=> \Elementor\Controls_Manager::CHOOSE,
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
						'left' 		=> 'margin-right: auto; margin-left: 0',
						'center' 	=> 'margin: 0 auto',
						'right' 	=> 'margin-left: auto; margin-right: 0',
					],
					'selectors' => [
						'{{WRAPPER}} .haru-menu-toggle' => '{{VALUE}}',
					],
					'condition' => [
						'toggle!' 	=> '',
						'dropdown!' => 'none',
					],
                ]
            );

            $this->add_control(
				'heading_onepage_menu',
				[
					'label' 	=> __( 'OnePage Menu', 'haru-teespace' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'is_onepage_menu',
				[
					'label' 		=> __( 'Is OnePage Menu', 'haru-teespace' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">OnePage Menu Tutorial</a> to manage your menus.', 'haru-teespace' ), 'https://harutheme.com/forums/topic/how-to-create-navigation-menu-one-page/' ),
					'prefix_class' 	=> 'haru-nav-menu--',
					'return_value' 	=> 'onepage',
					'frontend_available' => true,
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
	            'section_style_main-menu',
	            [
	                'label' => esc_html__( 'Main Menu', 'haru-teespace' ),
	                'tab' => Controls_Manager::TAB_STYLE,
	            ]
	        );

	        $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'menu_typography',
					'default' => '',
					'selector' => '{{WRAPPER}} .haru-item.haru-item--main',
				]
			);

			$this->start_controls_tabs( 'tabs_menu_item_style' );

			$this->start_controls_tab(
				'tab_menu_item_normal',
				[
					'label' => __( 'Normal', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_menu_item',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main' => 'color: {{VALUE}}',
						'{{WRAPPER}} .haru-nav-menu--main .vertical-view-more' => 'color: {{VALUE}}',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_menu_item_hover',
				[
					'label' => __( 'Hover', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_menu_item_hover',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main:hover,
						{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main.haru-item-active,
						{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main.highlighted,
						{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main:focus, 
						{{WRAPPER}} .haru-nav-menu--main .vertical-view-more:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'pointer_color_menu_item_hover',
				[
					'label' => __( 'Pointer Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main:before,
						{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main:after' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'pointer!' => [ 'none' ],
					],
				]
			);

			$this->add_control(
				'pointer_color_menu_item_hover_transparent',
				[
					'label' => __( 'Pointer Color Transparent', 'haru-teespace' ),
					'description' => __( 'Pointer Color when Header Transparent', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'.haru-header--transparent:not(.haru-header--sticky-on) {{WRAPPER}} .haru-nav-menu--main.haru--pointer-highlight .haru-item--main:hover:after, .haru-header--transparent:not(.haru-header--sticky-on) {{WRAPPER}} .haru-nav-menu--main.haru--pointer-highlight .haru-item--main.highlighted:after, .haru-header--transparent:not(.haru-header--sticky-on) {{WRAPPER}} .haru-nav-menu--main.haru--pointer-highlight .haru-item--main.haru-item-active:after' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'pointer!' => [ 'none' ],
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_menu_item_active',
				[
					'label' => __( 'Active', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_menu_item_active',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main.haru-item-active' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'pointer_color_menu_item_active',
				[
					'label' => __( 'Pointer Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main.haru-item-active:before,
						{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main.haru-item-active:after' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'pointer!' => [ 'none' ],
					],
				]
			);

			$this->add_control(
				'pointer_color_menu_item_active_transparent',
				[
					'label' => __( 'Pointer Color Transparent', 'haru-teespace' ),
					'description' => __( 'Pointer Color when Header Transparent', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main:before,
						{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main:after' => 'background-color: {{VALUE}}',
					],
					'selectors' => [
						'.haru-header--transparent:not(.haru-header--sticky-on) {{WRAPPER}} .haru-nav-menu--main.haru--pointer-highlight .haru-item--main:hover:after, .haru-header--transparent:not(.haru-header--sticky-on) {{WRAPPER}} .haru-nav-menu--main.haru--pointer-highlight .haru-item--main.highlighted:after, .haru-header--transparent:not(.haru-header--sticky-on) {{WRAPPER}} .haru-nav-menu--main.haru--pointer-highlight .haru-item--main.haru-item-active:after' => 'background-color: {{VALUE}}',
					],

					'condition' => [
						'pointer!' => [ 'none' ],
					],
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'hr',
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);

			$this->add_responsive_control(
				'pointer_width',
				[
					'label' => __( 'Pointer Width', 'haru-teespace' ),
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 20,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru--pointer-underline .haru-item.haru-item--main:after,
						 {{WRAPPER}} .haru--pointer-overline .haru-item.haru-item--main:before,
						 {{WRAPPER}} .haru--pointer-double-line .haru-item.haru-item--main:before,
						 {{WRAPPER}} .haru--pointer-double-line .haru-item.haru-item--main:after' => 'height: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'pointer' => [ 'underline', 'overline', 'double-line' ],
					],
				]
			);

			$this->add_responsive_control(
				'pointer_height',
				[
					'label' => __( 'Pointer Height', 'haru-teespace' ),
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru--pointer-highlight .haru-item.haru-item--main:after' => 'height: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'pointer' => [ 'highlight' ],
					],
				]
			);

			$this->add_responsive_control(
				'padding_horizontal_menu_item',
				[
					'label' => __( 'Horizontal Padding', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 60,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .haru-nav-menu--main .vertical-view-more' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_responsive_control(
				'padding_vertical_menu_item',
				[
					'label' => __( 'Vertical Padding', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 60,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--main .haru-item.haru-item--main' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .haru-nav-menu--main .vertical-view-more' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_responsive_control(
				'menu_space_between',
				[
					'label' => __( 'Space Between', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 60,
						],
					],
					'selectors' => [
						'body:not(.rtl) {{WRAPPER}} .haru-nav-menu--layout-horizontal .haru-nav-menu > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
						'body.rtl {{WRAPPER}} .haru-nav-menu--layout-horizontal .haru-nav-menu > li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .haru-nav-menu--main:not(.haru-nav-menu--layout-horizontal) .haru-nav-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

	        $this->end_controls_section();

	        // Dropdown Sub Menu
	        $this->start_controls_section(
				'section_style_sub_down',
				[
					'label' => __( 'Dropdown Sub Menu', 'haru-teespace' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'subdown_description',
				[
					'raw' => __( 'On desktop, this will affect the submenu.', 'haru-teespace' ),
					'type' => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-descriptor',
				]
			);

			$this->start_controls_tabs( 'tabs_subdown_item_style' );

			$this->start_controls_tab(
				'tab_subdown_item_normal',
				[
					'label' => __( 'Normal', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_subdown_item',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' =>  Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--subdown a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'background_color_subdown_item',
				[
					'label' => __( 'Background Color', 'haru-teespace' ),
					'type' =>  Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--subdown' => 'background-color: {{VALUE}}',
					],
					'separator' => 'none',
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_subdown_item_hover',
				[
					'label' => __( 'Hover', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_subdown_item_hover',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--subdown a:hover,
						{{WRAPPER}} .haru-nav-menu--subdown a.haru-item-active,
						{{WRAPPER}} .haru-nav-menu--subdown a.highlighted' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'background_color_subdown_item_hover',
				[
					'label' => __( 'Background Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--subdown a:hover,
						{{WRAPPER}} .haru-nav-menu--subdown a.haru-item-active,
						{{WRAPPER}} .haru-nav-menu--subdown a.highlighted' => 'background-color: {{VALUE}}',
					],
					'separator' => 'none',
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_subdown_item_active',
				[
					'label' => __( 'Active', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_subdown_item_active',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--subdown a.haru-item-active' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'background_color_subdown_item_active',
				[
					'label' => __( 'Background Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--subdown a.haru-item-active' => 'background-color: {{VALUE}}',
					],
					'separator' => 'none',
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'subdown_typography',
					'default' => '',
					'exclude' => [ 'line_height' ],
					'selector' => '{{WRAPPER}} .haru-nav-menu--subdown .haru-item, {{WRAPPER}} .haru-nav-menu--subdown  .haru-sub-item',
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'subdown_border',
					'selector' => '{{WRAPPER}} .haru-nav-menu--subdown',
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'subdown_border_radius',
				[
					'label' => __( 'Border Radius', 'haru-teespace' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--subdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .haru-nav-menu--subdown li:first-child a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
						'{{WRAPPER}} .haru-nav-menu--subdown li:last-child a' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'subdown_box_shadow',
					'exclude' => [
						'box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .haru-nav-menu--main .haru-nav-menu--subdown, {{WRAPPER}} .haru-nav-menu__container.haru-nav-menu--subdown',
				]
			);

			$this->add_responsive_control(
				'padding_horizontal_subdown_item',
				[
					'label' => __( 'Horizontal Padding', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--subdown a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
					],
					'separator' => 'before',

				]
			);

			$this->add_responsive_control(
				'padding_vertical_subdown_item',
				[
					'label' => __( 'Vertical Padding', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--subdown a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_control(
				'heading_subdown_divider',
				[
					'label' => __( 'Divider', 'haru-teespace' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'subdown_divider',
					'selector' => '{{WRAPPER}} .haru-nav-menu--subdown li:not(:last-child)',
					'exclude' => [ 'width' ],
				]
			);

			$this->add_control(
				'subdown_divider_width',
				[
					'label' => __( 'Border Width', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--subdown li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'subdown_divider_border!' => '',
					],
				]
			);

			$this->add_responsive_control(
				'subdown_top_distance',
				[
					'label' => __( 'Distance', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--main > .haru-nav-menu > li > .haru-nav-menu--subdown, {{WRAPPER}} .haru-nav-menu__container.haru-nav-menu--subdown' => 'margin-top: {{SIZE}}{{UNIT}} !important',
					],
					'separator' => 'before',
				]
			);

			$this->end_controls_section();


			// Dropdown Mobile
	        $this->start_controls_section(
				'section_style_dropdown',
				[
					'label' => __( 'Dropdown Mobile', 'haru-teespace' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'dropdown_description',
				[
					'raw' => __( 'On desktop, this will affect the submenu. On mobile, this will affect the entire menu.', 'haru-teespace' ),
					'type' => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-descriptor',
				]
			);

			$this->start_controls_tabs( 'tabs_dropdown_item_style' );

			$this->start_controls_tab(
				'tab_dropdown_item_normal',
				[
					'label' => __( 'Normal', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_dropdown_item',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' =>  Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--dropdown a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'background_color_dropdown_item',
				[
					'label' => __( 'Background Color', 'haru-teespace' ),
					'type' =>  Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--dropdown' => 'background-color: {{VALUE}}',
					],
					'separator' => 'none',
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_dropdown_item_hover',
				[
					'label' => __( 'Hover', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_dropdown_item_hover',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--dropdown a:hover,
						{{WRAPPER}} .haru-nav-menu--dropdown a.haru-item-active,
						{{WRAPPER}} .haru-nav-menu--dropdown a.highlighted' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'background_color_dropdown_item_hover',
				[
					'label' => __( 'Background Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--dropdown a:hover,
						{{WRAPPER}} .haru-nav-menu--dropdown a.haru-item-active,
						{{WRAPPER}} .haru-nav-menu--dropdown a.highlighted' => 'background-color: {{VALUE}}',
					],
					'separator' => 'none',
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_dropdown_item_active',
				[
					'label' => __( 'Active', 'haru-teespace' ),
				]
			);

			$this->add_control(
				'color_dropdown_item_active',
				[
					'label' => __( 'Text Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--dropdown a.haru-item-active' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'background_color_dropdown_item_active',
				[
					'label' => __( 'Background Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--dropdown a.haru-item-active' => 'background-color: {{VALUE}}',
					],
					'separator' => 'none',
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'dropdown_typography',
					'default' => '',
					'exclude' => [ 'line_height' ],
					'selector' => '{{WRAPPER}} .haru-nav-menu--dropdown .haru-item, {{WRAPPER}} .haru-nav-menu--dropdown  .haru-sub-item',
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'dropdown_border',
					'selector' => '{{WRAPPER}} .haru-nav-menu--dropdown',
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'dropdown_border_radius',
				[
					'label' => __( 'Border Radius', 'haru-teespace' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .haru-nav-menu--dropdown li:first-child a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
						'{{WRAPPER}} .haru-nav-menu--dropdown li:last-child a' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'dropdown_box_shadow',
					'exclude' => [
						'box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .haru-nav-menu--main .haru-nav-menu--dropdown, {{WRAPPER}} .haru-nav-menu__container.haru-nav-menu--dropdown',
				]
			);

			$this->add_responsive_control(
				'padding_horizontal_dropdown_item',
				[
					'label' => __( 'Horizontal Padding', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--dropdown a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
					],
					'separator' => 'before',

				]
			);

			$this->add_responsive_control(
				'padding_vertical_dropdown_item',
				[
					'label' => __( 'Vertical Padding', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--dropdown a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_control(
				'heading_dropdown_divider',
				[
					'label' => __( 'Divider', 'haru-teespace' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'dropdown_divider',
					'selector' => '{{WRAPPER}} .haru-nav-menu--dropdown li:not(:last-child)',
					'exclude' => [ 'width' ],
				]
			);

			$this->add_control(
				'dropdown_divider_width',
				[
					'label' => __( 'Border Width', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--dropdown li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'dropdown_divider_border!' => '',
					],
				]
			);

			$this->add_responsive_control(
				'dropdown_top_distance',
				[
					'label' => __( 'Distance', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-nav-menu--main > .haru-nav-menu > li > .haru-nav-menu--dropdown, {{WRAPPER}} .haru-nav-menu__container.haru-nav-menu--dropdown' => 'margin-top: {{SIZE}}{{UNIT}} !important',
					],
					'separator' => 'before',
				]
			);

			$this->add_control(
				'heading_toggle_style',
				[
					'label' => __( 'Toggle Button', 'haru-teespace' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'color_toggle_button',
				[
					'label' => __( 'Toggle Button Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-menu-toggle' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'background_toggle_button',
				[
					'label' => __( 'Toggle Button Background', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-menu-toggle' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'icon_toggle_button_size',
				[
					'label' => __( 'Icon Font Size', 'haru-teespace' ),
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 10,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-menu-toggle' => 'font-size: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_responsive_control(
				'icon_toggle_box_size',
				[
					'label' => __( 'Box Size', 'haru-teespace' ),
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .haru-menu-toggle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->end_controls_section();

		}

		protected function render() {
			if ( ! class_exists( 'Haru_Nav_Menu' ) ) {
                require_once HARU_TEESPACE_CORE_DIR . '/includes/classes/class-haru-megamenu-nav.php';
            }

			$available_menus = $this->get_available_menus();

			if ( ! $available_menus ) {
				return;
			}

			$settings = $this->get_settings();

	        $args = array(
	        	'echo' 				=> false,
                'menu' 				=> $settings['menu'],
                'menu_class' 		=> 'haru-nav-menu',
                'menu_id' 			=> 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
                'fallback_cb' 		=> '__return_empty_string',
                'container' 		=> '',
                'walker' 			=> new Haru_Nav_Menu()
            );

            if ( 'vertical' === $settings['layout'] ) {
				$args['menu_class'] .= ' haru-vertical-menu';

				$this->add_render_attribute( 'menu-header', [
					'class' 		=> 'haru-menu-header',
					// 'role' 			=> 'button',
					// 'tabindex' 		=> '0',
					// 'aria-label' 	=> __( 'Menu Header', 'haru-teespace' )
				] );
			}

            // Add custom filter to handle Nav Menu HTML output.
			add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ], 10, 4 );
			add_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_classes' ] );
			add_filter( 'nav_menu_item_id', '__return_empty_string' );

            // General Menu.
			$menu_html = wp_nav_menu( $args );

			remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ], 10, 4 );
			remove_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_classes' ] );

			// Dropdown Menu Mobile.
			add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_mobile_classes' ], 10, 4 );
			// add_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_dropdown_classes' ] );
			$args['menu'] = $settings['menu_mobile'];
			$args['menu_id'] = 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id();
			$dropdown_menu_html = wp_nav_menu( $args );
			remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_mobile_classes' ], 10, 4 );
			// remove_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_dropdown_classes' ] );

			remove_filter( 'nav_menu_item_id', '__return_empty_string' );

			if ( empty( $menu_html ) ) {
				return;
			}

			$this->add_render_attribute( 'menu-toggle', [
				'class' 		=> 'haru-menu-toggle',
				// 'role' 			=> 'button',
				// 'tabindex' 		=> '0',
				// 'aria-label' 	=> __( 'Menu Toggle', 'haru-teespace' ),
				// 'aria-expanded' => 'false',
			] );

			if ( 'vertical' === $settings['layout'] ) {
				$this->add_render_attribute( 'menu-toggle', [
					'class' => 'toggle-vertical',
				] );
			}

			if ( Plugin::$instance->editor->is_edit_mode() ) {
				$this->add_render_attribute( 'menu-toggle', [
					'class' => 'elementor-clickable',
				] );
			}

			if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'main-menu', 'class', $settings['el_class'] );
				$this->add_render_attribute( 'menu-toggle', 'class', $settings['el_class'] );
			}

			if ( 'dropdown' !== $settings['layout'] ) :
				$this->add_render_attribute( 'main-menu', 'class', [
					'haru-nav-menu--main',
					'haru-nav-menu__container',
					'haru-nav-menu--layout-' . $settings['layout'],
				] );

				// Vertical
				if ( 'vertical' === $settings['layout'] ) :
					$this->add_render_attribute( 'main-menu', 'data-items-show', $settings['vertical_items'] );
					$this->add_render_attribute( 'main-menu', 'data-start', 'yes' == $settings['vertical_close'] ? 'close' : 'open' );
				endif;

				if ( $settings['pointer'] ) :
					$this->add_render_attribute( 'main-menu', 'class', 'haru--pointer-' . $settings['pointer'] );

					foreach ( $settings as $key => $value ) :
						if ( 0 === strpos( $key, 'animation' ) && $value ) :
							$this->add_render_attribute( 'main-menu', 'class', 'haru--animation-' . $value );

							break;
						endif;
					endforeach;
				endif; ?>

				<nav <?php echo $this->get_render_attribute_string( 'main-menu' ); ?>>
					<?php if ( 'vertical' === $settings['layout'] ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'menu-header' ); ?>>
						<i class="hicon-menu" aria-hidden="true"></i>
						<?php echo $settings['vertical_header']; ?>
					</div>
					<?php endif; ?>

					<?php if ( 'vertical' === $settings['layout'] ) : ?>
						<div class="menu-vertical-wrap">
					<?php endif; ?>

                	<?php echo $menu_html; ?>

                	<?php if ( 'vertical' === $settings['layout'] ) : ?>
                		<div class="menu-vertical-toggle">
			                <a href="javascript:;" class="vertical-view-more" data-open-text="<?php echo $settings['vertical_open_text']; ?>" data-close-text="<?php echo $settings['vertical_close_text']; ?>"><?php echo $settings['vertical_open_text']; ?></a>
			            </div>
            		<?php endif; ?>

	                <?php if ( 'vertical' === $settings['layout'] ) : ?>
						</div>
					<?php endif; ?>
                </nav>
                <?php
			endif;
			?>

			<?php if ( 'vertical' === $settings['layout'] ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'menu-toggle' ); ?>>
					<div <?php echo $this->get_render_attribute_string( 'menu-header' ); ?>>
						<i class="hicon-menu" aria-hidden="true"></i>
						<?php echo $settings['vertical_header']; ?>
					</div>
				</div>

				<!-- <div class="menu-vertical-wrap"> -->

					<nav class="haru-nav-menu--dropdown haru-nav-menu__container" aria-hidden="true">
						<?php echo $dropdown_menu_html; ?>
					</nav>

				<!-- </div> -->
			<?php endif; ?>

			<?php if ( 'vertical' !== $settings['layout'] ) : ?>
			<div <?php echo $this->get_render_attribute_string( 'menu-toggle' ); ?>>
				<i class="phosphor-list" aria-hidden="true"></i>
				<span class="elementor-screen-only"><?php _e( 'Menu', 'haru-teespace' ); ?></span>
			</div>
			<nav class="haru-nav-menu--dropdown haru-nav-menu__container" aria-hidden="true">
				<!-- <div class="haru-nav-menu__title"><?php echo esc_html__( 'Menu', 'haru-teespace' ); ?></div> -->
				<?php echo $dropdown_menu_html; ?>
			</nav>
			<?php endif; ?>
			<?php
		}

		public function handle_link_classes( $atts, $item, $args, $depth ) {
			$classes = $depth ? 'haru-sub-item' : 'haru-item';
			$is_anchor = false !== strpos( $atts['href'], '#' );

			// Check if the item is in the Main menu is Level 0
		    if ( ( $args->menu_class == 'haru-nav-menu' || $args->menu_class == 'haru-nav-menu haru-vertical-menu' ) && $depth == 0 ) {
		      $classes .= ' haru-item--main';
		    }

			if ( ! $is_anchor && in_array( 'current-menu-item', $item->classes ) ) {
				$classes .= ' haru-item-active';
			}

			if ( $is_anchor ) {
				$classes .= ' haru-item-anchor';
			}

			if ( empty( $atts['class'] ) ) {
				$atts['class'] = $classes;
			} else {
				$atts['class'] .= ' ' . $classes;
			}

			return $atts;
		}

		public function handle_link_mobile_classes( $atts, $item, $args, $depth ) {
			$classes = $depth ? 'haru-sub-item' : 'haru-item';
			$is_anchor = false !== strpos( $atts['href'], '#' );

			if ( ! $is_anchor && in_array( 'current-menu-item', $item->classes ) ) {
				$classes .= ' haru-item-active';
			}

			if ( $is_anchor ) {
				$classes .= ' haru-item-anchor';
			}

			if ( empty( $atts['class'] ) ) {
				$atts['class'] = $classes;
			} else {
				$atts['class'] .= ' ' . $classes;
			}

			return $atts;
		}

		public function handle_sub_menu_classes( $classes ) {
			$classes[] = 'haru-nav-menu--subdown';

			return $classes;
		}

		// public function handle_sub_menu_dropdown_classes( $classes ) {
		// 	$classes[] = 'haru-nav-menu--dropdown';

		// 	return $classes;
		// }

	}
}
