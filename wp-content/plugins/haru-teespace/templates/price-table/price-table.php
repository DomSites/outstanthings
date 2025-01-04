<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// @TODO: move here later
?>
<div class="haru-price-table__top">
    <?php if ( $has_icon ) : ?>
    <div class="haru-price-table__icon">
        <<?php echo implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] ); ?>>
        <?php
        if ( $is_new || $migrated ) {
            Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
        } elseif ( ! empty( $settings['icon'] ) ) {
            ?><i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i><?php
        }
        ?>
        </<?php echo $icon_tag; ?>>
    </div>

    <h6 class="haru-price-table__title">
        <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?><?php echo $this->get_render_attribute_string( 'title_text' ); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
    </h6>
    <?php if ( ! Utils::is_empty( $settings['description_text'] ) ) : ?>
    <p <?php echo $this->get_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></p>
    <?php endif; ?>
    
    <?php endif; ?>
</div>

<?php if ( $settings['list'] ) : ?>
    <div class="haru-price-table__content">
        <ul class="haru-price-table__list">
        <?php
            foreach ( $settings['list'] as $item ) :
        ?>
            <li class="haru-price-table__item <?php echo ( 'yes' == $item['list_disable'] ) ? 'content-disable' : ''; ?>">
            <?php if ( $item['list_title'] ) : ?>
                <span class="content-title"><?php echo $item['list_title']; ?></span>
            <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
