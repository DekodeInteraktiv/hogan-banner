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

if ( ! class_exists( '\\Dekode\\Hogan\\Banner' ) ) {

	/**
	 * Banner module class.
	 *
	 * @extends Modules base class.
	 */
	class Banner extends Module {

		/**
		 * Banner heading - optional
		 *
		 * @var string $heading
		 */
		public $heading;

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

			$fields = [];


			return $fields;
		}

		/**
		 * Map fields to object variable.
		 *
		 * @param array $content The content value.
		 */
		public function load_args_from_layout_content( $content ) {
			$this->heading       = isset( $content['heading'] ) ? esc_html( $content['heading'] ) : null;


			parent::load_args_from_layout_content( $content );
		}

		/**
		 * Validate module content before template is loaded.
		 */
		public function validate_args() {
			return true; //todo:
		}
	}
}
