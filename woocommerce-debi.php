<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://debi.pro
 * @since             1.0.0
 * @package           WooCommerce_Debi
 *
 * @wordpress-plugin
 * Plugin Name:       Debi Payment for WooCommerce
 * Plugin URI:        https://github.com/yourusername/debi-payment-for-woocommerce
 * Description:       Official Debi payment gateway integration for WooCommerce. Accept credit cards with installments and automatic debit payments.
 * Version:           1.1.0
 * Author:            Fernando del Peral
 * Author URI:        https://debi.pro
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       debi-payment-for-woocommerce
 * Domain Path:       /languages
 * Requires at least: 5.6
 * Requires PHP:      7.0
 * WC requires at least: 3.0
 * WC tested up to:   9.1
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

// Load API client class
if (!class_exists('debi')) {
	require_once plugin_dir_path(__FILE__) . 'debi.php';
}

if (woocommerce_debi_is_woocommerce_active()) {
	add_filter('woocommerce_payment_gateways', 'add_woocommerce_debi');
	function add_woocommerce_debi($gateways) {
		$gateways[] = 'WC_debi';
		return $gateways;
	}

	add_action('plugins_loaded', 'init_woocommerce_debi');
	function init_woocommerce_debi() {
		require_once plugin_dir_path(__FILE__) . 'class-wc-debi.php';
	}

	// Translations are automatically loaded from the languages directory

}

/**
 * @return bool
 */
function woocommerce_debi_is_woocommerce_active() {
	$active_plugins = (array) get_option('active_plugins', array());

	if (is_multisite()) {
		$active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
	}

	return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins);
}