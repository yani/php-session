# Changelog

## [4.0.0](https://github.com/yani/php-session/compare/v3.1.1...v4.0.0) (2023-01-10)


### ⚠ BREAKING CHANGES

* drop support for PHP 7.4
* support psr/simple-cache v2 and v3

### Features

* drop support for PHP 7.4 ([19358d0](https://github.com/yani/php-session/commit/19358d039685beca8c8ec14e8cba260aeacdc0fa))
* make Session iterable ([#11](https://github.com/yani/php-session/issues/11)) ([723a911](https://github.com/yani/php-session/commit/723a9116e16d1a20373b8d7bcee63c789eede86f))
* support psr/simple-cache v2 and v3 ([c3e7563](https://github.com/yani/php-session/commit/c3e756337fe2de35270201cf9a9271d42bc3b4ee)), closes [#2](https://github.com/yani/php-session/issues/2)
* upgrade dependencies ([243d859](https://github.com/yani/php-session/commit/243d859028fdfa0f4be4c8761f63a364b0f0e7f2)), closes [#2](https://github.com/yani/php-session/issues/2)


### Bug Fixes

* add ArrayAccess to Session class ([#7](https://github.com/yani/php-session/issues/7)) ([7d13b9d](https://github.com/yani/php-session/commit/7d13b9dd1fea5243f382ad51802146e5d60c963e))
* fix session regeneration when used with a CAS handler ([4adb6a3](https://github.com/yani/php-session/commit/4adb6a366302212e5415bde4152b67a78c83f076))
* Session::__get() should trigger error when data does not exist ([80fea20](https://github.com/yani/php-session/commit/80fea2000d4d4bb624c8e3fecc196a6ba4697899))
* sid generation in cookie middleware ([#5](https://github.com/yani/php-session/issues/5)) ([0fe1c63](https://github.com/yani/php-session/commit/0fe1c6322a46acf0b2ce9e4e7072e80563e28279))


### Miscellaneous Chores

* fix type checks ([314e8ff](https://github.com/yani/php-session/commit/314e8ff682484819e10e0cf0c63f4d1fb050617a))
* **master:** release 3.0.0 ([#8](https://github.com/yani/php-session/issues/8)) ([c0acd03](https://github.com/yani/php-session/commit/c0acd0399df2475a51edbc5b46d3231c52f469f7))
* **master:** release 3.0.1 ([#9](https://github.com/yani/php-session/issues/9)) ([4c485bd](https://github.com/yani/php-session/commit/4c485bd363ad46f90788cb886aebc6ad03ee198b))
* **master:** release 3.1.0 ([#12](https://github.com/yani/php-session/issues/12)) ([1021e85](https://github.com/yani/php-session/commit/1021e855870f73756928f914062cfda5e566250a))
* **master:** release 3.1.1 ([#13](https://github.com/yani/php-session/issues/13)) ([6b59688](https://github.com/yani/php-session/commit/6b5968893357d8742090a1f9d812b3bb20807039))
* test in ci ([0cf510a](https://github.com/yani/php-session/commit/0cf510a9fab5899e2bef2c94b6d5207d517ae932))
* upgrade dev dependencies ([53f29f8](https://github.com/yani/php-session/commit/53f29f8b3d3a97ee4f8a8a7d6c1df17e1458dfe6))

## [3.1.1](https://github.com/compwright/php-session/compare/v3.1.0...v3.1.1) (2022-12-29)


### Bug Fixes

* fix session regeneration when used with a CAS handler ([4adb6a3](https://github.com/compwright/php-session/commit/4adb6a366302212e5415bde4152b67a78c83f076))

## [3.1.0](https://github.com/compwright/php-session/compare/v3.0.1...v3.1.0) (2022-12-28)


### Features

* make Session iterable ([#11](https://github.com/compwright/php-session/issues/11)) ([723a911](https://github.com/compwright/php-session/commit/723a9116e16d1a20373b8d7bcee63c789eede86f))

## [3.0.1](https://github.com/compwright/php-session/compare/v3.0.0...v3.0.1) (2022-12-23)


### Miscellaneous Chores

* fix type checks ([314e8ff](https://github.com/compwright/php-session/commit/314e8ff682484819e10e0cf0c63f4d1fb050617a))
* test in ci ([0cf510a](https://github.com/compwright/php-session/commit/0cf510a9fab5899e2bef2c94b6d5207d517ae932))
* upgrade dev dependencies ([53f29f8](https://github.com/compwright/php-session/commit/53f29f8b3d3a97ee4f8a8a7d6c1df17e1458dfe6))

## [3.0.0](https://github.com/compwright/php-session/compare/v2.0.0...v3.0.0) (2022-12-23)


### ⚠ BREAKING CHANGES

* drop support for PHP 7.4
* support psr/simple-cache v2 and v3

### Features

* drop support for PHP 7.4 ([19358d0](https://github.com/compwright/php-session/commit/19358d039685beca8c8ec14e8cba260aeacdc0fa))
* support psr/simple-cache v2 and v3 ([c3e7563](https://github.com/compwright/php-session/commit/c3e756337fe2de35270201cf9a9271d42bc3b4ee)), closes [#2](https://github.com/compwright/php-session/issues/2)
* upgrade dependencies ([243d859](https://github.com/compwright/php-session/commit/243d859028fdfa0f4be4c8761f63a364b0f0e7f2)), closes [#2](https://github.com/compwright/php-session/issues/2)


### Bug Fixes

* add ArrayAccess to Session class ([#7](https://github.com/compwright/php-session/issues/7)) ([7d13b9d](https://github.com/compwright/php-session/commit/7d13b9dd1fea5243f382ad51802146e5d60c963e))
* Session::__get() should trigger error when data does not exist ([80fea20](https://github.com/compwright/php-session/commit/80fea2000d4d4bb624c8e3fecc196a6ba4697899))
* sid generation in cookie middleware ([#5](https://github.com/compwright/php-session/issues/5)) ([0fe1c63](https://github.com/compwright/php-session/commit/0fe1c6322a46acf0b2ce9e4e7072e80563e28279))
