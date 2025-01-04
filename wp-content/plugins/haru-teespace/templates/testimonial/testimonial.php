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
  <?php if ( in_array( $settings['pre_style'], array( 'slick' ) )  ) : ?>
    <ul class="haru-testimonial__list haru-slick haru-slick--nav-opacity haru-slick--nav-normal haru-slick--nav-center haru-slick--dots-bar" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : true, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "dots": true, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <li class="haru-testimonial__item-wrap">
        <?php endif; ?>
          <div class="haru-testimonial__item">
            <div class="haru-testimonial__image">
              <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
            </div>
            <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>
            <div class="haru-testimonial__meta">
              <h6 class="haru-testimonial__title">
                <?php if ( $item['list_link']['url'] ) : ?>
                  <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                <?php endif; ?>
                <?php echo esc_html( $item['list_title'] ); ?>
                <?php if ( $item['list_link']['url'] ) : ?>
                  </a>
                <?php endif; ?>
              </h6>
              <div class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
            </div>
          </div>

        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </li>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'slick-2' ) )  ) : ?>
    <ul class="haru-testimonial__list haru-slick haru-slick--nav-center haru-slick--nav-opacity haru-slick--nav-round haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "dots": true, "infinite" : true, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <li class="haru-testimonial__item-wrap">
        <?php endif; ?>

          <div class="haru-testimonial__item">
            <div class="haru-testimonial__top">
              <div class="haru-testimonial__image">
                <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
              </div>
              <div class="haru-testimonial__content">
                <h6 class="haru-testimonial__title">
                  <?php if ( $item['list_link']['url'] ) : ?>
                    <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                  <?php endif; ?>
                  <?php echo esc_html( $item['list_title'] ); ?><span class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span>
                  <?php if ( $item['list_link']['url'] ) : ?>
                    </a>
                  <?php endif; ?>
                </h6>
                <div class="haru-testimonial__rating">
                  <?php for ( $i = 0; $i < $item['list_rating']; $i++ ) : ?>
                    <div class="haru-testimonial__star"></div>
                  <?php endfor; ?>
                </div>
              </div>
            </div>
            
            <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>
          </div>

        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </li>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'slick-3' ) )  ) : ?>
    <ul class="haru-testimonial__list haru-slick haru-slick--nav-center haru-slick--nav-opacity haru-slick--nav-round haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "dots": true, "infinite" : true, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <li class="haru-testimonial__item-wrap">
        <?php endif; ?>

          <div class="haru-testimonial__item">
            <div class="haru-testimonial__top">
              <div class="haru-testimonial__image">
                <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
              </div>
              <div class="haru-testimonial__content">
                <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>
                <h6 class="haru-testimonial__title">
                  <?php if ( $item['list_link']['url'] ) : ?>
                    <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                  <?php endif; ?>
                  <?php echo esc_html( $item['list_title'] ); ?><span class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span>
                  <?php if ( $item['list_link']['url'] ) : ?>
                    </a>
                  <?php endif; ?>
                </h6>
              </div>
            </div>
          </div>

        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </li>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'slick-4' ) )  ) : ?>
    <ul class="haru-testimonial__list haru-slick haru-slick--nav-center haru-slick--nav-shadow haru-slick--nav-round haru-slick--dots-bar" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : true, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "dots": false, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <li class="haru-testimonial__item-wrap">
        <?php endif; ?>

          <div class="haru-testimonial__item">
            <div class="haru-testimonial__image">
              <div class="haru-testimonial__quote"><i class="hicon-quote"></i></div>
              <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
            </div>
            <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>
            <h6 class="haru-testimonial__title">
              <?php if ( $item['list_link']['url'] ) : ?>
                <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
              <?php endif; ?>
              <?php echo esc_html( $item['list_title'] ); ?>
              <?php if ( $item['list_link']['url'] ) : ?>
                </a>
              <?php endif; ?>
              <span class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span>
            </h6>
          </div>

        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </li>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'slick-5' ) )  ) : ?>
    <ul class="haru-testimonial__list haru-slick haru-slick--nav-center haru-slick--nav-opacity haru-slick--nav-round haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "dots": false, "infinite" : true, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <li class="haru-testimonial__item-wrap">
        <?php endif; ?>

          <div class="haru-testimonial__item">
            <div class="haru-testimonial__rating">
              <?php for ( $i = 0; $i < $item['list_rating']; $i++ ) : ?>
                <div class="haru-testimonial__star"></div>
              <?php endfor; ?>
            </div>
            <h6 class="haru-testimonial__description-title">
              <?php if ( $item['list_link']['url'] ) : ?>
                <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
              <?php endif; ?>
              <?php echo esc_html( $item['list_description_title'] ); ?>
              <?php if ( $item['list_link']['url'] ) : ?>
                </a>
              <?php endif; ?>
            </h6>
            <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>
            <div class="haru-testimonial__top">
              <div class="haru-testimonial__image">
                <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
              </div>
              <div class="haru-testimonial__content">
                <h6 class="haru-testimonial__title">
                  <?php if ( $item['list_link']['url'] ) : ?>
                    <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                  <?php endif; ?>
                  <?php echo esc_html( $item['list_title'] ); ?>
                  <?php if ( $item['list_link']['url'] ) : ?>
                    </a>
                  <?php endif; ?>
                </h6>
                <div class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
              </div>
            </div>
          </div>

        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </li>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'slick-6' ) )  ) : ?>
    <ul class="haru-testimonial__list haru-slick haru-slick--nav-bottom-right haru-slick--nav-shadow haru-slick--nav-round haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "dots": false, "infinite" : true, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>, "arrows": false, "dots": true}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <li class="haru-testimonial__item-wrap">
        <?php endif; ?>

          <div class="haru-testimonial__item">
            <div class="haru-testimonial__rating">
              <?php for ( $i = 0; $i < $item['list_rating']; $i++ ) : ?>
                <div class="haru-testimonial__star"></div>
              <?php endfor; ?>
            </div>
            <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>
            <div class="haru-testimonial__bottom">
              <div class="haru-testimonial__image">
                <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
              </div>
              <div class="haru-testimonial__content">
                <h6 class="haru-testimonial__title">
                  <?php if ( $item['list_link']['url'] ) : ?>
                    <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                  <?php endif; ?>
                  <?php echo esc_html( $item['list_title'] ); ?>
                  <?php if ( $item['list_link']['url'] ) : ?>
                    </a>
                  <?php endif; ?>
                </h6>
                <div class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
              </div>
            </div>
          </div>

        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </li>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'slick-7' ) )  ) : ?>
    <ul class="haru-testimonial__list haru-slick haru-slick--nav-center haru-slick--nav-shadow haru-slick--nav-round haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "dots": false, "infinite" : true, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 1575,"settings" : {"dots": true, "arrows": false}}, {"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>, "adaptiveHeight": true}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <li class="haru-testimonial__item-wrap">
        <?php endif; ?>

          <div class="haru-testimonial__item">
            <div class="haru-testimonial__image">
              <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
            </div>

            <div class="haru-testimonial__content">
              <div class="haru-testimonial__rating">
                <?php for ( $i = 0; $i < $item['list_rating']; $i++ ) : ?>
                  <div class="haru-testimonial__star"></div>
                <?php endfor; ?>
              </div>
              
              <h6 class="haru-testimonial__description-title"><?php echo esc_html( $item['list_description_title'] ); ?></h6>
              <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>

              <h6 class="haru-testimonial__title">
                <?php if ( $item['list_link']['url'] ) : ?>
                  <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                <?php endif; ?>
                <?php echo esc_html( $item['list_title'] ); ?><span class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span>
                <?php if ( $item['list_link']['url'] ) : ?>
                  </a>
                <?php endif; ?>
              </h6>
            </div>

          </div>

        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </li>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'grid' ) ) ) : ?>
    <ul class="haru-testimonial__list">
      <?php
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
      <li class="haru-testimonial__item-wrap haru-testimonial__columns-<?php echo esc_attr( $settings['columns'] ); ?> haru-testimonial__columns--tablet-<?php echo esc_attr( $settings['columns_tablet'] ); ?> haru-testimonial__columns--mobile-<?php echo esc_attr( $settings['columns_mobile'] ); ?>">
        <div class="haru-testimonial__item">
          <?php if ( $item['list_link']['url'] ) : ?>
          <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
          <?php endif; ?>
            <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" class="haru-testimonial__image" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
          <?php if ( $item['list_link']['url'] ) : ?>
          </a>
          <?php endif; ?>
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'grid-2' ) ) ) : ?>
    <ul class="haru-testimonial__list">
      <?php
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
      <li class="haru-testimonial__item-wrap haru-testimonial__columns-2 haru-testimonial__columns--tablet-2 haru-testimonial__columns--mobile-1">
        <div class="haru-testimonial__item">
          <div class="haru-testimonial__top">
            <div class="haru-testimonial__rating">
              <?php for ( $i = 0; $i < $item['list_rating']; $i++ ) : ?>
                <div class="haru-testimonial__star"></div>
              <?php endfor; ?>
            </div>
            <div class="haru-testimonial__description-title"><?php echo esc_html( $item['list_description_title'] ); ?></div>
            <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>
          </div>

          <div class="haru-testimonial__bottom">
            <div class="haru-testimonial__image">
              <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
            </div>
            <div class="haru-testimonial__content">
              <h6 class="haru-testimonial__title">
                <?php if ( $item['list_link']['url'] ) : ?>
                  <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                <?php endif; ?>
                <?php echo esc_html( $item['list_title'] ); ?>
                <?php if ( $item['list_link']['url'] ) : ?>
                  </a>
                <?php endif; ?>
              </h6>
              <div class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
            </div>
          </div>
          
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'scroll' ) ) ) : ?>
    <ul class="haru-testimonial__list">
      <?php
      $loop = 1;
      if ( count($settings['list']) < ( intval( $settings['scroll_columns'] ) * 2 ) ) {
        $loop = 2;
      }

      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
      <li class="haru-testimonial__item-wrap haru-testimonial__columns-<?php echo esc_attr( $settings['scroll_columns'] ); ?> haru-testimonial__columns--tablet-<?php echo esc_attr( $settings['scroll_columns_tablet'] ); ?> haru-testimonial__columns--mobile-<?php echo esc_attr( $settings['scroll_columns_mobile'] ); ?>">
        <div class="haru-testimonial__item">
          <div class="haru-testimonial__top">
            <div class="haru-testimonial__image">
              <?php if ( $item['list_link']['url'] ) : ?>
              <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
              <?php endif; ?>
                <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
              <?php if ( $item['list_link']['url'] ) : ?>
              </a>
              <?php endif; ?>
            </div>

            <div class="haru-testimonial__content">
              <h6 class="haru-testimonial__title">
                <?php if ( $item['list_link']['url'] ) : ?>
                  <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                <?php endif; ?>
                <?php echo esc_html( $item['list_title'] ); ?>
                  <?php if ( $item['list_sub_title'] ) : ?>
                    <span class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span>
                  <?php endif; ?>
                <?php if ( $item['list_link']['url'] ) : ?>
                  </a>
                <?php endif; ?>
              </h6>
              
              <div class="haru-testimonial__rating">
                <?php for ( $i = 0; $i < $item['list_rating']; $i++ ) : ?>
                  <div class="haru-testimonial__star"></div>
                <?php endfor; ?>
              </div>
            </div>
            
          </div>
          <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>
        </div>
      </li>
      <?php endforeach; ?>

      <?php 
        if ( $loop == 2 ) :
          foreach ( $settings['list'] as $item ) : 
          $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
          $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <li class="haru-testimonial__item-wrap haru-testimonial__columns-<?php echo esc_attr( $settings['scroll_columns'] ); ?> haru-testimonial__columns--tablet-<?php echo esc_attr( $settings['scroll_columns_tablet'] ); ?> haru-testimonial__columns--mobile-<?php echo esc_attr( $settings['scroll_columns_mobile'] ); ?>">
          <div class="haru-testimonial__item">
            <div class="haru-testimonial__top">

              <div class="haru-testimonial__image">
                <?php if ( $item['list_link']['url'] ) : ?>
                <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                <?php endif; ?>
                  <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
                <?php if ( $item['list_link']['url'] ) : ?>
                </a>
                <?php endif; ?>
              </div>

              <div class="haru-testimonial__content">
                <h6 class="haru-testimonial__title">
                  <?php if ( $item['list_link']['url'] ) : ?>
                    <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                  <?php endif; ?>
                  <?php echo esc_html( $item['list_title'] ); ?>
                    <?php if ( $item['list_sub_title'] ) : ?>
                      <span class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span>
                    <?php endif; ?>
                  <?php if ( $item['list_link']['url'] ) : ?>
                    </a>
                  <?php endif; ?>
                </h6>

                <div class="haru-testimonial__rating">
                  <?php for ( $i = 0; $i < $item['list_rating']; $i++ ) : ?>
                    <div class="haru-testimonial__star"></div>
                  <?php endfor; ?>
                </div>
              </div>
            </div>

            <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>
          </div>
        </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'slick-8' ) )  ) : ?>
    <ul class="haru-testimonial__list haru-slick haru-slick--nav-center haru-slick--nav-opacity haru-slick--nav-round haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "dots": false, "infinite" : true, "centerMode" : true, "centerPadding": "0", "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>, "centerMode" : false}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <li class="haru-testimonial__item-wrap">
        <?php endif; ?>

          <div class="haru-testimonial__item">
            <div class="haru-testimonial__top">
              <div class="haru-testimonial__image">
                <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
              </div>
              <div class="haru-testimonial__content">
                <h6 class="haru-testimonial__title">
                  <?php if ( $item['list_link']['url'] ) : ?>
                    <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                  <?php endif; ?>
                  <?php echo esc_html( $item['list_title'] ); ?><span class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span>
                  <?php if ( $item['list_link']['url'] ) : ?>
                    </a>
                  <?php endif; ?>
                </h6>
                <div class="haru-testimonial__rating">
                  <?php for ( $i = 0; $i < $item['list_rating']; $i++ ) : ?>
                    <div class="haru-testimonial__star"></div>
                  <?php endfor; ?>
                </div>
              </div>
            </div>
            
            <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>
          </div>

        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </li>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'slick-9' ) )  ) : ?>
    <ul class="haru-testimonial__list haru-slick haru-slick--nav-top-right haru-slick--nav-shadow haru-slick--nav-round haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "dots": false, "infinite" : true, "centerMode" : false, "centerPadding": "0", "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <li class="haru-testimonial__item-wrap">
        <?php endif; ?>

          <div class="haru-testimonial__item">
            <div class="haru-testimonial__image">
              <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
            </div>

            <div class="haru-testimonial__description"><?php echo esc_html( $item['list_description'] ); ?></div>

            <div class="haru-testimonial__content">
              <h6 class="haru-testimonial__title">
                <?php if ( $item['list_link']['url'] ) : ?>
                  <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                <?php endif; ?>
                <?php echo esc_html( $item['list_title'] ); ?><span class="haru-testimonial__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></span>
                <?php if ( $item['list_link']['url'] ) : ?>
                  </a>
                <?php endif; ?>
              </h6>
              <!-- <div class="haru-testimonial__rating">
                <?php for ( $i = 0; $i < $item['list_rating']; $i++ ) : ?>
                  <div class="haru-testimonial__star"></div>
                <?php endfor; ?>
              </div> -->
            </div>
          </div>

        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </li>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </ul>
  <?php endif; ?>
  
<?php endif; ?>
