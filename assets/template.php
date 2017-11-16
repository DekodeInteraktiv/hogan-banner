<?php
/**
 * Template for banner module
 *
 * $this is an instance of the Banner object.
 *
 * @package Hogan
 */

namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Banner ) ) {
	return; // Exit if accessed directly.
}
?>

<div class="column">
	<?php if ( ! empty( $this->image_content ) ) : ?>
		<?php echo $this->image_content; ?>
	<?php endif; ?>
</div>
<div class="column">
	<?php if ( ! empty( $this->tagline ) ) : ?>
		<?php echo '<div class="tagline">' . $this->tagline . '</div>'; ?>
	<?php endif; ?>

	<?php if ( ! empty( $this->heading ) ) : ?>
		<h2 class="heading"><?php echo $this->heading; ?></h2>
	<?php endif; ?>

	<?php if ( ! empty( $this->content ) ) : ?>
		<?php echo '<p> ' . $this->content . '</p>'; ?>
	<?php endif; ?>

	<?php echo $this->cta_link; ?>
</div>
