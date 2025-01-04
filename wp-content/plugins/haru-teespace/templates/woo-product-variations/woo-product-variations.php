<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

use \Haru_TeeSpace\Classes\Helper as ControlsHelper;


global $post, $product;

$product_id = $settings['product_id'];
$post       = get_post( $product_id );
$product    = wc_get_product( $product_id );

if ( $product_id <= 0 ) {
    return; // die( 'Invalid Products' );
}

if ( ! isset( $post->post_type ) || strcmp( $post->post_type, 'product' ) != 0 ) {
    return; // die( 'Invalid Products' );
}

$button_class = array();

if ( $settings['button_style'] == 'style-1' ) {
    $button_class = [
        'haru-button',
        'haru-button--bg-primary',
        'haru-button--size-medium',
        'haru-button--round-normal',
        'haru-button--shadow-' . $settings['button_shadow'],
    ];
} else if ( $settings['button_style'] == 'style-2' ) {
    $button_class = [
        'haru-button',
        'haru-button--bg-black',
        'haru-button--size-medium',
        'haru-button--round-normal',
        'haru-button--shadow-' . $settings['button_shadow'],
    ];
} else if ( $settings['button_style'] == 'style-3' ) {
    $button_class = [
        'haru-button',
        'haru-button--outline-gray',
        'haru-button--size-medium',
        'haru-button--round-normal',
    ];
} else if ( $settings['button_style'] == 'style-4' ) {
    $button_class = [
        'haru-button',
        'haru-button--text-black',
        'haru-button--size-medium',
    ];
}

?>
<?php if ( $settings['layout'] == 'popup' ) : ?>
    <a href="#product-variations-popup-<?php the_ID(); ?>" class="open-popup-link product-variations-btn <?php echo esc_attr( join( ' ', $button_class ) ); ?>" data-popup-id="product-variations-popup-<?php the_ID(); ?>" data-effect="mfp-zoom-in2"><?php echo esc_html( $settings['button_text'] ); ?></a>
    <div id="product-variations-popup-<?php the_ID(); ?>" class="product-variations-popup white-popup mfp-hide">
<?php endif; ?>

    <div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
    <?php
        do_action( 'woocommerce_' . $product->get_type() . '_add_to_cart' );
    ?>
    </div>

<?php if ( $settings['layout'] == 'popup' ) : ?>
    </div>
<?php endif; ?>

<?php
wp_reset_postdata();
