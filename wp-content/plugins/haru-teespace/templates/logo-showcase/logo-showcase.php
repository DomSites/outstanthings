<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( $settings['list'] ) : ?>
  <?php if ( 'slick' == $settings['pre_style'] ) : ?>
    <ul class="haru-logo-showcase__list haru-slick haru-slick--nav-opacity haru-slick--nav-center" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : <?php echo esc_attr( ( 'yes' == $settings['loop'] ) ? 'true' : 'false' ); ?>, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <li class="haru-logo-showcase__item-wrap">
        <?php endif; ?>
            <div class="haru-logo-showcase__item haru-logo-showcase__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
              <?php if ( $item['list_link']['url'] ) : ?>
              <a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
              <?php endif; ?>
                <img src="<?php echo esc_url( $item['list_logo']['url'] ); ?>" class="haru-logo-showcase__image" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
              <?php if ( $item['list_link']['url'] ) : ?>
              </a>
              <?php endif; ?>
            </div>
        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </li>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( 'slick-2' == $settings['pre_style'] ) : ?>
    <ul class="haru-logo-showcase__quote haru-slick" data-slick='{"slidesToShow" : 1, "slidesToScroll" : 1, "arrows" : false, "infinite" : <?php echo esc_attr( ( 'yes' == $settings['loop'] ) ? 'true' : 'false' ); ?>, "fade": true, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "asNavFor" : ".haru-logo-showcase__list" }'>
      <?php
        foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
      <li class="haru-logo-showcase__quote-item">
        <div class="haru-logo-showcase__description"><?php echo $item['list_description']; ?></div>
      </li>
      <?php endforeach; ?>
    </ul>

    <ul class="haru-logo-showcase__list haru-slick haru-slick--nav-opacity haru-slick--nav-center" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : 1, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "fade": false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "asNavFor" : ".haru-logo-showcase__quote", "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <li class="haru-logo-showcase__item-wrap">
          <div class="haru-logo-showcase__item haru-logo-showcase__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
            <a href="javascript:;">
              <img src="<?php echo esc_url( $item['list_logo']['url'] ); ?>" class="haru-logo-showcase__image" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
            </a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'grid' ) ) ) : ?>
    <ul class="haru-logo-showcase__list">
      <?php
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
      <li class="haru-logo-showcase__item-wrap haru-logo-showcase__columns-<?php echo esc_attr( $settings['columns'] ); ?> haru-logo-showcase__columns--tablet-<?php echo esc_attr( $settings['columns_tablet'] ); ?> haru-logo-showcase__columns--mobile-<?php echo esc_attr( $settings['columns_mobile'] ); ?>">
        <div class="haru-logo-showcase__item haru-logo-showcase__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
          <?php if ( $item['list_link']['url'] ) : ?>
          <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
          <?php endif; ?>
            <img src="<?php echo esc_url( $item['list_logo']['url'] ); ?>" class="haru-logo-showcase__image" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
          <?php if ( $item['list_link']['url'] ) : ?>
          </a>
          <?php endif; ?>
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
<?php endif; ?>
