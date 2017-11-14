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

<?php if ( ! empty( $this->heading ) ) : ?>
	<h2 class="heading"><?php echo $this->heading; ?></h2>
<?php endif; ?>
