<?php
/**
 * Extension-Boilerplate
 *
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * Custom Fonts - Modified For ReduxFramework
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     Custom Fonts - Extension for use Custom Fonts
 * @author      HaruTheme
 * @version     1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_Extension_customize_fonts' ) ) {

    class ReduxFramework_Extension_customize_fonts {

        public static $instance;

        static $version = "1.0.0";

        protected $parent;
        
        protected $field_name;

        public $extension_url;

        public $extension_dir;


        /**
         * Class Constructor
         *
         * @since       1.0
         * @access      public
         * @return      void
         */
        public function __construct( $parent ) {

            $this->parent = $parent;

            if ( !is_admin() ) return;

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }

            $this->field_name = 'customize_fonts';

            self::$instance = $this;

            add_filter( 'redux/haru_teespace_options/field/typography/custom_fonts', array( $this, 'add_custom_fonts' ), 10, 2 );

        }

        /**
         * Get the demo folders/files
         * Provided fallback where some host require FTP info
         *
         * @return array list of files for demos
         */
        public function add_custom_fonts( $array ) {
            $font_arr = [];

            if ( class_exists( 'Bsf_Custom_Fonts_Render' ) ) {
                // $fonts = Bsf_Custom_Fonts_Taxonomy::get_fonts(); // Deprecated from 2.0.1
                $fonts = Bsf_Custom_Fonts_Render::get_instance()->get_existing_font_posts();

                foreach( $fonts as $key => $font ) {
                    $font_obj = get_post( $font );
                    // $font_arr[$key] = $key; // Deprecated from 2.0.1
                    $font_arr[$font_obj->post_title] = $font_obj->post_title;
                }
            }

            $array = array(
                'custom_fonts' => $font_arr
            );

            return $array;
        }

        public static function get_instance() {
            return self::$instance;
        }

        // Forces the use of the embeded field path vs what the core typically would use
        public function overload_field_path( $field ) {
            return dirname( __FILE__ ) . '/' . $this->field_name . '/field_' . $this->field_name . '.php';
        }

    } // class
} // if
