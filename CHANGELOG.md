# Changelog

All the changes can be found below. Order used:
 - Added
 - Changed
 - Deprecated
 - Removed
 - Fixed
 - Security

## [master]
- Updated `symfony` dependencies to `2.7.*`.

### Added
- `CodeBlockRenderer` for `league/commonmark`, to be used for code highlighting directly from markdown.
- Added ES6 keywords `from`, `as`, `of`, `with` to `javascript`.

### Changed
- Tests now use `PSR-4` namespaces.

### Fixed
- Typos in `python` definition.
- Fixed comments in `clike` and `less`.
- Fixed Strings in `csharp`.
- Fixed Tags in `markup` and `handlebars`.

## v0.4.2

### Added
- `SmallTalk` language definition.
- `Yaml` language definition.
- `Wiki Markup` language definition.

### Fixed
- Usage with `utf-8` charset.

## v0.4.1

### Added
- `Stylus` language definition.
- `SAS` language definition.
- `reStructured Text` language definition.

### Fixed
- `Gherkin` language definition.
- `Bash` language definition.
- `C-like` language definition for multiline comments.
- `SQL` ,`Markup`, `Python` language definition cleanup.

## v0.4.0

### Changed
 - Renamed `NodeFactory` class to `Lexer`.

## v0.3.1
### Added
 - F# language definition.

### Removed
- `autoload.php`.

### Fixed
 - `C#` language definition.
 - `CSS` language definition.
 - `PHP` language definition.

## v0.3.0

### Changed
- Renamed to `Spectrum`.

## v0.2.0

### Added
- Added `autoload.php` for autolading files without composer.
- `React JSX` language definition.
- `TypeScript` language definition.
- `Highlight Keyword` plugin.

### Changed
- Refactored languages to use static properties for better mapping.

## v0.1.0
- Initial release.
