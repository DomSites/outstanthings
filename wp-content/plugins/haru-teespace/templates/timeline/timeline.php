<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/


if ( 'style-1' == $settings['pre_style'] ) : ?>
	<?php if ( $settings['list'] ) : ?>
		<div class="timeline-slider-nav" 
			data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : false, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "asNavFor" : ".timeline-slider-for", "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
	        <?php foreach ( $settings['list'] as $item ) :
	        ?>
	            <div class="timeline-thumb">
	            	<span class="timeline-dot font__secondary"><?php echo esc_html( $item['list_time'] ); ?></span>
	            </div>
	        <?php endforeach; ?>
	    </div>

		<div class="timeline-slider-for haru-slick haru-slick--nav-center haru-slick--nav-opacity" 
	    		data-slick='{"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll'] ); ?>, "arrows" : <?php echo esc_attr( ( 'yes' == $settings['arrows'] ) ? 'true' : 'false' ); ?>, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "asNavFor" : ".timeline-slider-nav", "autoplay": <?php echo esc_attr( ( 'yes' == $settings['autoPlay'] ) ? 'true' : 'false' ); ?>, "autoplaySpeed": <?php echo esc_attr( $settings['autoPlaySpeed'] ? $settings['autoPlaySpeed'] : '3000' ); ?>, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_tablet'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_tablet'] ); ?>}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : <?php echo esc_attr( $settings['slidesToShow_mobile'] ); ?>, "slidesToScroll" : <?php echo esc_attr( $settings['slidesToScroll_mobile'] ); ?>}}] }'>
			<?php
				foreach (  $settings['list'] as $item ) :
				$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
				$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
			?>
				<div class="timeline-item">
					<?php if ( in_array( $settings['pre_style'], array( 'style-1', 'style-2' ) ) ) : ?>
						<?php if ( $item['list_link']['url'] ) : ?>
							<a class="" href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
						<?php endif; ?>
								<div class="timeline-item__image">
									<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="">
								</div>
						<?php if ( $item['list_link']['url'] ) : ?>
							</a>
						<?php endif; ?>
					<?php endif; ?>
					<div class="timeline-item__content">
						<h6 class="timeline-item__title">
							<?php if ( $item['list_link']['url'] ) : ?>
								<a class="" href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
							<?php endif; ?>
							<?php echo esc_html( $item['list_title'] ); ?>
							<?php if ( $item['list_link']['url'] ) : ?>
								</a>
							<?php endif; ?>
						</h6>
						
						<?php
							$video_id = $item['list_video'];
							if ( $video_id ) :
						?>
						<div class="timeline-item__video">
							<h6 class="timeline-item__video-title"><a href="<?php echo esc_url( get_the_permalink( $video_id ) ); ?>"><?php echo get_the_title( $video_id ); ?></a></h6>
						</div>
						<?php endif; ?>
						<div class="timeline-item__description"><?php echo $item['list_description']; ?></div>
						<?php
							$timeline_award = $item['list_award'];
							if ( $timeline_award ) :
						?>
						<div class="timeline-item__award">
							<?php foreach ( $timeline_award as $award ) : ?>
								<div class="timeline-item__award-image">
									<img src="<?php echo esc_url( $award['url'] ); ?>" alt="">
								</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
<?php elseif ( 'style-2' == $settings['pre_style'] ) : ?>
	<?php if ( $settings['list_timeline'] ) : ?>
		<ul class="timeline-list">
			<?php
				foreach (  $settings['list_timeline'] as $item ) :
				$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
				$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
			?>
				<li class="timeline-item">
			        <div class="timeline-item__year font__secondary">
			            <?php if ( isset( $item['list_time'] ) ) : 
			                echo esc_html( $item['list_time'] );
			            endif; ?>
			        </div>
			        <div class="timeline-item__content">
			        	<?php if ( isset( $item['list_title'] ) ) : ?>
			            <h6 class="timeline-item__winner">
			            	<?php if ( $item['list_link']['url'] ) : ?>
								<a class="" href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
							<?php endif; ?>
							<?php echo esc_html( $item['list_title'] ); ?>
							<?php if ( $item['list_link']['url'] ) : ?>
								</a>
							<?php endif; ?>
			            </h6>
			        	<?php endif; ?>
			            <div class="timeline-item__meta">
			                <?php
								$video_id = $item['list_video'];
								if ( $video_id ) :
							?>
							<div class="timeline-item__video">
								<h6 class="timeline-item__video-title"><a href="<?php echo esc_url( get_the_permalink( $video_id ) ); ?>"><?php echo get_the_title( $video_id ); ?></a></h6>
							</div>
							<?php endif; ?>
				            <div class="timeline-item__festival">
				                <?php if ( isset( $item['list_description'] ) ) :
				                    echo esc_html( $item['list_description'] ); 
				                endif; ?>
				            </div>
			            </div>
			        </div>
			        <?php if ( $item['list_link']['url'] ) : ?>
			            <div class="timeline-item__url">
			                <a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
			                    <?php if ( isset( $item['list_link_text'] ) ) :
			                        echo esc_html( $item['list_link_text'] );
			                    endif; ?>
			                    <i class="ti-arrow-top-right"></i>
			                </a>
			            </div>
			        <?php endif; ?>
			    </li>
		    <?php endforeach; ?>
	    </ul>
    <?php endif; ?>
<?php elseif ( 'style-3' == $settings['pre_style'] ) : ?>
	<?php if ( $settings['list_timeline'] ) : ?>
		<ul class="timeline-list">
			<?php
				foreach (  $settings['list_timeline'] as $item ) :
				$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
				$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
			?>
				<li class="timeline-item">
			        <div class="timeline-item__year font__secondary">
			            <?php if ( isset( $item['list_time'] ) ) : 
			                echo esc_html( $item['list_time'] );
			            endif; ?>
			        </div>
			        <div class="timeline-item__content">
			        	<?php if ( isset( $item['list_title'] ) ) : ?>
			            <h6 class="timeline-item__winner">
			                <?php if ( $item['list_link']['url'] ) : ?>
								<a class="" href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
							<?php endif; ?>
							<?php echo esc_html( $item['list_title'] ); ?>
							<?php if ( $item['list_link']['url'] ) : ?>
								</a>
							<?php endif; ?>
			            </h6>
			            <?php endif; ?>
			            
			            <div class="timeline-item__meta">
			                <?php
								$video_id = $item['list_video'];
								if ( $video_id ) :
							?>
							<div class="timeline-item__video">
								<h6 class="timeline-item__video-title"><a href="<?php echo esc_url( get_the_permalink( $video_id ) ); ?>"><?php echo get_the_title( $video_id ); ?></a></h6>
							</div>
							<?php endif; ?>
				            <div class="timeline-item__festival">
				                <?php if ( isset( $item['list_description'] ) ) :
				                    echo esc_html( $item['list_description'] ); 
				                endif; ?>
				            </div>
			            </div>
			        </div>
			        <?php if ( $item['list_link']['url'] ) : ?>
			            <div class="timeline-item__url">
			                <a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
			                    <?php if ( isset( $item['list_link_text'] ) ) :
			                        echo esc_html( $item['list_link_text'] );
			                    endif; ?>
			                    <i class="ti-arrow-top-right"></i>
			                </a>
			            </div>
			        <?php endif; ?>
			    </li>
		    <?php endforeach; ?>
	    </ul>
    <?php endif; ?>
<?php endif; ?>
