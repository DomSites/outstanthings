<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

extract($settings);

$attribute_keys = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo esc_attr( $variations_attr ); // WPCS: XSS ok. ?>">

    <?php
        $upload_enable = false;
        $i = 1;

        if ( class_exists( 'DNDMFU_WC_MAIN' ) || class_exists( 'DNDMFU_WC_PRO_MAIN' ) ) {
            if ( ( get_option('wcf_drag_n_drop_disable') !== 'yes' && get_post_meta( $product->get_id(), 'disable_dnd_file_upload_wc', true ) == '' ) || ( get_option('wcf_drag_n_drop_disable') == 'yes' && get_post_meta( $product->get_id(), 'enable_dnd_file_upload_wc', true ) !== '' ) ) {
                $upload_enable = true;
                $i = 2;
            }
        }

        $total_step = count($attributes) + $i;
    ?>

    <div class="step-progress">
        <ul class="step-list" data-total-step="<?php echo esc_attr( $total_step ); ?>">
            <?php if ( $upload_enable == true ) : ?>
                <li class="step-active" data-step="1"><span><?php echo esc_html__( '01', 'haru-teespace' ); ?></span></li>
            <?php endif; ?>
            
            <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                <li class="<?php echo ( $upload_enable == false && $i == 1 ) ? 'step-active' : ''; ?>" data-step="<?php echo esc_attr( $i ); ?>"><span><?php echo esc_html__( '0', 'haru-teespace' ); ?><?php echo esc_html( $i ); ?></span></li>
            <?php $i++; endforeach;?>

            <li data-step="<?php echo esc_attr( $total_step ); ?>"><span><?php echo esc_html__( '0', 'haru-teespace' ); ?><?php echo esc_html( $total_step ); ?></span></li>
        </ul>
    </div>

    <div class="variation-step-control" data-total-step="<?php echo esc_attr( $total_step ); ?>">
        <div class="variation-step-prev disable" data-prev=""><?php echo esc_html__( 'Back', 'haru-teespace' ); ?></div>
        <div class="variation-step-next disable" data-next="2"><?php echo esc_html__( 'Next Step', 'haru-teespace' ); ?></div>
    </div>

    <div class="variation-slide-step" data-step="1">
        <?php if ( $upload_enable == true ) : ?>
        <div class="variation-step"><span><?php echo esc_html__( 'Step 1', 'haru-teespace' ); ?></span></div>
        <?php endif; ?>

        <?php do_action( 'woocommerce_before_variations_form' ); ?>
    </div>

    <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
        <p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'haru-teespace' ) ) ); ?></p>
    <?php else : ?>
        <div class="variations">
            <?php
                $i = 1;

                if ( class_exists( 'DNDMFU_WC_MAIN' ) || class_exists( 'DNDMFU_WC_PRO_MAIN' ) ) {
                    if ( ( get_option('wcf_drag_n_drop_disable') !== 'yes' && get_post_meta( $product->get_id(), 'disable_dnd_file_upload_wc', true ) == '' ) || ( get_option('wcf_drag_n_drop_disable') == 'yes' && get_post_meta( $product->get_id(), 'enable_dnd_file_upload_wc', true ) !== '' ) ) {
                        $upload_enable = true;
                        $i = 2;
                    }
                }
            ?>
            <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                <div class="variation-slide-step slide-attribute" data-step="<?php echo esc_attr( $i ); ?>">
                    <div class="variation-row">
                        <div class="variation-step"><span><?php echo esc_html__( 'Step', 'haru-teespace' ); ?> <?php echo esc_html( $i ); ?></span></div>
                        <label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo esc_html__( 'Choose your ', 'haru-teespace' ) . esc_html(wc_attribute_label( $attribute_name )); // WPCS: XSS ok. ?></label>
                        <div class="value">
                            <?php
                                // Custom to add color and image
                                $attribute = haru_get_wc_attribute_taxonomy( $attribute_name );
                                if ( isset( $attribute->attribute_type ) and $attribute->attribute_type == 'color' ) :

                                    $selected = isset( $_REQUEST[ 'attribute_' . $attribute_name ] ) ? wc_clean( urldecode( wp_unslash( $_REQUEST[ 'attribute_' . $attribute_name ] ) ) ) : $product->get_variation_default_attribute( $attribute_name ); // WPCS: input var ok, CSRF ok, sanitization ok.

                                    haru_wc_color_variation_attribute_options( array(
                                                                                    'options'   => $options,
                                                                                    'attribute' => $attribute_name,
                                                                                    'product'   => $product,
                                                                                    'selected'  => $selected
                                                                                ) );

                                elseif ( isset( $attribute->attribute_type ) and $attribute->attribute_type == 'image' ) :

                                    $selected = isset( $_REQUEST[ 'attribute_' . $attribute_name ] ) ? wc_clean( urldecode( wp_unslash( $_REQUEST[ 'attribute_' . $attribute_name ] ) ) ) : $product->get_variation_default_attribute( $attribute_name ); // WPCS: input var ok, CSRF ok, sanitization ok.

                                    haru_wc_image_variation_attribute_options( array(
                                                                                    'options'   => $options,
                                                                                    'attribute' => $attribute_name,
                                                                                    'product'   => $product,
                                                                                    'selected'  => $selected
                                                                                ) );
                                elseif ( isset( $attribute->attribute_type ) and $attribute->attribute_type == 'label' ) :

                                    $selected = isset( $_REQUEST[ 'attribute_' . $attribute_name ] ) ? wc_clean( urldecode( wp_unslash( $_REQUEST[ 'attribute_' . $attribute_name ] ) ) ) : $product->get_variation_default_attribute( $attribute_name ); // WPCS: input var ok, CSRF ok, sanitization ok.

                                    haru_wc_label_variation_attribute_options( array(
                                                                                    'options'   => $options,
                                                                                    'attribute' => $attribute_name,
                                                                                    'product'   => $product,
                                                                                    'selected'  => $selected
                                                                                ) );

                                else :
                                    $selected = isset( $_REQUEST[ 'attribute_' . $attribute_name ] ) ? wc_clean( urldecode( wp_unslash( $_REQUEST[ 'attribute_' . $attribute_name ] ) ) ) : $product->get_variation_default_attribute( $attribute_name ); // WPCS: input var ok, CSRF ok, sanitization ok.
                                    wc_dropdown_variation_attribute_options( array(
                                                                                 'options'   => $options,
                                                                                 'attribute' => $attribute_name,
                                                                                 'product'   => $product,
                                                                                 'selected'  => $selected,
                                                                                 'class'     => 'haru-variation-select-box'
                                                                             ) );
                                endif;
                                
                            ?>
                        </div>
                    </div>
                </div>

                <?php if ( end( $attribute_keys ) === $attribute_name ): ?>
                    <div class="variation-row">
                        <label class="label">&nbsp;</label>
                        <div class="value">
                            <?php echo wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear selection', 'haru-teespace' ) . '</a>' ) ); ?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php $i++; endforeach;?>
        </div>
        <?php do_action( 'woocommerce_after_variations_table' ); ?>

        <div class="variation-slide-step" data-step="<?php echo esc_attr( $i ); ?>">
            <?php if ( ! $product->is_sold_individually() ) : ?>
                <div class="add-to-cart-notice"><?php echo esc_html__( 'Choose Quantity', 'haru-teespace' ); ?></div>
            <?php else : ?>
                <div class="add-to-cart-notice"><?php echo esc_html__( 'Price Calculator', 'haru-teespace' ); ?></div>
            <?php endif; ?>

            <div class="single_variation_wrap">
                <div class="woocommerce-variation-price-notice"><?php echo esc_html__( 'The price will be visible here if configuration available.', 'haru-teespace' ); ?></div>

                <input type="hidden" name="print_your_own" value="<?php echo esc_attr( $product->get_id() ); ?>">
                <?php
                    /**
                     * Hook: woocommerce_before_single_variation.
                     */
                    do_action( 'woocommerce_before_single_variation' );

                    /**
                     * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
                     *
                     * @since 2.4.0
                     * @hooked woocommerce_single_variation - 10 Empty div for variation data.
                     * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
                     */
                    do_action( 'woocommerce_single_variation' );

                    /**
                     * Hook: woocommerce_after_single_variation.
                     */
                    do_action( 'woocommerce_after_single_variation' );
                ?>
            </div>
        </div>

    <?php endif; ?>

    <?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
