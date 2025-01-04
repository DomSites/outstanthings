<?php
/**
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

defined( 'ABSPATH' ) || exit;

class Haru_Woo_Stock_Status_Widget extends Haru_TeeSpace_Widget {

    /**
     * Constructor.
     */

    public function __construct() {
        $this->widget_id          = 'haru_widget_woo_stock_status';
        $this->widget_name        = esc_html__( 'Haru WooCommerce Stock Status', 'haru-teespace' );
        $this->widget_description = esc_html__( 'Widget filter in-stock and on-sale products.', 'haru-teespace' );
        $this->widget_cssclass    = 'widget-woo-stock-status';
        $this->cached             = false;

        $this->settings = array(
            'title'         => array(
                'type'  => 'text',
                'std'   => esc_html__( 'Stock status', 'haru-teespace' ),
                'label' => esc_html__( 'Title', 'haru-teespace' )
            ),
            'instock' => array(
                'type'   => 'checkbox',
                'std'    => '1',
                'label'   => esc_html__( 'In Stock filter', 'haru-teespace' ),
            ),
            'outofstock' => array(
                'type'   => 'checkbox',
                'std'    => '1',
                'label'   => esc_html__( 'Out Of Stock filter', 'haru-teespace' ),
            ),
            'onbackorder' => array(
                'type'   => 'checkbox',
                'std'    => '0',
                'label'   => esc_html__( 'On Back Order filter', 'haru-teespace' ),
            ),
            'onsale' => array(
                'type'   => 'checkbox',
                'std'    => '1',
                'label'   => esc_html__( 'On Sale filter', 'haru-teespace' ),
            ),
        );

        $this->hooks();

        parent::__construct();
    }

    function hooks() {
        add_action( 'woocommerce_product_query', array( $this, 'show_in_stock_products' ) );
        add_filter( 'loop_shop_post_in', array( $this, 'show_on_sale_products' ) );
    }

    public function show_in_stock_products( $query ) {
        $current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
        if ( in_array( 'instock', $current_stock_status ) ) {
            $meta_query = array(
                'relation' => 'AND',
                array(
                    'key'     => '_stock_status',
                    'value'   => 'instock',
                    'compare' => '=',
                ),
            );

            $query->set( 'meta_query', array_merge( WC()->query->get_meta_query(), $meta_query ) );
        }

        if ( in_array( 'outofstock', $current_stock_status ) ) {
            $meta_query = array(
                'relation' => 'AND',
                array(
                    'key'     => '_stock_status',
                    'value'   => 'outofstock',
                    'compare' => '=',
                ),
            );

            $query->set( 'meta_query', array_merge( WC()->query->get_meta_query(), $meta_query ) );
        }

        if ( in_array( 'onbackorder', $current_stock_status ) ) {
            $meta_query = array(
                'relation' => 'AND',
                array(
                    'key'     => '_stock_status',
                    'value'   => 'onbackorder',
                    'compare' => '=',
                ),
            );

            $query->set( 'meta_query', array_merge( WC()->query->get_meta_query(), $meta_query ) );
        }
    }

    public function show_on_sale_products( $ids ) {
        $current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
        if ( in_array( 'onsale', $current_stock_status ) ) {
            $ids = array_merge( $ids, wc_get_product_ids_on_sale() );
        }

        return $ids;
    }

    function get_link( $status ) {
        $base_link            = haru_shop_page_link( true );
        $link                 = remove_query_arg( 'stock_status', $base_link );
        $current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
        $option_is_set        = in_array( $status, $current_stock_status );

        if ( ! in_array( $status, $current_stock_status ) ) {
            $current_stock_status[] = $status;
        }

        foreach ( $current_stock_status as $key => $value ) {
            if ( $option_is_set && $value === $status ) {
                unset( $current_stock_status[ $key ] );
            }
        }

        if ( $current_stock_status ) {
            asort( $current_stock_status );
            $link = add_query_arg( 'stock_status', implode( ',', $current_stock_status ), $link );
            $link = str_replace( '%2C', ',', $link );
        }

        return $link;
    }

    public function widget( $args, $instance ) {
        ob_start();
        extract( $args );

        echo wp_kses_post( $args['before_widget'] );

        if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance ) ) {
            echo wp_kses_post( $args['before_title'] ) . $title . wp_kses_post( $args['after_title'] );
        }
        
        $current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
        ?>
        <ul>
            <?php if ( $instance['onsale'] ) : ?>
                <li>
                    <a href="<?php echo esc_url( $this->get_link( 'onsale' ) ); ?>" class="<?php echo in_array( 'onsale', $current_stock_status ) ? 'haru-active' : ''; ?>">
                        <?php esc_html_e( 'On sale', 'haru-teespace' ); ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ( $instance['instock'] ) : ?>
                <li>
                    <a href="<?php echo esc_url( $this->get_link( 'instock' ) ); ?>" class="<?php echo in_array( 'instock', $current_stock_status ) ? 'haru-active' : ''; ?>">
                        <?php esc_html_e( 'In stock', 'haru-teespace' ); ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ( $instance['outofstock'] ) : ?>
                <li>
                    <a href="<?php echo esc_url( $this->get_link( 'outofstock' ) ); ?>" class="<?php echo in_array( 'outofstock', $current_stock_status ) ? 'haru-active' : ''; ?>">
                        <?php esc_html_e( 'Out of stock', 'haru-teespace' ); ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ( $instance['onbackorder'] ) : ?>
                <li>
                    <a href="<?php echo esc_url( $this->get_link( 'onbackorder' ) ); ?>" class="<?php echo in_array( 'onbackorder', $current_stock_status ) ? 'haru-active' : ''; ?>">
                        <?php esc_html_e( 'On back order', 'haru-teespace' ); ?>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <?php

        echo wp_kses_post( $args['after_widget'] );

        $content = ob_get_clean();
        echo $content;
    }

}

if ( ! function_exists( 'haru_register_widget_woo_stock_status' ) ) {
    function haru_register_widget_woo_stock_status() {
        if ( class_exists( 'WooCommerce', true ) ) {
            register_widget( 'Haru_Woo_Stock_Status_Widget' );
        }
    }

    add_action( 'widgets_init', 'haru_register_widget_woo_stock_status' );
}
