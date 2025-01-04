<?php 
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
*/

get_header();
?>
<section class="haru-404-page">
  <div class="haru-container">
    <div class="haru-content-404">
      <div class="page-content">
        <h2 class="entry-title haru-title-404"><?php echo esc_html__( '404', 'teespace' ); ?></h2>
        <p class="txt2"><?php echo esc_html__( 'Sorry, looks like this page doesn\'t exist', 'teespace' ); ?></p>
        <p class="txt3"><?php echo esc_html__( 'You could either go to homepage', 'teespace' ); ?></p>
        <a href="<?php echo esc_url(home_url( '/' )); ?>" title="<?php echo esc_attr__( 'Home Page','teespace' ); ?>" class="haru-button haru-button--size-medium haru-button--bg-primary haru-button--round-normal">
          <?php echo esc_html__( 'Back to home', 'teespace' ); ?>
        </a>
      </div>
      <!-- .page-content -->
    </div>
  </div>
</section>
<?php get_footer(); ?>
