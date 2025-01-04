<?php
/**
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

defined( 'ABSPATH' ) || exit;

/**
 * Core class used to implement the Navigation Menu widget.
 *
 * @since 3.0.0
 *
 * @see WP_Widget
 */
class Haru_Nav_Menu_Widget extends WP_Widget {

    /**
     * Sets up a new Navigation Menu widget instance.
     *
     * @since 3.0.0
     */
    public function __construct() {
        $widget_ops = array(
            'description'                 => __( 'Add a navigation menu to your sidebar.', 'haru-teespace' ),
            'customize_selective_refresh' => true,
            'show_instance_in_rest'       => true,
        );
        parent::__construct( 'nav_menu', __( 'Haru Navigation Menu', 'haru-teespace' ), $widget_ops );
    }

    /**
     * Outputs the content for the current Navigation Menu widget instance.
     *
     * @since 3.0.0
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Navigation Menu widget instance.
     */
    public function widget( $args, $instance ) {
        if ( ! class_exists( 'Haru_Nav_Menu' ) ) {
            require_once HARU_TEESPACE_CORE_DIR . '/includes/classes/class-haru-megamenu-nav.php';
        }
        
        // Get menu.
        $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

        if ( ! $nav_menu ) {
            return;
        }

        $default_title = __( 'Menu' );
        $title         = ! empty( $instance['title'] ) ? $instance['title'] : '';

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        if ( $args ) echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $format = current_theme_supports( 'html5', 'navigation-widgets' ) ? 'html5' : 'xhtml';

        /**
         * Filters the HTML format of widgets with navigation links.
         *
         * @since 5.5.0
         *
         * @param string $format The type of markup to use in widgets with navigation links.
         *                       Accepts 'html5', 'xhtml'.
         */
        $format = apply_filters( 'navigation_widgets_format', $format );

        if ( 'html5' === $format ) {
            // The title may be filtered: Strip out HTML and make sure the aria-label is never empty.
            $title      = trim( strip_tags( $title ) );
            $aria_label = $title ? $title : $default_title;

            $nav_menu_args = array(
                'menu'              => $nav_menu,
                'menu_class'        => 'haru-nav-menu-template',
                'fallback_cb'       => '',
                'container'         => '',
                'walker'            => new Haru_Nav_Menu()
            );
        } else {
            $nav_menu_args = array(
                'fallback_cb' => '',
                'menu'        => $nav_menu,
                'walker'      => new Haru_Nav_Menu()
            );
        }

        /**
         * Filters the arguments for the Navigation Menu widget.
         *
         * @since 4.2.0
         * @since 4.4.0 Added the `$instance` parameter.
         *
         * @param array   $nav_menu_args {
         *     An array of arguments passed to wp_nav_menu() to retrieve a navigation menu.
         *
         *     @type callable|bool $fallback_cb Callback to fire if the menu doesn't exist. Default empty.
         *     @type mixed         $menu        Menu ID, slug, or name.
         * }
         * @param WP_Term $nav_menu      Nav menu object for the current menu.
         * @param array   $args          Display arguments for the current widget.
         * @param array   $instance      Array of settings for the current widget.
         */
        wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) );

        if ( $args ) echo $args['after_widget'];
    }

    /**
     * Handles updating settings for the current Navigation Menu widget instance.
     *
     * @since 3.0.0
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        if ( ! empty( $new_instance['title'] ) ) {
            $instance['title'] = sanitize_text_field( $new_instance['title'] );
        }
        if ( ! empty( $new_instance['nav_menu'] ) ) {
            $instance['nav_menu'] = (int) $new_instance['nav_menu'];
        }
        return $instance;
    }

    /**
     * Outputs the settings form for the Navigation Menu widget.
     *
     * @since 3.0.0
     *
     * @param array $instance Current settings.
     * @global WP_Customize_Manager $wp_customize
     */
    public function form( $instance ) {
        global $wp_customize;
        $title    = isset( $instance['title'] ) ? $instance['title'] : '';
        $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

        // Get menus.
        $menus = wp_get_nav_menus();

        $empty_menus_style     = '';
        $not_empty_menus_style = '';
        if ( empty( $menus ) ) {
            $empty_menus_style = ' style="display:none" ';
        } else {
            $not_empty_menus_style = ' style="display:none" ';
        }

        $nav_menu_style = '';
        if ( ! $nav_menu ) {
            $nav_menu_style = 'display: none;';
        }

        // If no menus exists, direct the user to go and create some.
        ?>
        <p class="nav-menu-widget-no-menus-message" <?php echo $not_empty_menus_style; ?>>
            <?php
            if ( $wp_customize instanceof WP_Customize_Manager ) {
                $url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
            } else {
                $url = admin_url( 'nav-menus.php' );
            }

            /* translators: %s: URL to create a new menu. */
            printf( __( 'No menus have been created yet. <a href="%s">Create some</a>.' ), esc_attr( $url ) );
            ?>
        </p>
        <div class="nav-menu-widget-form-controls" <?php echo $empty_menus_style; ?>>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'haru-teespace' ); ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id( 'nav_menu' ); ?>"><?php _e( 'Select Menu:', 'haru-teespace' ); ?></label>
                <select id="<?php echo $this->get_field_id( 'nav_menu' ); ?>" name="<?php echo $this->get_field_name( 'nav_menu' ); ?>">
                    <option value="0"><?php _e( '&mdash; Select &mdash;', 'haru-teespace' ); ?></option>
                    <?php foreach ( $menus as $menu ) : ?>
                        <option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
                            <?php echo esc_html( $menu->name ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <?php if ( $wp_customize instanceof WP_Customize_Manager ) : ?>
                <p class="edit-selected-nav-menu" style="<?php echo $nav_menu_style; ?>">
                    <button type="button" class="button"><?php _e( 'Edit Menu', 'haru-teespace' ); ?></button>
                </p>
            <?php endif; ?>
        </div>
        <?php
    }
}


if ( ! function_exists( 'haru_register_widget_navigation_menu' ) ) {
    function haru_register_widget_navigation_menu() {
        register_widget( 'Haru_Nav_Menu_Widget' );
    }

    add_action( 'widgets_init', 'haru_register_widget_navigation_menu' );
}