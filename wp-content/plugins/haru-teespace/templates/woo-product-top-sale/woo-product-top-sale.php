<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

global $woocommerce;

// Get products
$product_ids_on_sale = wc_get_product_ids_on_sale();

$ordering_args = WC()->query->get_catalog_ordering_args($settings['orderby'], $settings['order']);
$meta_query    = WC()->query->get_meta_query();

$args = array(
    'post_type'           => 'product',
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
    'orderby'             => $ordering_args['orderby'], // meta_value_num
    'order'               => $ordering_args['order'],
    'posts_per_page'      => $settings['posts_per_page'],
    'meta_query'          => $meta_query,
    'post__in'            => array_merge( array( 0 ), $product_ids_on_sale )
);
$products = new WP_Query($args);

haru_set_loop_prop( 'product_style', 'style-1' );
?>
<?php if ( $products->have_posts() ) : ?>
 	<ul class="haru-product-top-sale__list haru-slick haru-slick--nav-border haru-slick--nav-bottom-left" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
    <?php 
    $i = 1;
    while ( $products->have_posts() ) : $products->the_post(); ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
        	<li class="haru-product-top-sale__item">
        <?php endif; ?>
        	<?php wc_get_template_part( 'content', 'product' ); ?>
        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          	</li>
        <?php endif; ?>
    <?php $i++; endwhile; // end of the loop. ?>
    </ul>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-teespace' ) ?></div>
<?php endif; ?>

<?php haru_reset_loop(); ?>
<?php wp_reset_query(); ?>
