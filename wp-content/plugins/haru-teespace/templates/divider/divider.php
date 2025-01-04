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

<div class="haru-divider__content">
	<?php if ( in_array( $settings['pre_style'], array( 'style-1' ) ) ) : ?>
	<svg class="haru-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
		viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
		<defs>
			<path id="haru-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
			<linearGradient id="haru-wave-gradient">
	          	<stop offset="5%" stop-color="#ED5221" />
	          	<stop offset="95%" stop-color="#F4B30B" />
	        </linearGradient>
		</defs>
		<g class="haru-waves__parallax">
			<use xlink:href="#haru-wave" class="haru-waves__first" x="48" y="0" fill="<?php echo ( $settings['wave_color_1'] ) ? $settings['wave_color_1'] : '#f6fafc'; ?>" />
			<!-- <use xlink:href="#haru-wave" x="48" y="3" fill="url(#haru-wave-gradient)" /> -->
			<use xlink:href="#haru-wave" class="haru-waves__second" x="48" y="5" fill="<?php echo ( $settings['wave_color_2'] ) ? $settings['wave_color_2'] : '#ecdffd'; ?>" />
			<!-- <use xlink:href="#haru-wave" x="48" y="7" fill="#000" /> -->
		</g>
	</svg>
	<?php endif; ?>

	<?php if ( in_array( $settings['pre_style'], array( 'style-2' ) ) ) : ?>
	<div class="haru-divider__trapezoid haru-divider__trapezoid--<?php echo esc_attr( ( $settings['reverse_shape'] == 'yes' ) ? 'left' : 'right' ); ?>" style="background: linear-gradient(to right, <?php echo ( $settings['bg_color_1'] ) ? $settings['bg_color_1'] : '#f6fafc'; ?>, <?php echo ( $settings['bg_color_2'] ) ? $settings['bg_color_2'] : '#f6fafc'; ?>);">

	</div>
	<?php endif; ?>

	<?php if ( in_array( $settings['pre_style'], array( 'style-3' ) ) ) : ?>
	<div class="haru-divider__triangle haru-divider__triangle--<?php echo esc_attr( ( $settings['reverse_shape'] == 'yes' ) ? 'left' : 'right' ); ?>" style="background: linear-gradient(to right, <?php echo ( $settings['bg_color_1'] ) ? $settings['bg_color_1'] : '#f6fafc'; ?>, <?php echo ( $settings['bg_color_2'] ) ? $settings['bg_color_2'] : '#f6fafc'; ?>);">

	</div>
	<?php endif; ?>

	<?php if ( in_array( $settings['pre_style'], array( 'style-4' ) ) ) : ?>
	<svg class="haru-waves" fill="<?php echo ( $settings['wave_color_1'] ) ? $settings['wave_color_1'] : '#f6fafc'; ?>" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1440 150">
		<path d="M 0 26.1978 C 275.76 83.8152 430.707 65.0509 716.279 25.6386 C 930.422 -3.86123 1210.32 -3.98357 1439 9.18045 C 2072.34 45.9691 2201.93 62.4429 2560 26.198 V 172.199 L 0 172.199 V 26.1978 Z">
			<animate repeatCount="indefinite" fill="freeze" attributeName="d" dur="10s" values="M0 25.9086C277 84.5821 433 65.736 720 25.9086C934.818 -3.9019 1214.06 -5.23669 1442 8.06597C2079 45.2421 2208 63.5007 2560 25.9088V171.91L0 171.91V25.9086Z; M0 86.3149C316 86.315 444 159.155 884 51.1554C1324 -56.8446 1320.29 34.1214 1538 70.4063C1814 116.407 2156 188.408 2560 86.315V232.317L0 232.316V86.3149Z; M0 53.6584C158 11.0001 213 0 363 0C513 0 855.555 115.001 1154 115.001C1440 115.001 1626 -38.0004 2560 53.6585V199.66L0 199.66V53.6584Z; M0 25.9086C277 84.5821 433 65.736 720 25.9086C934.818 -3.9019 1214.06 -5.23669 1442 8.06597C2079 45.2421 2208 63.5007 2560 25.9088V171.91L0 171.91V25.9086Z">
			</animate>
		</path>
	</svg>
	<?php endif; ?>
</div>

