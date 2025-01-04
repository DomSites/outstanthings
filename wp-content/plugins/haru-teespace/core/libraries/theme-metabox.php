<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com     
*/

// https://github.com/orenhavshush/cmb2-post-format-show_on-filter
// Post Video Metabox
if ( ! function_exists( 'haru_teespace_field_metaboxes_post_video' ) ) {
  function haru_teespace_field_metaboxes_post_video() {

    $prefix = 'haru_';

    $cmb_post_video = new_cmb2_box( array(
      'id'            => $prefix . 'post_metabox_video',
      'title'         => esc_html__( 'Post Format Video Metabox', 'haru-teespace' ),
      'object_types'  => array( 'post' ), // Post type
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => true, // Show field names on the left
    ) );

    $cmb_post_video->add_field( array(
      'id'   => $prefix . 'post_video_source',
      'name' => esc_html__( 'Video Source', 'haru-teespace' ), 
      'desc' => esc_html__( 'Insert video URL or Embeded Code for Post Video', 'haru-teespace' ), 
      'type'        => 'textarea',
      'sanitization_cb' => false,
    ) );
  }

  add_action( 'cmb2_admin_init', 'haru_teespace_field_metaboxes_post_video' );
}

// Post Audio Metabox
if ( ! function_exists( 'haru_teespace_field_metaboxes_post_audio' ) ) {
  function haru_teespace_field_metaboxes_post_audio() {

    $prefix = 'haru_';

    $cmb_post_audio = new_cmb2_box( array(
      'id'            => $prefix . 'post_metabox_audio',
      'title'         => esc_html__( 'Post Format Audio Metabox', 'haru-teespace' ),
      'object_types'  => array( 'post' ), // Post type
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => true, // Show field names on the left
    ) );

    $cmb_post_audio->add_field( array(
      'id'   => $prefix . 'post_audio_url',
      'name' => esc_html__( 'Audio Source', 'haru-teespace' ), 
      'desc' => esc_html__( 'Insert Audio URL or Embeded Code for Post Audio', 'haru-teespace' ), 
      'type'        => 'textarea',
      'sanitization_cb' => false,
    ) );
  }

  add_action( 'cmb2_admin_init', 'haru_teespace_field_metaboxes_post_audio' );
}

// Post Link Metabox
if ( ! function_exists( 'haru_teespace_field_metaboxes_post_link' ) ) {
  function haru_teespace_field_metaboxes_post_link() {

    $prefix = 'haru_';

    $cmb_post_link = new_cmb2_box( array(
      'id'            => $prefix . 'post_metabox_link',
      'title'         => esc_html__( 'Post Format Link Metabox', 'haru-teespace' ),
      'object_types'  => array( 'post' ), // Post type
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => true, // Show field names on the left
    ) );

    $cmb_post_link->add_field( array(
      'id'      => $prefix . 'post_link_url',
      'name'    => esc_html__( 'Url', 'haru-teespace' ),
      'desc'    => esc_html__( 'Insert Url for Post Link.', 'haru-teespace' ),
      'type'    => 'text_url',
    ) );

    $cmb_post_link->add_field( array(
      'id'      => $prefix . 'post_link_text',
      'name'    => esc_html__( 'Text', 'haru-teespace' ),
      'desc'    => esc_html__( 'Insert Text for Post Link.', 'haru-teespace' ),
      'type'    => 'text',
    ) );
  }

  add_action( 'cmb2_admin_init', 'haru_teespace_field_metaboxes_post_link' );
}

// Post Gallery Metabox
if ( ! function_exists( 'haru_teespace_field_metaboxes_post_gallery' ) ) {
  function haru_teespace_field_metaboxes_post_gallery() {

    $prefix = 'haru_';

    $cmb_post_link = new_cmb2_box( array(
      'id'            => $prefix . 'post_metabox_gallery',
      'title'         => esc_html__( 'Post Format Gallery Metabox', 'haru-teespace' ),
      'object_types'  => array( 'post' ), // Post type
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => true, // Show field names on the left
    ) );

    $cmb_post_link->add_field( array(
      'id'      => $prefix . 'post_gallery_images',
      'name'    => esc_html__( 'Images', 'haru-teespace' ),
      'desc'    => esc_html__( 'Set images for Post Gallery.', 'haru-teespace' ),
      'type'    => 'file_list',
      'query_args' => array( 'type' => 'image' ),
    ) );
  }

  add_action( 'cmb2_admin_init', 'haru_teespace_field_metaboxes_post_gallery' );
}

