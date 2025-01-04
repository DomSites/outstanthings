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
	<ul class="haru-icon-list__list">
	<?php
		foreach ( $settings['list'] as $item ) :
		$target = $item['list_link']['is_external'] ? ' target="_blank"' : '';
    	$nofollow = $item['list_link']['nofollow'] ? ' rel="nofollow"' : '';
	?>
		<li class="haru-icon-list__item haru-icon-list__columns-<?php echo esc_attr( $settings['columns'] ); ?> haru-icon-list__columns--tablet-<?php echo esc_attr( $settings['columns_tablet'] ); ?> haru-icon-list__columns--mobile-<?php echo esc_attr( $settings['columns_mobile'] ); ?>">
			<div class="haru-icon-list__item-wrap">
				<?php if ( $item['list_link']['url'] ) : ?>
      			<a href="<?php echo esc_url( $item['list_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
          		<?php endif; ?>
				<div class="haru-icon-list__image">
					<img src="<?php echo esc_url( $item['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['list_title'] ); ?>">
	      		</div>
	      		<div class="haru-icon-list__content">
	              	<h6 class="haru-icon-list__title"><?php echo esc_html( $item['list_title'] ); ?></h6>
	              	<div class="haru-icon-list__sub-title"><?php echo esc_html( $item['list_sub_title'] ); ?></div>
              	</div>
	      		<?php if ( $item['list_link']['url'] ) : ?>
              	</a>
              	<?php endif; ?>
          	</div>
      	</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
