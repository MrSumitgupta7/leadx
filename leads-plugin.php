<?php
/**
 * Plugin Name: Leads
 * Description: A plugin for using wp custom table.
 * Version: 1.0
 * Author: Sumit Gupta From LUBUS.
 * Author URI: Your Site
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants.
define('LEADS_PLUGIN_VERSION', '1.0');
define('LEADS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LEADS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files using WordPress functions.
require_once LEADS_PLUGIN_DIR . 'database/leads-db.php';
require_once LEADS_PLUGIN_DIR . 'includes/admin/leads-admin.php';
require_once LEADS_PLUGIN_DIR . 'frontend/leads-frontend.php';
