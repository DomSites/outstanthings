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
	<?php
		foreach ( $settings['list'] as $item ) :
		$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
	?>
		<div class="text-scroll-item"><h6>
			<?php if ( $item['list_link']['url'] ) : ?>
              	<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
          	<?php endif; ?>
			<?php echo $item['list_title']; ?>
			<?php if ( $item['list_link']['url'] ) : ?>
              	</a>
          	<?php endif; ?>
		</h6></div>
	<?php endforeach; ?>
<?php endif; ?>
