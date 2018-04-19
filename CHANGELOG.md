# Changelog

## [2.1.3] - 2018-04-19
* Fix invalid `color` value in inline css. Use `inherit` as default color.

## [2.1.2] - 2018-04-05
* Update module to new registration method introduced in [Hogan Core #79](https://github.com/DekodeInteraktiv/hogan-core/pull/79)
* Set hogan-core dependency `"dekodeinteraktiv/hogan-core": ">=1.1.7"`

## [2.1.1] - 2018-03-23
* Added `.hogan-banner-cta` classname on the call to actions wrapper

## [2.1.0] - 2018-03-23
* [#18](https://github.com/DekodeInteraktiv/hogan-banner/pull/18) Add option to create a banner css themes with a filter

## [2.0.1] - 2018-03-22
* Added optional tagline.
### Two new filters
* `hogan/module/banner/acf/tagline` - Tagline field.
* `hogan/module/banner/tagline/enabled` - Enable or disable tagline. Default `false`.

## [2.0.0] - 2018-02-15
### Breaking changes
* Template `.column` classname has changed to `.hogan-banner-column`.
* Template has a new `.hogan-banner` wrapper div.
* Plugin now ships with some default CSS.
* All wrapper settings classnames has changed.
* New layout - Full background image.
* New filters.
* Hogan heading replaced by content_heading field.

### Internal
* Fix deprecated inner wrapper classname filter

## [1.1.1] - 2018-01-29
* Added optional secondary call to action button
	* Use filter `hogan/module/banner/secondary_cta/enabled` to enable. Default `false`.

## [1.1.0] - 2018-01-26
### Breaking Change
* [#2](https://github.com/DekodeInteraktiv/hogan-banner/pull/2) Heading classname changed from `.heading .alpha` to `.hogan-heading`
* [#1](https://github.com/DekodeInteraktiv/hogan-banner/pull/1) Button classname changed from `.button` to `.hogan-button`

### Internal
* [#3](https://github.com/DekodeInteraktiv/hogan-banner/pull/3) Added Travis-CI config
* [#2](https://github.com/DekodeInteraktiv/hogan-banner/pull/2) Late escaping
* [#2](https://github.com/DekodeInteraktiv/hogan-banner/pull/2) Use core heading component on heading
* [#1](https://github.com/DekodeInteraktiv/hogan-banner/pull/1) Use core button component to print out call to action button

## [1.0.5] - 2017-12-20
### Enhancement
* Added filters

### Internal
* Text content is no longer required
