# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
-

## [2.0.0] - 2020-01-05
### Added
- Strict types
- vimeo/psalm checks
### Modified
- PSR-4 autoloading
- Change tests namespace
- Update PHP to 7.2+
- Update dev dependencies

## [1.5.0] - 2019-02-04
### Added
- PHP 7.3/PCRE2 support

## [1.4.0] - 2018-03-21
### Added
- Partial HTTP 2 support within `%H` and `%r`
### Modified
- Update supported PHP versions (PHP5.6+ only, no HHVM)

## [1.3.1] - 2017-06-25
### Added
- Tests for issue #30
### Fixed
- `%u` was not matching usernames with dots (issue #30)

## [1.3.0] - 2017-04-24
### Added
- Now we have a change log!
- `scheme` property (nginx-only): https://github.com/kassner/log-parser/pull/27
- `LogParser::createEntry` allowing overwrite the `\stdClass`: https://github.com/kassner/log-parser/pull/28/files
