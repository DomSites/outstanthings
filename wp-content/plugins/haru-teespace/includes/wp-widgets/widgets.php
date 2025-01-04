<?php
/**
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Widgets
include_once( HARU_TEESPACE_CORE_DIR . 'includes/wp-widgets/haru-widget.php' );
include_once( HARU_TEESPACE_CORE_DIR . 'includes/wp-widgets/haru-post-list.php' );
include_once( HARU_TEESPACE_CORE_DIR . 'includes/wp-widgets/haru-navigation-menu.php' );
// WooCommerce
// if ( class_exists( 'WooCommerce', true ) ) {
	include_once( HARU_TEESPACE_CORE_DIR . 'includes/wp-widgets/haru-woo-layered-nav.php' );
	include_once( HARU_TEESPACE_CORE_DIR . 'includes/wp-widgets/haru-woo-stock-status.php' );
	include_once( HARU_TEESPACE_CORE_DIR . 'includes/wp-widgets/haru-woo-sorting.php' );
	include_once( HARU_TEESPACE_CORE_DIR . 'includes/wp-widgets/haru-woo-price-filter.php' );
// }
