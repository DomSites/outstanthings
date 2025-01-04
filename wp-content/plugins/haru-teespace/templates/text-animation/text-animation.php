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
<h2 class="haru-text-animation__heading">
	<?php if ( $settings['pre_title'] ) : ?>
		<span class="haru-text-animation__pre"><?php echo $settings['pre_title']; ?></span>
	<?php endif; ?>
	<?php
		if ( $settings['list'] ) :
			$text_type = '[ ';
			foreach ( $settings['list'] as $key => $item ) {
				if ( end($settings['list']) !== $item ) {
					$text_type .= '"' . $item['list_text'] . '", ';
				} else {
					$text_type .= '"' . $item['list_text'] . '"';
				}
				
			}
			$text_type .= ']';
	?>
  	<span class="haru-text-animation__typewrite" data-period="<?php echo esc_attr( $settings['period'] ); ?>" data-type='<?php echo esc_attr( $text_type ); ?>' data-color="">
	    <span class="haru-text-animation__typewrap"><?php echo $settings['list'][0]['list_text']; ?></span>
	    <?php //if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) : ?>
	    <?php //endif; ?>
  	</span>
  	<?php endif; ?>
  	<?php if ( $settings['sub_title'] ) : ?>
		<span class="haru-text-animation__sub"><?php echo $settings['sub_title']; ?></span>
	<?php endif; ?>
</h2>

<?php elseif ( in_array( $settings['pre_style'], array( 'style-4' ) ) ) : ?>
	<h2 class="haru-text-animation__heading">
	<?php if ( $settings['pre_title'] ) : ?>
		<span class="haru-text-animation__pre"><?php echo $settings['pre_title']; ?></span>
	<?php endif; ?>
	<?php if ( $settings['list'] ) : ?>
		<span class="haru-text-animation__list">
		<?php foreach ( $settings['list'] as $key => $item ) : ?>
			<?php if ( $item['list_text'] ) : ?>
			<span class="haru-text-animation__item" style="animation: rotate-text-up <?php echo $transition; ?>s <?php echo $time_hold * ($key + 1) + 1; ?>s;">
	          	<?php echo $item['list_text']; ?>
	      	</span>
	      	<?php endif; ?>
		<?php endforeach; ?>
		</span>
	<?php endif; ?>
	<?php if ( $settings['sub_title'] ) : ?>
		<span class="haru-text-animation__sub"><?php echo $settings['sub_title']; ?></span>
	<?php endif; ?>
	</h2>
<?php endif; ?>