<?php
/**
 * Plugin Name: Haru TeeSpace
 * Description: Haru TeeSpace extension from HaruTheme.
 * Plugin URI:  http://harutheme.com
 * Version:     1.5.6
 * Author:      HaruTheme
 * Author URI:  http://harutheme.com
 * Text Domain: haru-teespace
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Haru TeeSpace Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'Haru_TeeSpace' ) ) {
	final class Haru_TeeSpace {

		/**
		 * Plugin Version
		 *
		 * @since 1.0.0
		 *
		 * @var string The plugin version.
		 */
		const VERSION = '1.5.6';

		/**
		 * Minimum Elementor Version
		 *
		 * @since 1.0.0
		 *
		 * @var string Minimum Elementor version required to run the plugin.
		 */
		const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

		/**
		 * Minimum PHP Version
		 *
		 * @since 1.0.0
		 *
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const MINIMUM_PHP_VERSION = '7.0';

		/**
		 * Instance
		 *
		 * @since 1.0.0
		 *
		 * @access private
		 * @static
		 *
		 * @var Haru_TeeSpace The single instance of the class.
		 */
		private static $_instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @static
		 *
		 * @return Haru_TeeSpace An instance of the class.
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;

		}

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function __construct() {

			// Define some constant
			$this->define();

			// Include plugin files
			$this->includes();

			add_action( 'init', [ $this, 'i18n' ] );
			add_action( 'plugins_loaded', [ $this, 'init' ] );
			add_action( 'admin_init', [ $this, 'admin_assets' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_assets' ] );

			// On Editor - Register WooCommerce frontend hooks before the Editor init.
			// Priority = 5, in order to allow plugins remove/add their wc hooks on init. Some issues resolve by CSS
			if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
				add_action( 'init', [ $this, 'register_wc_hooks' ], 5 );
			}

			// Change settings of other Plugins
			add_filter('extendifysdk_load_library', '__return_false');

			// Disable revslider notice.
			if ( function_exists( 'rev_slider_shortcode' ) ) {
			    add_action( 'admin_init', 'haru_disable_revslider_notice' );
			}

			function haru_disable_revslider_notice() {
			    update_option( 'revslider-valid-notice', 'false' );
			}

			// Remove Contact Form 7 auto p
			add_filter( 'wpcf7_autop_or_not', '__return_false' );

			// https://stackoverflow.com/questions/66611705/getting-notice-is-wordpress-wp-scriptslocalize-was-called-incorrectly
			add_filter( 'doing_it_wrong_trigger_error', '__return_false', 10, 0 );
		}

		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 *
		 * Fired by `init` action hook.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function i18n() {

			load_plugin_textdomain( 'haru-teespace', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		}

		/**
		 * Initialize the plugin
		 *
		 * Load the plugin only after Elementor (and other plugins) are loaded.
		 * Checks for basic plugin requirements, if one check fail don't continue,
		 * if all check have passed load the files required to run the plugin.
		 *
		 * Fired by `plugins_loaded` action hook.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function init() {

			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
				return;
			}

			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_teespace_version' ] );
				return;
			}

			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
				return;
			}

			// Add Plugin actions
			// Add widgets categories
			add_action( 'elementor/elements/categories_registered', [ $this, 'add_teespace_widget_categories' ] );

			// Register widgets
			add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );

			// Register controls
			add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

			// Register Widget Styles
			add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

			// Register Widget Scripts
			add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have Elementor installed or activated.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_notice_missing_main_plugin() {

			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'haru-teespace' ),
				'<strong>' . esc_html__( 'Haru TeeSpace', 'haru-teespace' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'haru-teespace' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required Elementor version.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_notice_minimum_teespace_version() {

			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'haru-teespace' ),
				'<strong>' . esc_html__( 'Haru TeeSpace', 'haru-teespace' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'haru-teespace' ) . '</strong>',
				 self::MINIMUM_ELEMENTOR_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required PHP version.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_notice_minimum_php_version() {

			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

			$message = sprintf(
				/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'haru-teespace' ),
				'<strong>' . esc_html__( 'Haru TeeSpace', 'haru-teespace' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'haru-teespace' ) . '</strong>',
				 self::MINIMUM_PHP_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

		}

		/**
		 * Define Constants
		 *
		 * Define plugin constants
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function define() {

			if ( ! defined( 'HARU_TEESPACE_CORE_DIR' ) ) {
	            define( 'HARU_TEESPACE_CORE_DIR', plugin_dir_path(__FILE__) );
	        }

	        if ( ! defined( 'HARU_TEESPACE_CORE_URL' ) ) {
	            define( 'HARU_TEESPACE_CORE_URL', plugin_dir_url( __FILE__ ) );
	        }

	        if ( ! defined( 'HARU_TEESPACE_CORE_FILE' ) ) {
	            define( 'HARU_TEESPACE_CORE_FILE', __FILE__ );
	        }

	        if ( ! defined( 'HARU_TEESPACE_CORE_NAME' ) ) {
                define( 'HARU_TEESPACE_CORE_NAME', 'haru-teespace' );
            }

		}

		/**
		 * Include Files
		 *
		 * Include plugin files
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function includes() {

			require_once( 'includes/classes/class-haru-helper.php' );
			require_once( 'includes/classes/class-haru-controls-helper.php' );
			require_once( 'includes/classes/class-haru-templates.php' );
			require_once( 'includes/classes/class-haru-ajax-helper.php' );
			require_once( 'includes/classes/product-ajax-actions.php' );

			require_once( 'includes/helper/elementor-icons.php' );
			require_once( 'includes/helper/theme-functions.php' );
			require_once( 'includes/helper/woo-buy-now.php' );

			require_once( 'includes/posttypes/_init.php' );
			require_once( 'core/libraries/_init.php' );
			require_once( 'includes/maintenance/_init.php' );

			require_once( 'includes/wp-widgets/widgets.php' );

			// WooCommerce @TODO: check load
			require_once( 'includes/term-meta/index.php' ); // Add term meta to product attributes

		}

		/**
		 * Add Widgets Categories
		 *
		 * Use for Haru Widgets Categories
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		function add_teespace_widget_categories( $elements_manager ) {

			$elements_manager->add_category(
				'haru-elements',
				[
					'title' => esc_html__( 'Haru Elements', 'haru-teespace' ),
					'icon' => 'fa fa-plug',
				]
			);

			$elements_manager->add_category(
				'haru-header-elements',
				[
					'title' => esc_html__( 'Haru Header Elements', 'haru-teespace' ),
					'icon' => 'fa fa-plug',
				]
			);

			$elements_manager->add_category(
				'haru-footer-elements',
				[
					'title' => esc_html__( 'Haru Footer Elements', 'haru-teespace' ),
					'icon' => 'fa fa-plug',
				]
			);

		}

		/**
		 * Init Widgets
		 *
		 * Include widgets files and register them
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function init_widgets() {
			// Custom existing widget
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/custom-widget.php' );

			// Include Widget files
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/logo.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/logo-footer.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/footer-link.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/footer-text.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/nav-menu.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/nav-menu-popup.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/nav-menu-sidebar.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/nav-menu-template.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/heading.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/contact.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/social.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/video.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/counter.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/countdown.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/button.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/post-featured.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/banner.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/banner-list.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/banner-creative.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/tabs.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/images-gallery.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/logo-showcase.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/testimonial.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/team-member.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/icon-box.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/accordion.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/google-maps.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/price-table.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/particles.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/image-blob.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/text-animation.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/divider.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/decor.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/steps.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/icon-list.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/content-slideshow.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/price-calculator.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/toolbar-link.php' );

			// Header Elements
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/search.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/header-contact.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/header-button.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/close-row.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/header-icon-box.php' );
			
			// Menu Elements
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/menu-post.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/menu-tabs.php' );

			// Special TeeSpace
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/text-scroll.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/text-list.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/text-label.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/timeline.php' );

			// Slideshow
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/romeo-slideshow.php' );
			require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/layla-slideshow.php' );

			// Woo Widgets
			if ( class_exists( 'WooCommerce' ) ) {
				require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/woo-search.php' );
				require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/woo-cart.php' );
				require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/woo-wishlist.php' );
				require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/woo-account.php' );
				require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/woo-product-best-seller.php' );
				require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/woo-product-top-sale.php' );
				require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/woo-product-top-rated.php' );
				require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/woo-ajax-category.php' );
				require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/woo-product-slider.php' );
				require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/woo-ajax-order.php' );
				require_once( HARU_TEESPACE_CORE_DIR . '/includes/widgets/woo-product-variations.php' );
			}

			// Register widget
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Logo_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Logo_Footer_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Footer_Link_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Footer_Text_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Nav_Menu_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Nav_Menu_Popup_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Nav_Menu_Sidebar_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Nav_Menu_Template_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Heading_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Contact_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Social_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Video_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Counter_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Countdown_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Button_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Post_Featured_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Banner_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Banner_List_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Banner_Creative_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Tabs_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Images_Gallery_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Logo_Showcase_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Testimonial_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Team_Member_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Icon_Box_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Accordion_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Google_Maps_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Price_Table_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Particles_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Image_Blob_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Text_Animation_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Divider_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Decor_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Steps_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Icon_List_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Content_Slideshow_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Price_Calculator_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Toolbar_Link_Widget() );

			// Header
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Search_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Header_Contact_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Header_Button_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Close_Row_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Header_Icon_Box_Widget() );

			// Menu
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Menu_Post_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Menu_Tabs_Widget() );

			// Special TeeSpace
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Text_Scroll_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Text_List_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Text_Label_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Timeline_Widget() );

			// Slideshow
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Romeo_Slideshow_Widget() );
			\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Layla_Slideshow_Widget() );

			// Woo Widgets
			if ( class_exists( 'WooCommerce' ) ) {
				\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Woo_Search_Widget() );
				\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Woo_Cart_Widget() );
				\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Woo_Account_Widget() );
				if ( class_exists('YITH_WCWL') ) {
					\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Woo_Wishlist_Widget() );
				}
				\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Woo_Product_Best_Seller_Widget() );
				\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Woo_Product_Top_Sale_Widget() );
				\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Woo_Product_Top_Rated_Widget() );
				\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Woo_Ajax_Category_Widget() );
				\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Woo_Product_Slider_Widget() );
				\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Woo_Ajax_Order_Widget() );
				\Elementor\Plugin::instance()->widgets_manager->register( new \Haru_TeeSpace\Widgets\Haru_TeeSpace_Woo_Product_Variations_Widget() );
			}
		}

		/**
		 * Init WooCommerce before Editor
		 *
		 * Register WooCommerce frontend hooks before the Editor init
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function register_wc_hooks() {
			if ( class_exists( 'WooCommerce' ) ) {
				wc()->frontend_includes();
			}
		}

		/**
		 * Init Controls
		 *
		 * Include controls files and register them
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function init_controls() {

			// Include Control files
			// require_once( HARU_TEESPACE_CORE_DIR . '/includes/controls/test-control.php' );

			// Register control
			// \Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Test_Control() );

		}

		/**
		 * Widget Styles
		 *
		 * Include style files and register them
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function widget_styles() {
			wp_register_style( 'menu-animate', plugins_url( 'assets/lib/animate/animate.min.css', __FILE__ ) );
			wp_register_style( 'slick', plugins_url( 'assets/lib/slick/slick.css', __FILE__ ) );
			wp_register_style( 'magnific-popup', plugins_url( 'assets/lib/magnific-popup/magnific-popup.css', __FILE__ ) );
			wp_register_style( 'blobz', plugins_url( 'assets/lib/blobz/blobz.min.css', __FILE__ ) );
			wp_register_style( 'flickity', 'https://unpkg.com/flickity@2/dist/flickity.min.css' );
					
		}

		/**
		 * Widget Scripts
		 *
		 * Include script files and register them
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function widget_scripts() {

			wp_register_script( 'slick', plugins_url( 'assets/lib/slick/slick.min.js', __FILE__ ) );
			wp_register_script( 'isotope', plugins_url( 'assets/lib/isotope/isotope.pkgd.min.js', __FILE__ ) );
			wp_register_script( 'magnific-popup', plugins_url( 'assets/lib/magnific-popup/jquery.magnific-popup.min.js', __FILE__ ) );
			wp_register_script( 'particles', plugins_url( 'assets/lib/particles/particles.min.js', __FILE__ ) );
			wp_register_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js' );
			wp_register_script( 'flickity', 'https://unpkg.com/flickity@2.2.1/dist/flickity.pkgd.min.js' );

			wp_register_script( 'appear', plugins_url( 'assets/lib/appear/jquery.appear.js', __FILE__ ) );
			wp_register_script( 'countdown', plugins_url( 'assets/lib/countdown/jquery.countdown.js', __FILE__ ) );
			wp_register_script( 'redcountdown-knob', plugins_url( 'assets/lib/redcountdown/jquery.knob.min.js', __FILE__ ) );
			wp_register_script( 'redcountdown-debounce', plugins_url( 'assets/lib/redcountdown/jquery.ba-throttle-debounce.min.js', __FILE__ ) );
			wp_register_script( 'redcountdown', plugins_url( 'assets/lib/redcountdown/jquery.redcountdown.js', __FILE__ ) );
		}

		/**
		 * Admin Assets
		 *
		 * Include assets files for admin
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_assets() {
			wp_register_style( 'select2', plugins_url( HARU_TEESPACE_CORE_NAME . '/assets/lib/select2/select2.min.css' ), array(), false, 'all' );
			wp_register_script( 'select2', plugins_url( HARU_TEESPACE_CORE_NAME . '/assets/lib/select2/select2.full.min.js' ), array( 'jquery' ), false, false );

			wp_enqueue_style( 'haru-teespace', plugins_url( HARU_TEESPACE_CORE_NAME . '/assets/css/admin.css' ), array(), false, 'all' );
			wp_enqueue_script( 'haru-teespace', plugins_url( HARU_TEESPACE_CORE_NAME . '/assets/js/admin.js' ), array( 'jquery', 'select2' ), false, false );
		}
	}
}

Haru_TeeSpace::instance();
