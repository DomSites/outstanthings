<?php
/**
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! class_exists( 'Haru_TeeSpace_Posttypes' ) ) {
	class Haru_TeeSpace_Posttypes {
		private static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;

		}

		public function __construct() {

			add_action( 'init', [ $this, 'includes' ], 0 );

			// Force Add posttype support for Elementor
			$cpt_support = array( 'haru_header', 'haru_footer', 'haru_megamenu', 'haru_content' );
			foreach ( $cpt_support as $cpt_slug ) {
				add_post_type_support( $cpt_slug, 'elementor' );
				add_post_type_support( $cpt_slug, 'revisions' );
			}

			// Force Active Flexbox Container
			update_option( 'elementor_experiment-container', 'active' );

			// Force update WC Designer setting
			$wcdp_general = get_option( 'wcdp-settings-general' );

			if ( $wcdp_general ) {
				if ( array_key_exists( 'hide_addtocart', $wcdp_general ) && ( $wcdp_general['hide_addtocart'] == 'on' ) ) {
					$wcdp_general['hide_addtocart'] = '';

					update_option( 'wcdp-settings-general', $wcdp_general );
				}
			}

		}


		public function includes() {
			require_once( HARU_TEESPACE_CORE_DIR . 'includes/posttypes/header.php');
			require_once( HARU_TEESPACE_CORE_DIR . 'includes/posttypes/footer.php');
			require_once( HARU_TEESPACE_CORE_DIR . 'includes/posttypes/megamenu.php');
			require_once( HARU_TEESPACE_CORE_DIR . 'includes/posttypes/content.php');
		}
	}
}

Haru_TeeSpace_Posttypes::instance();
