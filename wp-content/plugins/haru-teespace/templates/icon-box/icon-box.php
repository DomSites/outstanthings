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
<?php if ( $has_icon ) : ?>
<div class="haru-icon-box__icon">
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

<div class="haru-icon-box__content">
    <h6 class="haru-icon-box__title">
        <<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); ?><?php echo $this->get_render_attribute_string( 'title_text' ); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
    </h6>
    <?php if ( ! Utils::is_empty( $settings['description_text'] ) ) : ?>
    <p <?php echo $this->get_render_attribute_string( 'description_text' ); ?>><?php echo $settings['description_text']; ?></p>
    <?php endif; ?>
</div>
<?php endif; ?>

