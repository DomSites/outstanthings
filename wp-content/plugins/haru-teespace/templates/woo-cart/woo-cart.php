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
<?php if ( 'yes' == $settings['cart_side'] ) : ?>
<div class="haru-cart-wrap cart-side <?php echo esc_attr( $settings['show_price'] == 'yes' ) ? 'with-price' : 'no-price'; ?>">
  <div class="haru-cart-opener">
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php echo esc_attr__( 'Shopping cart', 'haru-teespace' ); ?>">
      <div class="haru-cart-icon"><?php haru_cart_count(); ?></div>
      <div class="haru-cart-sub-total"><?php haru_cart_subtotal(); ?></div>
    </a>
  </div>
  <div class="cart-mask-overlay"></div>
  <div class="cart-side-widget">
    <div class="cart-side-header"><?php echo esc_html__( 'Shopping Cart', 'haru-teespace' ); ?>
      <div class="cart-side-close">
        <span class="cart-side-icon"></span>
        <?php echo esc_html__( 'Close', 'haru-teespace' ); ?>
      </div>
    </div>
    <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
  </div>
</div>
<?php else : ?>
  <div class="haru-cart-wrap <?php echo esc_attr( $settings['show_price'] == 'yes' ) ? 'with-price' : 'no-price'; ?>">
    <div class="haru-cart-opener">
      <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php echo esc_attr__( 'Shopping cart', 'haru-teespace' ); ?>">
        <div class="haru-cart-icon"><?php haru_cart_count(); ?></div>
        <div class="haru-cart-sub-total"><?php haru_cart_subtotal(); ?></div>
      </a>
    </div>
    <div class="haru-cart-content">
      <div class="widget_shopping_cart_content">
        <?php get_template_part( 'woocommerce/cart/mini-cart' ); ?>
      </div>
    </div>
    <?php if ( $settings['pre_style'] == 'style-3' ) : ?>
      <div class="bottom-bar-title"><?php echo esc_html( $settings['cart_title'] ); ?></div>
      <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="bottom-bar-link"></a>
    <?php endif; ?>
  </div>
<?php endif; ?>
