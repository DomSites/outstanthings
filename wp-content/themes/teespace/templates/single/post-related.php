<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
*/

// Doesn't display with Theme Unit Test
if ( false == haru_check_core_plugin_status() ) return;
?>
<div class="post-related">
    <h6 class="haru-heading haru-heading--style-1"><?php echo esc_html__( 'You may also like this', 'teespace' ); ?></h6>
    <div class="haru-slick haru-slick--nav-center haru-slick--nav-opacity haru-slick--dots-round"
        data-slick='{"rtl": <?php echo is_rtl() ? 'true' : 'false'; ?>, "slidesToShow" : 2, "slidesToScroll" : 1, "arrows" : true, "dots": false, "infinite" : false, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "autoplay": false, "autoplaySpeed": 5000, "responsive" : [{"breakpoint" : 991,"settings" : {"slidesToShow" : 2, "slidesToScroll" : 1, "dots": true, "arrows": true}}, {"breakpoint" : 767,"settings" : {"slidesToShow" : 1, "slidesToScroll" : 1, "dots": true, "arrows": true}}] }'
    >
        <?php 
            $args = array(
                'post__not_in'       => array( get_the_ID() ),
                'category__in'       => wp_get_post_categories( get_the_ID() ),
                'posts_per_page'     => 4, // 2+1?
                'orderby'            => array( 'type', 'rand' ),
                'post_type'          => 'post',
                'post_status'        => 'publish'
            );
            $related_posts         = new WP_Query( $args );
        ?>
        <?php 
            if ( $related_posts->have_posts() ) :
                while ( $related_posts->have_posts() ) : $related_posts->the_post();
        ?>
            <div class="related-item">
                <div class="post-image">
                    <a href="<?php echo esc_url( get_the_permalink() ); ?>" target="_self">
                    <?php the_post_thumbnail(); ?>
                    </a>
                </div>
                <div class="post-meta-category">
                    <?php if ( has_category() ) : ?>
                        <?php echo get_the_category_list(' '); ?>
                    <?php endif; ?>
                </div>
                <div class="post-meta">
                    <h5 class="post-title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" target="_self"><?php the_title(); ?></a></h5>
                </div>
            </div>
        <?php 
                endwhile;
            endif;
            wp_reset_query();
        ?>
    </div>
</div>