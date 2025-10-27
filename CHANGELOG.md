# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2025-10-27

### Security
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

### Added
- Created `uninstall.php` for proper plugin cleanup
- Created comprehensive `README.txt` for WordPress.org
- Added `.gitignore` file
- Created `languages/` directory for translations
- Created `assets/` directory for plugin icon and banners
- Added proper security checks to `debi.php` API client
- Added class existence checks to prevent double-loading

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

