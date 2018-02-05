# Banner Module for [Hogan](https://github.com/dekodeinteraktiv/hogan-banner) [![Build Status](https://travis-ci.org/DekodeInteraktiv/hogan-banner.svg?branch=master)](https://travis-ci.org/DekodeInteraktiv/hogan-banner)

## Installation
Install the module using Composer `composer require dekodeinteraktiv/hogan-banner` or simply by downloading this repository and placing it in `wp-content/plugins`

## Available filters
### Tagline
- `hogan/module/banner/tagline/enabled`. Enable tagline. Default `false`.

### Image
- `hogan/module/banner/image/required` Should image be required. Default `true`.
- `hogan/module/banner/image/args` Image arguments passed to `wp_get_attachment_image`.

### Call to action
- `hogan/module/banner/cta_css_classes` Call to action button classnames.
- `hogan/module/banner/secondary_cta/enabled`. Enable secondary call to action button. Default `false`.
- `hogan/module/banner/secondary_cta_css_classes` Secondary call to action button classnames.

### ACF Fields
- `hogan/module/banner/acf/image` - Image field
- `hogan/module/banner/acf/tagline` - Tagline field
- `hogan/module/banner/acf/content` - Content field
- `hogan/module/banner/acf/layout` - Layout option
- `hogan/module/banner/acf/theme/enabled` - Enable or disable theme option. Default `true`.
- `hogan/module/banner/acf/theme` - Theme option. Used to create different color themes.
- `hogan/module/banner/acf/theme_full` - Theme option when `full` layout is selected. Used to create different color themes.
- `hogan/module/banner/acf/width/enabled` - Enable or disable width option. Default `true`.
- `hogan/module/banner/acf/width` - Width option. Used to select if is banner should be inside grid or 100% page width.
- `hogan/module/banner/acf/content_position/enabled` - Enable or disable content position. Default `true`.
- `hogan/module/banner/acf/content_position` - Content position.
- `hogan/module/banner/acf/content_position_full` - Content position when `full` layout is selected.
- `hogan/module/banner/acf/text_align/enabled` - Enable or disable text align option. Default `true`.
- `hogan/module/banner/acf/text_align` - Text align
- `hogan/module/banner/acf/background_opacity` - Background opacity
