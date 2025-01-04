<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( !class_exists( 'Haru_MegaMenu_Post_Type' ) ) {
    class Haru_MegaMenu_Post_Type {
        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;

        }

        public function __construct(){

            add_action( 'init', array( $this, 'haru_megamenu' ) );

            add_filter( 'wp_edit_nav_menu_walker', array( $this, 'nav_edit_walker'), 100 );

            add_filter( 'haru_megamenu_item_config_toplevel', array( $this, 'megamenu_item_config_toplevel' ), 10, 5 );
            add_action( 'haru_megamenu_item_config' , array( $this, 'add_extra_fields_menu_config' ), 10, 5 );

            add_action( 'wp_update_nav_menu_item', array( $this, 'custom_nav_update' ), 10, 3 );

            add_action( 'admin_enqueue_scripts', array( $this, 'script' ) );

            add_filter( 'single_template', array( $this, 'haru_single_template' ) ); // Single template

        }
        
        public function haru_megamenu() {
            $labels = array(
                'menu_name'          => esc_html__( 'MegaMenu Builders', 'haru-teespace' ),
                'singular_name'      => esc_html__( 'MegaMenu', 'haru-teespace' ),
                'name'               => esc_html__( 'All MegaMenu', 'haru-teespace' ),
                'add_new'            => esc_html__( 'Add New', 'haru-teespace' ),
                'add_new_item'       => esc_html__( 'Add New MegaMenu', 'haru-teespace' ),
                'edit_item'          => esc_html__( 'Edit MegaMenu', 'haru-teespace' ),
                'new_item'           => esc_html__( 'Add New MegaMenu', 'haru-teespace' ),
                'view_item'          => esc_html__( 'View MegaMenu', 'haru-teespace' ),
                'search_items'       => esc_html__( 'Search MegaMenu', 'haru-teespace' ),
                'not_found'          => esc_html__( 'No MegaMenu items found', 'haru-teespace' ),
                'not_found_in_trash' => esc_html__( 'No MegaMenu items found in trash', 'haru-teespace' ),
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display MegaMenu of site', 'haru-teespace' ),
                'supports'              => array( 'title', 'editor', 'revisions', 'teespace'),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-menu',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => false,
                'can_export'            => true,
                'has_archive'           => false,
                'exclude_from_search'   => true,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
            );

            register_post_type( 'haru_megamenu', $args );
        }

        public static function nav_edit_walker() {
            $walker = 'Haru_MegaMenu_Config';

            if ( ! class_exists( $walker ) ) {
                require_once HARU_TEESPACE_CORE_DIR . '/includes/classes/class-haru-megamenu.php';
            }

            return $walker;
        }

        public static function megamenu_item_config_toplevel( $item_id, $item, $depth, $args, $id ) {
            $posts_array        = self::get_sub_megamenus();
            $icon_font          = get_post_meta( $item_id, 'haru_icon_font', true );
            $icon_image         = get_post_meta( $item_id, 'haru_icon_image', true );
            $mega_profile       = get_post_meta( $item_id, 'haru_mega_profile', true );
            $haru_width         = get_post_meta( $item_id, 'haru_width', true );
            $haru_full_width    = get_post_meta( $item_id, 'haru_full_width', true );
            $alignment          = get_post_meta( $item_id, 'haru_alignment', true );
        ?>
            <p class="field-icon-font description description-wide">   
                <label for="edit-menu-item-icon-font-<?php echo esc_attr( $item_id ); ?>"><?php echo esc_html__( 'Icon Font', 'haru-teespace' ); ?> <br>
                    <input type="text" name="menu-item-haru_icon_font[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $icon_font ); ?>">
                </label>
                <br>
                <span><?php _e( 'Please click <a href="https://harutheme.com/forums/topic/list-of-font-icons-use-in-each-theme-from-harutheme/" target="_blank"> <b>here</b></a> to see the list of icons.', 'haru-teespace' ); ?></span>
            </p>
            <p class="field-icon-image description description-wide">   
                <label for="edit-menu-item-icon-image-<?php echo esc_attr( $item_id ); ?>"><?php echo esc_html__( 'Icon Image', 'haru-teespace' ); ?></label>
                <div class="screenshot">
                    <?php if ( $icon_image ) : ?>
                        <img src="<?php echo esc_url( $icon_image ); ?>" alt="<?php echo esc_attr( $item->title ); ?>"/>
                    <?php endif; ?>
                </div>
                <input type="hidden" class="upload_image" name="menu-item-haru_icon_image[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $icon_image ); ?>">
                <div class="upload_image_action">
                    <input type="button" class="button add-image" value="Add">
                    <input type="button" class="button remove-image" value="Remove">
                </div>
                <span><?php echo esc_html__( 'If have both Icon Font & Icon Image, Icon Image will be used.', 'haru-teespace' ); ?></span>
            </p>

            <p class="field-addclass description description-wide">
                <label for="edit-menu-item-haru_mega_profile-<?php echo esc_attr( $item_id ); ?>"> 
                  <?php echo esc_html__( 'Megamenu Builder' ); ?> <br>
                    <select name="menu-item-haru_mega_profile[<?php echo esc_attr( $item_id ); ?>]">
                        <option value=""><?php echo esc_html__( 'Disable', 'haru-teespace' ); ?></option>
                        <?php foreach( $posts_array as $_post ) :  ?>
                          <option value="<?php echo esc_attr( $_post->post_name ); ?>" <?php selected( esc_attr( $mega_profile ), $_post->post_name ); ?> ><?php echo esc_html( $_post->post_title ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <a href="<?php echo  esc_url( admin_url( 'edit.php?post_type=haru_megamenu') ); ?>" target="_blank" title="<?php _e( 'Sub Megamenu Management', 'haru-teespace' ); ?>"><?php _e( 'Sub Megamenu Management', 'haru-teespace' ); ?></a><br>
                <span><?php _e( 'If enabled megamenu, its submenu will be disabled.', 'haru-teespace' ); ?></span>
            </p>

            <p class="field-haru_width description description-thin">   
                <label for="edit-menu-item-haru_width-<?php echo esc_attr($item_id); ?>"><?php _e( 'Width (Number of Pixels)', 'haru-teespace' ); ?><br>
                    <input type="text" name="menu-item-haru_width[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $haru_width ); ?>">
                </label>
            </p>

            <?php 
                $full_width = array(
                    'none'          => __( 'None', 'haru-teespace' ),
                    'container'     => __( 'Container', 'haru-teespace' ),
                    'stretch'       => __( 'Stretch', 'haru-teespace' ),
                ); 
            ?> 
            <p class="field-haru_full_width description description-thin">   
                <label for="edit-menu-item-haru_full_width-<?php echo esc_attr( $item_id ); ?>"><?php _e( 'Fullwidth', 'haru-teespace' ); ?><br>
                    <select name="menu-item-haru_full_width[<?php echo esc_attr( $item_id ); ?>]">
                        <?php foreach( $full_width as $key => $width ) : ?>
                        <option <?php selected( esc_attr( $haru_full_width ), $key ); ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $width ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </p>

            <p class="field-addclass description description-wide">
                <span><?php _e( 'If have both width & Fullwidth, Fullwidth will be used. Please set Fullwidth is None for Vertical Menu.', 'haru-teespace' ); ?></span>
            </p>

        <?php 
        }

        public static function add_extra_fields_menu_config( $item_id, $item, $depth, $args, $id ) {
            $text_label = get_post_meta( $item_id, 'haru_text_label', true );
            $text_label_color = get_post_meta( $item_id, 'haru_text_label_color', true );
        ?>
            <p class="field-addclass description description-thin">
                <label for="edit-menu-item-haru_text_label-<?php echo esc_attr( $item_id ); ?>"><?php _e( 'Label', 'haru-teespace' ); ?><br />
                    <input type="text" name="menu-item-haru_text_label[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $text_label ); ?>">
                </label>
            </p>

            <p class="field-addclass description description-thin">
                <label for="edit-menu-item-haru_text_label_color-<?php echo esc_attr($item_id); ?>"><?php _e( 'Label Color', 'haru-teespace' ); ?><br /></label>
                <input type="text" class="label-color label-color-<?php echo esc_attr( $item_id ); ?>" name="menu-item-haru_text_label_color[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $text_label_color ); ?>" data-id="<?php echo esc_attr( $item_id ); ?>">
            </p>
        <?php
        }

        public static function custom_nav_update( $menu_id, $menu_item_db_id, $args ) {
            $fields = array( 'haru_mega_profile', 'haru_text_label', 'haru_text_label_color', 'haru_alignment', 'haru_width', 'haru_full_width', 'haru_icon_font', 'haru_icon_image' );
            foreach ( $fields as $field ) {
                if ( isset( $_POST['menu-item-' . $field][$menu_item_db_id] ) ) {
                    $custom_value = $_POST['menu-item-' . $field][$menu_item_db_id];
                    update_post_meta( $menu_item_db_id, $field, $custom_value );
                }
            }
        }

        public static function get_sub_megamenus() {
            $args = array(
                'posts_per_page'   => -1,
                'offset'           => 0,
                'category'         => '',
                'category_name'    => '',
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'include'          => '',
                'exclude'          => '',
                'meta_key'         => '',
                'meta_value'       => '',
                'post_type'        => 'haru_megamenu',
                'post_mime_type'   => '',
                'post_parent'      => '',
                'suppress_filters' => true 
            );

            return get_posts( $args );  
        }

        public static function script() {
            wp_enqueue_media();
            wp_enqueue_script( 'haru-upload-image', HARU_TEESPACE_CORE_URL . 'assets/js/upload.js', array( 'jquery', 'wp-pointer' ), Haru_TeeSpace::VERSION, true );
        }

        public function haru_single_template($single) {
            global $post;

            /* Checks for single template by post type */
            if ( $post->post_type == 'haru_megamenu' ) {
                $template_path = HARU_TEESPACE_CORE_DIR . 'templates/single-builder/single-builder.php';

                return $template_path;
            }

            return $single;
        }
    }
}

Haru_MegaMenu_Post_Type::instance();
