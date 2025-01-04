<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$maintenance_social_profile = haru_get_option( 'maintenance_social_profile', array() );
?>
<?php if ( $maintenance_social_profile ) : ?>
    <ul class="maintenance-social-profile-wrapper">
    <?php foreach ( $maintenance_social_profile as $social ) : ?>
        <?php echo $social; ?>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
