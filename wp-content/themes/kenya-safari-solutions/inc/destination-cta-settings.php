<?php
/**
 * Destination CTA Settings Page
 */

// Add submenu page under Destinations
function kenya_safari_destination_cta_menu() {
    add_submenu_page(
        'edit.php?post_type=destination',
        'Destination CTA Settings',
        'CTA Settings',
        'manage_options',
        'destination-cta-settings',
        'kenya_safari_destination_cta_page'
    );
}
add_action('admin_menu', 'kenya_safari_destination_cta_menu');

// Register settings
function kenya_safari_register_destination_cta_settings() {
    register_setting('kenya_destination_cta_settings', 'kenya_destination_cta_title');
    register_setting('kenya_destination_cta_settings', 'kenya_destination_cta_description');
    register_setting('kenya_destination_cta_settings', 'kenya_destination_cta_button_text');
    register_setting('kenya_destination_cta_settings', 'kenya_whatsapp_number');
}
add_action('admin_init', 'kenya_safari_register_destination_cta_settings');

// Settings Page
function kenya_safari_destination_cta_page() {
    $cta_title = get_option('kenya_destination_cta_title', 'Plan Your {destination_name} Safari Today');
    $cta_description = get_option('kenya_destination_cta_description', 'Let our travel experts create a custom itinerary just for you');
    $cta_button_text = get_option('kenya_destination_cta_button_text', 'Inquire on WhatsApp');
    $whatsapp_number = get_option('kenya_whatsapp_number', '254700563754');
    ?>
    <div class="wrap">
        <h1>Destination CTA Settings</h1>
        <p>Customize the Call-to-Action section that appears on all destination pages.</p>
        
        <form method="post" action="options.php">
            <?php settings_fields('kenya_destination_cta_settings'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row">CTA Title</th>
                    <td>
                        <input type="text" name="kenya_destination_cta_title" 
                               value="<?php echo esc_attr($cta_title); ?>" 
                               class="regular-text" />
                        <p class="description">Use <code>{destination_name}</code> as a placeholder for the destination name.</p>
                     </td>
                 </tr>
                <tr>
                    <th scope="row">CTA Description</th>
                    <td>
                        <textarea name="kenya_destination_cta_description" rows="3" class="large-text"><?php echo esc_textarea($cta_description); ?></textarea>
                     </td>
                 </tr>
                <tr>
                    <th scope="row">Button Text</th>
                    <td>
                        <input type="text" name="kenya_destination_cta_button_text" 
                               value="<?php echo esc_attr($cta_button_text); ?>" 
                               class="regular-text" />
                     </td>
                 </tr>
                <tr>
                    <th scope="row">WhatsApp Number</th>
                    <td>
                        <input type="text" name="kenya_whatsapp_number" 
                               value="<?php echo esc_attr($whatsapp_number); ?>" 
                               class="regular-text" />
                        <p class="description">Enter number in international format without + sign. Example: <code>254700563754</code></p>
                     </td>
                 </tr>
             </table>
            
            <?php submit_button('Save Settings'); ?>
        </form>
        
        <div class="notice notice-info" style="margin-top: 20px;">
            <h3>Preview:</h3>
            <div style="background: linear-gradient(135deg, #f59e0b, #ea580c); padding: 20px; border-radius: 16px; color: white; max-width: 500px;">
                <h4 style="color: white; margin: 0 0 5px 0;"><?php echo esc_html(str_replace('{destination_name}', 'Maasai Mara', $cta_title)); ?></h4>
                <p style="color: rgba(255,255,255,0.9); margin: 0 0 10px 0;"><?php echo esc_html($cta_description); ?></p>
                <div style="background: white; color: #f59e0b; display: inline-block; padding: 10px 20px; border-radius: 999px; font-weight: bold;">
                    <?php echo esc_html($cta_button_text); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
