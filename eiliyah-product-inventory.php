<?php

/**
 * Plugin Name: Eiliyah Product Manager
 * Plugin URI: https://example.com/eiliyah-product-manager/
 * Description: A WordPress plugin for managing product inventory with custom fields, search, and filtering.
 * Version: 1.1
 * Author: Zakaria Khan
 * Author URI: https://example.com/
 * License: GPLv2 or later
 * Text Domain: eiliyah_product_manager
 */

// Load plugin text domain
function eiliyah_product_manager_load_textdomain()
{
    load_plugin_textdomain('eiliyah-product-manager', false, dirname(__FILE__) . '/languages');
}
add_action('plugins_loaded', 'eiliyah_product_manager_load_textdomain');

// Include core classes
require_once plugin_dir_path(__FILE__) . 'includes/class-product-manager.php';
$eiliyah_product_manager = new Product_Manager();


// Hook to load the JavaScript file
function eiliyah_product_inventory_enqueue_scripts($hook)
{
    // Only enqueue on the product admin page
    if ('edit.php' !== $hook || isset($_GET['post_type']) && $_GET['post_type'] !== 'product') {
        return;
    }

    // Enqueue the script
    wp_enqueue_script(
        'eiliyah-product-inventory-admin-scripts', // Handle
        plugin_dir_url(__FILE__) . 'assets/js/admin-scripts.js', // File path
        array('jquery'), // Dependencies (if any)
        null, // Version number (optional)
        true // Load in footer
    );
}
add_action('admin_enqueue_scripts', 'eiliyah_product_inventory_enqueue_scripts');
