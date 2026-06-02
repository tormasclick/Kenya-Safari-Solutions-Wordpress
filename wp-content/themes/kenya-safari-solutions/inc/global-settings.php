<?php
/**
 * Global Settings - WhatsApp Number
 */

// Add admin menu under Settings
function kenya_safari_global_settings_menu() {
    add_options_page(
        'Global Settings',
        'Global Settings',
        'manage_options',
        'kenya-safari-global',
        'kenya_safari_global_settings_page'
    );
}
add_action('admin_menu', 'kenya_safari_global_settings_menu');

// Register global settings
function kenya_safari_register_global_settings() {
    register_setting('kenya_global_settings', 'kenya_whatsapp_number');
}
add_action('admin_init', 'kenya_safari_register_global_settings');

// Settings Page
function kenya_safari_global_settings_page() {
    $whatsapp_number = get_option('kenya_whatsapp_number', '254700563754');
    ?>
    <div class="wrap">
        <h1>Global Settings</h1>
        <p>These settings apply across the entire website.</p>
        
        <form method="post" action="options.php">
            <?php settings_fields('kenya_global_settings'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row">WhatsApp Number</th>
                    <td>
                        <input type="text" name="kenya_whatsapp_number" 
                               value="<?php echo esc_attr($whatsapp_number); ?>" 
                               class="regular-text" />
                        <p class="description">Enter WhatsApp number in international format without + sign.</p>
                        <p class="description">Example: <code>254700563754</code> for +254 700 563 754</p>
                        <p class="description">This number will be used for all WhatsApp buttons across the site (Destinations, Marine, Accommodations, Rentals, etc.)</p>
                    </th>
                </tr>
            </table>
            
            <?php submit_button('Save Settings'); ?>
        </form>
        
        <div class="notice notice-info" style="margin-top: 20px;">
            <h3>Preview:</h3>
            <p>WhatsApp link will be: <code>https://wa.me/<?php echo esc_html($whatsapp_number); ?>?text=Your%20message</code></p>
        </div>
    </div>
    <?php
}
