<?php
/**
 * Template for banner module
 *
 * $this is an instance of the Banner object.
 *
 * Available properties:
 * $this->call_to_action (array|null)  Call to action link.
 * $this->content        (string|null) Main text content
 * $this->heading        (string|null) Module heading.
 * $this->tagline        (string|null) Tagline
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
	<div class="opacity-<?php echo $this->overlay_opacity; ?>" style="background-image: url('<?php echo $this->image_src; ?>');">
<?php endif; ?>

	<div class="column">
		<?php echo $this->image_content; ?>
	</div>
	<div class="column">
		<?php
		if ( ! empty( $this->tagline ) ) {
			printf( '<div class="tagline">%s</div>',
				esc_html( $this->tagline )
			);
		}

		if ( ! empty( $this->heading ) ) {
			printf( '<h2 class="hogan-heading">%s</h2>',
				wp_kses( $this->heading, [
					'br' => [],
				] )
			);
		}

		if ( ! empty( $this->content ) ) {
			echo wp_kses( $this->content, [
				'p'  => [],
				'br' => [],
			] );
		}

		if ( ! empty( $this->call_to_action ) ) {
			echo '<div>';
			hogan_component( 'button', $this->call_to_action );
			echo '</div>';
		}
		?>
	</div>

<?php if ( 'large' === $this->image_size && ! empty( $this->image_src ) ) : ?>
	</div>
<?php endif;
