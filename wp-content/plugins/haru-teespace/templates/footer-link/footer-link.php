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
	<ul>
		<?php
			foreach (  $settings['list'] as $item ) :
			$target = $item['list_content']['is_external'] ? ' target="_blank"' : '';
			$nofollow = $item['list_content']['nofollow'] ? ' rel="nofollow"' : '';
		?>
			<li><a href="<?php echo $item['list_content']['url']; ?>" <?php echo $target . $nofollow; ?>><?php echo $item['list_title']; ?></a></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
