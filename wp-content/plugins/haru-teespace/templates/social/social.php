<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

use \Elementor\Icons_Manager;

if ( $settings['list'] ) : ?>
	<ul>
		<?php 
			foreach (  $settings['list'] as $item ) :
			$target = $item['list_content']['is_external'] ? ' target="_blank"' : '';
			$nofollow = $item['list_content']['nofollow'] ? ' rel="nofollow"' : '';
		?>
			<?php if ( in_array( $settings['pre_style'], array( 'none', 'style-4' ) ) ) : ?>
			<li>
				<a href="<?php echo $item['list_content']['url']; ?>" <?php echo $target . $nofollow; ?>>
					<div class="haru-social__icon"><?php Icons_Manager::render_icon( $item['list_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
					<div class="haru-social__title"><?php echo $item['list_title']; ?></div>
				</a>
			</li>
			<?php endif; ?>

			<?php if ( in_array( $settings['pre_style'], array( 'style-1', 'style-3', 'style-5' ) ) ) : ?>
			<li>
				<a href="<?php echo $item['list_content']['url']; ?>" <?php echo $target . $nofollow; ?>>
					<div class="haru-social__icon"><?php Icons_Manager::render_icon( $item['list_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
				</a>
			</li>
			<?php endif; ?>

			<?php if ( in_array( $settings['pre_style'], array( 'style-2' ) ) ) : ?>
			<li>
				<a href="<?php echo $item['list_content']['url']; ?>" <?php echo $target . $nofollow; ?>>
					<div class="haru-social__title"><?php echo $item['list_title']; ?></div>
				</a>
			</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
