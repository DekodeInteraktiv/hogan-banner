<?php
/**
 * Banner module class
 *
 * @package Hogan
 */

declare( strict_types = 1 );

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
		 * Banner layout
		 *
		 * @var string
		 */
		public $layout = 'columns';

		/**
		 * Width layout
		 *
		 * @var string
		 */
		public $width = 'full';

		/**
		 * Content position
		 *
		 * @var string
		 */
		public $content_position = 'left';

		/**
		 * Text align
		 *
		 * @var string
		 */
		public $text_align = 'left';

		/**
		 * Theme
		 *
		 * @var string
		 */
		public $theme = 'dark';

		/**
		 * Theme transparent
		 *
		 * @var bool
		 */
		public $theme_text_bg = true;

		/**
		 * Tagline
		 *
		 * @var string|null
		 */
		public $tagline = null;

		/**
		 * Content
		 *
		 * @var string|null
		 */
		public $content = null;

		/**
		 * Main Image
		 *
		 * @var array|null
		 */
		public $main_image = null;

		/**
		 * Image
		 *
		 * @var array|null
		 */
		public $image = null;

		/**
		 * Call to action links.
		 *
		 * @var array
		 */
		public $call_to_actions = [];

		/**
		 * Module constructor.
		 */
		public function __construct() {

			$this->label    = __( 'Banner', 'hogan-banner' );
			$this->template = __DIR__ . '/assets/template.php';

			add_action( 'init', [ $this, 'set_defaults' ] );

			add_filter( 'hogan/module/outer_wrapper_classes', [ $this, 'outer_wrapper_classes' ], 10, 2 );

			parent::__construct();
		}

		/**
		 * Set defaults
		 *
		 * @return void
		 */
		public function set_defaults() {
			$this->content_position = (string) apply_filters( 'hogan/module/banner/defaults/content_position', 'left' );
			$this->text_align       = (string) apply_filters( 'hogan/module/banner/defaults/text_align', 'left' );
			$this->theme            = (string) apply_filters( 'hogan/module/banner/defaults/theme', 'dark' );
			$this->width            = (string) apply_filters( 'hogan/module/banner/defaults/width', 'full' );
		}

		/**
		 * Enqueue module assets
		 */
		public function enqueue_assets() {
			$_version = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? time() : HOGAN_BANNER_VERSION;
			wp_enqueue_style( 'hogan-banner', plugins_url( '/assets/hogan-banner.css', __FILE__ ), [], $_version );
		}

		/**
		 * Field definitions for module.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields(): array {
			/*
			 * Content tab
			 */
			$content_tab = [
				[
					'key'       => $this->field_key . '_content_tab',
					'label'     => __( 'Content', 'hogan-banner' ),
					'name'      => 'content_tab',
					'type'      => 'tab',
					'placement' => 'left',
					'endpoint'  => 0,
				],
			];

			/*
			 * Settings tab
			 */
			$settings_tab = [
				[
					'type'         => 'tab',
					'key'          => $this->field_key . '_settings_tab',
					'label'        => __( 'Settings', 'hogan-banner' ),
					'name'         => 'settings_tab',
					'instructions' => '',
					'placement'    => 'left',
					'endpoint'     => 0,
				],
			];

			/*
			 * Layout setting
			 */
			$content_tab[] = apply_filters( 'hogan/module/banner/acf/layout', [
				'type'          => 'button_group',
				'key'           => $this->field_key . '_layout',
				'name'          => 'layout',
				'label'         => __( 'Layout', 'hogan-banner' ),
				'default_value' => 'columns',
				'choices'       => [
					'columns' => __( 'Half and half ', 'hogan-banner' ),
					'full'    => __( 'Full background', 'hogan-banner' ),
				],
				'layout'        => 'horizontal',
				'return_format' => 'value',
				'wrapper'       => [
					'width' => 50,
				],
			] );

			/*
			 * Main banner image field
			 */
			$content_tab[] = apply_filters( 'hogan/module/banner/acf/main_image', [
				'type'          => 'image',
				'key'           => $this->field_key . '_main_image_id',
				'name'          => 'main_image_id',
				'label'         => __( 'Banner Image', 'hogan-banner' ),
				'instructions'  => '',
				'required'      => true,
				'return_format' => 'id',
				'preview_size'  => 'medium',
				'library'       => 'all',
				'wrapper'       => [
					'width' => 50,
				],
			] );

			/*
			 * Image field
			 */
			if ( true === apply_filters( 'hogan/module/banner/image/enabled', false ) ) {
				$content_tab[] = apply_filters( 'hogan/module/banner/acf/image', [
					'type'          => 'image',
					'key'           => $this->field_key . '_image_id',
					'name'          => 'image_id',
					'label'         => __( 'Content Image', 'hogan-banner' ),
					'instructions'  => '',
					'required'      => false,
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				] );
			}

			/*
			 * Tagline
			 */
			if ( true === apply_filters( 'hogan/module/banner/tagline/enabled', false ) ) {
				$content_tab[] = apply_filters( 'hogan/module/banner/acf/tagline', [
					'type'  => 'text',
					'key'   => $this->field_key . '_tagline',
					'label' => __( 'Tagline', 'hogan-banner' ),
					'name'  => 'tagline',
				] );
			}

			/*
			 * Heading field
			 *
			 * Can be disabled using filter hogan/module/banner/heading/enabled (true/false).
			 */
			hogan_append_heading_field( $content_tab, $this );

			/*
			 * Content field
			 */
			$content_tab[] = apply_filters( 'hogan/module/banner/acf/content', [
				'type'      => 'textarea',
				'key'       => $this->field_key . '_content',
				'name'      => 'content',
				'label'     => __( 'Add content', 'hogan-banner' ),
				'required'  => false,
				'rows'      => 4,
				'new_lines' => 'wpautop',
			] );

			/*
			 * Link fields
			 */
			$content_tab[] = [
				'type'          => 'link',
				'key'           => $this->field_key . '_cta',
				'label'         => __( 'Call to action', 'hogan-banner' ),
				'name'          => 'cta',
				'return_format' => 'array',
			];

			if ( true === apply_filters( 'hogan/module/banner/secondary_cta/enabled', false ) ) {
				$content_tab[] = [
					'type'          => 'link',
					'key'           => $this->field_key . '_secondary_cta',
					'label'         => __( 'Secondary call to action', 'hogan-banner' ),
					'name'          => 'secondary_cta',
					'return_format' => 'array',
				];
			}

			/*
			 * Theme setting
			 */
			if ( true === apply_filters( 'hogan/module/banner/acf/theme/enabled', true ) ) {

				$settings_tab[] = apply_filters( 'hogan/module/banner/acf/theme', [
					'type'          => 'button_group',
					'key'           => $this->field_key . '_theme',
					'name'          => 'theme',
					'label'         => __( 'Theme', 'hogan-banner' ),
					'instructions'  => __( 'Background color for content', 'hogan-banner' ),
					'default_value' => apply_filters( 'hogan/module/banner/defaults/theme', 'full' ),
					'choices'       => [
						'dark'  => __( 'Dark', 'hogan-banner' ),
						'light' => __( 'Light', 'hogan-banner' ),
					],
					'layout'        => 'horizontal',
					'return_format' => 'value',
					'wrapper'       => [
						'width' => 50,
					],
				] );

				$settings_tab[] = apply_filters( 'hogan/module/banner/acf/theme_on_full', [
					'type'              => 'true_false',
					'key'               => $this->field_key . 'theme_on_full',
					'name'              => 'theme_text_bg',
					'label'             => __( 'Content background', 'hogan-banner' ),
					'instructions'      => __( 'Use theme color as background for content?', 'hogan-banner' ),
					'conditional_logic' => [
						[
							[
								'field'    => $this->field_key . '_layout',
								'operator' => '==',
								'value'    => 'full',
							],
						],
					],
					'wrapper'           => [
						'width' => 50,
					],
				] );
			}

			/*
			 * Width setting
			 */
			if ( true === apply_filters( 'hogan/module/banner/acf/width/enabled', true ) ) {
				$settings_tab[] = apply_filters( 'hogan/module/banner/acf/width', [
					'type'          => 'button_group',
					'key'           => $this->field_key . '_width',
					'name'          => 'width',
					'label'         => __( 'Width', 'hogan-banner' ),
					'instructions'  => '',
					'default_value' => apply_filters( 'hogan/module/banner/defaults/width', 'full' ),
					'choices'       => [
						'full' => __( 'Full', 'hogan-banner' ),
						'grid' => __( 'Grid', 'hogan-banner' ),
					],
					'layout'        => 'horizontal',
					'return_format' => 'value',
				] );
			}

			/*
			 * Content position
			 */
			if ( true === apply_filters( 'hogan/module/banner/acf/content_position/enabled', true ) ) {
				$settings_tab[] = apply_filters( 'hogan/module/banner/acf/content_position_full', [
					'type'              => 'button_group',
					'key'               => $this->field_key . '_content_position_full',
					'name'              => 'content_position',
					'label'             => __( 'Content position', 'hogan-banner' ),
					'instructions'      => __( 'Position content on banner', 'hogan-banner' ),
					'default_value'     => apply_filters( 'hogan/module/banner/defaults/content_position', 'left' ),
					'choices'           => [
						'left'   => '<i class="dashicons dashicons-align-left"></i>',
						'center' => '<i class="dashicons dashicons-align-center"></i>',
						'right'  => '<i class="dashicons dashicons-align-right"></i>',
					],
					'layout'            => 'horizontal',
					'return_format'     => 'value',
					'conditional_logic' => [
						[
							[
								'field'    => $this->field_key . '_layout',
								'operator' => '==',
								'value'    => 'full',
							],
						],
					],
				] );

				$settings_tab[] = apply_filters( 'hogan/module/banner/acf/content_position', [
					'type'              => 'button_group',
					'key'               => $this->field_key . '_content_position',
					'name'              => 'content_position',
					'label'             => __( 'Content position', 'hogan-banner' ),
					'instructions'      => __( 'Position content on banner', 'hogan-banner' ),
					'default_value'     => apply_filters( 'hogan/module/banner/defaults/content_position', 'left' ),
					'choices'           => [
						'left'  => '<i class="dashicons dashicons-align-left"></i>',
						'right' => '<i class="dashicons dashicons-align-right"></i>',
					],
					'layout'            => 'horizontal',
					'return_format'     => 'value',
					'conditional_logic' => [
						[
							[
								'field'    => $this->field_key . '_layout',
								'operator' => '!=',
								'value'    => 'full',
							],
						],
					],
				] );
			}

			/*
			 * Text align
			 */
			if ( true === apply_filters( 'hogan/module/banner/acf/text_align/enabled', true ) ) {
				$settings_tab[] = apply_filters( 'hogan/module/banner/acf/text_align', [
					'type'          => 'button_group',
					'key'           => $this->field_key . '_text_align',
					'name'          => 'text_align',
					'label'         => __( 'Text align', 'hogan-banner' ),
					'instructions'  => __( 'Align text in content', 'hogan-banner' ),
					'default_value' => apply_filters( 'hogan/module/banner/defaults/text_align', 'left' ),
					'choices'       => [
						'left'   => '<i class="dashicons dashicons-editor-alignleft"></i>',
						'center' => '<i class="dashicons dashicons-editor-aligncenter"></i>',
						'right'  => '<i class="dashicons dashicons-editor-alignright"></i>',
					],
					'layout'        => 'horizontal',
					'return_format' => 'value',
				] );
			}

			return array_merge(
				$content_tab,
				$settings_tab
			);
		}

		/**
		 * Module outer wrapper classnames.
		 *
		 * @param array  $classnames Outer wrapper classnames.
		 * @param Module $module Module.
		 * @return array Classnames.
		 */
		public function outer_wrapper_classes( array $classnames, Module $module ) : array {
			if ( $this->name !== $module->name ) {
				return $classnames;
			}

			if ( ! empty( $module->content_position ) ) {
				$classnames[] = 'hogan-banner-content-' . $module->content_position;
			}

			if ( 'full' === $module->layout ) {
				$classnames[] = 'hogan-module-width-full';
			} elseif ( ! empty( $module->width ) ) {
				$classnames[] = 'hogan-module-width-' . $module->width;
			}

			if ( $module->theme_text_bg && 'full' === $module->layout ) {
				$classnames[] = 'hogan-banner-theme-' . $module->theme . '-transparent';
			} else {
				$classnames[] = 'hogan-banner-theme-' . $module->theme;
			}

			return array_merge( $classnames, [
				'hogan-banner-layout-' . $module->layout,
				'hogan-banner-text-' . $module->text_align,
			] );
		}

		/**
		 * Map raw fields from acf to object variable.
		 *
		 * @param array $raw_content Content values.
		 * @param int   $counter Module location in page layout.
		 *
		 * @return void
		 */
		public function load_args_from_layout_content( array $raw_content, int $counter = 0 ) {

			parent::load_args_from_layout_content( $raw_content, $counter );

			if ( ! empty( $raw_content['content_position'] ) ) {
				$this->content_position = $raw_content['content_position'];
			}

			if ( ! empty( $raw_content['layout'] ) ) {
				$this->layout = $raw_content['layout'];
			}

			if ( ! empty( $raw_content['text_align'] ) ) {
				$this->text_align = $raw_content['text_align'];
			}

			if ( ! empty( $raw_content['theme'] ) ) {
				$this->theme = $raw_content['theme'];
			}

			if ( ! empty( $raw_content['width'] ) ) {
				$this->width = $raw_content['width'];
			}

			$this->theme_text_bg = ! $raw_content['theme_text_bg'];

			// Main Image.
			if ( ! empty( $raw_content['main_image_id'] ) ) {
				$main_image = wp_parse_args(
					apply_filters( 'hogan/module/banner/main_image/args', [] ), [
						'size' => 'full',
						'icon' => false,
						'attr' => [],
					]
				);

				$main_image['id'] = $raw_content['main_image_id'];
				$this->main_image = $main_image;
			}

			// Image.
			if ( ! empty( $raw_content['image_id'] ) ) {
				$image = wp_parse_args(
					apply_filters( 'hogan/module/banner/image/args', [] ), [
						'size' => 'full',
						'icon' => false,
						'attr' => [],
					]
				);

				$image['id'] = $raw_content['image_id'];
				$this->image = $image;
			}

			// Tagline.
			if ( true === apply_filters( 'hogan/module/banner/tagline/enabled', false ) && ! empty( $raw_content['tagline'] ) ) {
				$this->tagline = $raw_content['tagline'];
			}

			// Content.
			$this->content = $raw_content['content'];

			// Call to actions.
			$call_to_actions = [];

			if ( ! empty( $raw_content['cta'] ) ) {
				$cta              = $raw_content['cta'];
				$cta['title']     = $cta['title'] ?: __( 'Read more', 'hogan-banner' );
				$cta['classname'] = apply_filters( 'hogan/module/banner/cta_css_classes', '', $this );

				$call_to_actions[] = $cta;
			}

			if ( true === apply_filters( 'hogan/module/banner/secondary_cta/enabled', false ) && ! empty( $raw_content['secondary_cta'] ) ) {
				$secondary_cta              = $raw_content['secondary_cta'];
				$secondary_cta['title']     = $secondary_cta['title'] ?: __( 'Read more', 'hogan-banner' );
				$secondary_cta['classname'] = apply_filters( 'hogan/module/banner/secondary_cta_css_classes', 'hogan-secondary-button', $this );

				$call_to_actions[] = $secondary_cta;
			}

			$this->call_to_actions = $call_to_actions;
		}

		/**
		 * Validate module content before template is loaded.
		 *
		 * @return bool Whether validation of the module is successful / filled with content.
		 */
		public function validate_args(): bool {
			return ! empty( $this->main_image ) || empty( apply_filters( 'hogan/module/banner/main_image/required', 1 ) );
		}
	}
} // End if().
