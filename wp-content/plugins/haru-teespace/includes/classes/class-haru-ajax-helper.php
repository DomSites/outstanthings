<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

namespace Haru_TeeSpace\Classes;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'Haru_Ajax_Helper' ) ) {
    class Haru_Ajax_Helper {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;

        }

        public function __construct(){

        }

        public function haru_paging_nav_cpt() {
            the_posts_pagination(
                array(
                    'mid_size'  => 1,
                    'prev_text' => esc_html__( 'Prev', 'haru-teespace' ),
                    'next_text' => esc_html__( 'Next', 'haru-teespace' )
                )
            );
        }

        public function haru_paging_load_more_cpt() {
            global $wp_query;

            if ( $wp_query->max_num_pages < 2 ) {
                return;
            }

            $link = get_next_posts_page_link( $wp_query->max_num_pages );

            if ( ! empty( $link ) ) :
            ?>
                <a data-href="<?php echo esc_url( $link ); ?>" type="button" class="cpt-load-more haru-button haru-button--bg-black haru-button--size-large haru-button--round-large"></i>
                    <?php echo esc_html__( 'Load More', 'haru-teespace' ); ?>
                </a>
            <?php
            endif;
        }

        public function haru_paging_infinitescroll_cpt() {
            global $wp_query;

            if ( $wp_query->max_num_pages < 2 ) {
                return;
            }

            $link = get_next_posts_page_link( $wp_query->max_num_pages );
            if ( ! empty( $link ) ) :
            ?>
                <nav id="infinite_scroll_button" data-max-page="<?php echo esc_attr( $wp_query->max_num_pages ); ?>" data-msgText="<?php echo esc_attr__( 'Loading...', 'haru-teespace' ); ?>" data-finishedMsg="<?php echo esc_attr__( 'All items loaded.', 'haru-teespace' ); ?>">
                    <a href="<?php echo esc_url( $link ); ?>"></a>
                </nav>
                <div id="infinite_scroll_loading" class="align-center infinite-scroll-loading"></div>
            <?php
            endif;
        }
    }
}

Haru_Ajax_Helper::instance();
