<?php
/**
 * Template for banner module
 *
 * $this is an instance of the Banner object.
 *
 * Available properties:
 * $this->call_to_action (array|null)  Call to action link.
 * $this->content        (string|null) Main text content.
 * $this->heading        (string|null) Module heading.
 * $this->image          (array|null)  Image.
 * $this->tagline        (string|null) Tagline.
 *
 * @package Hogan
 */

declare( strict_types = 1 );

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Banner ) ) {
	return; // Exit if accessed directly.
}
?>
	<?php if ( 'large' === $this->image_size && ! empty( $this->image_src ) ) : ?>
	<div class="opacity-<?php echo esc_attr( $this->overlay_opacity ); ?>" style="background-image: url('<?php echo esc_url( $this->image_src ); ?>');">
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

		$call_to_action_buttons = [];

		if ( ! empty( $this->call_to_action ) ) {
			$call_to_action_buttons[] = $this->call_to_action;
		}

		if ( ! empty( $this->secondary_call_to_action ) ) {
			$call_to_action_buttons[] = $this->secondary_call_to_action;
		}

		if ( ! empty( $call_to_action_buttons ) ) {
			echo '<div>';
			foreach ( $call_to_action_buttons as $button ) {
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
