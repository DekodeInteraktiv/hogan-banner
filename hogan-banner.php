<?php
/**
 * Plugin Name: Hogan Module: Banner
 * Plugin URI: https://github.com/dekodeinteraktiv/hogan-banner
 * GitHub Plugin URI: https://github.com/dekodeinteraktiv/hogan-banner
 * Description: Banner Module for Hogan.
 * Version: 2.1.3
 * Author: Dekode
 * Author URI: https://dekode.no
 * License: GPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * Text Domain: hogan-banner
 * Domain Path: /languages/
 *
 * @package Hogan
 * @author Dekode
 */

declare( strict_types=1 );
namespace Dekode\Hogan\Banner;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'HOGAN_BANNER_VERSION', '2.1.3' );

add_action( 'plugins_loaded', __NAMESPACE__ . '\\hogan_load_textdomain' );
add_action( 'hogan/include_modules', __NAMESPACE__ . '\\hogan_register_module' );

/**
 * Register module text domain
 */
function hogan_load_textdomain() {
	\load_plugin_textdomain( 'hogan-banner', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register module in Hogan
 *
 * @param \Dekode\Hogan\Core $core Hogan Core instance.
 */
function hogan_register_module( \Dekode\Hogan\Core $core ) {
	require_once 'class-banner.php';
	$core->register_module( new \Dekode\Hogan\Banner() );
}
