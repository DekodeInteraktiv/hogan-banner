<?php
/**
 * Template for banner module
 *
 * $this is an instance of the Banner object.
 *
 * Available properties:
 * $this->call_to_actions (array)       Call to action links.
 * $this->content         (string|null) Main text content.
 * $this->heading         (string|null) Module heading.
 * $this->image           (array|null)  Image.
 * $this->tagline         (string|null) Tagline.
 * $this->dim_image       (boolean)     Should the image be dimmed.
 *
 * @package Hogan
 */

declare( strict_types = 1 );

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Banner ) ) {
	return; // Exit if accessed directly.
}

<?php do_action( 'hogan/module/banner/open_wrapper', $this ); ?>
?>
<div class="hogan-banner">
	<div class="<?php echo esc_attr( hogan_classnames( 'hogan-banner-column hogan-banner-image', [ 'hogan-banner-dim-image' => $this->dim_image ] ) ); ?>">
		<?php
		if ( ! empty( $this->main_image ) ) {
			echo wp_get_attachment_image(
				$this->main_image['id'],
				$this->main_image['size'],
				$this->main_image['icon'],
				$this->main_image['attr']
			);
		}
		?>
	</div>
	<?php if ( ! empty( $this->image ) || ! empty( $this->tagline ) || ! empty( $this->heading ) || ! empty( $this->content ) || ! empty( $this->call_to_actions ) ) : ?>
		<div class="hogan-banner-column hogan-banner-content">
			<div class="hogan-banner-content-inner">
				<?php
				if ( ! empty( $this->image ) ) {
					echo wp_get_attachment_image(
						$this->image['id'],
						$this->image['size'],
						$this->image['icon'],
						$this->image['attr']
					);
				}

				if ( ! empty( $this->tagline ) ) {
					printf(
						'<div class="hogan-tagline">%s</div>',
						esc_html(
							$this->tagline
						)
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
					echo '<div class="hogan-banner-cta">';
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
	<?php endif; ?>
</div>
<?php do_action( 'hogan/module/banner/close_wrapper', $this ); ?>
