<?php
/**
 * @package    HaruTheme/Haru PrintSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/


defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Haru_Woo_Buy_Now_Button' ) ) {
    class Haru_Woo_Buy_Now_Button {
        protected static $_instance = null;

        protected function __construct() {
            $this->includes();
            $this->hooks();
            $this->init();

            do_action( 'haru_woo_buy_now_button', $this );
        }

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        protected function includes() {
            // Do something
            // Maybe change action hook of theme
        }

        protected function hooks() {
            add_action( 'template_redirect', array( $this, 'buy_now_button_submit' ) );

            add_filter( 'woocommerce_post_class', array( $this, 'haru_buy_now_product_class' ), 99, 2 );

            if ( ! function_exists( 'haru_get_option' ) ) {
                return;
            }

            $buy_now = haru_get_option( 'haru_product_buy_now', '0' );

            if ( $buy_now == '1' ) {
                $this->button_position_single();

                // Add button for archive product
                $buy_now_archive = haru_get_option( 'haru_product_buy_now_archive', '0' );

                if ( $buy_now_archive == '1' ) {
                    $this->button_position_archive();
                }
            }
        }

        protected function init() {
            // Do something
        }

        /**
         * Button Single Position
         */
        public function button_position_single() {
            // Add button for single
            $position_single = apply_filters( 'haru_woo_buy_now_single_position', haru_get_option( 'haru_woo_buy_now_single_position', 'after_add_to_cart' ) );

            switch ( $position_single ) {
                case 'before_add_to_cart':
                    add_action( 'woocommerce_after_add_to_cart_quantity', array( $this, 'buy_now_button_single' ) );
                    break;

                case 'after_add_to_cart':
                    add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'buy_now_button_single' ) );
                    break;
            }
        }

        /**
         * Button Archive Position
         */
        public function button_position_archive() {
            $position_archive = apply_filters( 'haru_woo_buy_now_position_archive', haru_get_option( 'haru_woo_buy_now_position_archive', 'after_add_to_cart' ) );

            switch ( $position_archive ) {
                case 'after_title':
                    add_action( 'woocommerce_shop_loop_item_title', array( $this, 'buy_now_button_archive' ), 11 );
                    break;

                case 'after_rating':
                    add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'buy_now_button_archive' ), 6 );
                    break;

                case 'after_price':
                    add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'buy_now_button_archive' ), 11 );
                    break;

                case 'before_add_to_cart':
                    add_action( 'woocommerce_after_shop_loop_item', array( $this, 'buy_now_button_archive' ), 9 );
                    break;

                case 'after_add_to_cart':
                    add_action( 'woocommerce_after_shop_loop_item', array( $this, 'buy_now_button_archive' ), 11 );
                    break;
            }
        }

        /**
         * Button Redirect Location
         */
        public function button_redirect_location( $product_id ) {
            $redirect = apply_filters( 'haru_buy_now_redirect', haru_get_option( 'haru_woo_buy_now_redirect', 'checkout' ) );
            $custom_url = apply_filters( 'haru_buy_now_redirect_custom_url', haru_get_option( 'haru_woo_buy_now_custom_redirect', '/' ) );
            $redirect_url = '';

            switch ( $redirect ) {
                case 'checkout':
                    $redirect_url = wc_get_checkout_url();
                    break;

                case 'cart':
                    $redirect_url = wc_get_cart_url();
                    break;

                case 'custom':
                    $redirect_url = $custom_url;
                    break;

                default:
                    $redirect_url = wc_get_checkout_url();
                    break;
            }

            return $redirect_url;
        }

        /**
         * Button Markup for Single Product Page
         */
        public function buy_now_button_single() {
            global $product;

            if ( apply_filters( 'haru_woo_buy_now_button_disable', false, $product ) ) {
                return;
            }

            if ( ! $this->haru_is_valid_product( $product, 'single' ) ) {
                return;
            }

            $product_id        = $product->get_ID();
            $position_single   = apply_filters( 'haru_woo_buy_now_single_position', haru_get_option( 'haru_woo_buy_now_single_position', 'after_add_to_cart' ) );
            $button_class      = apply_filters( 'haru_woo_buy_now_button_class_single', 'single_add_to_cart_button button alt haru-buy-now-btn' . ' position-' . $position_single, $product_id );
            $button_text       = apply_filters( 'haru_woo_buy_now_button_text_single', esc_html__( 'Buy now', 'haru-teespace' ), $product_id );
            $redirect_location = apply_filters( 'haru_woo_buy_now_redirect_location', haru_get_option( 'haru_woo_buy_now_redirect', 'checkout' ), $product_id );
            $custom_url        = apply_filters( 'haru_woo_buy_now_redirect_custom_url', haru_get_option( 'haru_woo_buy_now_custom_redirect', '/' ), $product_id );

            do_action( 'haru_woo_buy_now_button_single_before_load', $product );

            if ( ! empty( $custom_url ) && 'custom' === $redirect_location ) {
                // For custom link
                return printf( '<a href="%s" target="_blank" class="%s" rel="nofollow">%s</a>', esc_url( $custom_url ), esc_attr( $button_class ), esc_html__( $button_text, 'haru-teespace' ) );
            }

            return printf( '<button type="submit" name="haru-buy-now" value="%d" class="%s">%s</button>', $product_id, esc_attr( $button_class ), esc_html__( $button_text, 'haru-teespace' ) );
        }

        /**
         * Button Markup for Shop/Archive Page
         */
        public function buy_now_button_archive() {
            global $product;

            if ( apply_filters( 'woo_buy_now_button_disable', false, $product ) ) {
                return;
            }

            if ( ! $this->haru_is_valid_product( $product, 'archive' ) ) {
                return;
            }

            if ( ! $product->is_purchasable() || ! $product->is_in_stock() ) {
                return;
            }

            $product_id        = $product->get_ID();
            $position_archive = apply_filters( 'haru_woo_buy_now_archive_position', haru_get_option( 'haru_woo_buy_now_archive_position', 'after_price' ) );
            $button_class      = apply_filters( 'haru_woo_buy_now_button_class_archive', 'haru-btn-buy-now button product_type_simple add_to_cart_button' . ' position-' . $position_archive, $product_id );
            $button_text       = apply_filters( 'haru_woo_buy_now_button_text_archive', esc_html__( 'Buy now', 'haru-teespace' ), $product_id );
            $quantity          = 1; // TODO change to option
            $redirect_location = apply_filters( 'haru_woo_buy_now_redirect_location', haru_get_option( 'haru_woo_buy_now_redirect', 'checkout' ), $product_id );
            $custom_url        = apply_filters( 'haru_woo_buy_now_redirect_custom_url', haru_get_option( 'haru_woo_buy_now_custom_redirect', '/' ), $product_id );

            // Check quantity is not bigger then stock
            if ( $product->get_manage_stock() ) {
                $stock_quantity        = $product->get_stock_quantity(); // get product stock quantity
                $is_backorders_allowed = $product->backorders_allowed(); // get product backorder allowed

                if ( $stock_quantity < $quantity && ! $is_backorders_allowed ) {
                    $quantity = $stock_quantity;
                }
            }

            do_action( 'haru_woo_buy_now_button_archive_before_load', $product );

            if ( $product->is_type( 'simple' ) ) {
                // For custom link
                if ( ! empty( $custom_url ) && 'custom' === $redirect_location ) {
                    return printf( '<a href="%s" target="_blank" data-quantity="%s" class="%s" data-product_id="%s" rel="nofollow">%s</a>', esc_url( $custom_url ), intval( $quantity ), esc_attr( $button_class ), $product_id, esc_html__( $button_text, 'haru-teespace' ) );
                }

                $redirect_url = $this->button_redirect_location( $product_id );

                $redirect_url = add_query_arg(
                    array(
                        'haru-buy-now' => $product_id,
                        'quantity' => intval( $quantity )
                    ),
                    $redirect_url
                );

                return printf( '<a href="%s" data-quantity="%s" class="%s" data-product_id="%s" rel="nofollow">%s</a>', esc_url( $redirect_url ), intval( $quantity ), esc_attr( $button_class ), $product_id, esc_html__( $button_text, 'haru-teespace' ) );
            }

            return;
        }

        public function haru_is_valid_product( $product, $context = 'archive' ) {
            if ( ! function_exists( 'haru_get_option' ) ) {
                return;
            }

            $valid = false;

            if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
                return false;
            }

            if ( $context === 'single' ) {
                if ( $product->is_in_stock() && $product->is_purchasable() ) {
                    $valid = true;
                }
            } else {
                if ( $product->is_type( 'simple' ) && $product->is_in_stock() && $product->is_purchasable() ) {
                    $valid = true;
                }
            }

            // check cats
            $selected_cats = haru_get_option( 'haru_woo_buy_now_cats', [] );

            if ( ! empty( $selected_cats ) && ( $selected_cats[0] !== '0' ) ) {
                if ( ! has_term( $selected_cats, 'product_cat', $product->get_id() ) ) {
                    $valid = false;
                }
            }

            return apply_filters( 'haru_buy_now_is_valid_product', $valid, $product );
        }

        /**
         * Button Submit Action Handler for Single Product Page Button
         */
        public function buy_now_button_submit() {
            if ( ! isset( $_REQUEST['haru-buy-now'] ) ) {
                return false;
            }

            $quantity     = isset( $_REQUEST['quantity'] ) ? absint( $_REQUEST['quantity'] ) : 1;
            $product_id   = isset( $_REQUEST['haru-buy-now'] ) ? absint( $_REQUEST['haru-buy-now'] ) : '';
            $variation_id = isset( $_REQUEST['variation_id'] ) ? absint( $_REQUEST['variation_id'] ) : '';
            $variation    = [];
            $redirect_url = $this->button_redirect_location( $product_id );

            if ( $product_id ) {
                if ( $variation_id ) {
                    // For Variable Product
                    if ( isset( $_REQUEST ) && ! empty( $_REQUEST ) ) {
                        foreach ( $_REQUEST as $name => $value ) {
                            if ( str_starts_with( $name, 'attribute_' ) ) {
                                $variation[ $name ] = esc_html( $value );
                            }
                        }
                    }
                } else {
                    WC()->cart->add_to_cart( $product_id, $quantity );
                }

                wp_safe_redirect( $redirect_url );
                exit;
            }
        }

        public function haru_buy_now_product_class( $classes, $product ) {
            if ( ! function_exists( 'haru_get_option' ) ) {
                return;
            }

            if ( haru_get_option( 'haru_woo_buy_now_hide_atc', 'no' ) == '1' ) {
                // Single Product
                if ( $product && is_product( $product ) ) {
                    $classes[] = 'haru-buy-now-hide-atc';
                }

                // Archive Product
                if ( $product && $this->haru_is_valid_product( $product ) ) {
                    $classes[] = 'haru-buy-now-hide-atc';
                }
            }

            return $classes;
        }
    }
}

/**
 * Returns the main instance.
 */
function haru_woo_buy_now_button() {
    if ( ! class_exists( 'WooCommerce', false ) ) {
        return false;
    }

    return Haru_Woo_Buy_Now_Button::instance();
}

add_action( 'wp_loaded', 'haru_woo_buy_now_button' ); // plugins_loaded