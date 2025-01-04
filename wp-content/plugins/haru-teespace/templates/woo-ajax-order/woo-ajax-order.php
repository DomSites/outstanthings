<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

use \Haru_TeeSpace\Classes\Helper as ControlsHelper;

global $wp_query;

$original_query = $wp_query;

if ( $settings['post_type'] != 'by_id' ) {
    if ( $settings['product_cat_ids'] == '' ) {
        // $terms = ControlsHelper::get_terms( 'product_cat' );
        // var_dump($terms);
        $settings_term = $settings;
        // if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        //     $settings_term['product_cat_ids'] = reset($terms)->term_id;
        // }
        $args = ControlsHelper::get_product_query_args( $settings_term );
    } else {
        $terms = ControlsHelper::get_terms( 'product_cat', $settings['product_cat_ids'] );
        $settings_term = $settings;
        // if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        //     $settings_term['product_cat_ids'] = reset($terms)->term_id;
        // }
        $args = ControlsHelper::get_product_query_args( $settings_term );
    }

    if ( $settings['product_filter_all'] == 'show' ) {
        $args = ControlsHelper::get_product_query_args( $settings );
    }
} else {
    $args = ControlsHelper::get_product_query_args( $settings );
}

if ( $settings['product_tabs'] ) {
    $order = $settings['product_tabs'][0];

    if ( $order == 'new' ) {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    } elseif ( $order == 'best_selling' ) {
        $args['meta_key'] = 'total_sales';
        $args['orderby'] = 'meta_value_num';
    } elseif ( $order == 'featured' ) {
        // $tax_query   = WC()->query->get_tax_query();
        $tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
            'operator' => 'IN',
        );
        // $tax_query[] = array(
        // 'taxonomy' => 'product_cat',
        //         'terms'    => array_map('sanitize_title', explode(',', $product_cats)),
        //         'field'    => 'slug',
        //         'operator' => 'IN'
        // );
        $args['tax_query'][]  = $tax_query;
    } elseif ( $order == 'sale' ) {
        $product_ids_on_sale = wc_get_product_ids_on_sale();
        $ordering_args = WC()->query->get_catalog_ordering_args('date', 'desc');
        $meta_query    = WC()->query->get_meta_query();

        $args['orderby']        = $ordering_args['orderby'];
        $args['order']          = $ordering_args['order'];
        $args['meta_query'] = $meta_query;
        $args['post__in']   = array_merge( array( 0 ), $product_ids_on_sale );
    } elseif ( $order == 'top_rated' ) {
        $ordering_args = WC()->query->get_catalog_ordering_args('date', 'desc');
        $meta_query    = WC()->query->get_meta_query();

        $args['meta_key']   = '_wc_average_rating';
        $args['orderby']        = $ordering_args['orderby'];
        $args['order']          = $ordering_args['order'];
        $args['meta_query'] = $meta_query;
    } else {
        $args['orderby'] = 'rand';
    }
} else {
    $order = 'new';
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
}

