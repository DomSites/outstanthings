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
	<ul class="haru-banner-list__list haru-slick haru-slick--nav-border haru-slick--nav-top-right" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
		<?php 
			foreach (  $settings['list'] as $item ) :
			$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
		?>
			<li class="haru-banner-list__item haru-banner-list__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
				<div class="haru-banner-list__item-wrap">
					<?php if ( $item['list_link']['url'] ) : ?>
	      			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	          		<?php endif; ?>
					<div class="haru-banner-list__image">
						<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
		      		</div>
		      		<div class="haru-banner-list__content">
		              	<h6 class="haru-banner-list__title"><?php echo esc_html( $item['list_title'] ); ?><span class="haru-banner-list__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span></h6>
		              	<?php if ( $item['list_description'] && in_array( $settings['hover'], array( 'style-4' ) ) ) : ?>
		              	<div class="haru-banner-list__description"><?php echo esc_html( $item['list_description'] ); ?></div>
		              	<?php endif; ?>
		              	<?php if ( $item['list_button_text'] && in_array( $settings['hover'], array( 'style-4' ) ) ) : ?>
		              	<div class="haru-banner-list__btn">
		              		<div class="haru-button haru-button--outline haru-button--outline-gray haru-button--size-large haru-button--round-normal"><?php echo esc_html( $item['list_button_text'] ); ?></div>
		              	</div>
		              	<?php endif; ?>
	              	</div>
		      		<?php if ( $item['list_link']['url'] ) : ?>
	              	</a>
	              	<?php endif; ?>
              	</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php elseif ( in_array( $settings['pre_style'], array( 'slick-2' ) ) ) : ?>
	<ul class="haru-banner-list__list haru-slick haru-slick--nav-opacity haru-slick--nav-center" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : true, "centerMode" : true, "centerPadding": "10%", "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
		<?php 
			foreach (  $settings['list'] as $item ) :
			$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
		?>
			<li class="haru-banner-list__item haru-banner-list__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
				<div class="haru-banner-list__item-wrap">
					<?php if ( $item['list_link']['url'] ) : ?>
	      			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	          		<?php endif; ?>
					<div class="haru-banner-list__image">
						<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
		      		</div>
		      		<div class="haru-banner-list__content">
		              	<h6 class="haru-banner-list__title"><?php echo esc_html( $item['list_title'] ); ?><span class="haru-banner-list__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span></h6>
		              	<?php if ( $item['list_description'] && in_array( $settings['hover'], array( 'style-4' ) ) ) : ?>
		              	<div class="haru-banner-list__description"><?php echo esc_html( $item['list_description'] ); ?></div>
		              	<?php endif; ?>
		              	<?php if ( $item['list_button_text'] && in_array( $settings['hover'], array( 'style-4' ) ) ) : ?>
		              	<div class="haru-banner-list__btn">
		              		<div class="haru-button haru-button--outline haru-button--outline-gray haru-button--size-large haru-button--round-normal"><?php echo esc_html( $item['list_button_text'] ); ?></div>
		              	</div>
		              	<?php endif; ?>
	              	</div>
		      		<?php if ( $item['list_link']['url'] ) : ?>
	              	</a>
	              	<?php endif; ?>
              	</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php elseif ( in_array( $settings['pre_style'], array( 'slick-3' ) ) ) : ?>
	<ul class="haru-banner-list__list haru-slick haru-slick--nav-shadow haru-slick--nav-center haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 1575,"settings" : {"dots": true, "arrows": false}}, {"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>, "dots": true}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>, "dots": true}}] }'>
		<?php 
			foreach (  $settings['list'] as $item ) :
			$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
		?>
			<li class="haru-banner-list__item haru-banner-list__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
				<div class="haru-banner-list__item-wrap">
					<?php if ( $item['list_link']['url'] ) : ?>
	      			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	          		<?php endif; ?>
					<div class="haru-banner-list__image">
						<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
		      		</div>
		      		<div class="haru-banner-list__content">
		              	<h6 class="haru-banner-list__title"><?php echo esc_html( $item['list_title'] ); ?><span class="haru-banner-list__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span></h6>
		              	<?php if ( $item['list_description'] && in_array( $settings['hover'], array( 'style-4' ) ) ) : ?>
		              	<div class="haru-banner-list__description"><?php echo esc_html( $item['list_description'] ); ?></div>
		              	<?php endif; ?>
		              	<?php if ( $item['list_button_text'] && in_array( $settings['hover'], array( 'style-4' ) ) ) : ?>
		              	<div class="haru-banner-list__btn">
		              		<div class="haru-button haru-button--outline haru-button--outline-gray haru-button--size-large haru-button--round-normal"><?php echo esc_html( $item['list_button_text'] ); ?></div>
		              	</div>
		              	<?php endif; ?>
	              	</div>
		      		<?php if ( $item['list_link']['url'] ) : ?>
	              	</a>
	              	<?php endif; ?>
              	</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php elseif ( in_array( $settings['pre_style'], array( 'slick-4' ) ) ) : ?>
	<ul class="haru-banner-list__list haru-slick haru-slick--nav-opacity haru-slick--nav-center" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
		<?php 
			foreach (  $settings['list'] as $item ) :
			$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
		?>
			<li class="haru-banner-list__item haru-banner-list__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
				<div class="haru-banner-list__item-wrap">
					<?php if ( $item['list_link']['url'] ) : ?>
	      			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	          		<?php endif; ?>
					<div class="haru-banner-list__image">
						<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
		      		</div>
		      		<div class="haru-banner-list__content">
		              	<h6 class="haru-banner-list__title"><?php echo esc_html( $item['list_title'] ); ?><span class="haru-banner-list__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span></h6>
		              	<?php if ( $item['list_description'] && in_array( $settings['hover'], array( 'style-4' ) ) ) : ?>
		              	<div class="haru-banner-list__description"><?php echo esc_html( $item['list_description'] ); ?></div>
		              	<?php endif; ?>
		              	<?php if ( $item['list_button_text'] && in_array( $settings['hover'], array( 'style-4' ) ) ) : ?>
		              	<div class="haru-banner-list__btn">
		              		<div class="haru-button haru-button--outline haru-button--outline-gray haru-button--size-large haru-button--round-normal"><?php echo esc_html( $item['list_button_text'] ); ?></div>
		              	</div>
		              	<?php endif; ?>
	              	</div>
		      		<?php if ( $item['list_link']['url'] ) : ?>
	              	</a>
	              	<?php endif; ?>
              	</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php elseif ( in_array( $settings['pre_style'], array( 'grid' ) ) ) : ?>
    <ul class="haru-banner-list__list">
  		<?php
	      	foreach ( $settings['list'] as $item ) : 
      		$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      	?>
		<li class="grid-item haru-banner-list__item haru-banner-list__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
			<div class="haru-banner-list__item-wrap">
				<?php if ( $item['list_link']['url'] ) : ?>
      			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
          		<?php endif; ?>
				<div class="haru-banner-list__image">
					<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
	      		</div>
	      		<div class="haru-banner-list__content">
	              	<h6 class="haru-banner-list__title"><?php echo esc_html( $item['list_title'] ); ?><span class="haru-banner-list__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span></h6>
	              	<?php if ( $item['list_description'] && in_array( $settings['hover'], array( 'style-4' ) ) ) : ?>
	              	<div class="haru-banner-list__description"><?php echo esc_html( $item['list_description'] ); ?></div>
	              	<?php endif; ?>
	              	<?php if ( $item['list_button_text'] && in_array( $settings['hover'], array( 'style-4' ) ) ) : ?>
	              	<div class="haru-banner-list__btn">
	              		<div class="haru-button haru-button--outline-gray haru-button--size-large haru-button--round-normal"><?php echo esc_html( $item['list_button_text'] ); ?></div>
	              	</div>
	              	<?php endif; ?>
              	</div>
	      		<?php if ( $item['list_link']['url'] ) : ?>
              	</a>
              	<?php endif; ?>
          	</div>
		</li>
      	<?php endforeach; ?>
    </ul>
    <?php endif; ?>