// Post Quote Metabox
if ( ! function_exists( 'haru_teespace_field_metaboxes_post_quote' ) ) {
  function haru_teespace_field_metaboxes_post_quote() {

    $prefix = 'haru_';

    $cmb_post_quote = new_cmb2_box( array(
      'id'            => $prefix . 'post_metabox_quote',
      'title'         => esc_html__( 'Post Format Quote Metabox', 'haru-teespace' ),
      'object_types'  => array( 'post' ), // Post type
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => true, // Show field names on the left
    ) );

    $cmb_post_quote->add_field( array(
      'id'      => $prefix . 'post_quote_text',
      'name'    => esc_html__( 'Text', 'haru-teespace' ),
      'desc'    => esc_html__( 'Insert Text for Post Quote.', 'haru-teespace' ),
      'type'        => 'textarea',
        'sanitization_cb' => false,
    ) );

    $cmb_post_quote->add_field( array(
      'id'      => $prefix . 'post_quote_author',
      'name'    => esc_html__( 'Author', 'haru-teespace' ),
      'desc'    => esc_html__( 'Insert Author for Post Quote.', 'haru-teespace' ),
      'type'    => 'text',
    ) );

    $cmb_post_quote->add_field( array(
      'id'      => $prefix . 'post_quote_url',
      'name'    => esc_html__( 'Url', 'haru-teespace' ),
      'desc'    => esc_html__( 'Insert Url for Post Quote.', 'haru-teespace' ),
      'type'    => 'text_url',
    ) );
  }

  add_action( 'cmb2_admin_init', 'haru_teespace_field_metaboxes_post_quote' );
}

// Get Sidebar List
if ( ! function_exists( 'haru_get_sidebar_list_options' ) ) {
  function haru_get_sidebar_list_options() {

    if ( ! is_admin() ) {
      return array();
    }

    $sidebar_list = array();

    foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
      $sidebar_list[ $sidebar['id'] ] = ucwords( $sidebar['name'] );
    }

    return $sidebar_list;
  }
}

// Get Header List
if ( ! function_exists( 'haru_teespace_get_header_list_options' ) ) {
  function haru_teespace_get_header_list_options() {

    if ( !is_admin() ) {
      return array();
    }

    $query_args  = array(
      'post_type'         => 'haru_header',
      'post_status'       => 'publish',
      'posts_per_page'    => -1,
    );

    $page_query = new WP_Query( $query_args );

    $page_list = array();

    if ( $page_query->have_posts() ) {
      while($page_query->have_posts()) : $page_query->the_post();
        $key = get_the_ID();
        $page_list[$key] = get_the_title();
      endwhile;
    }

    return $page_list;
  }
}

// Get Footer List
if ( ! function_exists( 'haru_teespace_get_footer_list_options' ) ) {
  function haru_teespace_get_footer_list_options() {

    if ( !is_admin() ) {
      return array();
    }

    $query_args  = array(
      'post_type'         => 'haru_footer',
      'post_status'       => 'publish',
      'posts_per_page'    => -1,
    );

    $page_query = new WP_Query( $query_args );

    $page_list = array();

    if ( $page_query->have_posts() ) {
      while($page_query->have_posts()) : $page_query->the_post();
        $key = get_the_ID();
        $page_list[$key] = get_the_title();
      endwhile;
    }

    return $page_list;
  }
}

