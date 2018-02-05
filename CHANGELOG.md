# Changelog

## [Unreleased]
### Breaking changes
* Tagline is disabled by default. Use filter `hogan/module/banner/tagline/enabled` to enable.
* Tagline classname has changed from `.tagline` to `.hogan-tagline`.
* Template `.column` classname has changed to `.hogan-banner-column`.
* Template has a new `.hogan-banner` wrapper div.
* Plugin now ships with some default CSS.
* All wrapper settings classnames has changed.
* New layout - Full background image.
* New filters.

### Internal
* Fix deprecated inner wrapper classname filter

## [1.1.1] - 2018-01-29
- Added optional secondary call to action button
    - Use filter `hogan/module/banner/secondary_cta/enabled` to enable. Default `false`.

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
