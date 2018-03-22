<?php
/**
 * Hogan Banner CSS theme
 *
 * @package Hogan
 */

$themes  = apply_filters( 'hogan/module/banner/themes', $this->themes );
$default = '';
$large   = '';

foreach ( $themes as $theme => $colors ) {
	$defaults = [
		'backgroundColor' => 'transparent',
		'color'           => 'currentColor',
	];

	$colors = wp_parse_args( $colors, $defaults );

	$default .= <<<CSS
		.hogan-banner-theme-{$theme} .hogan-banner-content,
		.hogan-banner-theme-{$theme}.hogan-banner-layout-full .hogan-banner-content-inner,
		.hogan-banner-theme-{$theme}-transparent.hogan-banner-layout-full .hogan-banner-content-inner {
			background-color: {$colors['backgroundColor']};
			color: {$colors['color']};
		}
CSS;

	$large .= <<<CSS
		.hogan-banner-theme-{$theme}-transparent.hogan-banner-layout-full .hogan-banner-content-inner {
			background-color: transparent;
		}
CSS;
}

// phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
echo <<<CSS
	{$default}
	@media screen and ( min-width: 768px ) {
		{$large}
	}
CSS;
