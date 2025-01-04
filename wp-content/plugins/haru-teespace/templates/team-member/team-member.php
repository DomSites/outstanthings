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

if ( $settings['list'] ) : ?>
  <?php if ( in_array( $settings['pre_style'], array( 'slick' ) )  ) : ?>
    <div class="haru-team-member__list haru-slick haru-slick--nav-shadow haru-slick--nav-center haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "dots": false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 1575,"settings" : {"dots": true, "arrows": false}}, {"breakpoint" : 991,"settings" : {"dots": true, "slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"dots": true, "slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <div class="haru-team-member__item-wrap">
        <?php endif; ?>
          <div class="haru-team-member__item">
            <div class="haru-team-member__image">
              <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
              <?php if ( ( $item['selected_icon_1'] && $item['social_link_1']['url'] ) || ( $item['selected_icon_2'] && $item['social_link_2']['url'] ) || ( $item['selected_icon_3'] && $item['social_link_3']['url'] ) || ( $item['selected_icon_4'] && $item['social_link_4']['url'] ) ) : ?>
              <ul class="haru-team-member__social">
                <?php if ( $item['selected_icon_1'] && $item['social_link_1']['url'] ) : ?>
                <li>
                  <a href="<?php echo esc_url( $item['social_link_1']['url'] ); ?>">
                    <?php Icons_Manager::render_icon( $item['selected_icon_1'], [ 'aria-hidden' => 'true' ] ); ?>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ( $item['selected_icon_2'] && $item['social_link_2']['url'] ) : ?>
                <li>
                  <a href="<?php echo esc_url( $item['social_link_2']['url'] ); ?>">
                    <?php Icons_Manager::render_icon( $item['selected_icon_2'], [ 'aria-hidden' => 'true' ] ); ?>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ( $item['selected_icon_3'] && $item['social_link_3']['url'] ) : ?>
                <li>
                  <a href="<?php echo esc_url( $item['social_link_3']['url'] ); ?>">
                    <?php Icons_Manager::render_icon( $item['selected_icon_3'], [ 'aria-hidden' => 'true' ] ); ?>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ( $item['selected_icon_4'] && $item['social_link_4']['url'] ) : ?>
                <li>
                  <a href="<?php echo esc_url( $item['social_link_4']['url'] ); ?>">
                    <?php Icons_Manager::render_icon( $item['selected_icon_4'], [ 'aria-hidden' => 'true' ] ); ?>
                  </a>
                </li>
                <?php endif; ?>
              </ul>
              <?php endif; ?>
            </div>
            <div class="haru-team-member__meta">
              <div class="haru-team-member__info">
                <h6 class="haru-team-member__title">
                  <?php if ( $item['list_link']['url'] ) : ?>
                    <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                  <?php endif; ?>
                  <?php echo esc_html( $item['list_title'] ); ?>
                  <?php if ( $item['list_link']['url'] ) : ?>
                    </a>
                  <?php endif; ?>
                </h6>
                <div class="haru-team-member__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
              </div>
            </div>

          </div>

        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </div>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'slick-2' ) )  ) : ?>
    <div class="haru-team-member__list haru-slick haru-slick--nav-opacity haru-slick--nav-normal haru-slick--nav-center haru-slick--dots-round" data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "dots": false, "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
      <?php
      $i = 1; 
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
        <?php if ( ( $i == 1 ) || ( ( $i % $settings['rows'] ) == 1 ) || ( $settings['rows'] == 1 ) ) : ?>
          <div class="haru-team-member__item-wrap">
        <?php endif; ?>
          <div class="haru-team-member__item">
            <div class="haru-team-member__image">
              <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
              <?php if ( ( $item['selected_icon_1'] && $item['social_link_1']['url'] ) || ( $item['selected_icon_2'] && $item['social_link_2']['url'] ) || ( $item['selected_icon_3'] && $item['social_link_3']['url'] ) || ( $item['selected_icon_4'] && $item['social_link_4']['url'] ) ) : ?>
              <ul class="haru-team-member__social">
                <?php if ( $item['selected_icon_1'] && $item['social_link_1']['url'] ) : ?>
                <li>
                  <a href="<?php echo esc_url( $item['social_link_1']['url'] ); ?>">
                    <?php Icons_Manager::render_icon( $item['selected_icon_1'], [ 'aria-hidden' => 'true' ] ); ?>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ( $item['selected_icon_2'] && $item['social_link_2']['url'] ) : ?>
                <li>
                  <a href="<?php echo esc_url( $item['social_link_2']['url'] ); ?>">
                    <?php Icons_Manager::render_icon( $item['selected_icon_2'], [ 'aria-hidden' => 'true' ] ); ?>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ( $item['selected_icon_3'] && $item['social_link_3']['url'] ) : ?>
                <li>
                  <a href="<?php echo esc_url( $item['social_link_3']['url'] ); ?>">
                    <?php Icons_Manager::render_icon( $item['selected_icon_3'], [ 'aria-hidden' => 'true' ] ); ?>
                  </a>
                </li>
                <?php endif; ?>

                <?php if ( $item['selected_icon_4'] && $item['social_link_4']['url'] ) : ?>
                <li>
                  <a href="<?php echo esc_url( $item['social_link_4']['url'] ); ?>">
                    <?php Icons_Manager::render_icon( $item['selected_icon_4'], [ 'aria-hidden' => 'true' ] ); ?>
                  </a>
                </li>
                <?php endif; ?>
              </ul>
              <?php endif; ?>
            </div>
            <div class="haru-team-member__meta">
              <div class="haru-team-member__info">
                <h6 class="haru-team-member__title">
                  <?php if ( $item['list_link']['url'] ) : ?>
                    <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                  <?php endif; ?>
                  <?php echo esc_html( $item['list_title'] ); ?>
                  <?php if ( $item['list_link']['url'] ) : ?>
                    </a>
                  <?php endif; ?>
                </h6>
                <div class="haru-team-member__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
              </div>
            </div>

          </div>

        <?php if ( ( ( $i % $settings['rows'] ) == 0 )  || ( $settings['rows'] == 1 ) ) : ?>
          </div>
        <?php endif; ?>
      <?php $i++; endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if ( in_array( $settings['pre_style'], array( 'grid', 'grid-2' ) ) ) : ?>
    <ul class="haru-team-member__list">
      <?php
      foreach ( $settings['list'] as $item ) : 
        $target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
      ?>
      <li class="haru-team-member__item-wrap haru-team-member__columns-<?php echo esc_attr( $settings['columns'] ); ?> haru-team-member__columns--tablet-<?php echo esc_attr( $settings['columns_tablet'] ); ?> haru-team-member__columns--mobile-<?php echo esc_attr( $settings['columns_mobile'] ); ?>">
        <div class="haru-team-member__item">
          <div class="haru-team-member__image">
            <img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
          </div>

          <div class="haru-team-member__meta">
            <div class="haru-team-member__info">
              <h6 class="haru-team-member__title">
                <?php if ( $item['list_link']['url'] ) : ?>
                  <a href="<?php echo $item['list_link']['url']; ?>" <?php echo $target . $nofollow; ?>>
                <?php endif; ?>
                <?php echo esc_html( $item['list_title'] ); ?>
                <?php if ( $item['list_link']['url'] ) : ?>
                  </a>
                <?php endif; ?>
              </h6>
              <div class="haru-team-member__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
            </div>

            <?php if ( ( $item['selected_icon_1'] && $item['social_link_1']['url'] ) || ( $item['selected_icon_2'] && $item['social_link_2']['url'] ) || ( $item['selected_icon_3'] && $item['social_link_3']['url'] ) || ( $item['selected_icon_4'] && $item['social_link_4']['url'] ) ) : ?>
            <ul class="haru-team-member__social">
              <?php if ( $item['selected_icon_1'] && $item['social_link_1']['url'] ) : ?>
              <li>
                <a href="<?php echo esc_url( $item['social_link_1']['url'] ); ?>">
                  <?php Icons_Manager::render_icon( $item['selected_icon_1'], [ 'aria-hidden' => 'true' ] ); ?>
                </a>
              </li>
              <?php endif; ?>

              <?php if ( $item['selected_icon_2'] && $item['social_link_2']['url'] ) : ?>
              <li>
                <a href="<?php echo esc_url( $item['social_link_2']['url'] ); ?>">
                  <?php Icons_Manager::render_icon( $item['selected_icon_2'], [ 'aria-hidden' => 'true' ] ); ?>
                </a>
              </li>
              <?php endif; ?>

              <?php if ( $item['selected_icon_3'] && $item['social_link_3']['url'] ) : ?>
              <li>
                <a href="<?php echo esc_url( $item['social_link_3']['url'] ); ?>">
                  <?php Icons_Manager::render_icon( $item['selected_icon_3'], [ 'aria-hidden' => 'true' ] ); ?>
                </a>
              </li>
              <?php endif; ?>

              <?php if ( $item['selected_icon_4'] && $item['social_link_4']['url'] ) : ?>
              <li>
                <a href="<?php echo esc_url( $item['social_link_4']['url'] ); ?>">
                  <?php Icons_Manager::render_icon( $item['selected_icon_4'], [ 'aria-hidden' => 'true' ] ); ?>
                </a>
              </li>
              <?php endif; ?>
            </ul>
            <?php endif; ?>
          </div>
        </div>
      </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
<?php endif; ?>