if ( ! function_exists( 'haru_teespace_field_metaboxes_header' ) ) {
  function haru_teespace_field_metaboxes_header() {
    $prefix = 'haru_header_';

    $cmb_header = new_cmb2_box( array(
      'id'            => $prefix . 'metabox',
      'title'         => esc_html__( 'Header Metabox', 'haru-teespace' ),
      'object_types'  => array( 'haru_header' ), // Post type
    ) );

    $cmb_header->add_field( array(
      'name'      => esc_html__( 'Is Header Sidebar', 'haru-teespace' ),
      'desc'      => esc_html__( 'This option will set your Header with Sidebar layout.', 'haru-teespace' ),
      'id'      => $prefix . 'sidebar',
      'type'        => 'radio_inline',
      'options'     => array(
        '1'     => esc_html__( 'Yes', 'haru-teespace' ),
        '0'     => esc_html__( 'No', 'haru-teespace' )
      ),
      'default' => '0',
    ) );

    $cmb_header->add_field( array(
      'name'      => esc_html__( 'Header Sidebar has Fixed Row', 'haru-teespace' ),
      'desc'      => esc_html__( 'This option will use when Header Sidebar has fixed row with class .header-sidebar-fixed.', 'haru-teespace' ),
      'id'      => $prefix . 'sidebar_fixed_row',
      'type'        => 'radio_inline',
      'options'     => array(
        '1'     => esc_html__( 'Yes', 'haru-teespace' ),
        '0'     => esc_html__( 'No', 'haru-teespace' )
      ),
      'default' => '0',
      'attributes' => array(
        'required'                => true, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'sidebar',
        'data-conditional-value'  => wp_json_encode( array( '1' ) ),
      ),
    ) );

    $cmb_header->add_field( array(
      'name'      => esc_html__( 'Header Sidebar Hidden', 'haru-teespace' ),
      'desc'      => esc_html__( 'Hidden Header Sidebar on Mobile or Tablet. You should use Normal Header on Mobile Devices.', 'haru-teespace' ),
      'id'      => $prefix . 'sidebar_hidden',
      'type'        => 'radio_inline',
      'options'     => array(
        'mobile'     => esc_html__( 'Mobile', 'haru-teespace' ),
        'tablet'     => esc_html__( 'Tablet', 'haru-teespace' )
      ),
      'default' => 'tablet',
      'attributes' => array(
        'required'                => true, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'sidebar',
        'data-conditional-value'  => wp_json_encode( array( '1' ) ),
      ),
    ) );
  }

  add_action( 'cmb2_admin_init', 'haru_teespace_field_metaboxes_header' );
}

