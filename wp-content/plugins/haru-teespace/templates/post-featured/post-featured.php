<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

use \Haru_TeeSpace\Classes\Helper as ControlsHelper;
use \Haru_TeeSpace\Classes\Haru_Template;

global $wp_query;

$original_query = $wp_query;

$args = ControlsHelper::get_query_args( $settings );

$wp_query = new \WP_Query( $args );
?>

<?php if ( have_posts() ) : ?>
	<?php if ( in_array( $settings['pre_style'], array( 'slick' ) ) ) : ?>
		
		<div class="post-list haru-slick haru-slick--nav-shadow haru-slick--nav-center haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 1575,"settings" : {"dots": true, "arrows": false}}, {"breakpoint" : 991,"settings" : {"dots": true, "slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"dots": true, "slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
			<?php
		        while ( have_posts() ) : the_post();
	    			echo Haru_Template::haru_get_template( 'post-featured/post-' . $settings['post_style'] . '.php', $settings );
		        endwhile;
			?>
		</div>

	<?php elseif ( in_array( $settings['pre_style'], array( 'slick-2', 'slick-3' ) ) ) : ?>

		<div class="post-list haru-slick haru-slick--nav-opacity haru-slick--nav-center" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
			<?php
		        while ( have_posts() ) : the_post();
	    			echo Haru_Template::haru_get_template( 'post-featured/post-' . $settings['post_style'] . '.php', $settings );
		        endwhile;
			?>
		</div>
		
	<?php elseif ( 'grid' == $settings['pre_style'] ) : ?>

		<div class="post-list">
			<?php
		        while ( have_posts() ) : the_post();
	    			echo Haru_Template::haru_get_template( 'post-featured/post-' . $settings['post_style'] . '.php', $settings );
		        endwhile;
			?>
		</div>

	<?php endif; ?>

<?php else : ?>
    <div class="haru-info"><?php echo esc_html__( 'No video found', 'haru-teespace' ); ?></div>
<?php endif; ?>

<?php 
wp_reset_query();
$wp_query = $original_query;
