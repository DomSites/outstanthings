<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( $cross_sells ) : 

$cross_sells_product_display_columns = '5';

// Use for check arrow
$page_layout = get_post_meta( get_the_ID(), 'haru_layout', true );
if ( ( $page_layout == '' ) || ( $page_layout == 'default' ) ) {
    $page_layout = haru_get_option( 'haru_page_layout', 'haru-container' );
}
?>

	<div class="cross-sells">
		<?php
		$heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', __( 'You may be interested in&hellip;', 'teespace' ) );

		if ( $heading ) :
			?>
			<h2 class="haru-heading haru-heading--style-1"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

        <ul class="haru-slick haru-slick--nav-center haru-slick--nav-round-shadow haru-slick--dots-round"
            data-slick='{"slidesToShow" : <?php echo esc_attr( $cross_sells_product_display_columns ); ?>, "slidesToScroll" : 1, "arrows" : true, "dots": false, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": false, "autoplaySpeed": 3000, "responsive" : [{"breakpoint" : <?php echo ( 'haru-container' == $page_layout ) ? '1310' : '1575'; ?>,"settings" : {"dots": true, "arrows": false}}, {"breakpoint" : 991,"settings" : {"slidesToShow" : 3, "slidesToScroll" : 1, "dots": true, "arrows": false}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : 2, "slidesToScroll" : 1, "dots": true, "arrows": false}}] }'
        >

        <?php haru_set_loop_prop( 'product_style', 'style-1' ); ?>
			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
					$post_object = get_post( $cross_sell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part( 'content', 'product' );
				?>

			<?php endforeach; ?>
		<?php haru_reset_loop(); ?>

		</ul>

	</div>
	<?php
endif;

wp_reset_postdata();
