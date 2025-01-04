<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

?>
<div class="my-wishlist">
    <?php if ( class_exists( 'YITH_WCWL' ) ) : ?>
    <div class="my-wishlist-wrap"><?php echo haru_woocommerce_wishlist(); ?></div>
    <?php if ( $settings['pre_style'] == 'style-2' ) : ?>
        <div class="bottom-bar-title"><?php echo esc_html( $settings['wishlist_title'] ); ?></div>
        <?php
            $wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
            if ( function_exists( 'icl_object_id' ) ){
                $wishlist_page_id = icl_object_id( $wishlist_page_id, 'page', true );
            }
        ?>
        <a href="<?php echo esc_url( get_permalink( $wishlist_page_id ) ); ?>" class="bottom-bar-link"></a>
      <?php endif; ?>
    <?php endif; ?>
</div>
