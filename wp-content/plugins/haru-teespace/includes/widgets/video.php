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
use \Elementor\Modules\DynamicTags\Module as TagsModule;
use \Elementor\Plugin;
use \Elementor\Icons_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Embed;
use \Elementor\Utils;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Video_Widget' ) ) {
	class Haru_TeeSpace_Video_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-video';
		}

		public function get_title() {
			return esc_html__( 'Haru Video', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-instagram-video';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'videos',
                'video',
                'player', 
                'embed', 
                'youtube', 
                'vimeo', 
                'dailymotion'
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

		protected function register_controls() {

			$this->start_controls_section(
	            'section_video',
	            [
	                'label' => esc_html__( 'Video', 'haru-teespace' ),
	                'tab' => Controls_Manager::TAB_CONTENT,
	            ]
	        );

	        $this->add_control(
				'pre_style',
				[
					'label' => __( 'Pre Video', 'haru-teespace' ),
					'description' 	=> __( 'If you choose Pre Video you will use Style default from our theme.', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' 		=> __( 'Default', 'haru-teespace' ),
						'button-icon' 	=> __( 'Button Icon', 'haru-teespace' ),
						'button-icon-2' => __( 'Button Icon 2', 'haru-teespace' ),
						'button-text' 	=> __( 'Button Text', 'haru-teespace' ),
					]
				]
			);

			$this->add_control(
				'button_text',
				[
					'label' => esc_html__( 'Button Text', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'View video', 'haru-teespace' ),
					'default' => esc_html__( 'View video', 'haru-teespace' ),
					'label_block' => true,
					'condition' => [
						'pre_style' => 'button-text',
					],
					'separator' => 'after',
				]
			);

	        $this->add_control(
				'video_type',
				[
					'label' => esc_html__( 'Source', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'youtube',
					'options' => [
						'youtube' => esc_html__( 'YouTube', 'haru-teespace' ),
						'vimeo' => esc_html__( 'Vimeo', 'haru-teespace' ),
						'dailymotion' => esc_html__( 'Dailymotion', 'haru-teespace' ),
						'hosted' => esc_html__( 'Self Hosted', 'haru-teespace' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'youtube_url',
				[
					'label' => esc_html__( 'Link', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
						'categories' => [
							TagsModule::POST_META_CATEGORY,
							TagsModule::URL_CATEGORY,
						],
					],
					'placeholder' => esc_html__( 'Enter your URL', 'haru-teespace' ) . ' (YouTube)',
					'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
					'label_block' => true,
					'condition' => [
						'video_type' => 'youtube',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'vimeo_url',
				[
					'label' => esc_html__( 'Link', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
						'categories' => [
							TagsModule::POST_META_CATEGORY,
							TagsModule::URL_CATEGORY,
						],
					],
					'placeholder' => esc_html__( 'Enter your URL', 'haru-teespace' ) . ' (Vimeo)',
					'default' => 'https://vimeo.com/235215203',
					'label_block' => true,
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'dailymotion_url',
				[
					'label' => esc_html__( 'Link', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
						'categories' => [
							TagsModule::POST_META_CATEGORY,
							TagsModule::URL_CATEGORY,
						],
					],
					'placeholder' => esc_html__( 'Enter your URL', 'haru-teespace' ) . ' (Dailymotion)',
					'default' => 'https://www.dailymotion.com/video/x6tqhqb',
					'label_block' => true,
					'condition' => [
						'video_type' => 'dailymotion',
					],
				]
			);

			$this->add_control(
				'insert_url',
				[
					'label' => esc_html__( 'External URL', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => 'hosted',
					],
				]
			);

			$this->add_control(
				'hosted_url',
				[
					'label' => esc_html__( 'Choose File', 'haru-teespace' ),
					'type' => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
						'categories' => [
							TagsModule::MEDIA_CATEGORY,
						],
					],
					'media_type' => 'video',
					'condition' => [
						'video_type' => 'hosted',
						'insert_url' => '',
					],
				]
			);

			$this->add_control(
				'external_url',
				[
					'label' => esc_html__( 'URL', 'haru-teespace' ),
					'type' => Controls_Manager::URL,
					'autocomplete' => false,
					'options' => false,
					'label_block' => true,
					'show_label' => false,
					'dynamic' => [
						'active' => true,
						'categories' => [
							TagsModule::POST_META_CATEGORY,
							TagsModule::URL_CATEGORY,
						],
					],
					'media_type' => 'video',
					'placeholder' => esc_html__( 'Enter your URL', 'haru-teespace' ),
					'condition' => [
						'video_type' => 'hosted',
						'insert_url' => 'yes',
					],
				]
			);

			$this->add_control(
				'start',
				[
					'label' => esc_html__( 'Start Time', 'haru-teespace' ),
					'type' => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Specify a start time (in seconds)', 'haru-teespace' ),
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'end',
				[
					'label' => esc_html__( 'End Time', 'haru-teespace' ),
					'type' => Controls_Manager::NUMBER,
					'description' => esc_html__( 'Specify an end time (in seconds)', 'haru-teespace' ),
					'condition' => [
						'video_type' => [ 'youtube', 'hosted' ],
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'video_options',
				[
					'label' => esc_html__( 'Video Options', 'haru-teespace' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'autoplay',
				[
					'label' => esc_html__( 'Autoplay', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'show_image_overlay',
								'value' => '',
							],
							[
								'name' => 'image_overlay[url]',
								'value' => '',
							],
						],
					],
				]
			);

			$this->add_control(
				'play_on_mobile',
				[
					'label' => esc_html__( 'Play On Mobile', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'condition' => [
						'autoplay' => 'yes',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'mute',
				[
					'label' => esc_html__( 'Mute', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'loop',
				[
					'label' => esc_html__( 'Loop', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type!' => 'dailymotion',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'controls',
				[
					'label' => esc_html__( 'Player Controls', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'haru-teespace' ),
					'label_on' => esc_html__( 'Show', 'haru-teespace' ),
					'default' => 'yes',
					'condition' => [
						'video_type!' => 'vimeo',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'showinfo',
				[
					'label' => esc_html__( 'Video Info', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'haru-teespace' ),
					'label_on' => esc_html__( 'Show', 'haru-teespace' ),
					'default' => 'yes',
					'condition' => [
						'video_type' => [ 'dailymotion' ],
					],
				]
			);

			$this->add_control(
				'modestbranding',
				[
					'label' => esc_html__( 'Modest Branding', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'condition' => [
						'video_type' => [ 'youtube' ],
						'controls' => 'yes',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'logo',
				[
					'label' => esc_html__( 'Logo', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'haru-teespace' ),
					'label_on' => esc_html__( 'Show', 'haru-teespace' ),
					'default' => 'yes',
					'condition' => [
						'video_type' => [ 'dailymotion' ],
					],
				]
			);

			// YouTube.
			$this->add_control(
				'yt_privacy',
				[
					'label' => esc_html__( 'Privacy Mode', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'description' => esc_html__( 'When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'haru-teespace' ),
					'condition' => [
						'video_type' => 'youtube',
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'lazy_load',
				[
					'label' => esc_html__( 'Lazy Load', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'video_type',
								'operator' => '===',
								'value' => 'youtube',
							],
							[
								'relation' => 'and',
								'terms' => [
									[
										'name' => 'show_image_overlay',
										'operator' => '===',
										'value' => 'yes',
									],
									[
										'name' => 'video_type',
										'operator' => '!==',
										'value' => 'hosted',
									],
								],
							],
						],
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'rel',
				[
					'label' => esc_html__( 'Suggested Videos', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'' => esc_html__( 'Current Video Channel', 'haru-teespace' ),
						'yes' => esc_html__( 'Any Video', 'haru-teespace' ),
					],
					'condition' => [
						'video_type' => 'youtube',
					],
				]
			);

			// Vimeo.
			$this->add_control(
				'vimeo_title',
				[
					'label' => esc_html__( 'Intro Title', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'haru-teespace' ),
					'label_on' => esc_html__( 'Show', 'haru-teespace' ),
					'default' => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_portrait',
				[
					'label' => esc_html__( 'Intro Portrait', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'haru-teespace' ),
					'label_on' => esc_html__( 'Show', 'haru-teespace' ),
					'default' => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'vimeo_byline',
				[
					'label' => esc_html__( 'Intro Byline', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'haru-teespace' ),
					'label_on' => esc_html__( 'Show', 'haru-teespace' ),
					'default' => 'yes',
					'condition' => [
						'video_type' => 'vimeo',
					],
				]
			);

			$this->add_control(
				'color',
				[
					'label' => esc_html__( 'Controls Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'condition' => [
						'video_type' => [ 'vimeo', 'dailymotion' ],
					],
				]
			);

			$this->add_control(
				'download_button',
				[
					'label' => esc_html__( 'Download Button', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'haru-teespace' ),
					'label_on' => esc_html__( 'Show', 'haru-teespace' ),
					'condition' => [
						'video_type' => 'hosted',
					],
				]
			);

			$this->add_control(
				'poster',
				[
					'label' => esc_html__( 'Poster', 'haru-teespace' ),
					'type' => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
					'condition' => [
						'video_type' => 'hosted',
					],
				]
			);

			$this->add_control(
				'view',
				[
					'label' => esc_html__( 'View', 'haru-teespace' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => 'youtube',
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
				'section_image_overlay',
				[
					'label' => esc_html__( 'Image Overlay', 'haru-teespace' ),
					'condition' => [
						'pre_style' => 'default',
					],
				]
			);

			$this->add_control(
				'show_image_overlay',
				[
					'label' => esc_html__( 'Image Overlay', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'label_off' => esc_html__( 'Hide', 'haru-teespace' ),
					'label_on' => esc_html__( 'Show', 'haru-teespace' ),
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'image_overlay',
				[
					'label' => esc_html__( 'Choose Image', 'haru-teespace' ),
					'type' => Controls_Manager::MEDIA,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'dynamic' => [
						'active' => true,
					],
					'condition' => [
						'show_image_overlay' => 'yes',
					],
					'frontend_available' => true,
				]
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name' => 'image_overlay', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_overlay_size` and `image_overlay_custom_dimension`.
					'default' => 'full',
					'separator' => 'none',
					'condition' => [
						'show_image_overlay' => 'yes',
					],
				]
			);

			$this->add_control(
				'show_play_icon',
				[
					'label' => esc_html__( 'Play Icon', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'condition' => [
						'show_image_overlay' => 'yes',
						'image_overlay[url]!' => '',
					],
				]
			);

			$this->add_control(
				'lightbox',
				[
					'label' => esc_html__( 'Lightbox', 'haru-teespace' ),
					'type' => Controls_Manager::SWITCHER,
					'frontend_available' => true,
					'label_off' => esc_html__( 'Off', 'haru-teespace' ),
					'label_on' => esc_html__( 'On', 'haru-teespace' ),
					'condition' => [
						'show_image_overlay' => 'yes',
						'image_overlay[url]!' => '',
					],
					'separator' => 'before',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'section_video_style',
				[
					'label' => esc_html__( 'Video', 'haru-teespace' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'aspect_ratio',
				[
					'label' => esc_html__( 'Aspect Ratio', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'169' => '16:9',
						'219' => '21:9',
						'43' => '4:3',
						'32' => '3:2',
						'11' => '1:1',
						'916' => '9:16',
					],
					'default' => '169',
					'prefix_class' => 'elementor-aspect-ratio-',
					'frontend_available' => true,
				]
			);

			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name' => 'css_filters',
					'selector' => '{{WRAPPER}} .elementor-wrapper',
				]
			);

			$this->add_control(
				'play_icon_title',
				[
					'label' => esc_html__( 'Play Icon', 'haru-teespace' ),
					'type' => Controls_Manager::HEADING,
					'condition' => [
						'show_image_overlay' => 'yes',
						'show_play_icon' => 'yes',
					],
					'separator' => 'before',
				]
			);

			$this->add_control(
				'play_icon_color',
				[
					'label' => esc_html__( 'Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-custom-embed-play i' => 'color: {{VALUE}}',
						'{{WRAPPER}} .elementor-custom-embed-play svg' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'show_image_overlay' => 'yes',
						'show_play_icon' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'play_icon_size',
				[
					'label' => esc_html__( 'Size', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 10,
							'max' => 300,
						],
					],
					'selectors' => [
						// Not using a CSS vars because the default size value is coming from a global scss file.
						'{{WRAPPER}} .elementor-custom-embed-play i' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .elementor-custom-embed-play svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'show_image_overlay' => 'yes',
						'show_play_icon' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'play_icon_text_shadow',
					'selector' => '{{WRAPPER}} .elementor-custom-embed-play i',
					'fields_options' => [
						'text_shadow_type' => [
							'label' => _x( 'Shadow', 'Text Shadow Control', 'haru-teespace' ),
						],
					],
					'condition' => [
						'show_image_overlay' => 'yes',
						'show_play_icon' => 'yes',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'section_lightbox_style',
				[
					'label' => esc_html__( 'Lightbox', 'haru-teespace' ),
					'tab' => Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_image_overlay' => 'yes',
						'image_overlay[url]!' => '',
						'lightbox' => 'yes',
					],
				]
			);

			$this->add_control(
				'lightbox_color',
				[
					'label' => esc_html__( 'Background Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'#elementor-lightbox-{{ID}}' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'lightbox_ui_color',
				[
					'label' => esc_html__( 'UI Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button' => 'color: {{VALUE}}',
						'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button svg' => 'fill: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'lightbox_ui_color_hover',
				[
					'label' => esc_html__( 'UI Hover Color', 'haru-teespace' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button:hover' => 'color: {{VALUE}}',
						'#elementor-lightbox-{{ID}} .dialog-lightbox-close-button:hover svg' => 'fill: {{VALUE}}',
					],
					'separator' => 'after',
				]
			);

			$this->add_control(
				'lightbox_video_width',
				[
					'label' => esc_html__( 'Content Width', 'haru-teespace' ),
					'type' => Controls_Manager::SLIDER,
					'default' => [
						'unit' => '%',
					],
					'range' => [
						'%' => [
							'min' => 30,
						],
					],
					'selectors' => [
						'(desktop+)#elementor-lightbox-{{ID}} .elementor-video-container' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'lightbox_content_position',
				[
					'label' => esc_html__( 'Content Position', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'frontend_available' => true,
					'options' => [
						'' => esc_html__( 'Center', 'haru-teespace' ),
						'top' => esc_html__( 'Top', 'haru-teespace' ),
					],
					'selectors' => [
						'#elementor-lightbox-{{ID}} .elementor-video-container' => '{{VALUE}}; transform: translateX(-50%);',
					],
					'selectors_dictionary' => [
						'top' => 'top: 60px',
					],
				]
			);

			$this->add_responsive_control(
				'lightbox_content_animation',
				[
					'label' => esc_html__( 'Entrance Animation', 'haru-teespace' ),
					'type' => Controls_Manager::ANIMATION,
					'frontend_available' => true,
				]
			);

			$this->end_controls_section();

		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			$video_url = $settings[ $settings['video_type'] . '_url' ];

			if ( 'hosted' === $settings['video_type'] ) {
				$video_url = $this->get_hosted_video_url();
			} else {
				$embed_params = $this->get_embed_params();
				$embed_options = $this->get_embed_options();
			}

			if ( empty( $video_url ) ) {
				return;
			}

			if ( 'youtube' === $settings['video_type'] ) {
				$video_html = '<div class="elementor-video"></div>';
			}

			if ( 'hosted' === $settings['video_type'] ) {
				$this->add_render_attribute( 'video-wrapper', 'class', 'e-hosted-video' );

				ob_start();

				$this->render_hosted_video();

				$video_html = ob_get_clean();
			} else {
				$is_static_render_mode = Plugin::$instance->frontend->is_static_render_mode();
				$post_id = get_queried_object_id();

				if ( $is_static_render_mode ) {
					$video_html = Embed::get_embed_thumbnail_html( $video_url, $post_id );
					// YouTube API requires a different markup which was set above.
				} else if ( 'youtube' !== $settings['video_type'] ) {
					$video_html = Embed::get_embed_html( $video_url, $embed_params, $embed_options );
				}
			}

			if ( empty( $video_html ) ) {
				echo esc_url( $video_url );

				return;
			}

			$this->add_render_attribute( 'video-wrapper', 'class', 'elementor-wrapper' );
			$this->add_render_attribute( 'video-wrapper', 'class', 'haru-video' );

			// Pre style
			if ( in_array( $settings['pre_style'], array( 'button-text', 'button-icon', 'button-icon-2' ) ) ) {
				$settings['lightbox'] = 'yes';
			}

			$this->add_render_attribute( 'video-wrapper', 'class', 'haru-video--' . $settings['pre_style'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'video-wrapper', 'class', $settings['el_class'] );
			}

			// 
			if ( ! $settings['lightbox'] ) {
				$this->add_render_attribute( 'video-wrapper', 'class', 'elementor-fit-aspect-ratio' );
			}

			$this->add_render_attribute( 'video-wrapper', 'class', 'elementor-open-' . ( $settings['lightbox'] ? 'lightbox' : 'inline' ) );
			?>
			<div <?php $this->print_render_attribute_string( 'video-wrapper' ); ?>>

				<?php
				if ( ! $settings['lightbox'] ) {
					Utils::print_unescaped_internal_string( $video_html ); // XSS ok.
				}

				// Pre style
				if ( in_array( $settings['pre_style'], array( 'button-text', 'button-icon', 'button-icon-2' ) ) ) {
					$settings['lightbox'] = 'yes';

					$this->add_render_attribute( 'image-overlay', 'class', 'elementor-custom-embed-image-overlay' );

					if ( 'hosted' === $settings['video_type'] ) {
						$lightbox_url = $video_url;
					} else {
						$lightbox_url = Embed::get_embed_url( $video_url, $embed_params, $embed_options );
					}

					$lightbox_options = [
						'type' => 'video',
						'videoType' => $settings['video_type'],
						'url' => $lightbox_url,
						'modalOptions' => [
							'id' => 'elementor-lightbox-' . $this->get_id(),
							'entranceAnimation' => $settings['lightbox_content_animation'],
							'entranceAnimation_tablet' => $settings['lightbox_content_animation_tablet'],
							'entranceAnimation_mobile' => $settings['lightbox_content_animation_mobile'],
							'videoAspectRatio' => $settings['aspect_ratio'],
						],
					];

					if ( 'hosted' === $settings['video_type'] ) {
						$lightbox_options['videoParams'] = $this->get_hosted_params();
					}

					$this->add_render_attribute( 'image-overlay', [
						'data-elementor-open-lightbox' => 'yes',
						'data-elementor-lightbox' => wp_json_encode( $lightbox_options ),
						// 'e-action-hash' => Plugin::instance()->frontend->create_action_hash( 'lightbox', $lightbox_options ),
					] );

					if ( Plugin::$instance->editor->is_edit_mode() ) {
						$this->add_render_attribute( 'image-overlay', [
							'class' => 'elementor-clickable',
						] );
					}
				}
				?>
				<?php if ( 'button-text' == $settings['pre_style']  ) : ?>
				<div <?php $this->print_render_attribute_string( 'image-overlay' ); ?>>
					<a href="#" class="haru-button haru-button--text-black haru-button-link haru-button--size-large"><?php echo $settings['button_text']; ?>
						<?php
							Icons_Manager::render_icon( [
								'library' => 'hicon',
								'value' => 'hicon-play-circle',
							], [ 'aria-hidden' => 'true' ] );
						?>
					</a>
				</div>
				<?php endif; ?>

				<!--  -->
				<?php if ( in_array( $settings['pre_style'], array( 'button-icon', 'button-icon-2' ) ) ) : ?>
				<div <?php $this->print_render_attribute_string( 'image-overlay' ); ?>>
					<a href="#" class="haru-button-link">
						<?php
							Icons_Manager::render_icon( [
								'library' => 'hicon',
								'value' => 'hicon-play-circle',
							], [ 'aria-hidden' => 'true' ] );
						?>
					</a>
				</div>
				<?php endif; ?>

				<!-- Default -->
				<?php if ( 'default' == $settings['pre_style']  ) : ?>
				<?php
				if ( $this->has_image_overlay() ) {
					$this->add_render_attribute( 'image-overlay', 'class', 'elementor-custom-embed-image-overlay' );

					if ( $settings['lightbox'] ) {
						if ( 'hosted' === $settings['video_type'] ) {
							$lightbox_url = $video_url;
						} else {
							$lightbox_url = Embed::get_embed_url( $video_url, $embed_params, $embed_options );
						}

						$lightbox_options = [
							'type' => 'video',
							'videoType' => $settings['video_type'],
							'url' => $lightbox_url,
							'modalOptions' => [
								'id' => 'elementor-lightbox-' . $this->get_id(),
								'entranceAnimation' => $settings['lightbox_content_animation'],
								'entranceAnimation_tablet' => $settings['lightbox_content_animation_tablet'],
								'entranceAnimation_mobile' => $settings['lightbox_content_animation_mobile'],
								'videoAspectRatio' => $settings['aspect_ratio'],
							],
						];

						if ( 'hosted' === $settings['video_type'] ) {
							$lightbox_options['videoParams'] = $this->get_hosted_params();
						}

						$this->add_render_attribute( 'image-overlay', [
							'data-elementor-open-lightbox' => 'yes',
							'data-elementor-lightbox' => wp_json_encode( $lightbox_options ),
							// 'e-action-hash' => Plugin::instance()->frontend->create_action_hash( 'lightbox', $lightbox_options ),
						] );

						if ( Plugin::$instance->editor->is_edit_mode() ) {
							$this->add_render_attribute( 'image-overlay', [
								'class' => 'elementor-clickable',
							] );
						}
					} else {
						// When there is an image URL but no ID, it means the overlay image is the placeholder. In this case, get the placeholder URL.
						if ( empty( $settings['image_overlay']['id'] && ! empty( $settings['image_overlay']['url'] ) ) ) {
							$image_url = $settings['image_overlay']['url'];
						} else {
							$image_url = Group_Control_Image_Size::get_attachment_image_src( $settings['image_overlay']['id'], 'image_overlay', $settings );
						}

						$this->add_render_attribute( 'image-overlay', 'style', 'background-image: url(' . $image_url . ');' );
					}
					?>
					<div <?php $this->print_render_attribute_string( 'image-overlay' ); ?>>
						<?php if ( $settings['lightbox'] ) : ?>
							<?php Group_Control_Image_Size::print_attachment_image_html( $settings, 'image_overlay' ); ?>
						<?php endif; ?>
						<?php if ( 'yes' === $settings['show_play_icon'] ) : ?>
							<?php if ( 'button-text' == $settings['pre_style']  ) : ?>
								<a href="" class="haru-button haru-button--bg-primary haru-button--size-medium haru-button--round-normal haru-button-link"><?php echo $settings['button_text']; ?></a>
							<?php endif; ?>

							<div class="elementor-custom-embed-play" role="button">
								<?php
									Icons_Manager::render_icon( [
										'library' => 'hicon',
										'value' => 'hicon-play-circle',
									], [ 'aria-hidden' => 'true' ] );
								?>
								<span class="elementor-screen-only"><?php echo esc_html__( 'Play Video', 'haru-teespace' ); ?></span>
							</div>
						<?php endif; ?>
					</div>
				<?php } ?>
				<?php endif; ?>
			</div>
			<?php
		}


		/**
		 * Render video widget as plain content.
		 *
		 * Override the default behavior, by printing the video URL insted of rendering it.
		 *
		 * @since 1.4.5
		 * @access public
		 */
		public function render_plain_content() {
			$settings = $this->get_settings_for_display();

			if ( 'hosted' !== $settings['video_type'] ) {
				$url = $settings[ $settings['video_type'] . '_url' ];
			} else {
				$url = $this->get_hosted_video_url();
			}

			echo esc_url( $url );
		}

		/**
		 * Get embed params.
		 *
		 * Retrieve video widget embed parameters.
		 *
		 * @since 1.5.0
		 * @access public
		 *
		 * @return array Video embed parameters.
		 */
		public function get_embed_params() {
			$settings = $this->get_settings_for_display();

			$params = [];

			if ( $settings['autoplay'] && ! $this->has_image_overlay() ) {
				$params['autoplay'] = '1';

				if ( $settings['play_on_mobile'] ) {
					$params['playsinline'] = '1';
				}
			}

			$params_dictionary = [];

			if ( 'youtube' === $settings['video_type'] ) {
				$params_dictionary = [
					'loop',
					'controls',
					'mute',
					'rel',
					'modestbranding',
				];

				if ( $settings['loop'] ) {
					$video_properties = Embed::get_video_properties( $settings['youtube_url'] );

					$params['playlist'] = $video_properties['video_id'];
				}

				$params['start'] = $settings['start'];

				$params['end'] = $settings['end'];

				$params['wmode'] = 'opaque';
			} elseif ( 'vimeo' === $settings['video_type'] ) {
				$params_dictionary = [
					'loop',
					'mute' => 'muted',
					'vimeo_title' => 'title',
					'vimeo_portrait' => 'portrait',
					'vimeo_byline' => 'byline',
				];

				$params['color'] = str_replace( '#', '', $settings['color'] );

				$params['autopause'] = '0';
			} elseif ( 'dailymotion' === $settings['video_type'] ) {
				$params_dictionary = [
					'controls',
					'mute',
					'showinfo' => 'ui-start-screen-info',
					'logo' => 'ui-logo',
				];

				$params['ui-highlight'] = str_replace( '#', '', $settings['color'] );

				$params['start'] = $settings['start'];

				$params['endscreen-enable'] = '0';
			}

			foreach ( $params_dictionary as $key => $param_name ) {
				$setting_name = $param_name;

				if ( is_string( $key ) ) {
					$setting_name = $key;
				}

				$setting_value = $settings[ $setting_name ] ? '1' : '0';

				$params[ $param_name ] = $setting_value;
			}

			return $params;
		}

		/**
		 * Whether the video widget has an overlay image or not.
		 *
		 * Used to determine whether an overlay image was set for the video.
		 *
		 * @since 1.0.0
		 * @access protected
		 *
		 * @return bool Whether an image overlay was set for the video.
		 */
		protected function has_image_overlay() {
			$settings = $this->get_settings_for_display();

			return ! empty( $settings['image_overlay']['url'] ) && 'yes' === $settings['show_image_overlay'];
		}

		/**
		 * @since 2.1.0
		 * @access private
		 */
		private function get_embed_options() {
			$settings = $this->get_settings_for_display();

			$embed_options = [];

			if ( 'youtube' === $settings['video_type'] ) {
				$embed_options['privacy'] = $settings['yt_privacy'];
			} elseif ( 'vimeo' === $settings['video_type'] ) {
				$embed_options['start'] = $settings['start'];
			}

			$embed_options['lazy_load'] = ! empty( $settings['lazy_load'] );

			return $embed_options;
		}

		/**
		 * @since 2.1.0
		 * @access private
		 */
		private function get_hosted_params() {
			$settings = $this->get_settings_for_display();

			$video_params = [];

			foreach ( [ 'autoplay', 'loop', 'controls' ] as $option_name ) {
				if ( $settings[ $option_name ] ) {
					$video_params[ $option_name ] = '';
				}
			}

			if ( $settings['mute'] ) {
				$video_params['muted'] = 'muted';
			}

			if ( $settings['play_on_mobile'] ) {
				$video_params['playsinline'] = '';
			}

			if ( ! $settings['download_button'] ) {
				$video_params['controlsList'] = 'nodownload';
			}

			if ( $settings['poster']['url'] ) {
				$video_params['poster'] = $settings['poster']['url'];
			}

			return $video_params;
		}

		/**
		 * @param bool $from_media
		 *
		 * @return string
		 * @since 2.1.0
		 * @access private
		 */
		private function get_hosted_video_url() {
			$settings = $this->get_settings_for_display();

			if ( ! empty( $settings['insert_url'] ) ) {
				$video_url = $settings['external_url']['url'];
			} else {
				$video_url = $settings['hosted_url']['url'];
			}

			if ( empty( $video_url ) ) {
				return '';
			}

			if ( $settings['start'] || $settings['end'] ) {
				$video_url .= '#t=';
			}

			if ( $settings['start'] ) {
				$video_url .= $settings['start'];
			}

			if ( $settings['end'] ) {
				$video_url .= ',' . $settings['end'];
			}

			return $video_url;
		}

		/**
		 *
		 * @since 2.1.0
		 * @access private
		 */
		private function render_hosted_video() {
			$video_url = $this->get_hosted_video_url();
			if ( empty( $video_url ) ) {
				return;
			}

			$video_params = $this->get_hosted_params();
			/* Sometimes the video url is base64, therefore we use `esc_attr` in `src`. */
			?>
			<video class="elementor-video" src="<?php echo esc_attr( $video_url ); ?>" <?php Utils::print_html_attributes( $video_params ); ?>></video>
			<?php
		}
	}
}