$products = new \WP_Query( $args );
?>  

    <?php if ( $settings['product_filter'] != 'hide' ) : ?>
    <div class="product-order-top">
        <?php if ( $settings['product_filter'] != 'hide' ) : ?>
        <ul class="product-filter product-filter--<?php echo esc_attr( $settings['product_filter'] ); ?> <?php echo esc_attr( ( $settings['view_more'] == 'arrow' || $settings['view_more'] == 'button' ) ? 'has-' . $settings['view_more'] : '' ); ?>">
            <?php if ( $settings['product_filter_all'] == 'show' ) : ?>
                <li>
                    <h6 class="tab-item-heading">
                        <a class="filter-item filter-all active"
                            href="javascript:;" 
                            data-order="*"
                        ><?php echo esc_html__( 'All', 'haru-teespace' ); ?></a>
                    </h6>
                </li>
            <?php endif; ?>

            <?php 
                foreach ( $settings['product_tabs'] as $key => $tab ) :
                $tab_title = $tab . '_title';
            ?>
            <li>
                <h6 class="tab-item-heading">
                    <a class="filter-item <?php if ( ( $key == 0 ) && ( $settings['product_filter_all'] == 'hide' ) ) echo 'active'; ?>"
                        href="javascript:;" 
                        data-order ="<?php echo esc_attr( $tab ); ?>"
                    ><?php echo esc_html( $settings[$tab_title] ); ?></a>
                </h6>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="product-ajax-content">
        <div class="ajax-loading-icon"><div class="loading-bar"></div></div>
        <div class="product-order-content">
            <?php if ( in_array( $settings['layout'], array( 'grid' ) ) ) : ?>
            <div class="product-list animated fadeIn haru-clear">
                <?php haru_set_loop_prop( 'product_style', $settings['product_style'] ); ?>
                <?php
                    if ( $products->have_posts() ) :
                        while ( $products->have_posts() ) : $products->the_post();
                            wc_get_template_part( 'content', 'product' );
                        endwhile;
                ?>
                <?php else : ?>
                    <div class="haru-info"><?php echo esc_html__( 'No product found. Please set Product Order.', 'haru-teespace' ); ?></div>
                <?php endif; ?>
                <?php haru_reset_loop(); ?>
            </div>
            <?php endif; ?>

            <?php if ( in_array( $settings['layout'], array( 'slick' ) ) ) : ?>
            <div class="product-list animated fadeIn haru-clear haru-slick haru-slick--nav-shadow haru-slick--nav-center haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 1575,"settings" : {"dots": true, "arrows": false}}, {"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>, "dots": true}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>, "dots": true}}] }'>
                <?php haru_set_loop_prop( 'product_style', $settings['product_style'] ); ?>
                <?php
                    if ( $products->have_posts() ) :
                        $i = 1;
                        while ( $products->have_posts() ) : $products->the_post();
                ?>
                            <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
                                <div class="haru-woo-product-order__item-wrap">
                            <?php endif; ?>
                                    <?php wc_get_template_part( 'content', 'product' ); ?>
                            <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
                                </div>
                            <?php endif; ?>
                        <?php $i++; endwhile; ?>
                <?php else : ?>
                    <div class="haru-info"><?php echo esc_html__( 'No product found. Please set Product Order.', 'haru-teespace' ); ?></div>
                <?php endif; ?>
                <?php haru_reset_loop(); ?>
            </div>
            <?php endif; ?>

            <?php if ( in_array( $settings['layout'], array( 'grid' ) ) && $settings['view_more'] == 'button' ) : ?>
                <?php
                    if ( $products->max_num_pages > 1 ) :
                    
                    if ( $order == 'new' ) {
                        $view_more_link = get_post_type_archive_link( 'product' ) . '?orderby=date';
                    } elseif ( $order == 'top_rated' ) {
                        $view_more_link = get_post_type_archive_link( 'product' ) . '?orderby=rating';
                    } elseif ( $order == 'best_selling' ) {
                        $view_more_link = get_post_type_archive_link( 'product' ) . '?orderby=popularity';
                    } else {
                        $view_more_link = get_post_type_archive_link( 'product' );
                    }
                ?>
                <div class="products-ajax-view-more <?php echo esc_attr( $settings['view_more'] == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( ( $settings['product_filter_all'] == 'show' || $settings['product_filter'] == 'hide' ) ? get_post_type_archive_link( 'product' ) : $view_more_link ); ?>" class="haru-button haru-button--outline-gray haru-button--size-medium haru-button--round-normal"><?php echo esc_html__( 'View more', 'haru-teespace' ); ?></a>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php if ( $products->max_num_pages > 1 ) : ?>
    <div class="product-control <?php echo esc_attr( $settings['view_more'] == 'arrow' ? '' : 'hide-control' ); ?>">
        <div class="product-control-item disable"
            data-max_pages="<?php echo esc_attr( $products->max_num_pages ); ?>" 
            data-current_page="1"
            data-order="<?php echo esc_attr( ($settings['product_filter_all'] == 'show' || $settings['product_filter'] == 'hide' ) ? '*' : $order ); ?>"
            data-action="prev"
        ></div>
        <div class="product-control-item"
            data-max_pages="<?php echo esc_attr( $products->max_num_pages ); ?>" 
            data-current_page="1"
            data-order="<?php echo esc_attr( ($settings['product_filter_all'] == 'show' || $settings['product_filter'] == 'hide' ) ? '*' : $order ); ?>"
            data-action="next"
        ></div>
    </div>
    <?php else : ?>
    <div class="product-control hide-control">
        <div class="product-control-item disable"
            data-max_pages="1" 
            data-current_page="1"
            data-order="<?php echo esc_attr( ($settings['product_filter_all'] == 'show' || $settings['product_filter'] == 'hide' ) ? '*' : $order ); ?>"
            data-action="prev"
        ></div>
        <div class="product-control-item"
            data-max_pages="1" 
            data-current_page="1"
            data-order="<?php echo esc_attr( ($settings['product_filter_all'] == 'show' || $settings['product_filter'] == 'hide' ) ? '*' : $order ); ?>"
            data-action="next"
        ></div>
    </div>
    <?php endif; ?>

<?php
wp_reset_query();
$wp_query = $original_query;

