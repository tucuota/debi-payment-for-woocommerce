<?php
/* @wordpress-plugin
 * Plugin Name:       WooCommerce Debi
 * Plugin URI:        https://wpruby.com/plugin/woocommerce-custom-payment-gateway-pro/
 * Description:       Add gateway debi to Woocommerce to receive payments.
 * Version:           1.1.0
 * WC requires at least: 2.6
 * WC tested up to: 3.5
 * Author:            Fernando del Peral
 * Author URI:        https://debi.pro
 * Text Domain:       woocommerce-debi
 * Domain Path: /languages
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

$active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
if (woocommerce_debi_is_woocommerce_active()) {
	add_filter('woocommerce_payment_gateways', 'add_woocommerce_debi');
	function add_woocommerce_debi($gateways) {
		$gateways[] = 'WC_debi';
		return $gateways;
	}

	add_action('plugins_loaded', 'init_woocommerce_debi');
	function init_woocommerce_debi() {
		require 'class-wc-debi.php';
	}

	add_action('plugins_loaded', 'woocommerce_debi_load_plugin_textdomain');
	function woocommerce_debi_load_plugin_textdomain() {
		load_plugin_textdomain('woocommerce-debi', FALSE, basename(dirname(__FILE__)) . '/languages/');
	}

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