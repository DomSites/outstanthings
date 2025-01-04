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

if ( ! empty( $settings['thousand_separator'] ) ) {
	$delimiter = empty( $settings['thousand_separator_char'] ) ? ',' : $settings['thousand_separator_char'];
} else {
	$delimiter = '';
}

?>

<div class="gr-counter gr-animated">
	<?php if ( in_array( $settings['pre_style'], array( 'style-1', 'style-5' ) ) ) : ?>
		<div class="haru-counter__number-wrap">
			<span class="haru-counter__number-prefix"><?php echo $settings['prefix']; ?></span>
			<span class="haru-counter__number gr-number-counter" 
				data-duration="<?php echo esc_attr( $settings['duration'] ); ?>"
				data-to-value="<?php echo esc_attr( $settings['ending_number'] ); ?>"
				data-from-value="<?php echo esc_attr( $settings['starting_number'] ); ?>"
				data-delimiter="<?php echo esc_attr( $delimiter ); ?>"
			><?php echo $settings['starting_number']; ?></span>
			<span class="haru-counter__suffix"><?php echo $settings['suffix']; ?></span>
		</div>
		<?php if ( $settings['title'] ) : ?>
			<div class="haru-counter__title"><?php echo $settings['title']; ?></div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( 'style-2' == $settings['pre_style'] ) : ?>
		<div class="haru-counter__number-wrap">
			<span class="haru-counter__number-prefix"><?php echo $settings['prefix']; ?></span>
			<span class="haru-counter__number gr-number-counter" 
				data-duration="<?php echo esc_attr( $settings['duration'] ); ?>"
				data-to-value="<?php echo esc_attr( $settings['ending_number'] ); ?>"
				data-from-value="<?php echo esc_attr( $settings['starting_number'] ); ?>"
				data-delimiter="<?php echo esc_attr( $delimiter ); ?>"
			><?php echo $settings['starting_number']; ?></span>
			<span class="haru-counter__suffix"><?php echo $settings['suffix']; ?></span>
		</div>
		<?php if ( $settings['title'] ) : ?>
			<div class="haru-counter__title"><?php echo $settings['title']; ?></div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( 'style-3' == $settings['pre_style'] ) : ?>
		<div class="haru-counter__number-wrap">
			<span class="haru-counter__number-prefix"><?php echo $settings['prefix']; ?></span>
			<span class="haru-counter__number gr-number-counter" 
				data-duration="<?php echo esc_attr( $settings['duration'] ); ?>"
				data-to-value="<?php echo esc_attr( $settings['ending_number'] ); ?>"
				data-from-value="<?php echo esc_attr( $settings['starting_number'] ); ?>"
				data-delimiter="<?php echo esc_attr( $delimiter ); ?>"
			><?php echo $settings['starting_number']; ?></span>
			<span class="haru-counter__suffix"><?php echo $settings['suffix']; ?></span>
		</div>
		<?php if ( $settings['title'] ) : ?>
			<div class="haru-counter__title"><?php echo $settings['title']; ?></div>
		<?php endif; ?>
		<?php if ( $settings['description'] ) : ?>
			<div>
			<div class="haru-counter__description"><?php echo $settings['description']; ?></div>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( 'style-4' == $settings['pre_style'] ) : ?>
		<div class="haru-counter__number-wrap">
			<span class="haru-counter__number-prefix"><?php echo $settings['prefix']; ?></span>
			<span class="haru-counter__number gr-number-counter" 
				data-duration="<?php echo esc_attr( $settings['duration'] ); ?>"
				data-to-value="<?php echo esc_attr( $settings['ending_number'] ); ?>"
				data-from-value="<?php echo esc_attr( $settings['starting_number'] ); ?>"
				data-delimiter="<?php echo esc_attr( $delimiter ); ?>"
			><?php echo $settings['starting_number']; ?></span>
			<span class="haru-counter__suffix"><?php echo $settings['suffix']; ?></span>
		</div>
		<?php if ( $settings['title'] ) : ?>
			<div class="haru-counter__title"><?php echo $settings['title']; ?></div>
		<?php endif; ?>
	<?php endif; ?>
</div>
