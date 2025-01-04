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
        $terms = ControlsHelper::get_terms( 'product_cat' );
        $settings_term = $settings;
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $settings_term['product_cat_ids'] = reset($terms)->term_id;
        }
        $args = ControlsHelper::get_product_query_args( $settings_term );
    } else {
        $terms = ControlsHelper::get_terms( 'product_cat', $settings['product_cat_ids'] );
        $settings_term = $settings;
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $settings_term['product_cat_ids'] = reset($terms)->term_id;
        }
        $args = ControlsHelper::get_product_query_args( $settings_term );
    }

    if ( $settings['product_filter_all'] == 'show' ) {
        $args = ControlsHelper::get_product_query_args( $settings );
    }
} else {
    $args = ControlsHelper::get_product_query_args( $settings );
}

$products = new \WP_Query( $args );
?>

    <?php if ( $settings['product_filter'] != 'hide' ) : ?>
    <div class="product-category-top">
        <?php if ( $settings['product_filter'] != 'hide' ) : ?>
        <ul class="product-filter product-filter--<?php echo esc_attr( $settings['product_filter'] ); ?> <?php echo esc_attr( ( $settings['view_more'] == 'arrow' || $settings['view_more'] == 'button' ) ? 'has-' . $settings['view_more'] : '' ); ?>">
            <?php if ( $settings['product_filter_all'] == 'show' ) : ?>
                <li>
                    <h6 class="tab-item-heading">
                        <a class="filter-item filter-all active"
                            href="javascript:;" 
                            data-category="*"
                        ><?php echo esc_html__( 'All', 'haru-teespace' ); ?></a>
                    </h6>
                </li>
            <?php endif; ?>
            <?php foreach ( $terms as $key => $term ) : ?>
            <li>
                <h6 class="tab-item-heading">
                    <a class="filter-item <?php if ( ( $key == 0 ) && ( $settings['product_filter_all'] == 'hide' ) ) echo 'active'; ?>"
                        href="javascript:;" 
                        data-category ="<?php echo esc_attr( $term->term_id ); ?>"
                    ><?php echo esc_html( $term->name ); ?></a>
                </h6>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="product-ajax-content">
        <div class="ajax-loading-icon"><div class="loading-bar"></div></div>
        <div class="product-category-content">
            <?php if ( in_array( $settings['layout'], array( 'grid', 'masonry' ) ) ) : ?>
            <div class="product-list animated fadeIn haru-clear">
                <?php haru_set_loop_prop( 'product_style', $settings['product_style'] ); ?>
                <?php
                    if ( $products->have_posts() ) :
                        while ( $products->have_posts() ) : $products->the_post();
                            wc_get_template_part( 'content', 'product' );
                        endwhile;
                ?>
                <?php else : ?>
                    <div class="haru-info"><?php echo esc_html__( 'No product found. Please set Product Categories.', 'haru-teespace' ); ?></div>
                <?php endif; ?>
                <?php haru_reset_loop(); ?>
            </div>
            <?php endif; ?>

            <?php if ( in_array( $settings['layout'], array( 'grid', 'masonry' ) ) && $settings['view_more'] == 'button' ) : ?>
                <?php if ( $products->max_num_pages > 1 ) : ?>
                <div class="products-ajax-view-more <?php echo esc_attr( $settings['view_more'] == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( ( $settings['product_filter_all'] == 'show' || $settings['product_filter'] == 'hide' ) ? get_post_type_archive_link('product') : get_term_link( $terms[0], 'product_cat' ) ); ?>" class="haru-button haru-button--outline-gray haru-button--size-medium haru-button--round-normal"><?php echo esc_html__( 'View more', 'haru-teespace' ); ?></a>
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
            data-category="<?php echo esc_attr( ($settings['product_filter_all'] == 'show' || $settings['product_filter'] == 'hide' ) ? '*' : $terms[0]->term_id ); ?>"
            data-action="prev"
        ></div>
        <div class="product-control-item"
            data-max_pages="<?php echo esc_attr( $products->max_num_pages ); ?>" 
            data-current_page="1"
            data-category="<?php echo esc_attr( ($settings['product_filter_all'] == 'show' || $settings['product_filter'] == 'hide' ) ? '*' : $terms[0]->term_id ); ?>"
            data-action="next"
        ></div>
    </div>
    <?php else : ?>
    <div class="product-control hide-control">
        <div class="product-control-item disable"
            data-max_pages="1" 
            data-current_page="1"
            data-category="<?php echo esc_attr( ($settings['product_filter_all'] == 'show' || $settings['product_filter'] == 'hide' ) ? '*' : $terms[0]->term_id ); ?>"
            data-action="prev"
        ></div>
        <div class="product-control-item"
            data-max_pages="1" 
            data-current_page="1"
            data-category="<?php echo esc_attr( ($settings['product_filter_all'] == 'show' || $settings['product_filter'] == 'hide' ) ? '*' : $terms[0]->term_id ); ?>"
            data-action="next"
        ></div>
    </div>
    <?php endif; ?>

<?php
wp_reset_query();
$wp_query = $original_query;

