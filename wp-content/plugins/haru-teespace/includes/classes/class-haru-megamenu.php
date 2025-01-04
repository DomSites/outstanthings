<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! class_exists( 'Haru_MegaMenu_Config' ) ) {
    class Haru_MegaMenu_Config extends Walker_Nav_Menu_Edit  {
        
        public function start_lvl( &$output, $depth = 0, $args = array() ) {}
        
        public function end_lvl( &$output, $depth = 0, $args = array() ) {}

        public function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {

            $item_output = '';

            parent::start_el( $item_output, $item, $depth, $args, $current_object_id );

            $output .= preg_replace(
                // NOTE: Check this regex from time to time!
                '/(?=<(fieldset|p)[^>]+class="[^"]*field-move)/',
                $this->get_fields( $item, $depth, $args ),
                $item_output
            );

        }

        protected function get_fields( $item, $depth, $args = array(), $id = 0 ) {
            ob_start();

            /**
             * Get menu item custom fields from plugins/themes
             *
             * @since 0.1.0
             * @since 1.0.0 Pass correct parameters.
             *
             * @param int    $item_id  Menu item ID.
             * @param object $item     Menu item data object.
             * @param int    $depth    Depth of menu item. Used for padding.
             * @param array  $args     Menu item args.
             * @param int    $id       Nav menu ID.
             *
             * @return string Custom fields HTML.
             */

            if ( $depth == 0 ) {
                do_action( 'haru_megamenu_item_config_toplevel', $item->ID, $item, $depth, $args, $id );
            }

            do_action( 'haru_megamenu_item_config', $item->ID, $item, $depth, $args, $id );

            return ob_get_clean();
        }
    }
}