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

global $wp_query;

$original_query = $wp_query;

if ( $settings['post_type'] != 'by_id' ) {
    // if ( $settings['product_cat_ids'] == '' ) {
        $args = ControlsHelper::get_product_query_args( $settings );
    // } else {
    //     $terms = ControlsHelper::get_terms( 'product_cat', $settings['product_cat_ids'] );
    //     $settings_term = $settings;
    //     $settings_term['product_cat_ids'] = reset($terms)->term_id;
    //     $args = ControlsHelper::get_product_query_args( $settings_term );
    // }
} else {
    $args = ControlsHelper::get_product_query_args( $settings );
}

// @TODO: change to setting
haru_set_loop_prop( 'product_style', 'style-1' );
$products = new \WP_Query( $args );
?>  
    <?php if ( $products->have_posts() ) : ?>
    <ul class="haru-woo-product-slider__list haru-slick haru-slick--nav-shadow haru-slick--nav-center haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 1575,"settings" : {"dots": true, "arrows": false}}, {"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>, "dots": true}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>, "dots": true}}] }'>
        <?php haru_set_loop_prop( 'product_style', $settings['product_style'] ); ?>
        <?php
            $i = 1;
            while ( $products->have_posts() ) : $products->the_post();
        ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
            <li class="haru-woo-product-slider__item-wrap">
        <?php endif; ?>
            <!-- <div class="haru-woo-product-slider__item"> -->
                <?php wc_get_template_part( 'content', 'product' ); ?>
            <!-- </div> -->
        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
            </li>
        <?php endif; ?>
      <?php $i++; endwhile; ?>
    </ul>
    <?php else : ?>
        <div class="haru-info"><?php echo esc_html__( 'No product found', 'haru-teespace' ); ?></div>
    <?php endif; ?>

<?php haru_reset_loop(); ?>
<?php
wp_reset_query();
$wp_query = $original_query;

