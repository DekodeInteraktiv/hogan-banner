<?php
/**
 * Template for banner module
 *
 * $this is an instance of the Banner object.
 *
 * Available properties:
 * $this->call_to_actions (array)  Call to action links.
 * $this->content         (string|null) Main text content.
 * $this->heading         (string|null) Module heading.
 * $this->image           (array|null)  Image.
 * $this->tagline         (string|null) Tagline.
 *
 * @package Hogan
 */

declare( strict_types = 1 );

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Banner ) ) {
	return; // Exit if accessed directly.
}
?>
	<?php
	if ( 'large' === $this->image_size && ! empty( $this->image_src ) ) :
		$large_image_wrapper_classes = array_merge(
			[ 'opacity-' . $this->overlay_opacity ],
			apply_filters( 'hogan/module/banner/large_image_wrapper_classes', [], $this )
		);
		$large_image_wrapper_classes = trim( implode( ' ', array_filter( $large_image_wrapper_classes ) ) );

		$large_image_wrapper_styles = array_merge(
			[ 'background-image: url(' . esc_url( $this->image_src . ')' ) ],
			apply_filters( 'hogan/module/banner/large_image_wrapper_styles', [], $this )
		);
		$large_image_wrapper_styles = trim( implode( '; ', array_filter( $large_image_wrapper_styles ) ) );
	?>
	<div class="<?php echo esc_attr( $large_image_wrapper_classes ); ?>" style="<?php echo esc_attr( $large_image_wrapper_styles ); ?>">
<?php endif; ?>

	<div class="column">
		<?php
		if ( ! empty( $this->image ) ) {
			echo wp_get_attachment_image(
				$this->image['id'],
				$this->image['size'],
				$this->image['icon'],
				$this->image['attr']
			);
		}
		?>
	</div>
	<div class="column">
		<?php
		if ( ! empty( $this->tagline ) ) {
			printf(
				'<div class="tagline">%s</div>',
				esc_html( $this->tagline )
			);
		}

		if ( ! empty( $this->heading ) ) {
			hogan_component(
				'heading', [
					'title' => $this->heading,
				]
			);
		}

		if ( ! empty( $this->content ) ) {
			echo wp_kses(
				$this->content, [
					'p'  => [],
					'br' => [],
				]
			);
		}

		if ( ! empty( $this->call_to_actions ) ) {
			echo '<div>';
			foreach ( $this->call_to_actions as $button ) {
				echo '<span>';
				hogan_component( 'button', $button );
				echo '</span>';
			}
			echo '</div>';
		}

		?>
	</div>

	<?php
	if ( 'large' === $this->image_size && ! empty( $this->image_src ) ) {
		echo '</div>';
	}
