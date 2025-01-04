<?php

if ( !class_exists( 'Haru_Nav_Menu' ) ) {
    class Haru_Nav_Menu extends Walker_Nav_Menu {
        
       /**
         * __construct function.
         * 
         * @access public
         * @return void
         */
        public function __construct() {
            add_filter( 'nav_menu_css_class' , array( $this, 'add_nav_class' ), 10 , 2 );
        }
        
        /**
         * special_nav_class function.
         * 
         * @access public
         * @param mixed $classes
         * @param mixed $item
         * @return void
         */
        public function add_nav_class( $classes, $item ) {
            if ( in_array( 'current-menu-item', $classes ) ) {
                $classes[] = 'active ';
            }

            return $classes;
        }

        /**
         * start_el function.
         * 
         * @access public
         * @param mixed &$output
         * @param mixed $item
         * @param int $depth (default: 0)
         * @param array $args (default: array())
         * @param int $id (default: 0)
         * @return void
         */
        // public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

            $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            // @Add MegaMenu
            $haru_mega_profile = $this->getSubMegaMenuProfile( $item, $depth );
            if ( $haru_mega_profile ) {
                $classes[] = 'menu-item-has-children';
                $classes[] = 'menu-item-mega-menu';
            }

            if ( $item->haru_full_width ) {
                $classes[] = 'menu-item-full-' . $item->haru_full_width;
            }

            if ( $item->haru_alignment ) {
                $classes[] = 'aligned-' . $item->haru_alignment;
            }

            /**
             * Filters the arguments for a single nav menu item.
             *
             * @since 4.4.0
             *
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param WP_Post  $item  Menu item data object.
             * @param int      $depth Depth of menu item. Used for padding.
             */
            $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

            /**
             * Filters the CSS classes applied to a menu item's list item element.
             *
             * @since 3.0.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
             * @param WP_Post  $item    The current menu item.
             * @param stdClass $args    An object of wp_nav_menu() arguments.
             * @param int      $depth   Depth of menu item. Used for padding.
             */
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            /**
             * Filters the ID applied to a menu item's list item element.
             *
             * @since 3.0.1
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
             * @param WP_Post  $item    The current menu item.
             * @param stdClass $args    An object of wp_nav_menu() arguments.
             * @param int      $depth   Depth of menu item. Used for padding.
             */
            $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li' . $id . $class_names . '>';

            $atts           = array();
            $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = ! empty( $item->target ) ? $item->target : '';
            if ( '_blank' === $item->target && empty( $item->xfn ) ) {
                $atts['rel'] = 'noopener noreferrer';
            } else {
                $atts['rel'] = $item->xfn;
            }
            $atts['href']         = ! empty( $item->url ) ? $item->url : '';
            $atts['aria-current'] = $item->current ? 'page' : '';

            /**
             * Filters the HTML attributes applied to a menu item's anchor element.
             *
             * @since 3.6.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param array $atts {
             *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
             *
             *     @type string $title        Title attribute.
             *     @type string $target       Target attribute.
             *     @type string $rel          The rel attribute.
             *     @type string $href         The href attribute.
             *     @type string $aria_current The aria-current attribute.
             * }
             * @param WP_Post  $item  The current menu item.
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param int      $depth Depth of menu item. Used for padding.
             */

            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                    $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            /** This filter is documented in wp-includes/post-template.php */
            $title = apply_filters( 'the_title', $item->title, $item->ID );

            /**
             * Filters a menu item's title.
             *
             * @since 4.4.0
             *
             * @param string   $title The menu item's title.
             * @param WP_Post  $item  The current menu item.
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param int      $depth Depth of menu item. Used for padding.
             */

            $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . $this->display_icon( $item ) . $title . $args->link_after;
            
            if ( $args->walker->has_children || $haru_mega_profile ) {
                $item_output .= '<span class="sub-arrow" data-id="' . esc_attr( $item->ID ) . '"><i></i></span>';
            }

            if ( $item->haru_text_label ) {
                $item_output .= '<span class="menu-label" style="background-color: ' . $item->haru_text_label_color . ';">' . $item->haru_text_label . '</span>';
            }

            $item_output .= '</a>';
            $item_output .= $args->after;
            // @Add MegaMenu
            if ( $haru_mega_profile ) {
                $item_output .= $this->generateSubMegaMenu( $item , $haru_mega_profile );
            }

            // Add this directly after the description paragraph in the start_el() method
            do_action( 'wp_nav_menu_item_custom_fields', $item->ID, $item, $depth, $args, $id );
            // end added section
            
            /**
             * Filters a menu item's starting output.
             *
             * The menu item's starting output only includes `$args->before`, the opening `<a>`,
             * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
             * no filter for modifying the opening and closing `<li>` for a menu item.
             *
             * @since 3.0.0
             *
             * @param string   $item_output The menu item's starting HTML output.
             * @param WP_Post  $item        Menu item data object.
             * @param int      $depth       Depth of menu item. Used for padding.
             * @param stdClass $args        An object of wp_nav_menu() arguments.
             */
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

        /**
         * Traverse elements to create list from elements.
         *
         * Display one element if the element doesn't have any children otherwise,
         * display the element and its children. Will only traverse up to the max
         * depth and no ignore elements under that depth. It is possible to set the
         * max depth to include all depths, see walk() method.
         *
         * This method should not be called directly, use the walk() method instead.
         *
         * @since 2.5.0
         *
         * @param object $element           Data object.
         * @param array  $children_elements List of elements to continue traversing (passed by reference).
         * @param int    $max_depth         Max depth to traverse.
         * @param int    $depth             Depth of current element.
         * @param array  $args              An array of arguments.
         * @param string $output            Used to append additional content (passed by reference).
         */

        public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
            if ( ! $element ) {
                return;
            }

            $id_field = $this->db_fields['id'];
            $id       = $element->$id_field;

            // @Add hide sub menu if use mega menu
            if ( $this->getSubMegaMenuProfile( $element, $depth ) ) {
                $children_elements[ $id ] = array();
            }

            // Display this element.
            $this->has_children = ! empty( $children_elements[ $id ] );
            if ( isset( $args[0] ) && is_array( $args[0] ) ) {
                $args[0]['has_children'] = $this->has_children; // Back-compat.
            }

            $this->start_el( $output, $element, $depth, ...array_values( $args ) );

            // Descend only when the depth is right and there are childrens for this element.
            if ( ( 0 == $max_depth || $max_depth > $depth + 1 ) && isset( $children_elements[ $id ] ) ) {

                foreach ( $children_elements[ $id ] as $child ) {

                    if ( ! isset( $newlevel ) ) {
                        $newlevel = true;
                        // Start the child delimiter.
                        $this->start_lvl( $output, $depth, ...array_values( $args ) );
                    }
                    $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
                }
                unset( $children_elements[ $id ] );
            }

            if ( isset( $newlevel ) && $newlevel ) {
                // End the child delimiter.
                $this->end_lvl( $output, $depth, ...array_values( $args ) );
            }

            // End this element.
            $this->end_el( $output, $element, $depth, ...array_values( $args ) );
        }

        /**
         *
         */
        public function getSubMegaMenuProfile( $item, $depth ) {
            return isset( $item->haru_mega_profile ) && $item->haru_mega_profile ? $item->haru_mega_profile : false;
        }

        /**
         *
         */
        public function generateSubMegaMenu( $item, $haru_mega_profile ) {
            if ( $haru_mega_profile ) {
                $args = array(
                    'name'        => $haru_mega_profile,
                    'post_type'   => 'haru_megamenu',
                    'post_status' => 'publish',
                    'numberposts' => 1
                );

                $posts = get_posts($args);

                if ( $posts && isset($posts[0]) ) {
                    $post = $posts[0];
                    $content = apply_filters( 'haru_render_post_builder', do_shortcode( $post->post_content ), $post);
                    $width  = $item->haru_width ? 'style="width: ' . $item->haru_width . 'px;"' : '';

                    return '<ul class="sub-menu ' . esc_attr( $post->post_name ) . '" ' . $width . '><li class="mega-menu-content">' . $content . '</li></ul>';
                }
            }

            return '';
        }

        public function display_icon( $item ) {
            if ( $item->haru_icon_image ) {
                return '<span class="menu-icon"><img src="' . esc_url( $item->haru_icon_image ) . '" alt="' . esc_attr( $item->title ) . '"/></span>';
            } elseif ( $item->haru_icon_font ) {
                return '<span class="menu-icon"><i class="' . esc_attr( $item->haru_icon_font ) . '"></i></span>';
            }
        }
    }
}