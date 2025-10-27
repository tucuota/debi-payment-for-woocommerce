# WordPress.org Submission Checklist

This checklist helps ensure your plugin is ready for WordPress.org submission.

## Required Files

- [x] Main plugin file with proper headers
- [x] README.txt for WordPress.org
- [x] uninstall.php for cleanup
- [x] .gitignore file
- [ ] Plugin icon (assets/icon-256x256.jpg)
- [ ] Plugin banner (assets/banner-772x250.jpg)
- [ ] Screenshots (assets/screenshots/)

## Code Quality

- [x] Security headers in all PHP files (WPINC check)
- [x] Input sanitization and validation
- [x] Output escaping
- [x] Direct access prevention
- [x] Code comments and documentation
- [ ] Nonce verification for forms
- [ ] SQL injection prevention (N/A - no direct database queries)

## WordPress Standards

- [x] PHP 7.0+ compatible
- [x] WordPress 5.6+ compatible
- [x] WooCommerce 3.0+ compatible
- [x] Text domain: woocommerce-debi
- [x] Translation ready (languages folder created)
- [x] No debug code (echo, print_r, etc.)

## Plugin Headers

The plugin header in `woocommerce-debi.php` includes:
- [x] Plugin Name
- [x] Description
- [x] Version
- [x] Author
- [x] Author URI
- [x] License
- [x] License URI
- [x] Text Domain
- [x] Domain Path
- [x] Requires WordPress
- [x] Requires PHP
- [x] WC requires at least
- [x] WC tested up to

## Security Checklist

- [x] All user inputs sanitized
- [x] All outputs escaped
- [x] Direct file access prevented
- [x] Proper capability checks
- [ ] Nonce verification on forms
- [x] No hardcoded credentials
- [x] No eval(), exec(), system() calls

## Documentation

- [x] README.md
- [x] README.txt (WordPress.org format)
- [x] CHANGELOG.md
- [x] Inline code comments
- [x] Function documentation

## Testing

Before submission, test:
- [ ] Plugin activation
- [ ] Plugin deactivation
- [ ] Plugin uninstallation
- [ ] Payment processing (sandbox mode)
- [ ] Configuration save/load
- [ ] All WordPress and WooCommerce versions mentioned
- [ ] Different PHP versions

## Assets Needed

### Plugin Icon
- 256x256 pixels
- JPG or PNG format
- Place in: `assets/icon-256x256.jpg`

### Plugin Banner
- 772x250 pixels
- JPG or PNG format
- Place in: `assets/banner-772x250.jpg`

### Screenshots
Minimum 1 screenshot recommended (maximum 10):
- 880x660 pixels
- PNG format
- Place in: `assets/screenshots/`
- Suggested filenames:
  - `screenshot-1.png` - Settings page
  - `screenshot-2.png` - Checkout with payment fields
  - `screenshot-3.png` - Order with payment details

## Known Issues to Address

1. **Add Nonce Verification**: WooCommerce payment gateways should verify nonces on submission
2. **Improve Output Escaping**: All echo statements in payment_fields() should use esc_html()
3. **Add Plugin Icons**: Create and add plugin icon and banner images
4. **Add Screenshots**: Create screenshot images for the plugin repository
5. **Translation**: Add .pot file and prepare for translation

## After Submission

1. Monitor the SVN repository
2. Respond to reviewer feedback promptly
3. Update description/banners if rejected
4. Fix any security or code quality issues
5. Resubmit with corrections

## Useful Links

- [Plugin Developer Handbook](https://developer.wordpress.org/plugins/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)
- [Plugin Submission](https://wordpress.org/plugins/developers/submit/)
- [Security Best Practices](https://developer.wordpress.org/plugins/security/)