// Page Metabox
if ( ! function_exists( 'haru_teespace_field_metaboxes_page' ) ) {
  function haru_teespace_field_metaboxes_page() {

    $prefix = 'haru_';

    $cmb_page = new_cmb2_box( array(
      'id'            => $prefix . 'metabox',
      'title'         => esc_html__( 'Page Metabox', 'haru-teespace' ),
      'object_types'  => array( 'page', 'post' ), // Post type
      'vertical_tabs' => true, // Set vertical tabs, default false
      'tabs' => array(
        array(
          'id'      => $prefix . 'page_layout_meta_box',
          'icon'    => 'dashicons-text',
          'title'   => esc_html__( 'Layout', 'haru-teespace' ),
          'fields' => array(
            $prefix . 'layout_style',
            $prefix . 'layout',
            $prefix . 'sidebar',
            $prefix . 'left_sidebar',
            $prefix . 'right_sidebar',
            $prefix . 'extra_class',
          ),
        ),
        array(
          'id'    => $prefix . 'page_header_meta_box',
          'icon' => 'dashicons-align-left',
          'title' => esc_html__( 'Header', 'haru-teespace' ),
          'fields' => array(
            $prefix . 'header',
            $prefix . 'header_transparent',
            $prefix . 'header_transparent_skin',
            $prefix . 'header_sticky',
            $prefix . 'header_sticky_element',
          ),
        ),
        array(
          'id'    => $prefix . 'page_footer_meta_box',
          'icon' => 'dashicons-align-right',
          'title' => esc_html__( 'Footer', 'haru-teespace' ),
          'fields' => array(
            $prefix . 'footer',
          ),
        ),
        array(
          'id'    => $prefix . 'page_title_meta_box',
          'icon' => 'dashicons-menu-alt',
          'title' => esc_html__( 'Title', 'haru-teespace' ),
          'fields' => array(
            $prefix . 'show_title',
            $prefix . 'title_layout',
            $prefix . 'title_content_layout',
            $prefix . 'title_bg_image',
            $prefix . 'title_custom',
            $prefix . 'sub_title_custom',
            $prefix . 'title_breadcrumbs',
          ),
        ),
      )
    ) );

    $cmb_page->add_field( array(
      'name'          => esc_html__( 'Layout Style', 'haru-teespace' ),
      'desc'      => esc_html__( 'Set Layout Style for this page. This option will override settings in Theme Options -> General Settings -> Layout Style.', 'haru-teespace' ),
      'id'            => $prefix . 'layout_style',
      'type'        => 'radio_inline',
      'options'     => array(
        'default'   => esc_html__( 'Default', 'haru-teespace' ),
        'boxed'   => esc_html__( 'Boxed', 'haru-teespace' ),
        'wide'    => esc_html__( 'Wide', 'haru-teespace' ),
        'float'   => esc_html__( 'Float', 'haru-teespace' )
      ),
      'default' => 'default',
    ) );

    $cmb_page->add_field( array(
      'name'          => esc_html__( 'Page Layout', 'haru-teespace' ),
      'desc'      => esc_html__( 'Set Page Layout for this page. This option will override settings in Theme Options -> XXX -> Layout.', 'haru-teespace' ),
      'id'            => $prefix . 'layout',
      'type'        => 'radio_inline',
      'options'     => array(
        'default'   => esc_html__( 'Default', 'haru-teespace' ),
        'full-width'      => esc_html__( 'Full Width', 'haru-teespace' ),
        'haru-container' => esc_html__( 'Container', 'haru-teespace' ),
        'haru-container haru-container--large' => esc_html__( 'Large Container', 'haru-teespace' )
      ),
      'default' => 'default',
    ) );

    $cmb_page->add_field( array(
      'name'          => esc_html__( 'Page Sidebar', 'haru-teespace' ),
      'desc'      => esc_html__( 'Set Page Sidebar for this page. This option will override settings in Theme Options -> XXX -> Sidebar.', 'haru-teespace' ),
      'id'            => $prefix . 'sidebar',
      'type'          => 'radio_image',
      'options'       => array(
        'default'   => esc_html__( 'Default', 'haru-teespace' ),
        'none'    => esc_html__( 'No Sidebar', 'haru-teespace' ),
        'left'    => esc_html__( 'Left Sidebar', 'haru-teespace' ),
        'right'   => esc_html__( 'Right Sidebar', 'haru-teespace' ),
        'two'     => esc_html__( 'Two Sidebar', 'haru-teespace' ),
      ),
      'images_path'      => plugins_url( HARU_TEESPACE_CORE_NAME . '/assets/'),
      'images'           => array(
        'default'   => 'images/sidebar-none.png',
        'none'    => 'images/sidebar-none.png',
        'left'    => 'images/sidebar-left.png',
        'right'   => 'images/sidebar-right.png',
        'two'     => 'images/sidebar-two.png',
      ),
    ) );

    $cmb_page->add_field( array(
      'name'        => esc_html__( 'Sidebar Left', 'haru-teespace' ),
      'desc'        => esc_html__( 'Select a sidebar to display if use layout have sidebar left. This option will override settings in Theme Options -> XXX -> Sidebar Left.', 'haru-teespace' ),
      'id'        => $prefix . 'left_sidebar',
      'type'              => 'pw_select',
      'options_cb'    => 'haru_get_sidebar_list_options',
      'attributes' => array(
        'placeholder'         => esc_html__( 'Select sidebar Left for Single Page', 'haru-teespace' ),
        'required'                => true, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'sidebar',
        'data-conditional-value'  => wp_json_encode( array( 'left', 'two' ) ),
      ),
    ) );

    $cmb_page->add_field( array(
      'name'        => esc_html__( 'Sidebar Right', 'haru-teespace' ),
      'desc'        => esc_html__( 'Select a sidebar to display if use layout have sidebar right. This option will override settings in Theme Options -> XXX -> Sidebar Right.', 'haru-teespace' ),
      'id'        => $prefix . 'right_sidebar',
      'type'              => 'pw_select',
      'options_cb'    => 'haru_get_sidebar_list_options',
      'attributes' => array(
        'placeholder'         => esc_html__( 'Select sidebar Right for Single Page', 'haru-teespace' ),
        'required'                => true, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'sidebar',
        'data-conditional-value'  => wp_json_encode( array( 'right', 'two' ) ),
      ),
    ) );

    $cmb_page->add_field( array(
      'name'          => esc_html__( 'Extra Class', 'haru-teespace' ),
      'desc'      => esc_html__( 'Add extra class to body and use Custom CSS to get different style.', 'haru-teespace' ),
      'id'            => $prefix . 'extra_class',
      'type'          => 'text',
    ) );

    // Header
    $cmb_page->add_field( array(
      'name'        => esc_html__( 'Header Layout', 'haru-teespace' ),
      'desc'        => esc_html__( 'Set Header for page. This option will override settings in Theme Options -> Header -> Header Builder Type.', 'haru-teespace' ),
      'id'        => $prefix . 'header',
      'type'              => 'pw_select',
      'options_cb'    => 'haru_teespace_get_header_list_options',
      'attributes' => array(
        'placeholder'       => esc_html__( 'Select Header', 'haru-teespace' ),
        'required'               => false, // Will be required only if visible.
      ),
    ) );

    $cmb_page->add_field( array(
      'name'      => esc_html__( 'Header Transparent', 'haru-teespace' ),
      'desc'      => esc_html__( 'Enable/Disable Header Transparent. This option will override settings in Theme Options -> Header -> Header Transparent.', 'haru-teespace' ),
      'id'      => $prefix . 'header_transparent',
      'type'        => 'radio_inline',
      'options'     => array(
        'default'   => esc_html__( 'Default', 'haru-teespace' ),
        '1'     => esc_html__( 'On', 'haru-teespace' ),
        '0'     => esc_html__( 'Off', 'haru-teespace' )
      ),
      'default' => 'default',
    ) );

    $cmb_page->add_field( array(
      'name'      => esc_html__( 'Header Transparent Skin', 'haru-teespace' ),
      'desc'      => esc_html__( 'Set Header Transparent. This option will override settings in Theme Options -> Header.', 'haru-teespace' ),
      'id'      => $prefix . 'header_transparent_skin',
      'type'        => 'radio_inline',
      'options'     => array(
        'default'   => esc_html__( 'Default', 'haru-teespace' ),
        'light'   => esc_html__( 'Light', 'haru-teespace' ),
        'dark'    => esc_html__( 'Dark', 'haru-teespace' ),
      ),
      'default' => 'default',
    ) );

    $cmb_page->add_field( array(
      'name'      => esc_html__( 'Header Sticky', 'haru-teespace' ),
      'desc'      => esc_html__( 'Enable/Disable Header Sticky. This option will override settings in Theme Options -> Header -> Header Sticky.', 'haru-teespace' ),
      'id'      => $prefix . 'header_sticky',
      'type'        => 'radio_inline',
      'options'     => array(
        'default'   => esc_html__( 'Default', 'haru-teespace' ),
        '1'     => esc_html__( 'On', 'haru-teespace' ),
        '0'     => esc_html__( 'Off', 'haru-teespace' )
      ),
      'default' => 'default',
    ) );

    $cmb_page->add_field( array(
      'name'      => esc_html__( 'Header Sticky Element', 'haru-teespace' ),
      'desc'      => esc_html__( 'Set Header Sticky Element. This option will override settings in Theme Options -> Header.', 'haru-teespace' ),
      'id'      => $prefix . 'header_sticky_element',
      'type'        => 'radio_inline',
      'options'     => array(
        'default'   => esc_html__( 'Default', 'haru-teespace' ),
        'header' => esc_html__( 'Header', 'haru-teespace' ),
        'menu'  => esc_html__( 'Menu', 'haru-teespace' ),
      ),
      'default' => 'default',
    ) );

    // Footer
    $cmb_page->add_field( array(
      'name'        => esc_html__( 'Footer Layout', 'haru-teespace' ),
      'desc'        => esc_html__( 'Set Footer for page. This option will override settings in Theme Options -> Footer.', 'haru-teespace' ),
      'id'        => $prefix . 'footer',
      'type'              => 'pw_select',
      'options_cb'    => 'haru_teespace_get_footer_list_options',
      'attributes' => array(
        'placeholder'       => esc_html__( 'Select Footer', 'haru-teespace' ),
        'required'               => false, // Will be required only if visible.
      ),
    ) );

    // Title
    $cmb_page->add_field( array(
      'name'      => esc_html__( 'Title', 'haru-teespace' ),
      'desc'      => esc_html__( 'Show/Hide Page Title. This option will override settings in Theme Options -> XXX -> Page Title.', 'haru-teespace' ),
      'id'      => $prefix . 'show_title',
      'type'        => 'radio_inline',
      'options'     => array(
        'default'   => esc_html__( 'Default', 'haru-teespace' ),
        '1'     => esc_html__( 'On', 'haru-teespace' ),
        '0'     => esc_html__( 'Off', 'haru-teespace' )
      ),
      'default' => 'default',
    ) );

    $cmb_page->add_field( array(
      'name'      => esc_html__( 'Title Layout', 'haru-teespace' ),
      'desc'      => esc_html__( 'This option will override settings in Theme Options -> XXX -> Page Title Layout.', 'haru-teespace' ),
      'id'      => $prefix . 'title_layout',
      'type'        => 'radio_inline',
      'options'     => array(
        'default'     => esc_html__( 'Default', 'haru-teespace' ),
        'full-width'      => esc_html__( 'Full Width', 'haru-teespace' ),
        'haru-container' => esc_html__( 'Container', 'haru-teespace' ),
        'haru-container haru-container--large' => esc_html__( 'Large Container', 'haru-teespace' )
      ),
      'default' => 'default',
      'attributes' => array(
        'required'                => true, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'show_title',
        'data-conditional-value'  => wp_json_encode( array( 'default', '1' ) ),
      ),
    ) );

    $cmb_page->add_field( array(
      'name'      => esc_html__( 'Title Content Layout', 'haru-teespace' ),
      'desc'      => esc_html__( 'This option will override settings in Theme Options -> XXX -> Page Title Content Layout.', 'haru-teespace' ),
      'id'      => $prefix . 'title_content_layout',
      'type'        => 'radio_inline',
      'options'     => array(
        'default'     => esc_html__( 'Default', 'haru-teespace' ),
        'full-width'      => esc_html__( 'Full Width', 'haru-teespace' ),
        'haru-container' => esc_html__( 'Container', 'haru-teespace' ),
        'haru-container haru-container--large' => esc_html__( 'Large Container', 'haru-teespace' )
      ),
      'default' => 'default',
      'attributes' => array(
        'required'                => true, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'show_title',
        'data-conditional-value'  => wp_json_encode( array( 'default', '1' ) ),
      ),
    ) );

    $cmb_page->add_field( array(
      'name'          => esc_html__( 'Title Background Image', 'haru-teespace' ),
      'desc'      => esc_html__( 'This option will override settings in Theme Options -> XXX -> Page Title Background.', 'haru-teespace' ),
      'id'            => $prefix . 'title_bg_image',
      'type'        => 'file',
      'options' => array(
        'url' => true, // Hide the text input for the url
      ),
      'query_args' => array(
        'type' => array(
          'image/gif',
          'image/jpeg',
          'image/png',
        ),
      ),
      'preview_size' => 'medium',
      'attributes' => array(
        'required'                => false, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'show_title',
        'data-conditional-value'  => wp_json_encode( array( 'default', '1' ) ),
      ),
    ) );

    $cmb_page->add_field( array(
      'name'          => esc_html__( 'Title Heading Custom', 'haru-teespace' ),
      'id'            => $prefix . 'title_custom',
      'desc'      => esc_html__( 'This option will override auto generate Title.', 'haru-teespace' ),
      'type'          => 'text',
      'attributes' => array(
        'required'                => false, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'show_title',
        'data-conditional-value'  => wp_json_encode( array( 'default', '1' ) ),
      ),
    ) );

    $cmb_page->add_field( array(
      'name'          => esc_html__( 'Sub Title Custom', 'haru-teespace' ),
      'id'            => $prefix . 'sub_title_custom',
      'desc'      => esc_html__( 'This option will override auto generate Sub Title.', 'haru-teespace' ),
      'type'          => 'text',
      'attributes' => array(
        'required'                => false, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'show_title',
        'data-conditional-value'  => wp_json_encode( array( 'default', '1' ) ),
      ),
    ) );

    $cmb_page->add_field( array(
      'name'      => esc_html__( 'Title Heading', 'haru-teespace' ),
      'desc'      => esc_html__( 'This option will override settings in Theme Options -> XXX -> Heading.', 'haru-teespace' ),
      'id'      => $prefix . 'title_heading',
      'type'        => 'radio_inline',
      'options'     => array(
        'default'   => esc_html__( 'Default', 'haru-teespace' ),
        '1'     => esc_html__( 'On', 'haru-teespace' ),
        '0'     => esc_html__( 'Off', 'haru-teespace' )
      ),
      'default' => 'default',
      'attributes' => array(
        'required'                => false, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'show_title',
        'data-conditional-value'  => wp_json_encode( array( 'default', '1' ) ),
      ),
    ) );

    $cmb_page->add_field( array(
      'name'      => esc_html__( 'Title Breadcrumbs', 'haru-teespace' ),
      'desc'      => esc_html__( 'This option will override settings in Theme Options -> XXX -> Breadcrumbs.', 'haru-teespace' ),
      'id'      => $prefix . 'title_breadcrumbs',
      'type'        => 'radio_inline',
      'options'     => array(
        'default'   => esc_html__( 'Default', 'haru-teespace' ),
        '1'     => esc_html__( 'On', 'haru-teespace' ),
        '0'     => esc_html__( 'Off', 'haru-teespace' )
      ),
      'default' => 'default',
      'attributes' => array(
        'required'                => false, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'show_title',
        'data-conditional-value'  => wp_json_encode( array( 'default', '1' ) ),
      ),
    ) );
  }

  add_action( 'cmb2_admin_init', 'haru_teespace_field_metaboxes_page' );
}

