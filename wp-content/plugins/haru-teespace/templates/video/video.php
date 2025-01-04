<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/
if ( $settings['video_desktop_url'] ) : ?>
<div class="haru-video__desktop">
	<video src="<?php echo $settings['video_desktop_url']['url']; ?>" autoplay muted webkit-playsinline playsinline loop></video>
</div>
<?php endif; ?>
<?php if ( $settings['video_mobile_url'] ) : ?>
<div class="haru-video__mobile">
	<video src="<?php echo $settings['video_mobile_url']['url']; ?>" autoplay muted webkit-playsinline playsinline loop></video>
</div>
<?php endif; ?>
