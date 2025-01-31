
![logo_teal_horizontal](https://github.com/user-attachments/assets/b94cfbf5-6799-462e-bad9-36b3c3ffbe85)

# WooCommerce IRIS Payment Gateway

A WordPress plugin that adds IRIS Payment Gateway functionality to your WooCommerce store, optimized for B2B transactions where instant digital payments are not the preferred option.

## Features

- 🔒 Secure B2B payment processing through IRIS
- 🛠️ Customizable order statuses (On Hold, Pending Payment, Processing, Completed)
- 👥 Role-based access control for payment gateway
- 📦 Support for WooCommerce block-based checkout
- ✅ HPOS (High-Performance Order Storage) compatible
- 🔄 Automatic order status updates and email notifications
- 💼 Perfect for business-to-business transactions

## Requirements

- WordPress 6.0 or higher
- WooCommerce 8.0 or higher
- PHP 7.4 or higher

## Installation

1. Download the plugin zip file
2. Go to WordPress Admin > Plugins > Add New
3. Click "Upload Plugin" and select the downloaded zip file
4. Click "Install Now"
5. Activate the plugin through the 'Plugins' menu in WordPress

## Configuration

1. Go to WooCommerce > Settings > Payments
2. Click on "IRIS Payment" to configure the gateway
3. Configure the following settings:
   - Enable/Disable the payment method
   - Title and description shown at checkout
   - VAT Number
   - Account Name
   - QR Code URL (optional)
   - Default order status
   - User role restrictions
   - Shipping method restrictions

## Usage

Once configured, the IRIS payment option will appear at checkout for your customers. The plugin:

- Allows customers to make payments via IRIS
- Uses order ID as payment reference
- Provides payment details on order confirmation page and in email
- Supports custom order status workflows

## Support

For support questions, feature requests or bug reports, please use the [GitHub issues](https://github.com/enigmart/wp-plugin-iris-payments/issues) page.

## License

This project is licensed under the GPLv3 License - see the [LICENSE](https://www.gnu.org/licenses/gpl-3.0.html) file for details.

## Changelog

### 2.0.1 - 2023-08-30
- Added HPOS Compatibility

### 2.0.0 - 2023-02-18
- Added Compatibility for WooCommerce block checkout

## Credits

Developed and maintained by [Enigmart](https://github.com/enigmart)
