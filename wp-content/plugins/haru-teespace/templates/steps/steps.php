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
  <?php if ( 'list' == $settings['pre_style'] ) : ?>
    <ul class="haru-steps__list">
      <?php
        foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <li class="haru-steps__item">
          <?php if ( $item['list_link']['url'] ) : ?>
          <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
          <?php endif; ?>
            <div class="haru-steps__content">
              <div class="haru-steps__image">
                <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
              </div>
              <div class="haru-steps__sub-title">
                <div class="haru-steps__sub-title-content"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
              </div>
              <div class="haru-steps__info">
                <h6 class="haru-steps__title"><?php echo esc_html( $item['list_title'] ); ?></h6>
                <div class="haru-steps__description"><?php echo esc_html( $item['list_description'] ); ?></div>
              </div>
            </div>
          <?php if ( $item['list_link']['url'] ) : ?>
          </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( 'list-2' == $settings['pre_style'] ) : ?>
    <ul class="haru-steps__list">
      <?php
        foreach ( $settings['list'] as $index => $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <li class="haru-steps__item <?php if ( $index == 0 ) echo 'active'; ?>" data-index="<?php echo esc_attr( $index ); ?>">
          <?php if ( $item['list_link']['url'] ) : ?>
          <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
          <?php endif; ?>
            <div class="haru-steps__content">
              <div class="haru-steps__sub-title">
                <div class="haru-steps__sub-title-content"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
              </div>
              <div class="haru-steps__info">
                <h6 class="haru-steps__title"><?php echo esc_html( $item['list_title'] ); ?></h6>
                <div class="haru-steps__image">
                  <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
                </div>
              </div>
            </div>
          <?php if ( $item['list_link']['url'] ) : ?>
          </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="haru-steps__images">
      <?php foreach ( $settings['list'] as $index => $item ) :  ?>
      <div class="haru-steps__image <?php if ( $index == 0 ) echo 'active'; ?>" data-index="<?php echo esc_attr( $index ); ?>">
        <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
      </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if ( 'list-3' == $settings['pre_style'] ) : ?>
    <ul class="haru-steps__list">
      <?php
        foreach ( $settings['list'] as $index => $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <li class="haru-steps__item <?php if ( $index == 0 ) echo 'active'; ?>" data-index="<?php echo esc_attr( $index ); ?>">
          <?php if ( $item['list_link']['url'] ) : ?>
          <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
          <?php endif; ?>
            <div class="haru-steps__content">
              <div class="haru-steps__sub-title">
                <div class="haru-steps__sub-title-content"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
                <div class="haru-steps__sub-title-decor">
                  <svg width="188" height="29" viewBox="0 0 188 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" d="M1 28C30.1765 7.62517 108.224 -20.8996 187 28" stroke="#B479D9" stroke-width="2" stroke-linecap="round" stroke-dasharray="5 5"/>
                  </svg>
                </div>
              </div>
              <div class="haru-steps__info">
                <h6 class="haru-steps__title"><?php echo esc_html( $item['list_title'] ); ?></h6>
                <div class="haru-steps__description"><?php echo esc_html( $item['list_description'] ); ?></div>
              </div>
              <div class="haru-steps__btn haru-button haru-button--text-primary haru-button--size-normal"><?php echo $item['list_button_text']; ?>
            </div>
          <?php if ( $item['list_link']['url'] ) : ?>
          </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( 'list-4' == $settings['pre_style'] ) : ?>
    <ul class="haru-steps__list">
      <?php
        foreach ( $settings['list'] as $index => $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <li class="haru-steps__item <?php if ( $index == 0 ) echo 'active'; ?>" data-index="<?php echo esc_attr( $index ); ?>">
          <?php if ( $item['list_link']['url'] ) : ?>
          <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
          <?php endif; ?>
            <div class="haru-steps__content">
              <div class="haru-steps__image">
                <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
              </div>
              <div class="haru-steps__info">
                <h6 class="haru-steps__title"><?php echo esc_html( $item['list_title'] ); ?></h6>
                <div class="haru-steps__description"><?php echo esc_html( $item['list_description'] ); ?></div>
              </div>
              <div class="haru-steps__sub-title">
                <div class="haru-steps__sub-title-content"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
                <div class="haru-steps__sub-title-decor">
                  <svg width="188" height="29" viewBox="0 0 188 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" d="M1 28C30.1765 7.62517 108.224 -20.8996 187 28" stroke="#ABABAB" stroke-width="2" stroke-linecap="round" stroke-dasharray="5 5"/>
                  </svg>
                </div>
              </div>
            </div>
          <?php if ( $item['list_link']['url'] ) : ?>
          </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ( 'slick' == $settings['pre_style'] ) : ?>
    <ul class="haru-steps__list haru-slick haru-slick--nav-opacity haru-slick--nav-center" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <li class="haru-steps__item-wrap">
        <?php endif; ?>
            <div class="haru-steps__item haru-steps__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
              <?php if ( $item['list_link']['url'] ) : ?>
              <a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
              <?php endif; ?>
                <img src="<?php echo esc_url( $item['list_logo']['url'] ); ?>" class="haru-steps__image" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
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

  <?php if ( in_array( $settings['pre_style'], array( 'grid' ) ) ) : ?>
    <ul class="haru-steps__list">
      <?php
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
      <li class="haru-steps__item-wrap haru-steps__columns-<?php echo esc_attr( $settings['columns'] ); ?> haru-steps__columns--tablet-<?php echo esc_attr( $settings['columns_tablet'] ); ?> haru-steps__columns--mobile-<?php echo esc_attr( $settings['columns_mobile'] ); ?>">
        <div class="haru-steps__item haru-steps__hover-<?php echo esc_attr( $settings['hover'] ); ?>">
          <?php if ( $item['list_link']['url'] ) : ?>
          <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
          <?php endif; ?>
            <img src="<?php echo esc_url( $item['list_logo']['url'] ); ?>" class="haru-steps__image" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
          <?php if ( $item['list_link']['url'] ) : ?>
          </a>
          <?php endif; ?>
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
<?php endif; ?>
