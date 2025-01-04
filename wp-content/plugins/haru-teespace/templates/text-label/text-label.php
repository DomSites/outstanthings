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
<?php if ( in_array( $settings['pre_style'], array( 'style-1', 'style-2', 'style-3' ) ) ) : ?>
<div class="haru-text-label__content">
	<?php if ( $settings['title'] ) : ?>
		<div class="haru-text-label__title"><?php echo $settings['title']; ?></div>
	<?php endif; ?>
  	<?php if ( $settings['sub_title'] ) : ?>
		<div class="haru-text-label__sub-title"><?php echo $settings['sub_title']; ?></div>
	<?php endif; ?>
</div>
<?php endif; ?>