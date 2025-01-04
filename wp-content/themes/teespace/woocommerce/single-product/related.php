<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( $related_products ) : 

$related_product_display_columns = haru_get_option( 'haru_related_product_display_columns', '4' );
$related_product_display_type = haru_get_option( 'haru_related_product_display_type', 'slideshow' );
?>
    <section class="related products">

        <?php
        $heading = apply_filters( 'woocommerce_product_related_products_heading', esc_html__( 'Related Products', 'teespace' ) );

        if ( $heading ) : ?>
            <h2 class="haru-heading haru-heading--style-1"><?php echo esc_html( $heading ); ?></h2>
        <?php endif; ?>

        <?php
            if ( $related_product_display_type == 'slideshow' ) :
            // Use for check arrow
            $single_layout = get_post_meta( get_the_ID(), 'haru_layout', true );
            if ( ( $single_layout == '' ) || ( $single_layout == 'default' ) ) {
                $single_layout = haru_get_option( 'haru_single_product_layout', 'haru-container' );
            }
        ?>

        <ul class="haru-slick haru-slick--nav-center haru-slick--nav-round-shadow haru-slick--dots-round"
            data-slick='{"slidesToShow" : <?php echo esc_attr( $related_product_display_columns ); ?>, "slidesToScroll" : 1, "arrows" : true, "dots": false, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": false, "autoplaySpeed": 3000, "responsive" : [{"breakpoint" : <?php echo ( 'haru-container' == $single_layout ) ? '1310' : '1575'; ?>,"settings" : {"dots": true, "arrows": false}}, {"breakpoint" : 991,"settings" : {"slidesToShow" : 3, "slidesToScroll" : 1, "dots": true, "arrows": false}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : 2, "slidesToScroll" : 1, "dots": true, "arrows": false}}] }'
        >

        <?php haru_set_loop_prop( 'product_style', 'style-1' ); ?>
            <?php foreach ( $related_products as $related_product ) : ?>

                <?php
                    $post_object = get_post( $related_product->get_id() );

                    setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                    wc_get_template_part( 'content', 'product' );
                ?>

            <?php endforeach; ?>
        <?php haru_reset_loop(); ?>
        
        </ul>

        <?php elseif ( $related_product_display_type == 'grid' ) : ?>
        <div class="related-grid layout-grid grid-columns-<?php echo esc_attr( $related_product_display_columns ); ?> grid-columns--tablet3 grid-columns--mobile2">

            <?php haru_set_loop_prop( 'product_style', 'style-1' ); ?>
                <?php foreach ( $related_products as $related_product ) : ?>

                    <?php
                        $post_object = get_post( $related_product->get_id() );

                        setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                        wc_get_template_part( 'content', 'product' );
                    ?>

                <?php endforeach; ?>
            <?php haru_reset_loop(); ?>
            
        </div>
        <?php endif; ?>

    </section>

<?php endif;

wp_reset_postdata();
