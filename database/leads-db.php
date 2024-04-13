<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Leads_DB {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'leads';
    }

    // Method to create the leads table.
    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $this->table_name (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            message TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Method to insert a lead into the database.
    public function insert_lead($data) {
        global $wpdb;
        $wpdb->insert($this->table_name, $data);
    }

    // Method to get all leads from the database.
    public function get_all_leads() {
        global $wpdb;
        $query = "SELECT * FROM $this->table_name ORDER BY created_at DESC";
        return $wpdb->get_results($query, ARRAY_A);
    }
}

// Instantiate Leads_DB class.
$leads_db = new Leads_DB();
