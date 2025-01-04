<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

use \Elementor\Plugin;

?>

<?php if ( $settings['list'] ) : ?>
	<?php if ( in_array( $settings['pre_style'], array( 'slick' ) ) ) : ?>
	<ul class="haru-content-slideshow__list haru-slick haru-slick--nav-opacity haru-slick--nav-center haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "fade": true, "infinite": true, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "dots" : <?php echo esc_attr( ( 'yes' == $settings['dots'] ) ? 'true' : 'false' ); ?>, "infinite" : true, "pauseOnHover": false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
		<?php 
			foreach (  $settings['list'] as $item ) :
		?>
			<li class="haru-content-slideshow__item">
				<?php if ( 'content' == $item['list_text_type'] ) : ?>
                    <div class="haru-content-slideshow__image">
	      				<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
		      		</div>
                <?php elseif ( 'template' == $item['list_text_type'] ) : ?>
                    <?php 
                        if ( ! empty( $item['list_primary_templates'] ) ) :
                            echo Plugin::$instance->frontend->get_builder_content( $item['list_primary_templates'], true );
                        endif;
                    ?>
                <?php endif;?>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<?php if ( in_array( $settings['pre_style'], array( 'slick-2' ) ) ) : ?>
	<ul class="haru-content-slideshow__list haru-slick haru-slick--nav-shadow haru-slick--nav-center haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "fade": true, "infinite": true, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "dots" : <?php echo esc_attr( ( 'yes' == $settings['dots'] ) ? 'true' : 'false' ); ?>, "infinite" : true, "pauseOnHover": false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
		<?php 
			foreach (  $settings['list'] as $item ) :
		?>
			<li class="haru-content-slideshow__item">
				<?php if ( 'content' == $item['list_text_type'] ) : ?>
                    <div class="haru-content-slideshow__image">
	      				<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
		      		</div>
                <?php elseif ( 'template' == $item['list_text_type'] ) : ?>
                    <?php 
                        if ( ! empty( $item['list_primary_templates'] ) ) :
                            echo Plugin::$instance->frontend->get_builder_content( $item['list_primary_templates'], true );
                        endif;
                    ?>
                <?php endif;?>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
<?php endif; ?>
