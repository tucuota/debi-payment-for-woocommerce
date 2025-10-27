<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link              https://debi.pro
 * @since             1.0.0
 * @package           WooCommerce_Debi
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

/**
 * Clean up plugin settings and data
 *
 * @since 1.0.0
 */
function woocommerce_debi_uninstall() {
	// Note: We're NOT deleting order meta data as per WordPress best practices
	// Order data should be preserved even after plugin uninstallation
	
	// Remove plugin-specific options if needed
	// delete_option('woocommerce_debi_settings');
	
	// Clear any transients if they exist
	// global $wpdb;
	// $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_woocommerce_debi_%'");
}

// Run uninstall function
woocommerce_debi_uninstall();

