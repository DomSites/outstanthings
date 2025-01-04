<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// namespace Haru_TeeSpace\Classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Haru_Helper' ) ) {
	class Haru_Helper {
		private static $_instance = null;

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

			// Render Header & Footer
			add_filter( 'haru_render_post_builder', [ $this, 'render_post_builder'] , 10, 2 );

		}

		public function render_page_content( $post_id ) {
	        if ( class_exists( 'Elementor\Core\Files\CSS\Post' ) ) {
	            $css_file = new Elementor\Core\Files\CSS\Post( $post_id );
	            $css_file->enqueue();
	        }

	        return Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post_id );
	    }

	    public function render_post_builder( $html, $post ) {
	        if ( ! empty( $post ) && ! empty( $post->ID ) ) {
	            return $this->render_page_content( $post->ID );
	        }

	        return $html;
	    }
	}
	
}

if ( did_action( 'elementor/loaded' ) ) {
	Haru_Helper::instance();
}
