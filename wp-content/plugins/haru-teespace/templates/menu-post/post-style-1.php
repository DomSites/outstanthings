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
<article class="post-item-menu post-item-menu--style-1">
    <div class="post-item-menu__thumbnail">
        <a href="<?php the_permalink(); ?>" class="post-item__image">
            <?php the_post_thumbnail(); ?>
        </a>
    </div>
    <div class="post-item-menu__content">
    	<h6 class="post-item-menu__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
        <div class="post-item-menu__category">
            <?php if ( has_category() ) : ?>
                <?php echo get_the_category_list( ' / ' ); ?>
            <?php endif; ?>
        </div>
    	<div class="post-item-menu__meta">
            <div class="post-item-menu__meta-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
        </div>
    </div>
</article>