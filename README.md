# WooCommerce Debi

Official Debi payment gateway integration for WooCommerce. Accept payments with flexible installment plans and automatic debit.

## Features

- 🔒 **Secure Payments** - PCI-compliant payment processing through Debi
- 💳 **Flexible Installments** - Configure up to 12 installment plans
- ⚙️ **Customizable Interest Rates** - Set interest rates for each installment plan
- 🔄 **Automatic Debit** - Schedule recurring payments automatically
- 🧪 **Sandbox Mode** - Test your integration before going live
- 🎯 **Easy Configuration** - Set up in minutes

## Requirements

- WordPress 5.6 or higher
- PHP 7.0 or higher
- WooCommerce 3.0 or higher

## Installation

### Automatic Installation

1. Log in to your WordPress admin panel
2. Navigate to **Plugins → Add New**
3. Search for "WooCommerce Debi"
4. Click **Install Now** and then **Activate**
5. Configure at **WooCommerce → Settings → Payments → Debi**

### Manual Installation

1. Download the plugin zip file
2. Extract to your WordPress plugins directory (`wp-content/plugins/`)
3. Log in to your WordPress admin panel
4. Navigate to **Plugins**
5. Find "WooCommerce Debi" and click **Activate**
6. Configure at **WooCommerce → Settings → Payments → Debi**

## Configuration

1. Go to **WooCommerce → Settings → Payments**
2. Find **"Débito automático (debi)"** and click **Manage**
3. Enable the payment method
4. Enter your Debi API credentials:
   - **Live Token** - Production API token
   - **Sandbox Token** - Testing API token
5. Configure installment plans and interest rates (0-12 installments)
6. Enable/disable sandbox mode
7. Save changes

### Getting Your API Credentials

1. Sign up at [debi.pro](https://debi.pro)
2. Navigate to the Developer section
3. Generate your API tokens for both live and sandbox environments

## How It Works

1. Install and activate the plugin
2. Configure your Debi API credentials
3. Set up installment plans with interest rates
4. Customers select their payment plan during checkout
5. Payments are processed securely through Debi's infrastructure

## Security

This plugin follows WordPress security best practices:

- All user inputs are sanitized and validated
- Direct access to files is prevented
- Nonces are used for form submissions
- Card data is sent directly to Debi's secure API (never stored)

## Support

For support, please visit [debi.pro/support](https://debi.pro/support)

## Development

We welcome contributions! Please ensure all code follows:
- WordPress Coding Standards
- Security best practices
- PHP compatibility standards

## License

This plugin is licensed under the GPL-2.0+ license.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for a complete list of changes.

## Credits

Developed by Fernando del Peral for [debi.pro](https://debi.pro)
