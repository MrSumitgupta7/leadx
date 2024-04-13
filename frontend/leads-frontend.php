<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Leads_Frontend {
    public function __construct() {
        add_shortcode('leads_form', array($this, 'render_lead_form'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        add_action('wp_ajax_submit_lead', array($this, 'submit_lead'));
        add_action('wp_ajax_nopriv_submit_lead', array($this, 'submit_lead'));
    }

    // Method to render lead capture form shortcode.
    public function render_lead_form() {
        ob_start();
        ?>
        <form id="lead-form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
            <?php wp_nonce_field('submit_lead_nonce', 'lead_nonce'); ?>
            <input type="hidden" name="action" value="submit_lead">
            <p><input type="text" name="name" placeholder="<?php _e('Your Name', 'leads'); ?>" required></p>
            <p><input type="email" name="email" placeholder="<?php _e('Your Email', 'leads'); ?>" required></p>
            <p><input type="tel" name="phone" placeholder="<?php _e('Your Phone', 'leads'); ?>"></p>
            <p><textarea name="message" placeholder="<?php _e('Your Message', 'leads'); ?>"></textarea></p>
            <p><input type="submit" value="<?php _e('Submit', 'leads'); ?>"></p>
        </form>
        <?php
        return ob_get_clean();
    }

    // Method to enqueue frontend scripts and styles.
    public function enqueue_frontend_scripts() {
        wp_enqueue_script('leads-frontend', LEADS_PLUGIN_URL . 'includes/frontend/assets/js/leads-frontend.js', array('jquery'), LEADS_PLUGIN_VERSION, true);
        wp_enqueue_style('leads-frontend', LEADS_PLUGIN_URL . 'includes/frontend/assets/css/leads-frontend.css', array(), LEADS_PLUGIN_VERSION);
    }

    // Method to handle lead form submission.
    public function submit_lead() {
        // Verify nonce.
        if (!isset($_POST['lead_nonce']) || !wp_verify_nonce($_POST['lead_nonce'], 'submit_lead_nonce')) {
            wp_send_json_error(__('Invalid nonce.', 'leads'));
        }

        // Handle form submission here.
        // You can access form data using $_POST.
        // Insert lead into database using Leads_DB class.
        global $leads_db;
        $data = array(
            'name' => sanitize_text_field($_POST['name']),
            'email' => sanitize_email($_POST['email']),
            'phone' => sanitize_text_field($_POST['phone']),
            'message' => sanitize_textarea_field($_POST['message']),
        );
        $leads_db->insert_lead($data);
        wp_send_json_success(__('Lead submitted successfully.', 'leads'));
    }
}

// Instantiate Leads_Frontend class.
$leads_frontend = new Leads_Frontend();
