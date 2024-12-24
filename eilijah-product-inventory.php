<?php

/**
 * Plugin Name: Advanced Product Manager
 * Plugin URI: https://example.com/advanced-product-manager/
 * Description: A WordPress plugin for managing product inventory with custom fields, search, and filtering.
 * Version: 1.0
 * Author: [Your Name]
 * Author URI: https://example.com/
 * License: GPLv2 or later
 * Text Domain: advanced-product-manager
 */

// Load plugin text domain
function advanced_product_manager_load_textdomain()
{
    load_plugin_textdomain('advanced-product-manager', false, dirname(__FILE__) . '/languages');
}
add_action('plugins_loaded', 'advanced_product_manager_load_textdomain');

// Include core classes
require_once plugin_dir_path(__FILE__) . 'includes/class-product-manager.php';
$advanced_product_manager = new Product_Manager();
