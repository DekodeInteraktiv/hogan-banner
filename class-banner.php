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
 * Legge settings i egen tab
 * Filtere
 * CSS i plugin (flow direction + bg color light and dark)
 * Kanskje to forskjellige templates som den velger imellom template.php og template-wide.php?
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
		 * Position for text on > mobile
		 *
		 * @var string $text_position
		 */
		public $text_position;

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

			$image_format_choices = apply_filters( 'hogan/module/banner/field/image_format_choices', [
				'square' => _x( 'Square', 'Image Format', 'hogan-banner' ),
				'large'  => _x( 'Large', 'Image Format', 'hogan-banner' ),
			] );

			$text_position_choices = apply_filters( 'hogan/module/banner/field/text_position_choices', [
				'left'   => _x( 'Left', 'Text Position', 'hogan-banner' ),
				'center' => _x( 'Center', 'Text Position', 'hogan-banner' ),
				'right'  => _x( 'Right', 'Text Position', 'hogan-banner' ),
			] );

			$background_color_choices = apply_filters( 'hogan/module/banner/field/background_color_choices', [
				'light' => _x( 'Light', 'Background Color', 'hogan-banner' ),
				'dark'  => _x( 'dark', 'Background Color', 'hogan-banner' ),
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
					'type'          => 'radio',
					'key'           => $this->field_key . '_image_format',
					'name'          => 'image_format',
					'label'         => __( 'Image Format', 'hogan-banner' ),
					'value'         => is_array( $image_format_choices ) && ! empty( $image_format_choices ) ? reset( $image_format_choices ) : null,
					// Use the first key in the choices array (default = right)
					'instructions'  => __( 'Choose image format', 'hogan-banner' ),
					'choices'       => $image_format_choices,
					'layout'        => 'horizontal',
					'return_format' => 'value',
				],
				[
					'type'          => 'radio',
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
					'type'              => 'radio',
					'key'               => $this->field_key . '_background_color',
					'name'              => 'background_color',
					'label'             => __( 'Background Color', 'hogan-banner' ),
					'value'             => is_array( $background_color_choices ) && ! empty( $background_color_choices ) ? reset( $background_color_choices ) : null,
					// Use the first key in the choices array (default = left)
					'instructions'      => __( 'Choose background color for the text field', 'hogan-banner' ),
					'choices'           => $background_color_choices,
					'layout'            => 'horizontal',
					'return_format'     => 'value',
					'conditional_logic' => [ //FIXME: Will not work if choice for image format is changed with filter
						[
							[
								'field'    => $this->field_key . '_image_format',
								'operator' => '==',
								'value'    => 'square',
							],
						],
					],
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
			$this->tagline       = $content['tagline'] ?? null;
			$this->heading       = isset( $content['heading'] ) ? esc_html( $content['heading'] ) : null;
			$this->content       = esc_html( $content['content'] );
			$this->text_position = $content['text_position']; //note: no need?
			$default_image_args  = [
				'size' => 'large',
				'icon' => false,
				'attr' => [],
			];

			$image_args = wp_parse_args( apply_filters( 'hogan/module/banner/image/constraints', [] ), $default_image_args );

			$this->image_content = wp_get_attachment_image( $content['image_id'], $image_args['size'], $image_args['icon'], $image_args['attr'] );

			if ( ! empty( $content['cta'] ) ) :
				$cta                 = $content['cta'];
				$cta_classes_array   = apply_filters( 'hogan/module/banner/cta_css_classes', [ 'button' ], $this );
				$cta_classes_escaped = array_map( 'esc_attr', $cta_classes_array );
				$this->cta_link      = sprintf( '<p><a href="%1$s"%2$s%3$s>%4$s</a></p>',
					$cta['url'] ?: '#',
					'' === $cta['target'] ? '' : ' target="' . $cta['target'] . '"',
					! empty( $cta_classes_escaped ) ? 'class="' . trim( implode( ' ', array_filter( $cta_classes_escaped ) ) ) . '"' : '',
					$cta['title'] ?: esc_html__( 'Read more', 'hogan-banner' )
				);
			else :
				$this->cta_link = '';
			endif;

			$this->content_allowed_html = apply_filters( 'hogan/module/banner/content/allowed_html', [
				'a' => [
					'href' => true,
				],
			] );

			parent::load_args_from_layout_content( $content );

			add_filter( 'hogan/module/banner/inner_wrapper_classes', function () {
				return [ 'columns', 'text-' . $this->text_position ];
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
