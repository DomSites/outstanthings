<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

?>
<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
	<img src="<?php echo esc_url( $settings['logo']['url'] ); ?>" class="haru-logo__default" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>">
	<img src="<?php echo esc_url( $settings['logo_retina']['url'] ); ?>" class="haru-logo__retina" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>">
	<img src="<?php echo esc_url( $settings['logo_dark']['url'] ); ?>" class="haru-logo__dark" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>">
	<img src="<?php echo esc_url( $settings['logo_dark_retina']['url'] ); ?>" class="haru-logo__dark-retina" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>">
</a>
