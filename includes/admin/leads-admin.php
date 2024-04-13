<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Leads_Admin {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('admin_footer', array($this, 'print_leads_table_template'));
    }

public function add_admin_menu() {
    add_menu_page(
        __('Leads', 'leads'),
        __('Leads', 'leads'),
        'manage_options',
        'leads-parent', // Unique slug for parent menu
        array($this, 'leads_page'),
        'dashicons-email',
        20
    );

    add_submenu_page(
        'leads-parent', // Use the slug of the parent menu
        __('All Leads', 'leads'),
        __('All Leads', 'leads'),
        'manage_options',
        'leads',
        array($this, 'leads_page')
    );

    add_submenu_page(
        'leads-parent', // Use the slug of the parent menu
        __('Add New Lead', 'leads'),
        __('Add New Lead', 'leads'),
        'manage_options',
        'add-new-lead',
        array($this, 'add_new_lead_page')
    );

    // Remove other submenu pages under 'leads' parent menu.
    remove_submenu_page('leads-parent', 'leads-parent');
}


    // Method to render admin page.
    public function leads_page() {
        ?>
        <div class="wrap">
            <h2><?php _e('All Leads', 'leads'); ?></h2>
            <div id="leads-table"></div>
        </div>
        <?php
    }

    // Method to render add new lead page.
    public function add_new_lead_page() {
        ?>
        <div class="wrap">
            <h2><?php _e('Add New Lead', 'leads'); ?></h2>
            <div id="add-lead-form"></div>
        </div>
        <?php
    }

    // Method to enqueue admin scripts and styles.
    public function enqueue_admin_scripts($hook) {
        if ('toplevel_page_leads' !== $hook) {
            return;
        }
        wp_enqueue_script('leads-admin', LEADS_PLUGIN_URL . 'includes/admin/assets/js/leads-admin.js', array('jquery'), LEADS_PLUGIN_VERSION, true);
        wp_enqueue_style('leads-admin', LEADS_PLUGIN_URL . 'includes/admin/assets/css/leads-admin.css', array(), LEADS_PLUGIN_VERSION);
    }

    // Method to print leads table template.
    public function print_leads_table_template() {
        include_once LEADS_PLUGIN_DIR . 'includes/admin/templates/leads-table.php';
    }
}

// Instantiate Leads_Admin class.
$leads_admin = new Leads_Admin();
