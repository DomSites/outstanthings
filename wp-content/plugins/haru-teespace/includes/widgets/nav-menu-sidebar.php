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
use \Elementor\Core\Responsive\Responsive;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Plugin;
use \Haru_TeeSpace\Classes\Helper;
use \Haru_TeeSpace\Classes\Haru_Template;
use \Haru_Nav_Menu;

if ( ! class_exists( 'Haru_TeeSpace_Nav_Menu_Sidebar_Widget' ) ) {
	class Haru_TeeSpace_Nav_Menu_Sidebar_Widget extends Widget_Base {

		protected $nav_menu_index = 1;

		public function get_name() {
			return 'haru-nav-menu-sidebar';
		}

		public function get_title() {
			return esc_html__( 'Haru Nav Menu Sidebar', 'haru-teespace' );
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
                'popup',
                'sidebar',
                'menu popup',
                'mega menu',
                'menu columns',
                'menu tab',
                'menu dropdown'
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
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

			$this->add_control(
				'layout',
				[
					'label' => __( 'Layout', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'canvas',
					'options' => [
						'canvas' => __( 'Canvas', 'haru-teespace' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_responsive_control(
                'sidebar_position',
                [
                    'label' 	=> __( 'Canvas Position', 'haru-teespace' ),
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
						'right' => [
							'title' 	=> __( 'Right', 'haru-teespace' ),
							'icon' 		=> 'eicon-h-align-right',
						],
					],
					'frontend_available' => true,
                ]
            );

			$this->add_control(
                'menu_content', [
                    'label' => __( 'Menu Content', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'menu' => __( 'Menu', 'haru-teespace' ),
                        'template' => __( 'Mega Menu Templates', 'haru-teespace' ),
                    ],
                    'default' => 'menu',
                ]
            );

			// Use Menu
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
						'condition' => [
	                        'menu_content' => 'menu',
	                    ]
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
						'condition' => [
	                        'menu_content' => 'menu',
	                    ]
					]
				);
			}

			// Use template
			$this->add_control(
                'menu_template', 
                [
                    'label' => __( 'Choose Template', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => Helper::get_megamenu_templates(),
                    'condition' => [
                        'menu_content' => 'template',
                    ]
                ]
            );

			$this->add_control(
				'toggle',
				[
					'label' 	=> __( 'Toggle Button', 'haru-teespace' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'burger',
					'options' 	=> [
						'burger' 	=> __( 'Hamburger', 'haru-teespace' ),
					],
					'prefix_class' 	=> 'haru-nav-menu--toggle haru-nav-menu--',
					'render_type' 	=> 'template',
					'frontend_available' => true,
				]
			);

			$this->add_control(
                'selected_icon',
                [
                    'label' => __( 'Toggle Icon', 'haru-teespace' ),
                    'type' => Controls_Manager::ICONS,
                    'separator' => 'before',
                    'fa4compatibility' => 'icon',
                    'default' => [
                        'value' => 'fas fa-search',
                        'library' => 'fa-solid',
                    ],
                ]
            );

			$this->add_responsive_control(
                'toggle_align',
                [
                    'label' 	=> __( 'Toggle Align', 'haru-teespace' ),
                    'type' 		=> \Elementor\Controls_Manager::CHOOSE,
                    'devices' => [ 'desktop', 'tablet', 'mobile' ],
                    'desktop_default'    => 'center',
                    'tablet_default'    => 'center',
                    'mobile_default'    => 'center',
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
						'{{WRAPPER}} .haru-menu-toggle-sidebar' => '{{VALUE}}',
					]
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
				'section_layout_style',
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
                'canvas_dark',
                [
                    'label'         => __( 'Canvas Dark', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Enable if use Canvas background dark.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

			$this->end_controls_section();

			// Sidebar Toggle
	        $this->start_controls_section(
				'section_style_dropdown',
				[
					'label' => __( 'Dropdown Menu', 'haru-teespace' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'dropdown_description',
				[
					'raw' => __( 'You can set style of Sidebar Menu here' ),
					'type' => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-descriptor',
				]
			);

			$this->add_responsive_control(
				'color_toggle_button',
				[
					'label' => __( 'Toggle Button Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-menu-toggle-sidebar' => 'color: {{VALUE}}',
					],
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'background_toggle_button',
				[
					'label' => __( 'Toggle Button Background', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .haru-menu-toggle-sidebar' => 'background-color: {{VALUE}}',
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
                'menu_class' 		=> 'haru-nav-menu-sidebar',
                'menu_id' 			=> 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
                'fallback_cb' 		=> '__return_empty_string',
                'container' 		=> '',
                'walker' 			=> new Haru_Nav_Menu()
            );

	        // Add custom filter to handle Nav Menu HTML output.
			// Toggle Menu.
			add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_mobile_classes' ], 10, 4 );
			$args['menu'] = $settings['menu'];
			$args['menu_id'] = 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id();
			$sidebar_menu_html = wp_nav_menu( $args );
			remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_mobile_classes' ], 10, 4 );

			remove_filter( 'nav_menu_item_id', '__return_empty_string' );

			if ( empty( $sidebar_menu_html ) ) {
				return;
			}

			// Set the selected icon.
            $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );

            if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
                // @todo: remove when deprecated
                // added as bc in 2.6
                // add old default
                $settings['icon'] = 'fa fa-search';
            }

            $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
            $has_icon = ( ! $is_new || ! empty( $settings['selected_icon']['value'] ) );

			$this->add_render_attribute( 'menu-toggle-sidebar', [
				'class' 		=> 'haru-menu-toggle-sidebar',
				'role' 			=> 'button',
				'tabindex' 		=> '0',
				'aria-label' 	=> __( 'Menu Toggle', 'haru-teespace' ),
			] );

			if ( Plugin::$instance->editor->is_edit_mode() ) {
				$this->add_render_attribute( 'menu-toggle-sidebar', [
					'class' => 'elementor-clickable',
				] );
			}

			if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'menu-nav', 'class', $settings['el_class'] );
				$this->add_render_attribute( 'menu-toggle-sidebar', 'class', $settings['el_class'] );
			}

			$this->add_render_attribute( 'menu-toggle-sidebar', 'data-effect', 'mfp-zoom-in2' );
			$this->add_render_attribute( 'menu-toggle-sidebar', 'data-id', 'haru-nav-menu-sidebar-' . $this->get_id() );

			$this->add_render_attribute( 'menu-nav', 'class', 'haru-nav-menu-sidebar--dropdown' );
			$this->add_render_attribute( 'menu-nav', 'class', 'haru-nav-menu-sidebar__container' );
			$this->add_render_attribute( 'menu-nav', 'role', 'navigation' );
			$this->add_render_attribute( 'menu-nav', 'aria-hidden', 'true' );

			$this->add_render_attribute( 'haru-nav-menu-sidebar-wrap', 'class', 'haru-nav-menu-sidebar-wrap' );
			$this->add_render_attribute( 'haru-nav-menu-sidebar-wrap', 'id', 'haru-nav-menu-sidebar-' . $this->get_id() );

			$this->add_render_attribute( 'haru-nav-menu-sidebar-wrap', 'class', 'sidebar-position sidebar-position--' . $settings['sidebar_position'] . ' sidebar-position--tablet-' . $settings['sidebar_position_tablet'] . ' sidebar-position--mobile-' . $settings['sidebar_position_mobile'] );

			$this->add_render_attribute( 'haru-nav-menu-sidebar-wrap', 'class', 'canvas-style canvas-style--dark-' . $settings['canvas_dark'] );

			?>
			<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
				<div <?php echo $this->get_render_attribute_string( 'menu-toggle-sidebar' ); ?>>
					<?php if ( $has_icon ) : ?>
	                    <?php if ( $is_new || $migrated ) : ?>
	                        <?php Icons_Manager::render_icon( $settings['selected_icon'] ); ?>
	                    <?php else : ?>
	                        <i class="<?php echo esc_attr( $settings['icon'] ); ?>"></i>
	                    <?php endif; ?>
	                <?php endif; ?>
					<span class="elementor-screen-only"><?php _e( 'Menu', 'haru-teespace' ); ?></span>
				</div>
			<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

			<div <?php echo $this->get_render_attribute_string( 'haru-nav-menu-sidebar-wrap' ); ?>>
				<?php if ( $settings['layout'] == 'canvas' ) : ?>
					<div class="haru-canvas-close"></div>
				<?php endif; ?>
				<?php if ( $settings['menu_content'] == 'menu' ) : ?>
					<nav <?php echo $this->get_render_attribute_string( 'menu-nav' ); ?>>
						<?php echo $sidebar_menu_html; ?>
					</nav>
				<?php elseif ( $settings['menu_content'] == 'template' ) : ?>
					<div class="haru-nav-menu-sidebar__container">
						<?php if ( $settings['menu_content'] == 'template' ) : ?>
						<?php
							$args = array(
			                    'include'     => array( $settings['menu_template'] ),
			                    'post_type'   => 'haru_megamenu',
			                    'post_status' => 'publish',
			                    'numberposts' => 1
			                );

			                $posts = get_posts($args);

			                if ( $posts && isset($posts[0]) ) {
			                    $post = $posts[0];
			                    $content = apply_filters( 'haru_render_post_builder', do_shortcode( $post->post_content ), $post);
			                    echo $content;
		                    }
						?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $settings['layout'] == 'canvas' ) : ?>
				<div class="haru-canvas-overlay"></div>
			<?php endif; ?>
			<?php
		}

		public function handle_link_mobile_classes( $atts, $item, $args, $depth ) {
			$classes = $depth ? 'haru-sub-citem' : 'haru-citem';
			$is_anchor = false !== strpos( $atts['href'], '#' );

			if ( ! $is_anchor && in_array( 'current-menu-item', $item->classes ) ) {
				$classes .= ' haru-citem-active';
			}

			if ( $is_anchor ) {
				$classes .= ' haru-citem-anchor';
			}

			if ( empty( $atts['class'] ) ) {
				$atts['class'] = $classes;
			} else {
				$atts['class'] .= ' ' . $classes;
			}

			return $atts;
		}
	}
}
