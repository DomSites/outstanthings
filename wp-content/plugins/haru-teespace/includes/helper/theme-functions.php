<?php
/**
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

use \Haru_TeeSpace\Classes\Haru_Template;

// Product Variations
if ( ! function_exists( 'haru_woocommerce_variable_add_to_cart' ) ) {

  /**
   * Output the variable product add to cart area.
   */
  function haru_woocommerce_variable_add_to_cart() {
    global $product;

    // Enqueue variation scripts.
    wp_enqueue_script( 'wc-add-to-cart-variation' );

    // Get Available variations?
    $get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

    // Load the template.
    echo Haru_Template::haru_get_template( 'woo-product-variations/variable.php', 
      array(
        'available_variations' => $get_variations ? $product->get_available_variations() : false,
        'attributes'           => $product->get_variation_attributes(),
        'selected_attributes'  => $product->get_default_attributes(),
      ) );

    // wc_get_template(
    //   'single-product/add-to-cart/variable.php',
    //   array(
    //     'available_variations' => $get_variations ? $product->get_available_variations() : false,
    //     'attributes'           => $product->get_variation_attributes(),
    //     'selected_attributes'  => $product->get_default_attributes(),
    //   )
    // );
  }
}

if ( ! function_exists( 'haru_woocommerce_variable_add_to_cart_list' ) ) {

  /**
   * Output the variable product add to cart area.
   */
  function haru_woocommerce_variable_add_to_cart_list() {
    global $product;

    // Enqueue variation scripts.
    wp_enqueue_script( 'wc-add-to-cart-variation' );

    // Get Available variations?
    $get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

    // Load the template.
    echo Haru_Template::haru_get_template( 'woo-product-variations/variable-list.php', 
      array(
        'available_variations' => $get_variations ? $product->get_available_variations() : false,
        'attributes'           => $product->get_variation_attributes(),
        'selected_attributes'  => $product->get_default_attributes(),
      ) );
  }
}

// Remove the comment reply button from it's default location
if ( ! function_exists( 'haru_remove_comment_reply_link' ) ) {
  function haru_remove_comment_reply_link( $link ) {
    return '';
  }

  add_filter( 'cancel_comment_reply_link', 'haru_remove_comment_reply_link', 10 );
}

// Add the comment reply button to the end of the comment form.
// Remove the haru_remove_comment_reply_link filter first so that it will actually output something.
if ( ! function_exists( 'haru_after_comment_form' ) ) {
  function haru_after_comment_form( $post_id ) {
    remove_filter( 'cancel_comment_reply_link', 'haru_remove_comment_reply_link', 10 );
    cancel_comment_reply_link( esc_html__( 'Cancel Reply', 'haru-teespace' ) );
  }

  add_action( 'comment_form', 'haru_after_comment_form', 99 );
}

if ( ! function_exists( 'haru_get_cancel_comment_reply_link' ) ) {
  function haru_get_cancel_comment_reply_link( $text ) {
    if ( empty( $text ) ) {
      $text = esc_html__( 'Click here to cancel reply.', 'haru-teespace' );
    }
   
    $style = isset( $_GET['replytocom'] ) ? '' : ' style="display:none;"';
    $link  = esc_html( remove_query_arg( array( 'replytocom', 'unapproved', 'moderation-hash' ) ) ) . '#respond';
   
    $formatted_link = '<a rel="nofollow" class="submit haru-button haru-button--size-medium haru-button--border-primary haru-button--round-normal" id="cancel-comment-reply-link" href="' . $link . '"' . $style . '>' . $text . '</a>';

    return $formatted_link;
  }
}


// Dokan WooCommerce Multivendor
if ( ! function_exists( 'haru_dokan_social_icons' ) ) {
  function haru_dokan_social_icons( $fields ) {
    $fields = [
      'fb' => [
        'icon'  => 'facebook-f',
        'title' => __( 'Facebook', 'haru-teespace' ),
      ],
      'twitter' => [
        'icon'  => 'twitter',
        'title' => __( 'Twitter', 'haru-teespace' ),
      ],
      'pinterest' => [
        'icon'  => 'pinterest-p',
        'title' => __( 'Pinterest', 'haru-teespace' ),
      ],
      'linkedin' => [
        'icon'  => 'linkedin-in',
        'title' => __( 'LinkedIn', 'haru-teespace' ),
      ],
      'youtube' => [
        'icon'  => 'youtube',
        'title' => __( 'Youtube', 'haru-teespace' ),
      ],
      'instagram' => [
        'icon'  => 'instagram',
        'title' => __( 'Instagram', 'haru-teespace' ),
      ],
      'flickr' => [
        'icon'  => 'flickr',
        'title' => __( 'Flickr', 'haru-teespace' ),
      ],
    ];

    return $fields;
  }

  add_filter( 'dokan_profile_social_fields', 'haru_dokan_social_icons' );
}


if ( ! function_exists( 'haru_hex2rgba' ) ) {
  function haru_hex2rgba( $color, $opacity = false ) {

    $default = 'rgb(0,0,0)';

    // Return default if no color provided
    if ( empty( $color ) )
      return $default; 

    // Sanitize $color if "#" is provided 
    if ( $color[0] == '#' ) {
      $color = substr( $color, 1 );
    }

    // Check if color has 6 or 3 characters and get values
    if ( strlen( $color ) == 6 ) {
      $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
      $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
      return $default;
    }

    // Convert hexadec to rgb
    $rgb =  array_map( 'hexdec', $hex );

    // Check if opacity is set(rgba or rgb)
    if ( $opacity ) {
      if ( abs( $opacity ) > 1 )
        $opacity = 1.0;

      $output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
    } else {
      $output = 'rgb(' . implode( ",", $rgb ) . ')';
    }

    // Return rgb(a) color string
    return $output;
  }
}
