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

if ( ! class_exists( 'Haru_TeeSpace_Nav_Menu_Template_Widget' ) ) {
	class Haru_TeeSpace_Nav_Menu_Template_Widget extends Widget_Base {

		protected $nav_menu_index = 1;

		public function get_name() {
			return 'haru-nav-menu-template';
		}

		public function get_title() {
			return esc_html__( 'Haru Nav Menu Template', 'haru-teespace' );
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
					'default' => 'hover',
					'options' => [
						'hover' => __( 'Hover (For Popup)', 'haru-teespace' ),
						'toggle' => __( 'Toggle (For Canvas)', 'haru-teespace' ),
					],
					'frontend_available' => true,
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
					]
				);
			} else {
				$this->add_control(
					'menu',
					[
						'type' => Controls_Manager::RAW_HTML,
						'raw' => '<strong>' . __( 'There are no menus in your site.', 'haru-teespace' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'haru-teespace' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
						// 'separator' => 'after',
						'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					]
				);
			}

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
                'menu_class' 		=> 'haru-nav-menu-template',
                'menu_id' 			=> 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
                'fallback_cb' 		=> '__return_empty_string',
                'container' 		=> '',
                'walker' 			=> new Haru_Nav_Menu()
            );

	        // Add custom filter to handle Nav Menu HTML output.
	        add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_mobile_classes' ], 10, 4 );
	        add_filter( 'nav_menu_item_id', '__return_empty_string' );

	        // Hover Menu.
			$menu_html = wp_nav_menu( $args );
			remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_mobile_classes' ], 10, 4 );

			// Toggle Menu.
			add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_mobile_classes' ], 10, 4 );
			$args['menu'] = $settings['menu'];
			$args['menu_id'] = 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id();
			$template_menu_html = wp_nav_menu( $args );
			remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_mobile_classes' ], 10, 4 );

			remove_filter( 'nav_menu_item_id', '__return_empty_string' );

			if ( empty( $template_menu_html ) ) {
				return;
			}		

			if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'menu-nav', 'class', $settings['el_class'] );
			}

			// haru-nav-menu-template--' . $settings['layout']
			// $this->add_render_attribute( 'menu-nav-wrap', 'class', 'haru-nav-menu-template' );
			$this->add_render_attribute( 'menu-nav-wrap', 'class', 'haru-nav-menu-template-layout-' . $settings['layout'] );
			$this->add_render_attribute( 'menu-nav', 'class', 'haru-nav-menu-template__container' );
			$this->add_render_attribute( 'menu-nav', 'role', 'navigation' );
			$this->add_render_attribute( 'menu-nav', 'aria-hidden', 'true' );

			?>

			<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
				<div <?php echo $this->get_render_attribute_string( 'menu-nav-wrap' ); ?>>
					<?php if ( $settings['layout'] == 'hover' ) : ?>
					<div class="haru-nav-menu-template--hover">
						<nav <?php echo $this->get_render_attribute_string( 'menu-nav' ); ?>>
							<?php echo $menu_html; ?>
						</nav>
					</div>
					<?php endif; ?>

					<div class="haru-nav-menu-template--dropdown">
						<nav <?php echo $this->get_render_attribute_string( 'menu-nav' ); ?>>
							<?php echo $template_menu_html; ?>
						</nav>
					</div>
				</div>
			<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>
			<?php
		}

		public function handle_link_mobile_classes( $atts, $item, $args, $depth ) {
			$classes = $depth ? 'haru-sub-titem' : 'haru-titem';
			$is_anchor = false !== strpos( $atts['href'], '#' );

			if ( ! $is_anchor && in_array( 'current-menu-item', $item->classes ) ) {
				$classes .= ' haru-titem-active';
			}

			if ( $is_anchor ) {
				$classes .= ' haru-titem-anchor';
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
