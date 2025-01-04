<?php
/**
 * The template for displaying the footer
 *
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 */

?>
<!DOCTYPE html>
<!-- Open HTML -->
<html <?php language_attributes(); ?>>
    <!-- Open Head -->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="//gmpg.org/xfn/11">
        <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) : ?>
            <?php
                if ( function_exists( 'haru_get_option' ) ) :
                    $custom_favicon = haru_get_option( 'haru_custom_favicon' );
                    if ( isset( $custom_favicon ) && !empty( $custom_favicon['url'] ) ) : 
            ?>
                <link rel="shortcut icon" href="<?php echo esc_url( haru_get_option( 'haru_custom_favicon' )['url'] ); ?>" />
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php wp_head(); ?>
    </head>
    <!-- Close Head -->
    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <!-- Open Haru Main -->
        <div id="haru-main">
        	<!-- Open Haru Content Main -->
            <div id="haru-content-main">
		        <div class="haru-single-builder">
					<?php
						if ( have_posts() ) :
				            // Start the Loop.
				            while ( have_posts() ) : the_post();
								the_content();
							endwhile;
							// End the Loop.
						endif;
					?>
				</div>
			</div>
		</div>
        <?php wp_footer(); ?>
    </body>
</html>