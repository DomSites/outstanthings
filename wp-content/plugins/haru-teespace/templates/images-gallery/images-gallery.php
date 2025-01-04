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

<?php if ( $settings['list'] ) : ?>
	<?php if ( in_array( $settings['pre_style'], array( 'slick' ) ) ) : ?>
	<ul class="haru-images-gallery__list haru-slick haru-slick--nav-opacity haru-slick--nav-center" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
		<?php 
			foreach (  $settings['list'] as $item ) :
		?>
			<li class="haru-images-gallery__item haru-images-gallery__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
				<div class="haru-images-gallery__image">
	      			<a href="<?php echo esc_url( $item['list_image']['url'] ); ?>" class="gallery-popup-link" data-elementor-open-lightbox="no">
	      				<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
	      			</a>
	      		</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php elseif ( in_array( $settings['pre_style'], array( 'slick-2' ) ) ) : ?>
	<ul class="haru-images-gallery__list haru-slick haru-slick--nav-opacity haru-slick--nav-center" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : true, "centerMode" : true, "centerPadding": "10%", "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
		<?php 
			foreach (  $settings['list'] as $item ) :
		?>
			<li class="haru-images-gallery__item haru-images-gallery__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
				<div class="haru-images-gallery__image">
	      			<a href="<?php echo esc_url( $item['list_image']['url'] ); ?>" class="gallery-popup-link" data-elementor-open-lightbox="no">
	      				<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
	      			</a>
	      		</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php elseif ( in_array( $settings['pre_style'], array( 'grid' ) ) ) : ?>
    <ul class="haru-images-gallery__list">
  		<?php
	      	foreach ( $settings['list'] as $item ) : 
      	?>
      	<li class="grid-item haru-images-gallery__item-wrap">
	        <div class="haru-images-gallery__item haru-images-gallery__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
          		<div class="haru-images-gallery__image">
	      			<a href="<?php echo esc_url( $item['list_image']['url'] ); ?>" class="gallery-popup-link" data-elementor-open-lightbox="no">
	      				<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
	      			</a>
	      		</div>
	        </div>
      	</li>
      	<?php endforeach; ?>
    </ul>
    <?php endif; ?>
<?php endif; ?>

<?php if ( $settings['list_creative'] ) : ?>
    <?php if ( in_array( $settings['pre_style'], array( 'creative' ) ) ) : ?>
    <ul class="haru-images-gallery__list">
    	<?php foreach ( $settings['list_creative'] as $item ) : ?>
      	<li class="haru-images-gallery__item haru-images-gallery__hover-<?php echo esc_attr( $settings['hover'] ); ?> <?php echo esc_attr( $item['list_size'] ); ?>">
      		<div class="haru-images-gallery__image">
      			<a href="<?php echo esc_url( $item['list_image']['url'] ); ?>" class="gallery-popup-link" data-elementor-open-lightbox="no">
      				<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
      			</a>
      		</div>
      	</li>
      	<?php endforeach; ?>
	</ul>
  	<?php endif; ?>
<?php endif; ?>
