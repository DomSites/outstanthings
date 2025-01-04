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
<article class="grid-item post-item post-item--style-3 post-item--hover-<?php echo esc_attr( $settings['hover'] ); ?>">
    <div class="post-item__wrap">
        <div class="post-item__thumbnail">
            <a href="<?php the_permalink(); ?>" class="post-item__image">
                <?php the_post_thumbnail(); ?>
            </a>
        </div>
        <div class="post-item__content">
        	<div class="post-item__meta">
                <div class="post-item__category">
                    <?php if ( has_category() ) : ?>
                        <?php echo get_the_category_list( ' ' ); ?>
                    <?php endif; ?>
                </div>
                <div class="post-item__meta-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
            </div>
            <h6 class="post-item__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
        </div>
    </div>
</article>