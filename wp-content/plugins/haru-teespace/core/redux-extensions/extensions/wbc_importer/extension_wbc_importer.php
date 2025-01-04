<?php
/**
 * Extension-Boilerplate
 *
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * Radium Importer - Modified For ReduxFramework
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     WBC_Importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0.2
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_extension_wbc_importer' ) ) {

    class ReduxFramework_extension_wbc_importer {

        public static $instance;

        static $version = "1.0.2";

        protected $parent;
        
        protected $field_name;

        private $filesystem = array();

        public $extension_url;

        public $extension_dir;

        public $demo_data_dir;

        public $wbc_import_files = array();

        public $active_import_id;

        public $active_import;


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

            //Hides importer section if anything but true returned. Way to abort :)
            if ( true !== apply_filters( 'wbc_importer_abort', true ) ) {
                return;
            }

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
                $this->demo_data_dir = apply_filters( "wbc_importer_dir_path", $this->extension_dir . 'demo-data/' );
            }

            //Delete saved options of imported demos, for dev/testing purpose
            // delete_option('wbc_imported_demos');

            $this->getImports();

            $this->field_name = 'wbc_importer';

            self::$instance = $this;

            add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array( &$this,
                    'overload_field_path'
                ) );

            add_action( 'wp_ajax_redux_wbc_importer', array(
                    $this,
                    'ajax_importer'
                ) );

            add_filter( 'redux/'.$this->parent->args['opt_name'].'/field/wbc_importer_files', array(
                    $this,
                    'addImportFiles'
                ) );

            //Adds Importer section to panel
            $this->add_importer_section();

            // Uncomment the below
            add_action( 'wbc_importer_after_content_import', array( $this, 'wbc_extended_example'), 10, 2 );

        }

        /**
         * Get the demo folders/files
         * Provided fallback where some host require FTP info
         *
         * @return array list of files for demos
         */
        public function demoFiles() {

            // $this->filesystem = $this->parent->filesystem->execute( 'object' );
            // $dir_array1 = $this->filesystem->dirlist( $this->demo_data_dir, false, true );
            $dir_array = $this->dirToArray($this->demo_data_dir);

            if ( !empty( $dir_array ) && is_array( $dir_array ) ) {
               
                uksort( $dir_array, 'strcasecmp' );
                return $dir_array;

            }else{

                $dir_array = array();

                $demo_directory = array_diff( scandir( $this->demo_data_dir ), array( '..', '.' ) );

                if ( !empty( $demo_directory ) && is_array( $demo_directory ) ) {
                    foreach ( $demo_directory as $key => $value ) {
                        if ( is_dir( $this->demo_data_dir.$value ) ) {

                            $dir_array[$value] = array( 'name' => $value, 'type' => 'd', 'files'=> array() );

                            $demo_content = array_diff( scandir( $this->demo_data_dir.$value ), array( '..', '.' ) );

                            foreach ( $demo_content as $d_key => $d_value ) {
                                if ( is_file( $this->demo_data_dir.$value.'/'.$d_value ) ) {
                                    $dir_array[$value]['files'][$d_value] = array( 'name'=> $d_value, 'type' => 'f' );
                                }
                            }
                        }
                    }

                    uksort( $dir_array, 'strcasecmp' );
                }
            }
            return $dir_array;
        }


        public function getImports() {

            if ( !empty( $this->wbc_import_files ) ) {
                return $this->wbc_import_files;
            }

            $imports = $this->demoFiles();

            $imported = get_option( 'wbc_imported_demos' );

            if ( !empty( $imports ) && is_array( $imports ) ) {
                $x = 1;
                foreach ( $imports as $import ) {

                    if ( !isset( $import['files'] ) || empty( $import['files'] ) ) {
                        continue;
                    }

                    if ( $import['type'] == "d" && !empty( $import['name'] ) ) {
                        $this->wbc_import_files['wbc-import-'.$x] = isset( $this->wbc_import_files['wbc-import-'.$x] ) ? $this->wbc_import_files['wbc-import-'.$x] : array();
                        $this->wbc_import_files['wbc-import-'.$x]['directory'] = $import['name'];

                        if ( !empty( $imported ) && is_array( $imported ) ) {
                            if ( array_key_exists( 'wbc-import-'.$x, $imported ) ) {
                                $this->wbc_import_files['wbc-import-'.$x]['imported'] = 'imported';
                            }
                        }

                        foreach ( $import['files'] as $file ) {
                            switch ( $file['name'] ) {
                            case 'content.xml':
                                $this->wbc_import_files['wbc-import-'.$x]['content_file'] = $file['name'];
                                break;

                            case 'theme-options.txt':
                            case 'theme-options.json':
                                $this->wbc_import_files['wbc-import-'.$x]['theme_options'] = $file['name'];
                                break;

                            case 'widgets.json':
                            case 'widgets.txt':
                                $this->wbc_import_files['wbc-import-'.$x]['widgets'] = $file['name'];
                                break;

                            case 'screen-image.png':
                            case 'screen-image.jpg':
                            case 'screen-image.gif':
                                $this->wbc_import_files['wbc-import-'.$x]['image'] = $file['name'];
                                break;
                            }

                        }

                        if ( !isset( $this->wbc_import_files['wbc-import-'.$x]['content_file'] ) ) {
                            unset( $this->wbc_import_files['wbc-import-'.$x] );
                            if ( $x > 1 ) $x--;
                        }

                    }

                    $x++;
                }

            }

        }

        public function addImportFiles( $wbc_import_files ) {

            if ( !is_array( $wbc_import_files ) || empty( $wbc_import_files ) ) {
                $wbc_import_files = array();
            }

            $wbc_import_files = wp_parse_args( $wbc_import_files, $this->wbc_import_files );

            return $wbc_import_files;
        }

        public function ajax_importer() {
            if ( !isset( $_REQUEST['nonce'] ) || !wp_verify_nonce( $_REQUEST['nonce'], "redux_{$this->parent->args['opt_name']}_wbc_importer" ) ) {
                die( 0 );
            }
            if ( isset( $_REQUEST['type'] ) && $_REQUEST['type'] == "import-demo-content" && array_key_exists( $_REQUEST['demo_import_id'], $this->wbc_import_files ) ) {

                $reimporting = false;

                if ( isset( $_REQUEST['wbc_import'] ) && $_REQUEST['wbc_import'] == 're-importing' ) {
                    $reimporting = true;
                }

                $this->active_import_id = $_REQUEST['demo_import_id'];

                $import_parts         = $this->wbc_import_files[$this->active_import_id];

                $this->active_import = array( $this->active_import_id => $import_parts );

                $content_file        = $import_parts['directory'];
                $demo_data_loc       = $this->demo_data_dir.$content_file;

                if ( file_exists( $demo_data_loc.'/'.$import_parts['content_file'] ) && is_file( $demo_data_loc.'/'.$import_parts['content_file'] ) ) {

                    if ( !isset( $import_parts['imported'] ) || true === $reimporting ) {
                        include $this->extension_dir.'inc/init-installer.php';
                        $installer = new Radium_Theme_Demo_Data_Importer( $this, $this->parent );
                    }else {
                        echo esc_html__( "Demo Already Imported", 'haru-teespace' );
                    }
                }

                die();
            }

            die();
        }

        public static function get_instance() {
            return self::$instance;
        }

        // Forces the use of the embeded field path vs what the core typically would use
        public function overload_field_path( $field ) {
            return dirname( __FILE__ ) . '/' . $this->field_name . '/field_' . $this->field_name . '.php';
        }

        function dirToArray( $dir ) {
           $result = array();
           $cdir = scandir($dir);

           foreach( $cdir as $key => $value ) {
              if ( ! in_array( $value, array( ".", ".." ) ) ) {
                if ( is_dir( $dir . DIRECTORY_SEPARATOR . $value ) ) {
                    $result[$value] = array(
                        'name' => $value,
                        'type' => 'd',
                        'files' => $this->dirToArray( $dir . DIRECTORY_SEPARATOR . $value ),
                    );
                } else {
                    $result[$value] = array(
                        'name' => $value,
                        'type' => 'f',
                    );
                } 
              }
           }
           
           return $result;
        }

        function add_importer_section() {
            // Checks to see if section was set in config of redux.
            for ( $n = 0; $n <= count( $this->parent->sections ); $n++ ) {
                if ( isset( $this->parent->sections[$n]['id'] ) && $this->parent->sections[$n]['id'] == 'wbc_importer_section' ) {
                    return;
                }
            }

            $wbc_importer_label = trim( esc_html( apply_filters( 'wbc_importer_label', __( 'Demo Importer', 'haru-teespace' ) ) ) );

            $wbc_importer_label = ( !empty( $wbc_importer_label ) ) ? $wbc_importer_label : __( 'Demo Importer', 'haru-teespace' );

            $wc_dp_import_url = admin_url( 'admin.php?page=' . 'wcdp-content-docs' );

            $this->parent->sections[] = array(
                'id'     => 'wbc_importer_section',
                'title'  => $wbc_importer_label,
                'desc'   => '<p class="description">'. apply_filters( 'wbc_importer_description', esc_html__( 'Works best to import on a new install of WordPress. Please make sure PHP Settings of your Server as suggestion in our document.', 'haru-teespace' ) ).'</p>',
                'icon'   => 'el-icon-website',
                'fields' => array(
                    array(
                        'id'       => 'haru_svg_support',
                        'type'     => 'switch',
                        'title'    => esc_html__( 'SVG Support', 'haru-teespace' ),
                        'subtitle' => esc_html__( 'Allow your site support SVG files', 'haru-teespace' ),
                        'desc'     => 'This option should turn On before import Demo Data. Please note if you turn off this, your site still can support SVG from other plugins like Elementor,... We suggest you to use <a href="https://wordpress.org/plugins/safe-svg/">this plugin</a> to be sure that all uploaded content is safe. If you will install this plugin, you can disable this option.',
                         'default'  => '1',
                    ),
                    array(
                        'id'    => 'haru_import_error',
                        'type'  => 'info',
                        'style' => 'critical',
                        'title' => esc_html__( 'Demo Importer Tutorial', 'haru-teespace' ),
                        'icon'  => 'el el-info-circle',
                        'desc'  => 'Please follow this topic: <a href="https://harutheme.com/forums/topic/how-to-import-demo-data-automatic-in-harutheme/" target="_blank">https://harutheme.com/forums/topic/how-to-import-demo-data-automatic-in-harutheme/</a>'
                    ),
                    array(
                        'id'    => 'haru_import_customize_product',
                        'type'  => 'info',
                        'style' => 'critical',
                        'title' => esc_html__( 'Import Customize Product (Design Online Product)', 'haru-teespace' ),
                        'icon'  => 'el el-info-circle',
                        'desc'  => 'Please click this link: <a href="' . $wc_dp_import_url . '" target="_blank">' . $wc_dp_import_url . '</a>'
                    ),
                    array(
                        'id'    => 'haru_import_time',
                        'type'  => 'info',
                        'style' => 'critical',
                        'title' => esc_html__( 'Demo Importer Time', 'haru-teespace' ),
                        'icon'  => 'el el-info-circle',
                        'desc'  => esc_html__( 'Demo Importer will take more than 5 minutes, so please patient when import demo data.', 'haru-teespace' ),
                    ),
                    array(
                        'id'   => 'wbc_demo_importer',
                        'type' => 'wbc_importer',
                    )
                )
            );

            // Add maintenance mode section
            $this->parent->sections[] = array(
                'title'      => esc_html__( 'Maintenance Mode', 'haru-teespace' ),
                'desc'       => '',
                'subsection' => false,
                'icon'       => 'el-icon-eye-close',
                'fields'     => array(
                    array(
                        'id'       => 'enable_maintenance',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Maintenance Mode', 'haru-teespace' ),
                        'subtitle' => esc_html__( 'Enable/Disable your site maintenance mode.', 'haru-teespace' ),
                        'desc'     => '',
                        'options'  => array(
                            '1' => 'On',
                            '0' => 'Off',
                        ),
                        'default'  => '0'
                    ),
                    array(
                        'id'          => 'maintenance_title',
                        'type'        => 'text',
                        'placeholder' => esc_html__( 'Maintenance Mode', 'haru-teespace' ),
                        'required'    => array( 'enable_maintenance', '=', '1' ),
                        'title'       => esc_html__( 'Maintenance title', 'haru-teespace' ),
                        'subtitle'    => esc_html__( 'Insert coming soon title.', 'haru-teespace' ),
                        'default'     => esc_html__( 'Maintenance Mode', 'haru-teespace' ),
                    ),
                    array(
                        'id'       => 'maintenance_background',
                        'type'     => 'media',
                        'url'      => true,
                        'required' => array( 'enable_maintenance', '=', '1' ),
                        'title'    => esc_html__( 'Maintenance Background', 'haru-teespace' ),
                        'subtitle' => esc_html__( 'Select maintenance background image.', 'haru-teespace' ),
                        'desc'     => '',
                        'default'  => '',
                        'args'     => array()
                    ),
                    array(
                        'id'          => 'online_time',
                        'type'        => 'datetime',
                        'placeholder' => 'Y/m/d H:i:s',
                        'required'    => array( 'enable_maintenance', '=', '1' ),
                        'title'       => esc_html__( 'Online time', 'haru-teespace' ),
                        'subtitle'    => esc_html__( 'Your page will automatic end maintenance mode after this time.', 'haru-teespace' ),
                    ),

                    array(
                        'id'          => 'timezone',
                        'type'        => 'text',
                        'placeholder' => 'Asia/Ho_Chi_Minh',
                        'required'    => array( 'enable_maintenance', '=', '1' ),
                        'title'       => esc_html__( 'Timezone', 'haru-teespace' ),
                        'subtitle'    => esc_html__( 'You can change timezone from here. More details: http://php.net/manual/en/timezones.php', 'haru-teespace' ),
                        'default'     => 'Asia/Ho_Chi_Minh',
                    ),
                    array(
                        'id'        => 'maintenance_social_profile',
                        'type'      => 'multi_text',
                        'required'  => array( 'enable_maintenance', '=', '1' ),
                        'title'     => esc_html__( 'Maintenance social profiles', 'haru-teespace'),
                        'subtitle'  => esc_html__( 'You can change # to your URL and fa fa-facebook to other social class. Please read more in the document.', 'haru-teespace'),
                        'desc' => esc_html__( 'Please insert code with format: <li><a href="#"><i class="fa fa-heart"></i></a></li>', 'haru-teespace'),
                        'default' => '<li><a href="#"><i class="fa fa-heart"></i></a></li>'
                    ),
                ),
            );

        }

        /************************************************************************
        * Extended Example:
        * Way to set menu, import revolution slider, and set home page.
        *************************************************************************/

        function wbc_extended_example( $demo_active_import , $demo_directory_path ) {

            reset( $demo_active_import );
            $current_key = key( $demo_active_import );

            /************************************************************************
            * Import slider(s) for the current demo being imported
            *************************************************************************/

            if ( class_exists( 'RevSlider' ) ) {

                // If it's demo3 or demo5
                $wbc_sliders_array = array(
                    // 'home1' => 'home-1.zip', // Set slider zip name
                    // 'home2' => 'home-2.zip', // Set slider zip name
                    'home3' => 'home-3.zip', // Set slider zip name
                    // 'home4' => 'home-4.zip', // Set slider zip name
                    // 'home5' => 'home-5.zip', // Set slider zip name
                    // 'home6' => 'home-6.zip', // Set slider zip name
                    'home7' => 'home-7.zip', // Set slider zip name
                    'home11' => 'home-11.zip', // Set slider zip name
                );

                if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
                    $wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];

                    if ( file_exists( $demo_directory_path.$wbc_slider_import ) ) {
                        $slider = new RevSlider();
                        $slider->importSliderFromPost( true, true, $demo_directory_path.$wbc_slider_import );
                    }
                }
            }

            /************************************************************************`
            * Setting Menus
            *************************************************************************/

            // If it's demo1 - demo6
            $wbc_menu_array = array( 'home1', 'home2', 'home3', 'home4', 'home5', 'home6', 'home7', 'home8', 'home9', 'home10', 'home11', 'home12' );

            if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
                $top_menu    = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
                $mobile_menu = get_term_by( 'name', 'Mobile Menu', 'nav_menu' );
                $vertical_menu = get_term_by( 'name', 'Vertical Menu', 'nav_menu' );
                $left_menu = get_term_by( 'name', 'Left Menu', 'nav_menu' );
                $right_menu = get_term_by( 'name', 'Right Menu', 'nav_menu' );
                $product_menu = get_term_by( 'name', 'Product Detail Menu', 'nav_menu' );

                if ( isset( $top_menu->term_id ) && isset( $mobile_menu->term_id ) ) {
                    set_theme_mod( 'nav_menu_locations', array(
                            'primary-menu' => $top_menu->term_id,
                            'mobile' => $mobile_menu->term_id,
                            'vertical' => $vertical_menu->term_id,
                        )
                    );
                }

            }

            /************************************************************************
            * Set HomePage
            *************************************************************************/

            // array of demos/homepages to check/select from
            $wbc_home_pages = array(
                'home1' => 'Home 1',
                'home2' => 'Home 2',
                'home3' => 'Home 3',
                'home4' => 'Home 4',
                'home5' => 'Home 5',
                'home6' => 'Home 6',
                'home7' => 'Home 7',
                'home8' => 'Home 8',
                'home9' => 'Home 9',
                'home10' => 'Home 10',
                'home11' => 'Home 11',
                'home12' => 'Home 12',
            );

            if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
                $page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
                if ( isset( $page->ID ) ) {
                    update_option( 'page_on_front', $page->ID );
                    update_option( 'show_on_front', 'page' );
                }
            }

        }


    } // class
} // if