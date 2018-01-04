<?php
/**
 * Banner module class
 *
 * @package Hogan
 */

declare( strict_types=1 );

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Hogan\\Banner' ) && class_exists( '\\Dekode\\Hogan\\Module' ) ) {

	/**
	 * Banner module class.
	 *
	 * @extends Modules base class.
	 */
	class Banner extends Module {

		/**
		 * Banner tagline - optional
		 *
		 * @var string|null $tagline
		 */
		public $tagline = null;

		/**
		 * Banner main text content
		 *
		 * @var string|null $content
		 */
		public $content = null;

		/**
		 * Image.
		 *
		 * @var array|null $image
		 */
		public $image = null;

		/**
		 * Image src for use in template.
		 *
		 * @var $image_src
		 */
		public $image_src;

		/**
		 * Call to action link.
		 *
		 * @var array|null $call_to_action
		 */
		public $call_to_action = null;

		/**************/
		/***SETTINGS***/
		/**************/

		/**
		 * Image size for one column or span both columns
		 *
		 * @var string $image_size
		 */
		public $image_size;

		/**
		 * Position for text on > mobile
		 *
		 * @var string $text_position
		 */
		public $text_position;

		/**
		 * Background color
		 *
		 * @var string $background_color
		 */
		public $background_color;

		/**
		 * Hero overlay opacity (behind text)
		 *
		 * @var string $overlay_opacity
		 */
		public $overlay_opacity;


		/**
		 * Module constructor.
		 */
		public function __construct() {

			$this->label    = __( 'Banner', 'hogan-banner' );
			$this->template = __DIR__ . '/assets/template.php';

			parent::__construct();
		}

		/**
		 * Field definitions for module.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields(): array {

			$image_size_choices = apply_filters( 'hogan/module/banner/settings/image_format_choices', [
				'square' => _x( 'Square', 'Image Format', 'hogan-banner' ),
				'large'  => _x( 'Large', 'Image Format', 'hogan-banner' ),
			] );

			$text_position_choices_square = apply_filters( 'hogan/module/banner/settings/text_position_choices', [
				'left'  => '<i class="dashicons dashicons-editor-alignleft"></i>',
				'right' => '<i class="dashicons dashicons-editor-alignright"></i>',
			] );

			$text_position_choices_large = apply_filters( 'hogan/module/banner/settings/text_position_choices', [
				'left'   => '<i class="dashicons dashicons-editor-alignleft"></i>',
				'center' => '<i class="dashicons dashicons-editor-aligncenter"></i>',
				'right'  => '<i class="dashicons dashicons-editor-alignright"></i>',
			] );

			$background_color_choices = apply_filters( 'hogan/module/banner/settings/background_color_choices', [
				'light' => _x( 'Light', 'Background Color', 'hogan-banner' ),
				'dark'  => _x( 'Dark', 'Background Color', 'hogan-banner' ),
				'none'  => _x( 'None', 'Background Color', 'hogan-banner' ),
			] );

			$constraints_defaults = [
				'min_width'  => '',
				'min_height' => '',
				'max_width'  => '',
				'max_height' => '',
				'min_size'   => '',
				'max_size'   => '',
				'mime_types' => '',
			];

			// Merge $args from filter with $defaults
			$constraints_args = wp_parse_args( apply_filters( 'hogan/module/banner/image/constraints', [] ), $constraints_defaults );

			$fields = [
				[
					'key'          => $this->field_key . '_content_tab',
					'label'        => __( 'Content', 'hogan-banner' ),
					'name'         => 'content_tab',
					'type'         => 'tab',
					'instructions' => 'Content related stuff',
					'placement'    => 'left',
					'endpoint'     => 0,
				],
				[
					'type'  => 'text',
					'key'   => $this->field_key . '_tagline',
					'label' => __( 'Tagline', 'hogan-banner' ),
					'name'  => 'tagline',
				],
			];

			// Heading field can be disabled using filter hogan/module/banner/heading/enabled (true/false).
			hogan_append_heading_field( $fields, $this );

			array_push( $fields,
				[
					'type'          => 'image',
					'key'           => $this->field_key . '_image_id',
					'name'          => 'image_id',
					'label'         => __( 'Add Image', 'hogan-banner' ),
					'instructions'  => apply_filters( 'hogan/module/banner/image/instructions', '', 'hogan-banner' ),
					'required'      => apply_filters( 'hogan/module/banner/image/required', 1 ),
					'return_format' => 'id',
					'preview_size'  => apply_filters( 'hogan/module/banner/image/preview_size', 'medium' ),
					'library'       => apply_filters( 'hogan/module/banner/image/library', 'all' ),
					'min_width'     => $constraints_args['min_width'],
					'min_height'    => $constraints_args['min_height'],
					'max_width'     => $constraints_args['max_width'],
					'max_height'    => $constraints_args['max_height'],
					'min_size'      => $constraints_args['min_size'],
					'max_size'      => $constraints_args['max_size'],
					'mime_types'    => $constraints_args['mime_types'],
				],
				[
					'type'      => 'textarea',
					'key'       => $this->field_key . '_content',
					'name'      => 'content',
					'label'     => __( 'Add content', 'hogan-text' ),
					'required'  => apply_filters( 'hogan/module/banner/content/required', 0 ),
					'rows'      => apply_filters( 'hogan/module/banner/content/rows', 4 ),
					'new_lines' => apply_filters( 'hogan/module/banner/content/new_lines', 'wpautop' ),
				],
				[
					'type'          => 'link',
					'key'           => $this->field_key . '_cta',
					'label'         => __( 'Call to action', 'hogan-banner' ),
					'name'          => 'cta',
					'return_format' => 'array',
				],
				[
					'type'         => 'tab',
					'key'          => $this->field_key . '_settings_tab',
					'label'        => __( 'Settings', 'hogan-banner' ),
					'name'         => 'settings_tab',
					'instructions' => '',
					'placement'    => 'left',
					'endpoint'     => 0,
				],
				[
					'type'          => 'button_group',
					'key'           => $this->field_key . '_image_size',
					'name'          => 'image_size',
					'label'         => __( 'Image Size', 'hogan-banner' ),
					'value'         => is_array( $image_size_choices ) && ! empty( $image_size_choices ) ? reset( $image_size_choices ) : null,
					// Use the first key in the choices array (default = square)
					'instructions'  => __( 'Choose image size', 'hogan-banner' ),
					'choices'       => $image_size_choices,
					'layout'        => 'horizontal',
					'return_format' => 'value',
				],
				[
					'type'              => 'button_group',
					'key'               => $this->field_key . '_text_position_square',
					'name'              => 'text_position_square',
					'label'             => __( 'Text Position', 'hogan-banner' ),
					'value'             => is_array( $text_position_choices_square ) && ! empty( $text_position_choices_square ) ? reset( $text_position_choices_square ) : null,
					// Use the first key in the choices array (default = left)
					'instructions'      => __( 'Choose text position', 'hogan-banner' ),
					'choices'           => $text_position_choices_square,
					'layout'            => 'horizontal',
					'return_format'     => 'value',
					'conditional_logic' => [ //FIXME: Will not work if choice for text position is changed with filter
						[
							[
								'field'    => $this->field_key . '_image_size',
								'operator' => '==',
								'value'    => 'square',
							],
						],
					],
				],
				[
					'type'              => 'button_group',
					'key'               => $this->field_key . '_text_position_large',
					'name'              => 'text_position_large',
					'label'             => __( 'Text Position', 'hogan-banner' ),
					'value'             => is_array( $text_position_choices_large ) && ! empty( $text_position_choices_large ) ? reset( $text_position_choices_large ) : null,
					// Use the first key in the choices array (default = left)
					'instructions'      => __( 'Choose text position', 'hogan-banner' ),
					'choices'           => $text_position_choices_large,
					'layout'            => 'horizontal',
					'return_format'     => 'value',
					'conditional_logic' => [ //FIXME: Will not work if choice for text position is changed with filter
						[
							[
								'field'    => $this->field_key . '_image_size',
								'operator' => '==',
								'value'    => 'large',
							],
						],
					],
				],
				[
					'type'              => 'button_group',
					'key'               => $this->field_key . '_background_color',
					'name'              => 'background_color',
					'label'             => __( 'Background Color', 'hogan-banner' ),
					'value'             => is_array( $background_color_choices ) && ! empty( $background_color_choices ) ? reset( $background_color_choices ) : null,
					// Use the first key in the choices array (default = light)
					'instructions'      => __( 'Choose background color for the text field', 'hogan-banner' ),
					'choices'           => $background_color_choices,
					'layout'            => 'horizontal',
					'return_format'     => 'value',
					'conditional_logic' => [ //FIXME: Will not work if choice for image size is changed with filter
						[
							[
								'field'    => $this->field_key . '_image_size',
								'operator' => '==',
								'value'    => 'square',
							],
						],
					],
				],
				[
					'type'              => 'range',
					'key'               => $this->field_key . '_overlay_opacity',
					'label'             => __( 'Overlay Opacity', 'hogan-banner' ),
					'name'              => 'overlay_opacity',
					'instructions'      => __( 'Choose opacity value for overlay behind text', 'hogan-banner' ),
					'conditional_logic' => [ //FIXME: Will not work if choice for image size is changed with filter
						[
							[
								'field'    => $this->field_key . '_image_size',
								'operator' => '==',
								'value'    => 'large',
							],
						],
					],
					'default_value'     => 60,
					'min'               => 60,
					'max'               => 100,
					'step'              => 10,
				]
			);

			return $fields;
		}

		/**
		 * Map raw fields from acf to object variable.
		 *
		 * @param array $raw_content Content values.
		 * @param int $counter Module location in page layout.
		 *
		 * @return void
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			$this->tagline = $raw_content['tagline'];
			$this->content = $raw_content['content'];

			$this->image_size = $raw_content['image_size'];

			if ( 'square' === $this->image_size ) {
				$this->text_position    = $raw_content['text_position_square'];
				$this->background_color = $raw_content['background_color'];
			} else {
				$this->text_position    = $raw_content['text_position_large'];
				$this->background_color = 'none';
				$this->overlay_opacity  = $raw_content['overlay_opacity'];
				$default_image_src_args = [
					'size' => 'large',
					'icon' => false,
				];
				$image_src_args         = wp_parse_args( apply_filters( 'hogan/module/banner/image_large/args', [] ), $default_image_src_args );
				$image_data             = wp_get_attachment_image_src( $raw_content['image_id'], $image_src_args['size'], $image_src_args['icon'] );
				if ( false !== $image_data ) {
					$this->image_src = $image_data[0];
				}
			}

			// Image.
			if ( ! empty( $raw_content['image_id'] ) ) {
				$image = wp_parse_args( apply_filters( 'hogan/module/banner/image/args', [] ), [
					'size' => 'large',
					'icon' => false,
					'attr' => [],
				] );

				$image['id'] = $raw_content['image_id'];
				$this->image = $image;
			}

			// Call to action button.
			if ( ! empty( $raw_content['cta'] ) ) {
				$cta              = $raw_content['cta'];
				$cta['title']     = $cta['title'] ?: __( 'Read more', 'hogan-banner' );
				$cta['classname'] = apply_filters( 'hogan/module/banner/cta_css_classes', '', $this );

				$this->call_to_action = $cta;
			}

			parent::load_args_from_layout_content( $raw_content, $counter );

			add_filter( 'hogan/module/banner/inner_wrapper_classes', function () {
				return [
					'columns',
					'text-' . $this->text_position,
					'image-size-' . $this->image_size,
					'bg-color-' . $this->background_color,
				];
			} );
		}

		/**
		 * Validate module content before template is loaded.
		 *
		 * @return bool Whether validation of the module is successful / filled with content.
		 */
		public function validate_args(): bool {
			return ! empty( $this->image_content ) || empty( apply_filters( 'hogan/module/banner/image/required', 1 ) );
		}
	}
} // End if().
