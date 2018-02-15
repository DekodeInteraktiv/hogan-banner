# Banner Module for [Hogan](https://github.com/dekodeinteraktiv/hogan-banner) [![Build Status](https://travis-ci.org/DekodeInteraktiv/hogan-banner.svg?branch=master)](https://travis-ci.org/DekodeInteraktiv/hogan-banner)

## Installation
Install the module using Composer `composer require dekodeinteraktiv/hogan-banner` or simply by downloading this repository and placing it in `wp-content/plugins`

## Available filters
### Default values
- `hogan/module/banner/defaults/content_position` - Default `left`.
- `hogan/module/banner/defaults/text_align` - Default `left`.
- `hogan/module/banner/defaults/theme` - Default `dark`.
- `hogan/module/banner/defaults/width` - Default `full`.

### Image
- `hogan/module/banner/main_image/required` - Should main image be required. Default `true`.
- `hogan/module/banner/main_image/args` - Main image arguments passed to `wp_get_attachment_image`.
- `hogan/module/banner/image/enabled` - Content image. Default `true`.
- `hogan/module/banner/image/args` - Image arguments passed to `wp_get_attachment_image`.

### Call to action
- `hogan/module/banner/cta/classnames` - Call to action button classnames.
- `hogan/module/banner/secondary_cta/enabled` - Enable secondary call to action button. Default `false`.
- `hogan/module/banner/secondary_cta/classnames` - Secondary call to action button classnames.

### ACF Fields
- `hogan/module/banner/acf/layout` - Layout option field.
- `hogan/module/banner/acf/main_image` - Main image field.
- `hogan/module/banner/acf/image` - Image field.
- `hogan/module/banner/acf/content_heading` - Heading field.
- `hogan/module/banner/acf/content` - Content field.
- `hogan/module/banner/acf/theme/enabled` - Enable or disable theme option. Default `true`.
- `hogan/module/banner/acf/theme` - Theme option. Used to create different color themes.
- `hogan/module/banner/acf/theme_on_full` - True/false select if we want background color on full layout.
- `hogan/module/banner/acf/width/enabled` - Enable or disable width option. Default `true`.
- `hogan/module/banner/acf/width` - Width option. Used to select if is banner should be inside grid or 100% page width.
- `hogan/module/banner/acf/content_position/enabled` - Enable or disable content position. Default `true`.
- `hogan/module/banner/acf/content_position` - Content position.
- `hogan/module/banner/acf/content_position_full` - Content position when `full` layout is selected.
- `hogan/module/banner/acf/text_align/enabled` - Enable or disable text align option. Default `true`.
- `hogan/module/banner/acf/text_align` - Text align.
