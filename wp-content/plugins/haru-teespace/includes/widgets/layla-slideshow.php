<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

namespace Haru_TeeSpace\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Plugin;
use \Elementor\Icons_Manager;
use \Haru_TeeSpace\Classes\Helper as ControlsHelper;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Layla_Slideshow_Widget' ) ) {
    class Haru_TeeSpace_Layla_Slideshow_Widget extends Widget_Base {

        public function get_name() {
            return 'haru-layla-slideshow';
        }

        public function get_title() {
            return esc_html__( 'Haru Layla Slideshow', 'haru-teespace' );
        }

        public function get_icon() {
            return 'eicon-video-playlist';
        }

        public function get_categories() {
            return [ 'haru-elements' ];
        }

        public function get_keywords() {
            return [
                'layla',
                'video',
                'videos',
                'slideshow',
                'video slideshow',
                'videos slideshow',
                'custom videos',
            ];
        }

        public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_style_depends() {
            return [ 'menu-animate' ];
        }

        protected function register_controls() {

            $this->start_controls_section(
                'content_section',
                [
                    'label'     => esc_html__( 'Content', 'haru-teespace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'layout',
                [
                  'label' => esc_html__( 'Layout', 'haru-teespace' ),
                  'type' => Controls_Manager::SELECT,
                  'default' => 'boxed',
                  'options' => [
                    'boxed'      => esc_html__( 'Boxed', 'haru-teespace' ),
                    'fullscreen'    => esc_html__( 'Fullscreen', 'haru-teespace' ),
                  ]
                ]
            );

            $this->add_control(
                'source_type',
                [
                    'label' => esc_html__( 'Source Type', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'haru_video',
                    'options' => [
                        'haru_video' => esc_html__( 'Videos', 'haru-teespace' ),
                        'all_post_types'  => esc_html__( 'All Posts', 'haru-teespace' ),
                        'gallery' => esc_html__( 'Gallery', 'haru-teespace' ),
                        'videos' => esc_html__( 'Custom Videos', 'haru-teespace' )
                    ],
                ]
            );

            // Video
            $this->add_control(
                'videos_ids',
                [
                    'label' => __( 'Search & Select', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => ControlsHelper::get_post_list('haru_video'),
                    'label_block' => true,
                    'multiple' => true,
                    'condition' => [
                        'source_type' => 'haru_video',
                    ],
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label' => __( 'Order By', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => ControlsHelper::get_post_orderby_options(),
                    'default' => 'date',
                    'condition' => [
                        'source_type' => 'haru_video',
                    ],
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => __( 'Order', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'asc' => 'Ascending',
                        'desc' => 'Descending',
                    ],
                    'default' => 'desc',
                    'condition' => [
                        'source_type' => array( 'haru_video', 'all_post_types' ),
                    ],
                ]
            );

            // Posts
            $this->add_control(
                'slides_posts',
                [
                    'label' => __( 'Search & Select', 'haru-teespace' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => ControlsHelper::get_post_list('post'),
                    'label_block' => true,
                    'multiple' => true,
                    'condition' => [
                        'source_type' => array( 'all_post_types' ),
                    ],
                ]
            );

            // Gallery
            $this->add_control(
                'slides_gallery',
                [
                    'label' => __( 'Slides', 'haru-teespace' ),
                    'type' => Controls_Manager::GALLERY,
                    'condition' => [
                        'source_type' => 'gallery'
                    ]
                ]
            );

            // Videos
            $repeater = new Repeater();
            $repeater->add_control(
                'video_title',
                [
                    'label' => __( 'Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                ]
            );

            $repeater->add_control(
                'video_media',
                [
                    'label' => __( 'Choose File', 'haru-teespace' ),
                    'type' => Controls_Manager::MEDIA,
                    'media_type' => 'video',
                ]
            );

            $repeater->add_control(
                'video_permalink',
                [
                    'label' => __( 'Permalink', 'haru-teespace' ),
                    'type' => Controls_Manager::URL,
                ]
            );

            $this->add_control(
                'videos',
                [
                    'label' => __( 'Videos', 'haru-teespace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        
                    ],
                    'title_field' => '{{{ video_title }}}',
                    'condition' => [
                        'source_type' => 'videos'
                    ]
                ]
            );

            $this->add_control(
                'el_class',
                [
                    'label' => __( 'CSS Classes', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => '',
                    'title' => __( 'Add your custom class WITHOUT the dot. e.g: my-class', 'haru-teespace' ),
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'section_content_counter',
                [
                    'label'     => __( 'Counter', 'haru-teespace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'counter_label',
                [
                    'label' => __( 'Counter Label', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Project' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'section_content_button',
                [
                    'label'     => __( 'View All Button', 'haru-teespace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'button_text',
                [
                    'label' => __( 'Button Text', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Click Here' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'button_link',
                [
                    'label' => __( 'Button Link', 'haru-teespace' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', 'haru-teespace' ),
                    'default' => [
                        'url' => '#',
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'section_content_social',
                [
                    'label'     => __( 'Socials', 'haru-teespace' ),
                    'tab'       => Controls_Manager::TAB_CONTENT,
                ]
            );

            $this->add_control(
                'social_title',
                [
                    'label' => __( 'Social Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Follow us' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $social = new Repeater();

            $social->add_control(
                'list_title', [
                    'label' => esc_html__( 'Title', 'haru-teespace' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'List Title' , 'haru-teespace' ),
                    'label_block' => true,
                ]
            );

            $social->add_control(
                'list_icon', [
                    'label' => esc_html__( 'Icon', 'haru-teespace' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-star',
                        'library' => 'solid',
                    ],
                    'label_block' => true,
                ]
            );

            $social->add_control(
                'list_content', [
                    'label' => esc_html__( 'Link', 'haru-teespace' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => __( 'https://your-link.com', 'haru-teespace' ),
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
            );

            $this->add_control(
                'list',
                [
                    'label' => esc_html__( 'Social List', 'haru-teespace' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $social->get_controls(),
                    'default' => [
                        [
                            'list_title' => esc_html__( 'Title #1', 'haru-teespace' ),
                            'list_icon' => esc_html__( 'Item icon. Click to select icon', 'haru-teespace' ),
                            'list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'haru-teespace' ),
                        ],
                        [
                            'list_title' => esc_html__( 'Title #2', 'haru-teespace' ),
                            'list_icon' => esc_html__( 'Item icon. Click to select icon', 'haru-teespace' ),
                            'list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'haru-teespace' ),
                        ],
                    ],
                    'title_field' => '{{{ list_title }}}',
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                'slide_section',
                [
                    'label' => esc_html__( 'Slide Options', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'slider_background_color',
                [
                    'label'     => __( 'Background Color', 'haru-teespace' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-layla-slideshow' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'layout' => [ 'boxed' ],
                    ],
                    
                ]
            );

            $this->add_control(
                'image_overlay_color',
                [
                    'label'     => __( 'Images Overlay Color', 'haru-teespace' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-layla-slideshow .slide-img:before' => 'background-color: {{VALUE}}',
                    ],
                    'separator' => 'after',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'      => 'title_typography',
                    'selector'  => '{{WRAPPER}} .haru-layla-slideshow .slide-title a',
                    'separator' => 'before',
                ]
            );
            
            $this->add_control(
                'text_color_counter',
                [
                    'label'     => __( 'Counter Text Color', 'haru-teespace' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-layla-slideshow .project-counter' => 'color: {{VALUE}}',
                    ],
                    
                ]
            );

            $this->add_control(
                'text_color_title',
                [
                    'label'     => __( 'Title Text Color', 'haru-teespace' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-layla-slideshow .title-wrap .slide-title.active a' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .haru-layla-slideshow .title-wrap .slide-title a' => '-webkit-text-stroke-color: {{VALUE}}',
                    ],
                    
                ]
            );

            $this->add_control(
                'text_color_button',
                [
                    'label'     => __( 'Button Text Color', 'haru-teespace' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-layla-slideshow .view-all-btn' => 'color: {{VALUE}}; border-bottom: 1px solid {{VALUE}}',
                    ],
                    
                ]
            );

            $this->add_control(
                'bullets_color',
                [
                    'label'     => __( 'Bullets Color', 'haru-teespace' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .haru-layla-slideshow .bullet-wrap .slide-bullet:after' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} .haru-layla-slideshow .bullet-wrap .slide-bullet:before' => 'border: 1px solid {{VALUE}}',
                    ],
                    
                ]
            );

            $this->end_controls_section();

        }

        protected function render() {
            $settings = $this->get_settings_for_display();

            $slider_type = 'images';
            if ( $settings['source_type'] == 'videos' )
                $slider_type = 'videos';

            $this->add_render_attribute( 'layla', 'class', 'haru-layla-slideshow' );

            $this->add_render_attribute( 'layla', 'class', 'haru-layla-slideshow--' . $settings['layout'] );

            $this->add_render_attribute( 'layla', 'id', 'haru-layla-slideshow' . rand() );

            $this->add_render_attribute( 'layla', 'data-slider-type', $slider_type );

            if ( ! empty( $settings['el_class'] ) ) {
                $this->add_render_attribute( 'layla', 'class', $settings['el_class'] );
            }

            ?>
            <?php if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) : ?>
                <div class="haru-notice"><?php echo esc_html__( 'Please note layout or action may doesn\'t works on Preview Mode or Editor Mode but works fine on Frontend Mode.', 'haru-teespace' ); ?></div>
            <?php endif; ?>

                <div <?php echo $this->get_render_attribute_string( 'layla' ); ?>>
                    <?php //echo Haru_Template::haru_get_template( 'layla-slideshow/layla-slideshow.php', $settings ); ?>
                    <?php
                        $return = [];
                        if ( $settings['source_type'] == 'haru_video' || $settings['source_type'] == 'all_post_types' ) {
                            $post_ids = $settings['source_type'] == 'haru_video' ? $settings['videos_ids'] : $settings['slides_posts'];
                            $post_query = array(
                                'posts_per_page' => -1,
                                'post__in' => $post_ids,
                                'orderby' => $settings['orderby'],
                                'order' => $settings['order']
                            );

                            if ( $settings['source_type'] == 'haru_video' ) {
                                $post_query['post_type'] = 'haru_video';
                            } else {
                                $post_query['post_type'] = 'post';
                            }
                            
                            $the_query = new \WP_Query( $post_query );
                                    
                            if ( is_object( $the_query ) && $the_query->have_posts() ) :
                                while ( $the_query->have_posts() ) : $the_query->the_post();
                                    $return[] = array(
                                        'id' => (int) get_the_ID(),
                                        'caption'  => '',
                                        'title' => get_the_title( ),
                                        'src' => has_post_thumbnail() ? wp_get_attachment_image_src( get_post_thumbnail_id( (int) get_the_ID() ), 'full' )[0] : '',
                                        'permalink' => get_permalink( )
                                    );
                                endwhile;
                            endif;

                            wp_reset_query();
                        }

                        if ( $settings['source_type'] == 'gallery' ) {
                            if ( ! empty( $settings['slides_gallery'] ) ) {
                                foreach ( $settings['slides_gallery'] as $bulk_img ) {
                                    $return[] = array( 
                                        'caption'  => wp_get_attachment_caption( $bulk_img['id'] ),
                                        'title' => get_the_title( $bulk_img['id'] ),
                                        'src' => $bulk_img['url'],
                                        'permalink' => get_post_meta( $bulk_img['id'], 'ce_permalink', true )
                                    );
                                }  
                            }
                        }

                        if ( $settings['source_type'] == 'videos' ) {
                            $return = $settings['videos'];
                        }

                        $slides = $return;
                    ?>
                    <div class="slider-wrap">
                        <div class="images-wrap">
                            <div class="slide-img-wrap">
                            <?php
                                $aindex = 0;
                                if ( ! empty( $slides ) ): 
                                    foreach( $slides as $slide ): 
                                        $aindex++;
                                        $extra_class = '';
                                        if ( $aindex == 1 ) {
                                            $extra_class = 'active';
                                        }
                                        // @TODO: scroll next page effect
                            ?>
                                <div class="slide-img <?php echo esc_attr( $extra_class ); ?>">
                                    <?php if ( $settings['source_type'] != 'videos' ) : ?>
                                    <img src="<?php echo esc_url( $slide['src'] ) ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>" />
                                    <?php endif; ?>

                                    <?php if ( $settings['source_type'] == 'videos' ) : ?>
                                        <?php if( $slide['video_media'] && is_array( $slide['video_media'] ) ) : ?>
                                            <video src="<?php echo esc_url( $slide['video_media']['url'] ) ?>" type="<?php echo esc_attr( get_post_mime_type( $slide['video_media']['id'] ) ) ?>" muted webkit-playsinline playsinline loop <?php if ( $aindex == 1 ) echo 'autoplay'; ?>>
                                            </video>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </div>
                        </div>

                        <div class="title-wrap">
                            <?php
                                $aindex = 0;
                                if ( ! empty( $slides ) ) : 
                                    foreach( $slides as $slide ): 
                                        $aindex++;
                                        $extra_class = '';
                                        if ( $aindex == 1 )
                                            $extra_class = 'active';
                                        // @TODO: scroll next page effect
                            ?>
                                <?php if ( $settings['source_type'] != 'videos' ) : ?>
                                    <div class="slide-title <?php echo esc_attr( $extra_class ) ?>" data-id="<?php echo esc_attr( $aindex ) ?>">
                                        <a href="<?php echo esc_url( $slide['permalink'] ) ?>"><?php echo esc_html( $slide['title'] ) ?></a>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $settings['source_type'] == 'videos' ) : ?>
                                    <div class="slide-title <?php echo esc_attr( $extra_class ) ?>" data-id="<?php echo esc_attr( $aindex ) ?>">
                                        <a href="<?php echo esc_url( $slide['video_permalink']['url'] ) ?>"><?php echo esc_html( $slide['video_title'] ) ?></a>
                                    </div>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        <?php endif; ?>
                        </div>

                        <div class="bullet-wrap">
                            <?php
                                $aindex = 1;
                                if ( ! empty( $slides ) ): 
                                    foreach( $slides as $slide ): 
                                        $extra_class = '';
                                        if ( $aindex == 1 )
                                            $extra_class = 'active';
                                        
                                ?>
                                    <div class="slide-bullet <?php echo esc_attr( $extra_class ) ?>" data-id="<?php echo esc_attr( $aindex ) ?>">
                                    </div>

                                    <?php $aindex++; endforeach; ?>
                                <?php endif; ?>
                        </div>

                        <div class="project-counter">
                            <span class="text"><?php echo esc_html( $settings['counter_label'] ) ?></span>
                            <span class="counter">1</span>
                            <span class="total"> / <?php echo count( $slides ) ?></span>
                        </div>

                        <a href="<?php echo esc_url( $settings['button_link']['url'] ) ?>" class="view-all-btn"><?php echo esc_html( $settings['button_text'] ) ?></a>

                        <?php if ( $settings['list'] ) : ?>
                            <div class="social-wrap">
                                <div class="social-label"><?php echo esc_html( $settings['social_title'] ); ?></div>
                                <ul class="social-list">
                                    <?php 
                                        foreach (  $settings['list'] as $item ) :
                                        $target = $item['list_content']['is_external'] ? ' target="_blank"' : '';
                                        $nofollow = $item['list_content']['nofollow'] ? ' rel="nofollow"' : '';
                                    ?>

                                    <li>
                                        <a href="<?php echo $item['list_content']['url']; ?>" <?php echo $target . $nofollow; ?>>
                                            <div class="social-list__icon"><?php Icons_Manager::render_icon( $item['list_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
                                            <div class="social-list__title"><?php echo $item['list_title']; ?></div>
                                        </a>
                                    </li>
                                        
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php
        }
    }
}
