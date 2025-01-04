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
?>

<?php if ( $settings['list'] ) : ?>
	<ul>
		<?php foreach (  $settings['list'] as $item ) : ?>
			<li>
				<div class="haru-header-contact__icon"><?php Icons_Manager::render_icon( $item['list_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
				<div class="haru-header-contact__content">
					<h6 class="haru-header-contact__title"><?php echo $item['list_title']; ?></h6>
					<div class="haru-header-contact__desc"><?php echo $item['list_content']; ?></div>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