// Term Metabox
if ( ! function_exists( 'haru_teespace_field_metaboxes_term' ) ) {
  function haru_teespace_field_metaboxes_term() {
    $prefix = 'haru_';

    $cmb_product_category = new_cmb2_box( array(
      'id'            => $prefix . 'metabox_product_category',
      'title'         => esc_html__( 'Term Metabox', 'haru-teespace' ),
      'object_types'  => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
      'taxonomies'    => array( 'category', 'post_tag', 'product_cat', 'product_tag' ),
    ) );

    $cmb_product_category->add_field( array(
      'name' => esc_html__( 'Title Background', 'haru-teespace' ), 
      'desc' => esc_html__( 'This image use for Term Page Title background like Category, Tag...', 'haru-teespace' ), 
      'id'   => $prefix . 'title_bg_image',
      'type' => 'file',
      'preview_size' => 'thumbnail',
    ) );
  }

  add_action( 'cmb2_admin_init', 'haru_teespace_field_metaboxes_term' );
}

// Product Metabox
if ( ! function_exists( 'haru_teespace_field_metaboxes_product' ) ) {
  function haru_teespace_field_metaboxes_product() {
    $prefix = 'haru_product_';

    $cmb_product = new_cmb2_box( array(
      'id'            => $prefix . 'metabox',
      'title'         => esc_html__( 'Product Metabox', 'haru-teespace' ),
      'object_types'  => array( 'product' ), // Post type
    ) );

    $cmb_product->add_field( array(
      'name' => esc_html__( 'Single Product Style', 'haru-teespace' ), 
      'desc' => esc_html__( 'This option will override Single Product layout in Theme Options -> WooCommerce -> Single Product -> Single Product Style', 'haru-teespace' ), 
      'id'   => $prefix . 'single_style',
      'type' => 'select',
      'options' => array(
        ''                    => esc_html__( 'Default', 'haru-teespace' ),
        'horizontal'          => esc_html__( 'Horizontal Slide', 'haru-teespace' ),
        'vertical'            => esc_html__( 'Vertical Slide', 'haru-teespace' ),
        'vertical_gallery'    => esc_html__( 'Vertical Gallery', 'haru-teespace' ),
        'grid_gallery'        => esc_html__( 'Grid Gallery', 'haru-teespace' )
      ),
      'default'      => '',
    ) );

    $cmb_product->add_field( array(
      'name' => esc_html__( 'Gallery Thumbnail Columns', 'haru-teespace' ), 
      'desc' => esc_html__( 'This option will override Single Product layout in Theme Options -> WooCommerce -> Single Product -> Single Product Gallery Thumbnail Columns', 'haru-teespace' ), 
      'id'   => $prefix . 'gallery_thumb_columns',
      'type' => 'select',
      'options' => array(
        ''      => esc_html__( 'Default', 'haru-teespace' ),
        '2'     => '2',
        '3'     => '3',
        '4'     => '4',
        '5'     => '5'
      ),
      'default'      => '',
      'attributes' => array(
        'required'                => false, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'single_style',
        'data-conditional-value'  => wp_json_encode( array( 'horizontal', 'vertical' ) ),
      ),
    ) );

    $cmb_product->add_field( array(
      'name' => esc_html__( 'Gallery Thumbnail Position', 'haru-teespace' ), 
      'desc' => esc_html__( 'This option will override Single Product layout in Theme Options -> WooCommerce -> Single Product -> Single Product Gallery Thumbnail Position', 'haru-teespace' ), 
      'id'   => $prefix . 'gallery_thumb_position',
      'type' => 'select',
      'options' => array(
        ''              => esc_html__( 'Default', 'haru-teespace' ),
        'thumbnail-left'        => esc_html__( 'Left', 'haru-teespace' ),
        'thumbnail-right'       => esc_html__( 'Right', 'haru-teespace' ),
      ),
      'default'      => '',
      'attributes' => array(
        'required'                => false, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'single_style',
        'data-conditional-value'  => wp_json_encode( array( 'vertical' ) ),
      ),
    ) );

    $cmb_product->add_field( array(
      'name' => esc_html__( 'Sticky Product Images', 'haru-teespace' ), 
      'desc' => esc_html__( 'This option will override Single Product layout in Theme Options -> WooCommerce -> Single Product -> Sticky Product Images', 'haru-teespace' ), 
      'id'   => $prefix . 'sticky_image',
      'type' => 'select',
      'options' => array(
        ''              => esc_html__( 'Default', 'haru-teespace' ),
        'no-sticky'     => esc_html__( 'No Sticky', 'haru-teespace' ),
        'sticky'        => esc_html__( 'Sticky', 'haru-teespace' ),
      ),
      'default'      => '',
      'attributes' => array(
        'required'                => false, // Will be required only if visible.
        'data-conditional-id'     => $prefix . 'single_style',
        'data-conditional-value'  => wp_json_encode( array( 'horizontal', 'vertical' ) ),
      ),
    ) );

    $cmb_product->add_field( array(
      'name' => esc_html__( 'Sticky Add To Cart', 'haru-teespace' ), 
      'desc' => esc_html__( 'This option will override Single Product layout in Theme Options -> WooCommerce -> Single Product -> Sticky Add To Cart', 'haru-teespace' ), 
      'id'   => $prefix . 'sticky_cart',
      'type' => 'select',
      'options' => array(
        ''              => esc_html__( 'Default', 'haru-teespace' ),
        'no-sticky'     => esc_html__( 'No Sticky', 'haru-teespace' ),
        'sticky'        => esc_html__( 'Sticky', 'haru-teespace' ),
      ),
      'default'      => '',
    ) );

    $cmb_product->add_field( array(
      'name' => esc_html__( 'Size Guide', 'haru-teespace' ), 
      'desc' => esc_html__( 'This image use for display Product Size Guide', 'haru-teespace' ), 
      'id'   => $prefix . 'size_guide',
      'type' => 'file',
      'preview_size' => 'thumbnail',
    ) );

    if ( class_exists( 'WPCleverWpcpo' ) ) {
      $cmb_product->add_field( array(
        'name' => esc_html__( 'Extra Options Style', 'haru-teespace' ), 
        'desc' => esc_html__( 'This option will override Single Product Options in Theme Options -> WooCommerce -> Single Product Options -> Extra Options Style', 'haru-teespace' ), 
        'id'   => $prefix . 'extra_options',
        'type' => 'select',
        'options' => array(
          ''         => esc_html__( 'Default', 'haru-teespace' ),
          'show'     => esc_html__( 'Show', 'haru-teespace' ),
          'toggle'   => esc_html__( 'Toggle', 'haru-teespace' ),
        ),
        'default'      => '',
      ) );
    }

    $cmb_product->add_field( array(
      'name' => esc_html__( 'Single Product Layout', 'haru-teespace' ), 
      'desc' => esc_html__( 'This option will override Single Product layout in Theme Options -> WooCommerce -> Single Product -> Single Product Layout', 'haru-teespace' ), 
      'id'   => 'haru_layout',
      'type' => 'select',
      'options' => array(
        ''                                          => esc_html__( 'Default', 'haru-teespace' ),
        'full-width'                                => esc_html__( 'Full Width', 'haru-teespace' ),
        'haru-container'                            => esc_html__( 'Container', 'haru-teespace' ),
        'haru-container haru-container--large'      => esc_html__( 'Large Container', 'haru-teespace' ),
      ),
      'default'      => '',
    ) );
  }

  add_action( 'cmb2_admin_init', 'haru_teespace_field_metaboxes_product' );
}