<?php endif; ?>

<?php if ( $settings['list_creative'] ) : ?>
    <?php if ( in_array( $settings['pre_style'], array( 'creative' ) ) ) : ?>
    <ul class="haru-banner-list__list haru-clear">
    	<?php
    		foreach ( $settings['list_creative'] as $item ) :
			$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
		?>
      	<li class="haru-banner-list__item <?php echo esc_attr( $item['list_size'] ); ?> haru-banner-list__hover-creative-<?php echo esc_attr( $settings['hover_creative'] ); ?>">
      		<div class="haru-banner-list__item-wrap">
	      		<?php if ( $item['list_link']['url'] ) : ?>
      			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
          		<?php endif; ?>
				<div class="haru-banner-list__image">
					<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
	      		</div>
	      		<div class="haru-banner-list__content">
	              	<h6 class="haru-banner-list__title"><?php echo esc_html( $item['list_title'] ); ?>
	              	<?php if ( 'style-2' == $settings['hover_creative'] ) : ?>
	              	<span class="haru-banner-list__description"><?php echo esc_html( $item['list_description'] ); ?></span>
	              	<?php endif; ?>
	              	</h6>
	              	<?php if ( 'style-1' == $settings['hover_creative'] ) : ?>
	              		<div class="haru-banner-list__description"><?php echo esc_html( $item['list_description'] ); ?></div>
              		<?php endif; ?>
              	</div>
	      		<?php if ( $item['list_link']['url'] ) : ?>
              	</a>
              	<?php endif; ?>
      		</div>
      	</li>
      	<?php endforeach; ?>
	</ul>
  	<?php endif; ?>
<?php endif; ?>
