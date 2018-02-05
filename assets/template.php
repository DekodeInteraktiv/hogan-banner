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
<div class="hogan-banner">
	<div class="hogan-banner-column hogan-banner-image">
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
	<div class="hogan-banner-column hogan-banner-content">
		<div class="hogan-banner-content-inner">
			<?php
			if ( ! empty( $this->tagline ) ) {
				printf(
					'<div class="hogan-tagline">%s</div>',
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
	</div>
</div>
