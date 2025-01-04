<?php
/**
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

use Automattic\WooCommerce\Internal\ProductAttributesLookup\Filterer;

defined( 'ABSPATH' ) || exit;

class Haru_Woo_Layered_Nav_Widget extends Haru_TeeSpace_Widget {

    /**
     * Constructor.
     */

    public function __construct() {
        if ( ! function_exists( 'wc_get_attribute_taxonomies' ) ) {
            return;
        }

        $this->widget_id          = 'haru_widget_woo_layered_nav';
        $this->widget_name        = esc_html__( 'Haru WooCommerce Layered Nav', 'haru-teespace' );
        $this->widget_description = esc_html__( 'Widget display WooCommerce Layered Nav filter.', 'haru-teespace' );
        $this->widget_cssclass    = 'widget-woo-layered-nav';
        $this->cached             = false;

        $attribute_array      = array();
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        if ( $attribute_taxonomies ) {
            foreach ( $attribute_taxonomies as $tax ) {
                $attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
            }
        }

        $categories_array = array(
            esc_html__( 'All categories', 'haru-teespace' ) => 'all',
        );

        $categories = $this->get_categories();

        if ( ! empty( $categories ) ) {
            foreach ( $categories as $cat ) {
                $title = $cat->post_title;
                $id    = ' (ID:' . $cat->id . ')';
                if ( property_exists( $cat, 'parent' ) && $cat->parent ) {
                    $title = $title . $id . ' (Parent ID:' . $cat->parent . ')';
                }
                $categories_array[ $title . $id ] = $cat->id;
            }
        }

        $this->settings = array(
            'title'         => array(
                'type'  => 'text',
                'std'   => esc_html__( 'Filter by', 'haru-teespace' ),
                'label' => esc_html__( 'Title', 'haru-teespace' )
            ),
            'attribute' => array(
                'type'   => 'dropdown',
                'std'    => '',
                'label'   => esc_html__( 'Attribute', 'haru-teespace' ),
                'options' => $attribute_array,
            ),
            'category' => array(
                'type'    => 'select2',
                'std' => array( 'all' ),
                'label'    => esc_html__( 'Show on category', 'haru-teespace' ),
                'options'  => $categories_array,
            ),
            'query_type' => array(
                'type'   => 'dropdown',
                'std'    => 'and',
                'label'   => esc_html__( 'Query type', 'haru-teespace' ),
                'options' => array(
                    'and' => esc_html__( 'AND', 'haru-teespace' ),
                    'or'  => esc_html__( 'OR', 'haru-teespace' ),
                ),
            ),
            'display'       => array(
                'type'   => 'dropdown',
                'std'    => 'list',
                'label'   => esc_html__( 'Display type', 'haru-teespace' ),
                'options' => array(
                    'list'   => esc_html__( 'List', 'haru-teespace' ),
                    'double' => esc_html__( '2 Columns', 'haru-teespace' ),
                    'list-inline' => esc_html__( 'List Inline', 'haru-teespace' ),
                ),
            ),
            'size' => array(
                'type'   => 'dropdown',
                'std'    => 'normal',
                'label'   => esc_html__( 'Swatches size', 'haru-teespace' ),
                'options' => array(
                    'normal' => esc_html__( 'Normal', 'haru-teespace' ),
                    'large'  => esc_html__( 'Large', 'haru-teespace' ),
                    'small'  => esc_html__( 'Small', 'haru-teespace' ),
                ),
            ),
            'labels' => array(
                'type'   => 'dropdown',
                'std'    => 'on',
                'label'   => esc_html__( 'Show labels', 'haru-teespace' ),
                'options' => array(
                    'on'  => esc_html__( 'ON', 'haru-teespace' ),
                    'off' => esc_html__( 'OFF', 'haru-teespace' ),
                ),
            ),
            'tooltips' => array(
                'type'   => 'dropdown',
                'std'    => 'off',
                'label'   => esc_html__( 'Show tooltips', 'haru-teespace' ),
                'options' => array(
                    'on'  => esc_html__( 'ON', 'haru-teespace' ),
                    'off' => esc_html__( 'OFF', 'haru-teespace' ),
                ),
            ),
        );

        parent::__construct();
    }

    public function get_categories() {
        global $wpdb;

        $categories = $wpdb->get_results(
            "
        SELECT
            t.term_id AS id,
            t.name    AS post_title,
            t.slug    AS post_url,
            parent    AS parent
        FROM {$wpdb->prefix}terms t
            LEFT JOIN {$wpdb->prefix}term_taxonomy tt
                    ON t.term_id = tt.term_id
        WHERE tt.taxonomy = 'product_cat'
        ORDER BY name"
        );

        return $categories;
    }
    
    public function widget( $args, $instance ) {
        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
        $taxonomy           = isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name( $instance['attribute'] ) : '';
        $category           = isset( $instance['category'] ) ? $instance['category'] : array( 'all' );
        $query_type         = isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';
        $display            = isset( $instance['display'] ) ? $instance['display'] : 'list';
        $template           = isset( $instance['template'] ) ? $instance['template'] : 'default';

        if ( ! is_shop() && ! is_product_taxonomy() && $template == 'default' ) {
            return;
        }

        $current_cat = get_queried_object();

        if ( ! is_array( $category ) ) {
            $category = explode( ',', $category );
        }

        if ( ! is_tax() && ! in_array( 'all', $category ) ) {
            return;
        }

        if ( ! in_array( 'all', $category ) && property_exists( $current_cat, 'term_id' ) && ! in_array( $current_cat->term_id, $category ) && ! in_array( $current_cat->parent, $category ) ) {
            return;
        }

        if ( ! taxonomy_exists( $taxonomy ) ) {
            return;
        }

        $get_terms_args = array( 'hide_empty' => '1' );

        $orderby = wc_attribute_orderby( $taxonomy );

        switch ( $orderby ) {
            case 'name':
                $get_terms_args['orderby']    = 'name';
                $get_terms_args['menu_order'] = false;
                break;
            case 'id':
                $get_terms_args['orderby']    = 'id';
                $get_terms_args['order']      = 'ASC';
                $get_terms_args['menu_order'] = false;
                break;
            case 'menu_order':
                $get_terms_args['menu_order'] = 'ASC';
                break;
        }

        $terms = get_terms( $taxonomy, $get_terms_args );

        if ( 0 === sizeof( $terms ) ) {
            return;
        }

        ob_start();

        echo wp_kses_post( $args['before_widget'] );

        if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance ) ) {
            echo wp_kses_post( $args['before_title'] ) . $title . wp_kses_post( $args['after_title'] );
        }

        if ( $template == 'default' ) {
            if ( 'dropdown' === $display ) {
               // Do something
            } else {
                $found = $this->layered_nav_list( $terms, $taxonomy, $query_type, $instance );
            }
        } else {
            // Do something
        }

        echo wp_kses_post( $args['after_widget'] );

        // Force found when option is selected - do not force found on taxonomy attributes
        if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
            $found = true;
        }

        if ( ! $found ) {
            ob_end_clean();
        } else {
            echo ob_get_clean();
        }
    }

    /**
     * Return the currently viewed taxonomy name.
     *
     * @return string
     */
    protected function get_current_taxonomy() {
        return is_tax() ? get_queried_object()->taxonomy : '';
    }

    /**
     * Return the currently viewed term ID.
     *
     * @return int
     */
    protected function get_current_term_id() {
        return absint( is_tax() ? get_queried_object()->term_id : 0 );
    }

    /**
     * Return the currently viewed term slug.
     *
     * @return int
     */
    protected function get_current_term_slug() {
        return absint( is_tax() ? get_queried_object()->slug : 0 );
    }

    /**
     * Get current page URL for layered nav items.
     *
     * @return string
     */
    protected function get_page_base_url() {
        if ( Automattic\Jetpack\Constants::is_defined( 'SHOP_IS_ON_FRONT' ) ) {
            $link = home_url();
        } elseif ( is_shop() ) {
            $link = get_permalink( wc_get_page_id( 'shop' ) );
        } elseif ( is_product_category() ) {
            $link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
        } elseif ( is_product_tag() ) {
            $link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
        } else {
            $queried_object = get_queried_object();
            $link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
        }

        // Min/Max.
        if ( isset( $_GET['min_price'] ) ) {
            $link = add_query_arg( 'min_price', wc_clean( wp_unslash( $_GET['min_price'] ) ), $link );
        }

        if ( isset( $_GET['max_price'] ) ) {
            $link = add_query_arg( 'max_price', wc_clean( wp_unslash( $_GET['max_price'] ) ), $link );
        }

        // Order by.
        if ( isset( $_GET['orderby'] ) ) {
            $link = add_query_arg( 'orderby', wc_clean( wp_unslash( $_GET['orderby'] ) ), $link );
        }

        /**
         * Search Arg.
         * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
         */
        if ( get_search_query() ) {
            $link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
        }

        // Post Type Arg
        if ( isset( $_GET['post_type'] ) ) {
            $link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );

            // Prevent post type and page id when pretty permalinks are disabled.
            if ( is_shop() ) {
                $link = remove_query_arg( 'page_id', $link );
            }
        }

        // Min Rating Arg
        if ( isset( $_GET['rating_filter'] ) ) {
            $link = add_query_arg( 'rating_filter', wc_clean( wp_unslash( $_GET['rating_filter'] ) ), $link );
        }

        // All current filters.
        if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
            foreach ( $_chosen_attributes as $name => $data ) {
                $filter_name = wc_attribute_taxonomy_slug( $name );
                if ( ! empty( $data['terms'] ) ) {
                    $link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
                }
                if ( 'or' === $data['query_type'] ) {
                    $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
                }
            }
        }

        return apply_filters( 'woocommerce_widget_get_current_page_url', $link, $this );
    }

    /**
     * Count products within certain terms, taking the main WP query into consideration.
     *
     * This query allows counts to be generated based on the viewed products, not all products.
     *
     * @param  array  $term_ids Term IDs.
     * @param  string $taxonomy Taxonomy.
     * @param  string $query_type Query Type.
     * @return array
     */
    protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
        if ( function_exists( 'WC' ) && version_compare( WC()->version, '5.5.0', '<' ) ) {
            global $wpdb;

            $tax_query  = WC_Query::get_main_tax_query();
            $meta_query = WC_Query::get_main_meta_query();
            if ( 'or' === $query_type ) {
                foreach ( $tax_query as $key => $query ) {
                    if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
                        unset( $tax_query[ $key ] );
                    }
                }
            }

            $meta_query     = new WP_Meta_Query( $meta_query );
            $tax_query      = new WP_Tax_Query( $tax_query );
            $meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
            $tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );
            // Generate query
            $query           = array();
            $query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
            $query['from']   = "FROM {$wpdb->posts}";
            $query['join']   = "
            INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
            INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
            INNER JOIN {$wpdb->terms} AS terms USING( term_id )
            " . $tax_query_sql['join'] . $meta_query_sql['join'];
            $query['where']  = "
            WHERE {$wpdb->posts}.post_type IN ( 'product' )
            AND {$wpdb->posts}.post_status = 'publish'
            " . $tax_query_sql['where'] . $meta_query_sql['where'] . '
            AND terms.term_id IN (' . implode( ',', array_map( 'absint', $term_ids ) ) . ')
        ';

            if ( $search = WC_Query::get_main_search_query_sql() ) {

                $query['where'] .= ' AND ' . $search;

                // if ( haru_get_option( 'search_by_sku' ) ) {
                    // search for variations with a matching sku and return the parent.
                    $sku_to_parent_id = $wpdb->get_col( $wpdb->prepare( "SELECT p.post_parent as post_id FROM {$wpdb->posts} as p join {$wpdb->wc_product_meta_lookup} ml on p.ID = ml.product_id and ml.sku LIKE '%%%s%%' where p.post_parent <> 0 group by p.post_parent", wc_clean( $_GET['s'] ) ) );

                    // Search for a regular product that matches the sku.
                    $sku_to_id = $wpdb->get_col( $wpdb->prepare( "SELECT product_id FROM {$wpdb->wc_product_meta_lookup} WHERE sku LIKE '%%%s%%';", wc_clean( $_GET['s'] ) ) );

                    $search_ids = array_merge( $sku_to_id, $sku_to_parent_id );

                    $search_ids = array_filter( array_map( 'absint', $search_ids ) );

                    if ( sizeof( $search_ids ) > 0 ) {
                        $query['where'] = str_replace( '))', ") OR ({$wpdb->posts}.ID IN (" . implode( ',', $search_ids ) . ')))', $query['where'] );
                    }
                // }
            }

            $query['group_by'] = 'GROUP BY terms.term_id';
            $query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
            $query             = implode( ' ', $query );

            // We have a query - let's see if cached results of this query already exist.
            $query_hash = md5( $query );

            // Maybe store a transient of the count values.
            $cache = apply_filters( 'woocommerce_layered_nav_count_maybe_cache', true );
            if ( true === $cache ) {
                $cached_counts = (array) get_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ) );
            } else {
                $cached_counts = array();
            }

            if ( ! isset( $cached_counts[ $query_hash ] ) ) {
                $results                      = $wpdb->get_results( $query, ARRAY_A ); // @codingStandardsIgnoreLine
                $counts                       = array_map( 'absint', wp_list_pluck( $results, 'term_count', 'term_count_id' ) );
                $cached_counts[ $query_hash ] = $counts;
                if ( true === $cache ) {
                    set_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ), $cached_counts, DAY_IN_SECONDS );
                }
            }

            return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
        } else {
            return wc_get_container()->get( Filterer::class )->get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type );
        }
    }

    /**
     * Show list based layered nav.
     *
     * @param  array  $terms
     * @param  string $taxonomy
     * @param  string $query_type
     * @return bool Will nav display?
     */
    protected function layered_nav_list( $terms, $taxonomy, $query_type, $instance ) {
        $labels            = isset( $instance['labels'] ) ? $instance['labels'] : 'on';
        $tooltips          = isset( $instance['tooltips'] ) ? $instance['tooltips'] : 'off';
        $size              = isset( $instance['size'] ) ? $instance['size'] : 'normal';
        $display           = isset( $instance['display'] ) ? $instance['display'] : 'list';
        $scroll_for_widget = haru_get_option( 'haru_archive_product_widget_scroll', true );

        // $is_brand = ( haru_get_opt( 'brands_attribute' ) == $taxonomy );

        $class  = 'show-labels-' . $labels;
        $class .= ' swatches-' . $size;
        $class .= ' swatches-display-' . $display;
        // $class .= ( $is_brand ) ? ' swatches-brands' : '';

        // List display
        if ( $scroll_for_widget == true ) {
        //     echo '<div class="haru-scroll">';
            $class .= ' haru-scroll-widget';
        }
        echo '<ul class="' . esc_attr( $class ) . '">';

        $term_counts = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );

        $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
        $found              = false;

        foreach ( $terms as $term ) {
            $current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
            $option_is_set  = in_array( $term->slug, $current_values );
            $count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

            // Skip the term for the current archive
            if ( $this->get_current_term_id() === $term->term_id ) {
                continue;
            }

            // Only show options with count > 0
            if ( 0 < $count ) {
                $found = true;
            } elseif ( 0 === $count && ! $option_is_set ) {
                continue;
            }

            $filter_name    = 'filter_' . sanitize_title( str_replace( 'pa_', '', $taxonomy ) );
            $current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( $_GET[ $filter_name ] ) ) : array();
            $current_filter = array_map( 'sanitize_title', $current_filter );

            if ( ! in_array( $term->slug, $current_filter ) ) {
                $current_filter[] = $term->slug;
            }

            $base_link = $this->get_page_base_url();
            $link      = remove_query_arg( $filter_name, $base_link );

            // Add current filters to URL.
            foreach ( $current_filter as $key => $value ) {
                // Exclude query arg for current term archive term.
                if ( $value === $this->get_current_term_slug() ) {
                    unset( $current_filter[ $key ] );
                }

                // Exclude self so filter can be unset on click.
                if ( $option_is_set && $value === $term->slug ) {
                    unset( $current_filter[ $key ] );
                }
            }

            if ( ! empty( $current_filter ) ) {
                asort( $current_filter );
                $link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

                // Add Query type Arg to URL.
                if ( 'or' === $query_type && ! ( 1 === count( $current_filter ) && $option_is_set ) ) {
                    $link = add_query_arg( 'query_type_' . wc_attribute_taxonomy_slug( $taxonomy ), 'or', $link );
                }
                $link = str_replace( '%2C', ',', $link );
            }

            // Add swatches block
            $swatch_div   = $swatch_style = '';
            // $swatch_color = get_term_meta( $term->term_id, 'color', true );
            // $swatch_image = get_term_meta( $term->term_id, 'image', true );
            $swatch_text  = get_term_meta( $term->term_id, 'not_dropdown', true );
            
            $swatch_color  = haru_get_term_meta( $term->term_id, 'product_attribute_color', true );
            $is_dual_color  = haru_get_term_meta( $term->term_id, 'product_attribute_color_dual', true );
            $secondary_color  = haru_get_term_meta( $term->term_id, 'product_attribute_color_2', true );

            $swatch_image = haru_get_term_meta( $term->term_id, 'product_attribute_image', true );

            $class          = $option_is_set ? 'chosen' : '';
            $filter_classes = '';

            $taxonomy = $term->taxonomy;
            $attribute_id = wc_attribute_taxonomy_id_by_name($taxonomy);
            $attribute = wc_get_attribute($attribute_id);
            $attribute_type = $attribute->type;

            if ( ! empty( $swatch_color ) && ( $attribute_type == 'color' ) ) {
                $class          .= ' with-swatch-color';
                $filter_classes .= ' with-bg';
                if ( $is_dual_color == '1' ) {
                    $swatch_style = 'background: linear-gradient(-45deg, ' . $swatch_color . ' 0%, ' . $swatch_color . ' 50%, ' . $secondary_color . ' 50%, ' . $secondary_color . ' 100%);';
                } else {
                    list( $r, $g, $b ) = sscanf( $swatch_color, "#%02x%02x%02x" );
                    $swatch_style = 'background-color: ' . $swatch_color . ';';
                }
            }

            if ( $swatch_image && ( $attribute_type == 'image' ) ) {
                $swatch_image = wp_get_attachment_image_url( $swatch_image, 'full' );

                $class          .= ' with-swatch-image';
                $filter_classes .= ' with-bg';
                $swatch_style    = 'background-image: url(' . $swatch_image . ');';
            }

            if ( ! empty( $swatch_text ) ) {
                $class          .= ' with-swatch-text';
                $filter_classes .= ' with-text';
            }

            if ( $tooltips == 'on' ) {
                $filter_classes .= ' attr-tooltip';
            }

            if ( ! empty( $swatch_style ) ) {
                $swatch_div = '<span style="' . $swatch_style . '" class="' . esc_attr( $filter_classes ) . '"><span class="haru-tooltip button-tooltip">' . esc_html( $term->name ) . '</span></span>';
            }

            echo '<li class="wc-layered-nav-term ' . esc_attr( $class ) . '">';

            echo ( true == $option_is_set || $count > 0 ) ? '<a rel="nofollow noopener" href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '" class="layered-nav-link">' : '<span>';

            echo '<span class="swatch-inner">';

            if ( $swatch_div ) {
                echo '<span class="filter-swatch">' . $swatch_div . '</span>';
            }

            echo '<span class="layer-term-name">' . esc_html( $term->name ) . '</span>';

            echo '</span>';

            echo ( true == $option_is_set || $count > 0 ) ? '</a>' : '</span>';

            echo ' <span class="count">' . absint( $count ) . '</span></li>';
        }

        echo '</ul>';
        // if ( $scroll_for_widget ) {
        //     echo '</div>';
        // }

        return $found;
    }

}

if ( ! function_exists( 'haru_register_widget_woo_layered_nav' ) ) {
    function haru_register_widget_woo_layered_nav() {
        if ( class_exists( 'WooCommerce', true ) ) {
            register_widget( 'Haru_Woo_Layered_Nav_Widget' );
        }
    }

    add_action( 'widgets_init', 'haru_register_widget_woo_layered_nav' );
}
