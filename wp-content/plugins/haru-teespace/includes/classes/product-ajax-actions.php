<?php
/**
 * @package    HaruTheme/Haru Movie
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

use \Haru_TeeSpace\Classes\Helper as ControlsHelper;

// Check Yith Compare
add_filter('yith_woocompare_actions_to_check_frontend', 'haru_yith_woocompare_check_frontend', 10, 2);
function haru_yith_woocompare_check_frontend() {
    return array( 'woof_draw_products', 'prdctfltr_respond_550', 'wbmz_get_products', 'jet_smart_filters', 'productfilter', 'haru_get_product_category', 'haru_get_product_category_next', 'haru_get_product_order', 'haru_get_product_order_next' );
}

// Product Category
add_action( 'wp_ajax_haru_get_product_category', 'haru_get_product_category' );
add_action( 'wp_ajax_nopriv_haru_get_product_category', 'haru_get_product_category' );

if ( ! function_exists( 'haru_get_product_category' ) ) {
    function haru_get_product_category( $settings ) {
        if ( empty($_POST['settings']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $settings       = $_POST['settings'];
        $category       = $_POST['category'];

        ob_start();

        $settings['product_cat_ids'] = explode(',', $category);
        $args = ControlsHelper::get_product_query_args( $settings );
        
        $products = new WP_Query( $args );
        ?>
        <div class="product-category-content" data-max_pages="<?php echo esc_attr( $products->max_num_pages ); ?>" data-category="<?php echo esc_attr( $category ); ?>">
            <?php if ( in_array($settings['layout'], array('grid', 'masonry') ) ) : ?>
                <div class="product-list animated fadeIn haru-clear">
                    <?php haru_set_loop_prop( 'product_style', $settings['product_style'] ); ?>
                    <?php
                        if ( $products->have_posts() ) :
                            while ( $products->have_posts() ) : $products->the_post();
                                wc_get_template_part( 'content', 'product' );
                            endwhile;
                    ?>
                    <?php else : ?>
                        <div class="haru-info"><?php echo esc_html__( 'No product found', 'haru-teespace' ); ?></div>
                    <?php endif; ?>
                    <?php haru_reset_loop(); ?>
                </div>
            <?php endif; ?>

            <?php if ( in_array( $settings['layout'], array( 'grid', 'masonry' ) ) && $settings['view_more'] == 'button' ) : ?>
                <?php if ( $products->max_num_pages > 1 ) : ?>
                <div class="products-ajax-view-more <?php echo esc_attr( $settings['view_more'] == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( get_term_link( (int)$settings['product_cat_ids'][0], 'product_cat' ) ); ?>" class="haru-button haru-button--outline-gray haru-button--size-medium haru-button--round-normal"><?php echo esc_html__( 'View more', 'haru-teespace' ); ?></a>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Product Category Next
add_action( 'wp_ajax_haru_get_product_category_next', 'haru_get_product_category_next' );
add_action( 'wp_ajax_nopriv_haru_get_product_category_next', 'haru_get_product_category_next' );

if ( ! function_exists( 'haru_get_product_category_next' ) ) {
    function haru_get_product_category_next( $settings ) {
        if ( empty($_POST['settings']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $settings       = $_POST['settings'];
        $category       = $_POST['category'];
        $current_page   = $_POST['current_page'];

        ob_start();

        if ( $category != '*' ) {
            $settings['product_cat_ids'] = explode( ',', $category );
        }

        $settings['paged'] = $current_page + 1;

        $args = ControlsHelper::get_product_query_args( $settings );
        
        $products = new WP_Query( $args );
        ?>
        <div class="product-category-content">
            <?php if ( in_array($settings['layout'], array( 'grid', 'masonry' ) ) ) : ?>
                <div class="product-list grid-columns animated fadeIn haru-clear">
                    <?php haru_set_loop_prop( 'product_style', $settings['product_style'] ); ?>
                    <?php
                        if ( $products->have_posts() ) :
                            while ( $products->have_posts() ) : $products->the_post();
                                wc_get_template_part( 'content', 'product' );
                            endwhile;
                    ?>
                    <?php else : ?>
                        <div class="haru-info"><?php echo esc_html__( 'No product found', 'haru-teespace' ); ?></div>
                    <?php endif; ?>
                    <?php haru_reset_loop(); ?>
                </div>
            <?php endif; ?>

            <?php if ( in_array( $settings['layout'], array( 'grid', 'masonry' ) ) && $settings['view_more'] == 'button' ) : ?>
                <?php if ( $products->max_num_pages > 1 ) : ?>
                <div class="products-ajax-view-more <?php echo esc_attr( $settings['view_more'] == 'arrow' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( ( $category == '*' ) ? get_post_type_archive_link( 'product' ) : get_term_link( $category, 'product_cat' ) ); ?>" class="haru-button haru-button--outline-gray haru-button--size-medium haru-button--round-normal"><?php echo esc_html__( 'View more', 'haru-teespace' ); ?></a>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Product Order
add_action( 'wp_ajax_haru_get_product_order', 'haru_get_product_order' );
add_action( 'wp_ajax_nopriv_haru_get_product_order', 'haru_get_product_order' );

if ( ! function_exists( 'haru_get_product_order' ) ) {
    function haru_get_product_order( $settings ) {
        if ( empty($_POST['settings']) || empty( $_POST['order'] ) ) {
            die('0');
        }

        $settings    = $_POST['settings'];
        $order       = $_POST['order'];

        ob_start();

        // Do something process product_cat_ids ?
        $args = ControlsHelper::get_product_query_args( $settings );

        // var_dump($order);
        if ( $order == 'new' ) {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        } elseif ( $order == 'best_selling' ) {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
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
            $args['orderby']    = $ordering_args['orderby'];
            $args['order']      = $ordering_args['order'];
            $args['meta_query'] = $meta_query;
        } else {
            $args['orderby'] = 'rand';
            $args['order'] = '';
            $args['meta_key'] = '';
        }
        
        $products = new WP_Query( $args );
        ?>
        <div class="product-order-content" data-max_pages="<?php echo esc_attr( $products->max_num_pages ); ?>" data-order="<?php echo esc_attr( $order ); ?>">
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
                        <div class="haru-info"><?php echo esc_html__( 'No product found', 'haru-teespace' ); ?></div>
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

            <?php if ( in_array($settings['layout'], array( 'grid' ) ) && $settings['view_more'] == 'button' ) : ?>
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
                    <a href="<?php echo esc_url( $view_more_link ); ?>" class="haru-button haru-button--outline-gray haru-button--size-medium haru-button--round-normal"><?php echo esc_html__( 'View more', 'haru-teespace' ); ?></a>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Product Order Next
add_action( 'wp_ajax_haru_get_product_order_next', 'haru_get_product_order_next' );
add_action( 'wp_ajax_nopriv_haru_get_product_order_next', 'haru_get_product_order_next' );

if ( ! function_exists( 'haru_get_product_order_next' ) ) {
    function haru_get_product_order_next( $settings ) {
        if ( empty( $_POST['settings'] ) || empty( $_POST['order'] ) ) {
            die('0');
        }

        $settings       = $_POST['settings'];
        $order          = $_POST['order'];
        $current_page   = $_POST['current_page'];

        ob_start();

        if ( $order != '*' ) {
            // Do something
        }

        $settings['paged'] = $current_page + 1;

        $args = ControlsHelper::get_product_query_args( $settings );

        if ( $order == '*' ) {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        } elseif ( $order == 'new' ) {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        } elseif ( $order == 'best_selling' ) {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        } elseif ( $order == 'featured' ) {
            $tax_query   = WC()->query->get_tax_query();
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
            $args['order'] = '';
            $args['meta_key'] = '';
        }
        
        $products = new WP_Query( $args );
        ?>
        <div class="product-order-content">
            <?php if ( in_array($settings['layout'], array( 'grid', 'masonry' ) ) ) : ?>
                <div class="product-list grid-columns animated fadeIn haru-clear">
                    <?php haru_set_loop_prop( 'product_style', $settings['product_style'] ); ?>
                    <?php
                        if ( $products->have_posts() ) :
                            while ( $products->have_posts() ) : $products->the_post();
                                wc_get_template_part( 'content', 'product' );
                            endwhile;
                    ?>
                    <?php else : ?>
                        <div class="haru-info"><?php echo esc_html__( 'No product found', 'haru-teespace' ); ?></div>
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
                <div class="products-ajax-view-more <?php echo esc_attr( $settings['view_more'] == 'arrow' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( ( $order == '*' ) ? get_post_type_archive_link( 'product' ) : $view_more_link ); ?>" class="haru-button haru-button--outline-gray haru-button--size-medium haru-button--round-normal"><?php echo esc_html__( 'View more', 'haru-teespace' ); ?></a>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Product Search
add_action( 'wp_ajax_haru_woo_search_ajax', 'haru_woo_search_ajax' );
add_action( 'wp_ajax_nopriv_haru_woo_search_ajax', 'haru_woo_search_ajax' );
if ( ! function_exists( 'haru_woo_search_ajax' ) ) {
    function haru_woo_search_ajax() {
        $posts_per_page = 8;
        $search_result_count = $_REQUEST['search_count'];

        // Need to option
        if ( ! empty( $search_result_count ) ) {
            $posts_per_page = $search_result_count;
        }

        $post_type = array( 'product' ); // Can change to option
        $keyword = $_REQUEST['keyword'];

        if ( $keyword ) {
            $search_query = array(
                's'              => $keyword,
                'order'          => 'DESC',
                'orderby'        => 'date',
                'post_status'    => 'publish',
                'post_type'      => $post_type,
                'posts_per_page' => $posts_per_page + 1, // +1 to check have more item
            );

            $search = new WP_Query( $search_query );

            if ( $search && count( $search->posts ) > 0 ) :
                $count = 0;
            ?>
            <ul class="product-search-list">
                <?php
                    if ( $search->have_posts() ):
                    while( $search->have_posts() ) : $search->the_post();
                        $product = wc_get_product( get_the_ID() );

                        if ( $count == $posts_per_page ) : 
                ?>
                    <li class="search-view-more">
                        <a href="<?php echo esc_url( site_url() ) . '?s=' . $keyword . '&post_type=product'; ?>"><?php echo esc_html__( 'View All Results', 'haru-teespace' ); ?></a>
                    </li>
                <?php
                    break; 
                    else :
                ?>
                    <li class="product-search-item">
                        <div class="product-search-item__thumbnail">
                            <?php echo wp_kses_post( get_the_post_thumbnail( get_the_ID(), 'woocommerce_thumbnail' ) ); ?>
                        </div>
                        <div class="product-search-item__info">
                            <h6 class="product-search-item__title"><a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php echo $product->get_title(); ?></a></h6>
                            <div class="product-search-item__price"><?php echo $product->get_price_html(); ?></div>
                        </div>
                    </li>
                <?php
                        endif;
                    $count++;
                    endwhile;
                    endif;
                    // wp_reset_query();
                ?>
            </ul>
            <?php
                else :
            ?>
                <ul class="product-search-list">
                    <li class="search-no-result"><?php echo esc_html__( 'No products were found matching your selection.', 'haru-teespace' ); ?></li>
                </ul>
            <?php
            endif;
        }

        wp_reset_query();
        die;
    }
}
