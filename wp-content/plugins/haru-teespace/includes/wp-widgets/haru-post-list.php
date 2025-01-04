<?php
/**
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

defined( 'ABSPATH' ) || exit;

class Haru_Post_List_Widget extends Haru_TeeSpace_Widget {

    /**
     * Constructor.
     */

    public function __construct() {
        $this->widget_id          = 'haru_widget_post_list';
        $this->widget_name        = esc_html__( 'Haru Post List', 'haru-teespace' );
        $this->widget_description = esc_html__( 'Widget display posts.', 'haru-teespace' );
        $this->widget_cssclass    = 'widget-post-list';
        $this->cached             = false;

        $categories               = array();
        $categories               = get_categories( array(
                                        'orderby' => 'NAME',
                                        'order'   => 'ASC'
                                    ));
        $categories_options = array();
        foreach ( $categories as $category ) {
            $categories_options[$category->term_id] = $category->name;
        }

        $this->settings = array(
            'title'         => array(
                'type'  => 'text',
                'std'   => esc_html__( 'Posts', 'haru-teespace' ),
                'label' => esc_html__( 'Title', 'haru-teespace' )
            ),
            'style'         => array(
                'type'    => 'select',
                'std'     => 'thumb-left',
                'label'   => esc_html__( 'Style', 'haru-teespace' ),
                'options' => array(
                    'thumb-left' => esc_html__( 'Thumbnail Left', 'haru-teespace' ),
                    'thumb-right' => esc_html__( 'Thumbnail Right', 'haru-teespace' ),
                    'thumb-full' => esc_html__( 'Thumbnail Full Width', 'haru-teespace' ),
                )
            ),
            'posts_per_page' => array(
                'type'  => 'number',
                'step'  => 1,
                'min'   => 1,
                'max'   => '',
                'std'   => 5,
                'label' => esc_html__( 'Number of posts to show', 'haru-teespace' )
            ),
            'orderby' => array(
                'type'    => 'select',
                'std'     => 'date',
                'label'   => esc_html__( 'Order by', 'haru-teespace' ),
                'options' => array(
                    'title'  => esc_html__( 'Title', 'haru-teespace' ),
                    'date'  => esc_html__( 'Date', 'haru-teespace' ),
                    'popular' => esc_html__( 'Popular', 'haru-teespace' ),
                    'comment' => esc_html__( 'Comment', 'haru-teespace' ),
                    'rand' => esc_html__( 'Random', 'haru-teespace' ),
                )
            ),
            'order'       => array(
                'type'    => 'select',
                'std'     => 'desc',
                'label'   => _x( 'Order', 'Sorting order', 'haru-teespace' ),
                'options' => array(
                    'asc'  => esc_html__( 'ASC', 'haru-teespace' ),
                    'desc' => esc_html__( 'DESC', 'haru-teespace' ),
                ),
            ),
            'categories' => array(
                'type'     => 'select',
                'std'      => array(),
                'multiple' => '1',
                'label'    =>esc_html__( 'Categories', 'haru-teespace' ),
                'desc'     => esc_html__( 'Select a category or leave blank for all', 'haru-teespace' ),
                'options'  => $categories_options,
            ),
            'hide_category' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Hide category in post meta info', 'haru-teespace' )
            ),
            'hide_author' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Hide author in post meta info', 'haru-teespace' )
            ),
            'hide_date' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Hide date in post meta info', 'haru-teespace' )
            ),
            'hide_comment' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Hide comment in post meta info', 'haru-teespace' )
            ),
        );

        parent::__construct();
    }
    
    public function widget( $args, $instance ) {
        ob_start();
        extract( $args );

        $title          = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $style          = isset( $instance['style'] ) ? $instance['style'] : $this->settings['style']['std'];
        $posts_per_page = ! empty( $instance['posts_per_page'] ) ? absint( $instance['posts_per_page'] ) : $this->settings['posts_per_page']['std'];
        $orderby        = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : $this->settings['orderby']['std'];
        $order          = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];
        $hide_category          = ! empty( $instance['hide_category'] ) ? sanitize_title( $instance['hide_category'] ) : $this->settings['hide_category']['std'];
        $hide_author          = ! empty( $instance['hide_author'] ) ? sanitize_title( $instance['hide_author'] ) : $this->settings['hide_author']['std'];
        $hide_date          = ! empty( $instance['hide_date'] ) ? sanitize_title( $instance['hide_date'] ) : $this->settings['hide_date']['std'];
        $hide_comment          = ! empty( $instance['hide_comment'] ) ? sanitize_title( $instance['hide_comment'] ) : $this->settings['hide_comment']['std'];

        $categories     = $instance['categories'];

        $query_args = array(
            'posts_per_page' => $posts_per_page,
            'post_status'    => 'publish',
            'post_type'      => 'post',
            'no_found_rows'  => 1,
            'order'          => $order,
            'meta_query'     => array(),
            'tax_query'      => array(
                'relation' => 'AND',
            ),
        ); // WPCS: slow query ok.

        if ( $categories ) {
            $query_args['category__in'] = $categories;
        }

        switch ( $orderby ) {
            case 'title':
                $query_args['orderby']  = 'title';
                break;
            case 'popular':
                $query_args['orderby'] = 'meta_value_num';
                break;
            case 'comment':
                $query_args['orderby'] = 'comment_count';
                break;
            case 'rand':
                $query_args['orderby'] = 'rand';
                break;

            default:
                $query_args['orderby'] = 'date';
        }

        $posts = new WP_Query( $query_args );

        if ( $posts && $posts->have_posts() ) :
            echo $before_widget;
                if ( $title ) echo $before_title . $title . $after_title;
                echo '<ul class="post-list ' . esc_attr( $style ) . '">';
                while ( $posts->have_posts() ) : $posts->the_post(); ?>
                    <li class="post-item">
                        <div class="post-thumbnail">
                            <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ); ?>" alt="<?php the_title_attribute(); ?>">
                            </a>
                        </div>
                        <div class="post-content">
                            <?php if ( $hide_category != '1' ) : ?>
                                <div class="post-category"><?php echo get_the_category_list(', '); ?></div>
                            <?php endif; ?>
                            <h6 class="post-title"><a href="<?php echo esc_url(get_the_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php echo get_the_title(); ?></a></h6>
                            <div class="post-meta">
                                <?php if ( $hide_author != '1' ) : ?>
                                    <span class="post-author"><?php printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() )); ?></span>
                                <?php endif; ?>

                                <?php if ( $hide_date != '1' ) : ?>
                                    <span class="post-datetime"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></span>
                                <?php endif; ?>

                                <?php if ( $hide_comment != '1' ) :
                                    $output = '';
                                    $number = get_comments_number( get_the_ID() );
                                    if ( $number > 1 ) {
                                        $output = str_replace( '%', number_format_i18n( $number ), ( false === false ) ? esc_html__( '%', 'haru-teespace' ) : false );
                                    } elseif ( $number == 0 ) {
                                        $output = ( false === false ) ? esc_html__( '0', 'haru-teespace' ) : false;
                                    } else { // must be one
                                        $output = ( false === false ) ? esc_html__( '1', 'haru-teespace' ) : false;
                                    }
                                ?>
                                    <span class="post-comment"><a href="<?php echo esc_url(get_comments_link()); ?>"><?php echo $output; ?></a></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endwhile;
                echo  '</ul>';
            echo $after_widget;
        endif;

        $content = ob_get_clean();
        wp_reset_query();
        echo $content;
    }

}

if ( ! function_exists( 'haru_register_widget_post_list' ) ) {
    function haru_register_widget_post_list() {
        register_widget( 'Haru_Post_List_Widget' );
    }

    add_action( 'widgets_init', 'haru_register_widget_post_list' );
}
