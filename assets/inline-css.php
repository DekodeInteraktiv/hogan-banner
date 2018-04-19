<?php
/**
 * Hogan Banner CSS theme
 *
 * Available properties:
 * $this->themes (array) Themes
 *
 * @package Hogan
 */

$default = '';
$large   = '';

foreach ( $this->themes as $theme => $colors ) {
	$defaults = [
		'backgroundColor' => 'transparent',
		'color'           => 'inherit',
	];

	$colors = wp_parse_args( $colors, $defaults );

	$default .= "
		.hogan-banner-theme-{$theme} .hogan-banner-content,
		.hogan-banner-theme-{$theme}.hogan-banner-layout-full .hogan-banner-content-inner,
		.hogan-banner-theme-{$theme}-transparent.hogan-banner-layout-full .hogan-banner-content-inner {
			background-color: {$colors['backgroundColor']};
			color: {$colors['color']};
		}
	";

	$large .= "
		.hogan-banner-theme-{$theme}-transparent.hogan-banner-layout-full .hogan-banner-content-inner {
			background-color: transparent;
		}
	";
}

echo trim( preg_replace( '/\s+/', ' ', "$default @media screen and ( min-width: 768px ) { $large }" ) ); // WPCS: XSS OK.
