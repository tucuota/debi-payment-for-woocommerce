# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2025-10-27

### Security
- All user-facing text converted to translatable strings
- Improved output escaping in payment fields
- Updated order meta keys to follow WordPress conventions
- Added proper input sanitization and validation in `process_payment()` method
- Added security headers (`WPINC` checks) to all PHP files
- Fixed direct `$_POST` access without sanitization
- Added card number validation with length and format checks
- Improved error handling with proper user-facing error messages

### Changed
- Updated plugin headers to include proper WordPress.org metadata
- Improved code documentation with PHPDoc blocks
- Enhanced payment field rendering with proper escaping
- Updated WooCommerce tested version to 8.0
- Improved plugin structure for WordPress.org submission
- Converted all Spanish hardcoded text to translatable English strings
- Updated all code comments to English
- Replaced Spanish order meta keys with English equivalents
- Payment field labels now fully translatable

### Added
- Created `uninstall.php` for proper plugin cleanup
- Created comprehensive `README.txt` for WordPress.org
- Added `.gitignore` file
- Created `languages/woocommerce-debi.pot` translation template
- Created `assets/` directory for plugin icon and banners
- Added proper security checks to `debi.php` API client
- Added class existence checks to prevent double-loading
- Full i18n support with translatable strings

### Fixed
- Fixed duplicate PHP opening tag in main plugin file
- Fixed require statements to use proper WordPress paths
- Fixed validation for installment quotas

## [1.0.0] - 2024-01-01

### Added
- Initial release
- Basic Debi payment gateway integration
- Sandbox mode support
- Configurable installment plans (0-12 installments)
- Interest rate configuration per installment
- Automatic subscription creation
- Customer and payment method tokenization
- Order metadata storage for subscription tracking

[1.1.0]: https://github.com/yourusername/woocommerce-debi/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/yourusername/woocommerce-debi/releases/tag/v1.0.0

