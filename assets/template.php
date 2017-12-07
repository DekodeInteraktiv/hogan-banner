<?php
/**
 * Template for banner module
 *
 * $this is an instance of the Banner object.
 *
 * Available properties:
 * $this->heading (string) Module heading.
 * TODO:
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
		<?php if ( ! empty( $this->tagline ) ) : ?>
			<?php echo '<div class="tagline">' . $this->tagline . '</div>'; ?>
		<?php endif; ?>

		<?php if ( ! empty( $this->heading ) ) : ?>
			<h2 class="heading alpha"><?php echo $this->heading; ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $this->content ) ) : ?>
			<?php echo $this->content; ?>
		<?php endif; ?>

		<?php echo $this->cta_link; ?>
	</div>

<?php if ( 'large' === $this->image_size && ! empty( $this->image_src ) ) : ?>
	</div>
<?php endif;
