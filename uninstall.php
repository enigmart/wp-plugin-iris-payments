<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package WooCommerce Iris Gateway
 */

// If this file is called directly, abort.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Clean up any plugin options if needed
// Currently no options need to be cleaned up
