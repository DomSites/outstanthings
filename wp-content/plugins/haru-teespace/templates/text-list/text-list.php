<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( $settings['list'] ) : ?>
	<ul class="haru-text-list__list">
	<?php
		foreach ( $settings['list'] as $item ) :
	?>
		<li class="haru-text-list__item">
		<?php if ( $item['list_title'] ) : ?>
          	<span class="text-title"><?php echo $item['list_title']; ?></span>
      	<?php endif; ?>
		<?php if ( $item['list_sub_title'] ) : ?>
          	<span class="text-sub-title"><?php echo $item['list_sub_title']; ?></span>
      	<?php endif; ?>
      	</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
