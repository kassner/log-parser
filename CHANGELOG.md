# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Modified
- Remove PHP 5.3 from Travis
- Add PHP 7.2 from Travis

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
