<?php
/**
 * Banner module class
 *
 * @package Hogan
 */

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *
 * DSS
 * Style text + bilde
 *
 * Style hero
 *
 * Plugin:
 * Ta i bruk dark eller light
 * Ta i bruk square eller large
 * Force square image if square is chosen
 * Editor style 2 columns
 * CSS i plugin (flow direction + bg color light and dark) med filter for å skru av
 * Kanskje to forskjellige templates som den velger imellom template.php og template-wide.php?
 * Button group icons for square || large?
 * Button group icons for dark || light?
 */

if ( ! class_exists( '\\Dekode\\Hogan\\Banner' ) ) {

	/**
	 * Banner module class.
	 *
	 * @extends Modules base class.
	 */
	class Banner extends Module {

		/**
		 * Banner tagline - optional
		 *
		 * @var string $tagline
		 */
		public $tagline;

		/**
		 * Banner heading - optional
		 *
		 * @var string $heading
		 */
		public $heading;

		/**
		 * Banner main text content
		 *
		 * @var string $content
		 */
		public $content;

		/**
		 * Rendered image content for use in template.
		 *
		 * @var $image_content
		 */
		public $image_content;

		/**
		 * Rendered call to action link.
		 *
		 * @var $cta_link
		 */
		public $cta_link;

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
		 * @var string background_color
		 */
		public $background_color;


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
		 */
		public function get_fields() {

			$image_size_choices = apply_filters( 'hogan/module/banner/field/image_format_choices', [
				'square' => _x( 'Square', 'Image Format', 'hogan-banner' ),
				'large'  => _x( 'Large', 'Image Format', 'hogan-banner' ),
			] );

			$text_position_choices = apply_filters( 'hogan/module/banner/field/text_position_choices', [
				'left'   => '<i class="dashicons dashicons-editor-alignleft"></i>',
				'center' => '<i class="dashicons dashicons-editor-aligncenter"></i>',
				'right'  => '<i class="dashicons dashicons-editor-alignright"></i>',
			] );

			$background_color_choices = apply_filters( 'hogan/module/banner/field/background_color_choices', [
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
			$constraints_args = wp_parse_args( apply_filters( 'hogan/module/banner/field/constraints', [] ), $constraints_defaults );

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
					//'instructions'  => '',
					'required'      => 1,
					'return_format' => 'id',
					'preview_size'  => apply_filters( 'hogan/module/banner/field/preview_size', 'medium' ),
					'library'       => apply_filters( 'hogan/module/banner/field/library', 'all' ),
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
					'required'  => 1,
					'rows'      => apply_filters( 'hogan/module/banner/content/rows', 4 ),
					'new_lines' => apply_filters( 'hogan/module/banner/content/new_lines', 'br' ),
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
					'type'          => 'button_group',
					'key'           => $this->field_key . '_text_position',
					'name'          => 'text_position',
					'label'         => __( 'Text Position', 'hogan-banner' ),
					'value'         => is_array( $text_position_choices ) && ! empty( $text_position_choices ) ? reset( $text_position_choices ) : null,
					// Use the first key in the choices array (default = left)
					'instructions'  => __( 'Choose text position', 'hogan-banner' ),
					'choices'       => $text_position_choices,
					'layout'        => 'horizontal',
					'return_format' => 'value',
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
					'key'               => 'field_5a0c5694e3144',
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
					'default_value'     => 50,
					'min'               => 0,
					'max'               => 100,
					'step'              => 1,
				]
			);

			return $fields;
		}

		/**
		 * Map fields to object variable.
		 *
		 * @param array $content The content value.
		 */
		public function load_args_from_layout_content( $content ) {
			$this->tagline          = $content['tagline'] ?? null;
			$this->heading          = isset( $content['heading'] ) ? esc_html( $content['heading'] ) : null;
			$this->content          = esc_html( $content['content'] );
			$this->image_size       = $content['image_size'];
			$this->text_position    = $content['text_position'];
			$this->background_color = $content['background_color'];

			$default_image_square_args = [
				'size' => 'large',
				'icon' => false,
				'attr' => [],
			];

			$default_image_large_args = [
				'size' => 'large',
				'icon' => false,
				'attr' => [],
			];

			if ( 'square' === $this->image_size ) {
				$image_args = wp_parse_args( apply_filters( 'hogan/module/banner/image_square/args', [] ), $default_image_square_args );
			} else {
				$image_args = wp_parse_args( apply_filters( 'hogan/module/banner/image_large/args', [] ), $default_image_large_args );
			}

			$this->image_content = wp_get_attachment_image( $content['image_id'], $image_args['size'], $image_args['icon'], $image_args['attr'] );

			if ( ! empty( $content['cta'] ) ) :
				$cta                 = $content['cta'];
				$cta_classes_array   = apply_filters( 'hogan/module/banner/cta_css_classes', [ 'button' ], $this );
				$cta_classes_escaped = array_map( 'esc_attr', $cta_classes_array );
				$this->cta_link      = sprintf( '<div><a href="%1$s"%2$s%3$s>%4$s</a></div>',
					$cta['url'] ?: '#',
					'' === $cta['target'] ? '' : ' target="' . $cta['target'] . '"',
					! empty( $cta_classes_escaped ) ? 'class="' . trim( implode( ' ', array_filter( $cta_classes_escaped ) ) ) . '"' : '',
					$cta['title'] ?: esc_html__( 'Read more', 'hogan-banner' )
				);
			else :
				$this->cta_link = '';
			endif;

			parent::load_args_from_layout_content( $content );

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
		 */
		public function validate_args() {
			return ! empty( $this->content ) && ! empty( $this->image_content );
		}
	}
}
