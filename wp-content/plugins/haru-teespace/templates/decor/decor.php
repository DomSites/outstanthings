<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( function_exists( 'haru_get_option' ) ) {
    $cl_primary = haru_get_option( 'haru_primary_color', '#2ebb77' );
} else {
    $cl_primary = '#2ebb77';
}
?>

<div class="haru-decor__content">
	<?php if ( in_array( $settings['pre_style'], array( 'style-1' ) ) ) : ?>
	<div class="haru-decor__circle haru-decor__circle--gradient" style="background: linear-gradient(to right, <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : esc_attr( $cl_primary ); ?> 23.86%, <?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : haru_hex2rgba( $cl_primary,  0.403383 ); ?> 93.86% );">
	</div>
	<?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-2' ) ) ) : ?>
    <div class="haru-decor__circle haru-decor__circle--gradient-2" style="background: linear-gradient(to right, <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : 'rgba(238, 194, 253, 0.89)'; ?> 19.22%, <?php echo ( ! empty( $settings['bg_color_2'] ) ) ? $settings['bg_color_2'] : 'rgba(170, 254, 234, 0.403383)'; ?> 71.44%, <?php echo ( ! empty( $settings['bg_color_3'] ) ) ? $settings['bg_color_3'] : 'rgba(216, 170, 198, 0)'; ?> 83.67% );">
    </div>
    <?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-3' ) ) ) : ?>
    <div class="haru-decor__ellipse haru-decor__ellipse--blur" style="background: <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : $cl_primary; ?>">
    </div>
    <?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-4' ) ) ) : ?>
    <div class="haru-decor__ellipse haru-decor__dotted" style="background-image: radial-gradient(circle, <?php echo ( ! empty( $settings['bg_color_1'] ) ) ? $settings['bg_color_1'] : $cl_primary; ?> <?php echo ( ! empty( $settings['dot_size']['size'] ) ) ? $settings['dot_size']['size'] . $settings['dot_size']['unit'] : '2px'; ?>, transparent 0)">
    </div>
    <?php endif; ?>

    <?php if ( in_array( $settings['pre_style'], array( 'style-5' ) ) ) : ?>
    <div class="haru-decor__circle haru-decor__circle--layered" style="">
    </div>
    <?php endif; ?>
</div>

