<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if access directly
}

if ( ! class_exists( 'Haru_Term_Meta' ) ):

	final class Haru_Term_Meta {

		private $taxonomy;
		private $post_type;
		private $fields = array();

		public function __construct( $taxonomy, $post_type, $fields = array() ) {

			$this->taxonomy  = $taxonomy;
			$this->post_type = $post_type;
			$this->fields    = $fields;

			add_action( 'delete_term', array( $this, 'delete_term' ), 5, 4 );

			// Add form
			add_action( "{$this->taxonomy}_add_form_fields", array( $this, 'add_fields' ) );
			add_action( "{$this->taxonomy}_edit_form_fields", array( $this, 'edit_fields' ), 10 );
			add_action( "created_term", array( $this, 'save_fields' ), 10, 3 );
			add_action( "edit_term", array( $this, 'save_fields' ), 10, 3 );
			add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts_styles' ) );

		}

		public function delete_term( $term_id, $tt_id, $taxonomy, $deleted_term ) {
			global $wpdb;

			$term_id = absint( $term_id );

			if ( $term_id and $taxonomy == $this->taxonomy ) {
				$wpdb->delete( $wpdb->haru_termmeta, array( 'haru_term_id' => $term_id ), array( '%d' ) );
			}
		}

		public function load_scripts_styles() {

			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );

			wp_enqueue_script( 'jquery-ui-sortable' );

			wp_enqueue_style( 'term-meta-style', HARU_TEESPACE_CORE_URL . 'includes/term-meta/css/term-meta.css' );
			wp_enqueue_script( 'term-meta-script', HARU_TEESPACE_CORE_URL . 'includes/term-meta/js/term-meta.js' );
		}

		public function save_fields( $term_id, $tt_id = '', $taxonomy = '' ) {

			if ( $taxonomy == $this->taxonomy ) {

				foreach ( $this->fields as $field ) {

					foreach ( $_POST as $post_key => $post_value ) {

						if ( $field[ 'id' ] == $post_key ) {

							switch ( $field[ 'type' ] ) {
								case 'text':
								case 'label':
								case 'color':
									haru_update_term_meta( $term_id, $field[ 'id' ], esc_html( $post_value ) );
									break;
								case 'url':
									haru_update_term_meta( $term_id, $field[ 'id' ], esc_url( $post_value ) );
									break;
								case 'image':
									haru_update_term_meta( $term_id, $field[ 'id' ], absint( $post_value ) );
									break;
								case 'textarea':
									haru_update_term_meta( $term_id, $field[ 'id' ], esc_html( $post_value ) );
									break;
								case 'editor':
									haru_update_term_meta( $term_id, $field[ 'id' ], wp_kses_post( $post_value ) );
									break;
								case 'select':
								case 'select2':
								case 'revslider':
									haru_update_term_meta( $term_id, $field[ 'id' ], $post_value);
									break;
								case 'checkbox':
									haru_update_term_meta( $term_id, $field[ 'id' ], esc_html( $post_value ) );
									break;
								default:
								 	do_action('haru-plugin-tmb-save-field', $term_id, $field, $post_value, $taxonomy);
									break;
							}
						}
					}
				}

			    do_action('haru-plugin-tmb-after-save-fields', $term_id, $taxonomy);

			}
		}

		public function add_fields() {
			$this->generate_fields();
		}

		private function generate_fields( $term = FALSE ) {

			$screen = get_current_screen();

			if ( ( $screen->post_type == $this->post_type ) and ( $screen->taxonomy == $this->taxonomy ) ) {
				$this->generate_form_fields( $term );
			}
		}

		private function generate_form_fields( $term ) {

		    $fields = apply_filters('haru-plugin-tmb-fields', $this->fields, $term);

			foreach ( $fields as $field ) {

			    $field = apply_filters('haru-plugin-tmb-field', $field, $term);

				$field[ 'id' ] = esc_html( $field[ 'id' ] );

				if ( ! $term ) {
					$field[ 'value' ] = isset( $field[ 'default' ] ) ? $field[ 'default' ] : '';
				} else {
					$field[ 'value' ] = haru_get_term_meta( $term->term_id, $field[ 'id' ], TRUE );
				}

				$field[ 'size' ]        = isset( $field[ 'size' ] ) ? $field[ 'size' ] : '40';
				$field[ 'required' ]    = ( isset( $field[ 'required' ] ) and $field[ 'required' ] == TRUE ) ? ' aria-required="true"' : '';
				$field[ 'placeholder' ] = ( isset( $field[ 'placeholder' ] ) ) ? ' placeholder="' . $field[ 'placeholder' ] . '"' : '';
				$field[ 'desc' ]        = ( isset( $field[ 'desc' ] ) ) ? $field[ 'desc' ] : '';

				$field['dependency'] = ( isset( $field[ 'dependency' ] ) ) ? $field[ 'dependency' ] : array();

				$this->field_start( $field, $term );
				switch ( $field[ 'type' ] ) {

					case 'text':
					case 'url':
						ob_start();

						?>
						<input name="<?php echo $field[ 'id' ] ?>" id="<?php echo $field[ 'id' ] ?>"
						       type="<?php echo $field[ 'type' ] ?>"
						       value="<?php echo $field[ 'value' ] ?>"
						       size="<?php echo $field[ 'size' ] ?>" <?php echo $field[ 'required' ] . $field[ 'placeholder' ] ?>>
						<?php
						echo ob_get_clean();
						break;
					case 'color':
						ob_start();

						?>
						<input name="<?php echo $field[ 'id' ] ?>" id="<?php echo $field[ 'id' ] ?>"
						       type="text" class="harucolorpicker"
						       value="<?php echo $field[ 'value' ] ?>"
						       size="<?php echo $field[ 'size' ] ?>" <?php echo $field[ 'required' ] . $field[ 'placeholder' ] ?>>
						<?php
						echo ob_get_clean();
						break;
					case 'label':
						ob_start();

						?>
						<input name="<?php echo $field[ 'id' ] ?>" id="<?php echo $field[ 'id' ] ?>"
						       type="text" class="haru_label"
						       value="<?php echo $field[ 'value' ] ?>"
						       size="<?php echo $field[ 'size' ] ?>" <?php echo $field[ 'required' ] . $field[ 'placeholder' ] ?>>
						<?php
						echo ob_get_clean();
						break;

					case 'textarea':
						ob_start();
						?>
						<textarea name="<?php echo $field[ 'id' ] ?>" id="<?php echo $field[ 'id' ] ?>" rows="5"
						          cols="<?php echo $field[ 'size' ] ?>"  <?php echo $field[ 'required' ] . $field[ 'placeholder' ] ?>><?php echo $field[ 'value' ] ?></textarea>
						<?php
						echo ob_get_clean();
						break;

					case 'editor':

						$field[ 'settings' ] = isset( $field[ 'settings' ] )
							? $field[ 'settings' ]
							: array(
								'textarea_rows' => 8,
								'quicktags'     => FALSE,
								'media_buttons' => FALSE
							);
						ob_start();
						wp_editor( $field[ 'value' ], $field[ 'id' ], $field[ 'settings' ] );
						echo ob_get_clean();
						break;

					case 'select':
					case 'select2':

						$field[ 'options' ]  = isset( $field[ 'options' ] ) ? $field[ 'options' ] : array();
						$field[ 'multiple' ] = isset( $field[ 'multiple' ] ) ? ' multiple="multiple"' : '';
						$css_class = ( $field[ 'type' ] == 'select2' ) ? 'haru-plugin-select2':'';

					    ob_start();
					   ?>
						<select name="<?php echo $field[ 'id' ] ?>" id="<?php echo $field[ 'id' ] ?>" class="<?php echo $css_class  ?>" <?php echo $field[ 'multiple' ] ?>>
						<?php
						foreach ( $field[ 'options' ] as $key => $option ) {
							echo '<option' . selected( $field[ 'value' ], $key, FALSE ) . ' value="' . $key . '">' . $option . '</option>';
						}
						?>
						</select>
						<?php
						echo ob_get_clean();
						break;


					case 'revslider':

					    ob_start();
						if( class_exists('RevSlider') ){

						$slider = new RevSlider();
						$field[ 'options' ] = array(''=>' - None - ') + $slider->getArrSlidersShort();


					   ?>
						<select name="<?php echo $field[ 'id' ] ?>" id="<?php echo $field[ 'id' ] ?>" class="haru-plugin-select2" <?php echo $field[ 'multiple' ] ?>>
						<?php
						foreach ( $field[ 'options' ] as $key => $option ) {
							echo '<option' . selected( $field[ 'value' ], $key, FALSE ) . ' value="' . $key . '">' . $option . '</option>';
						}
						?>
						</select>
						<?php
						} else { ?>
						<div class="error notice is-dismissible below-h2"><p><?php echo esc_html__('Revolution Slider is not Installed or Activated.', 'haru-teespace') ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'haru-teespace') ?></span></button></div>
						<?php
						}

						echo ob_get_clean();
						break;

					case 'icon':
						$field[ 'options' ]  = isset( $field[ 'options' ] ) ? $field[ 'options' ] : array();
						$field[ 'multiple' ] = isset( $field[ 'multiple' ] ) ? ' multiple="multiple"' : '';
						$css_class = 'haru-plugin-select2-icon';
					    ob_start();
					   ?>
						<select name="<?php echo $field[ 'id' ] ?>" id="<?php echo $field[ 'id' ] ?>" class="<?php echo $css_class  ?>" <?php echo $field[ 'multiple' ] ?>>
					    <option value=""><?php __('-- Choose Icon --', 'haru-teespace') ?></option>
						<?php
						foreach ( $field[ 'options' ] as $key => $option ) {
							echo '<option' . selected( $field[ 'value' ], $key, FALSE ) . ' value="' . $key . '">' . $option . '</option>';
						}
						?>
						</select>
						<?php
						echo ob_get_clean();
						break;

					case 'image':
						ob_start();
						?>
						<div class="meta-image-field-wrapper">
							<div style="float: left; margin-right: 10px;"><img
									data-placeholder="<?php echo esc_url( $this->haru_placeholder_img_src() ); ?>"
									src="<?php echo esc_url( $this->get_img_src( $field[ 'value' ] ) ); ?>" width="60px"
									height="60px"/>
							</div>
							<div style="line-height: 60px;">
								<input type="hidden" id="<?php echo $field[ 'id' ] ?>"
								       name="<?php echo $field[ 'id' ] ?>" value="<?php echo esc_attr($field[ 'value' ]) ?>"/>
								<button type="button"
								        class="haru_upload_image_button button button-primary button-small"><?php _e( 'Upload / Add image', 'haru-teespace' ); ?></button>
								<button type="button" style="<?php echo (empty($field[ 'value' ])?'display:none':'') ?>"
								        class="haru_remove_image_button button button-danger button-small"><?php _e( 'Remove image', 'haru-teespace' ); ?></button>
							</div>
							<div class="clear clearfix"></div>
						</div>
						<?php
						echo ob_get_clean();
						break;

					case 'checkbox':
						ob_start();
						?>
						<div>
							<input name="<?php echo $field[ 'id' ] ?>" id="<?php echo $field[ 'id' ] ?>-hidden"
						       type="hidden" class="harucheckboxhidden"
						       value="0"
						       <?php checked( $field[ 'value' ], 1, true ); ?>/>
							<input name="<?php echo $field[ 'id' ] ?>" id="<?php echo $field[ 'id' ] ?>"
						       type="checkbox" class="harucheckbox"
						       value="1"
						       <?php checked( $field[ 'value' ], 1, true ); ?>/>
					       	<script>
								if ( document.getElementById('<?php echo $field[ 'id' ] ?>').checked ) {
								   document.getElementById('<?php echo $field[ 'id' ] ?>-hidden').disabled = true;
								}
							</script>
						</div>
						<?php
						echo ob_get_clean();
						break;

					default:
					    do_action('haru-plugin-tmb-generate-field', $field, $term);
					break;

				}
				$this->field_end( $field, $term );

			}
		}

		private function field_start( $field, $term ) {

			$depends = empty($field['dependency'])?'':"data-depends='".json_encode($field['dependency'])."'";

            ob_start();
			if ( ! $term ) {
				?>
				<div <?php echo $depends ?> class="form-field <?php echo esc_attr( $field[ 'id' ] ) ?> <?php echo empty( $field[ 'required' ] ) ? '' : 'form-required' ?>">
				<label for="<?php echo esc_attr( $field[ 'id' ] ) ?>"><?php echo $field[ 'label' ] ?></label>
				<?php
			} else {
				?>
				<tr <?php echo $depends ?> class="form-field  <?php echo esc_attr( $field[ 'id' ] ) ?> <?php echo empty( $field[ 'required' ] ) ? '' : 'form-required' ?>"">
					<th scope="row"><label
							for="<?php echo esc_attr( $field[ 'id' ] ) ?>"><?php echo $field[ 'label' ] ?></label></th>
					<td>
				<?php
			}
			echo ob_get_clean();
		}

		public function get_img_src( $thumbnail_id = FALSE ) {
			if ( ! empty( $thumbnail_id ) ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = $this->haru_placeholder_img_src();
			}

			return $image;
		}

		public function haru_placeholder_img_src() {
			return HARU_TEESPACE_CORE_URL . 'includes/term-meta/images/placeholder.png';
		}

		private function field_end( $field, $term ) {

			ob_start();
			if ( ! $term ) {
				?>
				<p><?php echo $field[ 'desc' ] ?></p>
				</div>
				<?php
			} else {
				?>
				<p class="description"><?php echo $field[ 'desc' ] ?></p></td>
				</tr>
				<?php
			}
			echo ob_get_clean();
		}

		public function edit_fields( $term ) {
			$this->generate_fields( $term );
		}
	}

endif; // class_exists('Haru_Term_Meta')