<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Process to get URL
$login_url     = '';
$logout_url    = '';
$register_url  = '';
$account_url   = '';

if ( class_exists( 'WooCommerce' ) ) {
    global $woocommerce;

    $myaccount_page_id = wc_get_page_id( 'myaccount' );
    if ( $myaccount_page_id > 0 ) {
        $login_url    = get_permalink( $myaccount_page_id );
        $logout_url   = get_permalink( $myaccount_page_id );
        $register_url = get_permalink( $myaccount_page_id );
        $account_url  = get_permalink( $myaccount_page_id );
    } else {
        $login_url    = wp_login_url( get_permalink() );
        $logout_url   = wp_registration_url();
        $register_url = wp_registration_url();
        $account_url  = get_edit_user_link();
    }
} else {
    $login_url    = wp_login_url( get_permalink() );
    $logout_url   = wp_registration_url();
    $register_url = wp_registration_url();
    $account_url  = get_edit_user_link();
}

if ( 'yes' == $settings['custom_account'] ) {
	if ( $settings['custom_login_page'] ) {
		$login_url = get_permalink( $settings['custom_login_page'] );
	}

	if ( $settings['custom_logout_page'] ) {
		$logout_url = get_permalink( $settings['custom_logout_page'] );
	}
}

?>
<div class="haru-account__wrap">
    <?php
        if ( is_user_logged_in() ) :
            $orders  = get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );
            $account = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
            if ( $orders ) {
                $account .= '/' . $orders;
            }

            $user_id = get_current_user_id();
    ?>
        <div class="haru-account__content logged-in">
            <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" class="haru-account__link">
                <?php echo get_avatar( get_the_author_meta( 'ID', $user_id ), 45 ); ?>
                
                <?php if ( $settings['pre_style'] == 'style-4' ) : ?>
                    <div class="bottom-bar-title"><?php echo esc_html( $settings['account_title'] ); ?></div>
                <?php endif; ?>
            </a>
            <ul class="haru-account__menu">
                <?php
                    $current_user = wp_get_current_user(); 
                ?>
                <li class="haru-account__menu-item haru-account__menu-item--greeting">
                    <?php echo esc_html__( 'Howdy ', 'haru-teespace' ); ?>
                    <span class="haru-account__user-name"><?php echo esc_html( $current_user->user_login ); ?></span>
                </li>
                <li class="haru-account__menu-item">
                    <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>"><?php echo esc_html__( 'My Account', 'haru-teespace' ); ?></a>
                </li>
                <?php
                    $wishlist = '';
                    if ( class_exists('YITH_WCWL') ) :
                ?>
                <li class="haru-account__menu-item">
                    <a href="<?php echo esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ); ?>"><?php echo esc_html__( 'My Wishlist', 'haru-teespace' ); ?></a>
                </li>
                <?php endif; ?>
                <li class="haru-account__menu-item">
                    <a href="<?php echo esc_url( $account ); ?>"><?php echo esc_html__( 'My Orders', 'haru-teespace' ); ?></a>
                </li>
                <li class="haru-account__menu-item">
                    <a href="<?php echo esc_url( wp_logout_url( $logout_url ) ); ?>"><?php echo esc_html__( 'Logout', 'haru-teespace' ); ?></a>
                </li>
            </ul>
        </div>
    <?php else : ?>
        <div class="haru-account__content logged-out">
            <?php if ( in_array( $settings['pre_style'], array( 'style-1', 'style-4' ) ) ) : ?>
            <a href="<?php echo esc_url( $login_url ); ?>" class="haru-account__link">
                <?php if ( $settings['pre_style'] == 'style-4' ) : ?>
                    <div class="bottom-bar-title"><?php echo esc_html( $settings['account_title'] ); ?></div>
                <?php endif; ?>
            </a>
            <?php elseif ( in_array( $settings['pre_style'], array( 'style-2', 'style-3' ) ) ) : ?>
                <div class="haru-account__buttons">
                    <a class="haru-button haru-button--text haru-button--text-black haru-button-link" role="button" href="<?php echo esc_url( $login_url ); ?>">
                        <span class="haru-button-text"><?php echo $settings['login_text']; ?></span>
                    </a>
                    <?php if ( $settings['pre_style'] == 'style-2' ) : ?>
                    <a class="haru-button haru-button--bg-black haru-button--size-small haru-button--round-normal haru-button-link" role="button" href="<?php echo esc_url( $register_url ); ?>">
                        <span class="haru-button-text"><?php echo $settings['register_text']; ?></span>
                    </a>
                    <?php else : ?>
                    <a class="haru-button haru-button--bg-black haru-button--size-medium haru-button--round-normal haru-button-link" role="button" href="<?php echo esc_url( $register_url ); ?>">
                        <span class="haru-button-text"><?php echo $settings['register_text']; ?></span>
                    </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
