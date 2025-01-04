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
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Plugin;
use \Haru_TeeSpace\Classes\Haru_Template;

if ( ! class_exists( 'Haru_TeeSpace_Text_Scroll_Widget' ) ) {
	class Haru_TeeSpace_Text_Scroll_Widget extends Widget_Base {

		public function get_name() {
			return 'haru-text-scroll';
		}

		public function get_title() {
			return esc_html__( 'Haru Text Scroll', 'haru-teespace' );
		}

		public function get_icon() {
			return 'eicon-text';
		}

		public function get_categories() {
			return [ 'haru-elements' ];
		}

		public function get_keywords() {
            return [
                'heading',
                'scroll',
                'text',
            ];
        }

		public function get_custom_help_url() {
            return 'https://document.harutheme.com/elementor/';
        }

        public function get_script_depends() {

            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['flickity'];
            }

            return ['flickity'];

        }

        public function get_style_depends() {
            if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
                return ['flickity'];
            }

            return [ 'flickity' ];
        }

		protected function register_controls() {

			$this->start_controls_section(
	            'content_section',
	            [
	                'label' => esc_html__( 'Content', 'haru-teespace' ),
	                'tab' => Controls_Manager::TAB_CONTENT,
	            ]
	        );

	        $this->add_control(
				'pre_style',
				[
					'label' => __( 'Pre Text Scroll', 'haru-teespace' ),
					'description' 	=> __( 'If you choose Pre Text Scroll you will use Style default from our theme.', 'haru-teespace' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' 	=> __( 'Pre Text Scroll 1', 'haru-teespace' ),
						'style-2' 	=> __( 'Pre Text Scroll 2', 'haru-teespace' ),
						'style-3' 	=> __( 'Pre Text Scroll 3', 'haru-teespace' ),
					]
				]
			);

	        $repeater = new Repeater();

	        $repeater->add_control(
				'list_title', [
					'label' => esc_html__( 'Title', 'haru-teespace' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'List Title' , 'haru-teespace' ),
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'list_link', [
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
					'label' => esc_html__( 'Text List', 'haru-teespace' ),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'list_title' => esc_html__( 'Title #1', 'haru-teespace' ),
							'list_link' => esc_html__( 'Item Link.', 'haru-teespace' ),
						],
						[
							'list_title' => esc_html__( 'Title #2', 'haru-teespace' ),
							'list_link' => esc_html__( 'Item Link.', 'haru-teespace' ),
						],
					],
					'title_field' => '{{{ list_title }}}',
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
				'section_layout_title',
				[
					'label' => __( 'Layout', 'haru-teespace' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
                'background_dark',
                [
                    'label'         => __( 'Background Dark', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Enable if use for section has background dark.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

			$this->add_control(
                'scroll_time',
                [
                  	'label' => __( 'Text Scroll Speed', 'haru-teespace' ),
                  	'description'   => __( 'Scroll Speed , 1 is lowest.', 'haru-teespace' ),
                  	'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 10,
                    'step' => 1,
                    'default'   => 1,
                ]
            );

            $this->add_control(
                'rtl',
                [
                    'label'         => __( 'RTL', 'haru-teespace' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'description'   => __( 'Right to Left direction.', 'haru-teespace' ),
                    'default'       => 'no',
                    'return_value'  => 'yes',
                ]
            );

			$this->end_controls_section();

			$this->start_controls_section(
                'section_title_style',
                [
                    'label' => __( 'Style', 'haru-teespace' ),
                    'tab' => Controls_Manager::TAB_STYLE,
                ]
            );

            $this->add_control(
                'text_color',
                [
                    'label' => __( 'Text Color', 'haru-teespace' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .text-scroll-item h6' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .text-scroll-item h6:after' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'pre_style' => [ 'style-2' ],
                    ],
                ]
            );

            $this->end_controls_section();

		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( '' === $settings['list'] ) {
				return;
			}

        	$this->add_render_attribute( 'text-scroll', 'id', 'haru-text-scroll-' . $this->get_id() );

        	$this->add_render_attribute( 'text-scroll', 'class', 'haru-text-scroll' );

			$this->add_render_attribute( 'text-scroll', 'class', 'haru-text-scroll--' . $settings['pre_style'] );

			$this->add_render_attribute( 'text-scroll', 'data-id', 'haru-text-scroll-' . $this->get_id() );
			$this->add_render_attribute( 'text-scroll', 'data-speed', $settings['scroll_time'] );
			$this->add_render_attribute( 'text-scroll', 'data-rtl', $settings['rtl'] );

        	if ( ! empty( $settings['el_class'] ) ) {
				$this->add_render_attribute( 'text-scroll', 'class', $settings['el_class'] );
			}

        	?>

        	<?php if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) : ?>
                <div class="haru-notice"><?php echo esc_html__( 'Please note layout or action may doesn\'t works on Preview Mode or Editor Mode but works fine on Frontend Mode.', 'haru-teespace' ); ?></div>
            <?php endif; ?>

        	<?php if ( 'yes' == $settings['background_dark'] ) : ?>
        		<div class="background-dark">
    		<?php endif; ?>
	        	<div <?php echo $this->get_render_attribute_string( 'text-scroll' ); ?>>
	        		<?php echo Haru_Template::haru_get_template( 'text-scroll/text-scroll.php', $settings ); ?>
	    		</div>
    		<?php if ( 'yes' == $settings['background_dark'] ) : ?>
            	</div>
            <?php endif; ?>

    		<?php
		}

	}
}
