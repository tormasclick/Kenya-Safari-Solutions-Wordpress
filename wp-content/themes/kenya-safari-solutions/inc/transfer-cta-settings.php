<?php
/**
 * Transfer CTA Settings Page
 */

// Add submenu page under Transfers
function kenya_safari_transfer_cta_menu() {
    add_submenu_page(
        'edit.php?post_type=transfer',
        'Transfer CTA Settings',
        'CTA Settings',
        'manage_options',
        'transfer-cta-settings',
        'kenya_safari_transfer_cta_page'
    );
}
add_action('admin_menu', 'kenya_safari_transfer_cta_menu');

// Register settings
function kenya_safari_register_transfer_cta_settings() {
    register_setting('kenya_transfer_cta_settings', 'kenya_transfer_cta_title');
    register_setting('kenya_transfer_cta_settings', 'kenya_transfer_cta_description');
    register_setting('kenya_transfer_cta_settings', 'kenya_transfer_cta_button_text');
    register_setting('kenya_transfer_cta_settings', 'kenya_transfer_cta_footer_text');
}
add_action('admin_init', 'kenya_safari_register_transfer_cta_settings');

// Settings Page
function kenya_safari_transfer_cta_page() {
    $cta_title = get_option('kenya_transfer_cta_title', 'Book {transfer_name}');
    $cta_description = get_option('kenya_transfer_cta_description', 'Professional driver • Flight monitoring • Free waiting time');
    $cta_button_text = get_option('kenya_transfer_cta_button_text', 'Book via WhatsApp');
    $cta_footer_text = get_option('kenya_transfer_cta_footer_text', 'Free cancellation up to 24 hours before pickup');
    ?>
    <div class="wrap">
        <h1>Transfer CTA Settings</h1>
        <p>Customize the Call-to-Action section that appears on all transfer pages.</p>
        
        <form method="post" action="options.php">
            <?php settings_fields('kenya_transfer_cta_settings'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row">CTA Title</th>
                    <td>
                        <input type="text" name="kenya_transfer_cta_title" 
                               value="<?php echo esc_attr($cta_title); ?>" 
                               class="regular-text" />
                        <p class="description">Use <code>{transfer_name}</code> as a placeholder for the transfer name.</p>
                    </th>
                </tr>
                <tr>
                    <th scope="row">CTA Description</th>
                    <td>
                        <textarea name="kenya_transfer_cta_description" rows="2" class="large-text"><?php echo esc_textarea($cta_description); ?></textarea>
                    </th>
                </tr>
                <tr>
                    <th scope="row">Button Text</th>
                    <td>
                        <input type="text" name="kenya_transfer_cta_button_text" 
                               value="<?php echo esc_attr($cta_button_text); ?>" 
                               class="regular-text" />
                    </th>
                </tr>
                <tr>
                    <th scope="row">Footer Text</th>
                    <td>
                        <input type="text" name="kenya_transfer_cta_footer_text" 
                               value="<?php echo esc_attr($cta_footer_text); ?>" 
                               class="regular-text" />
                    </th>
                </tr>
            </table>
            
            <?php submit_button('Save Settings'); ?>
        </form>
        
        <div class="notice notice-info" style="margin-top: 20px;">
            <h3>Preview:</h3>
            <div style="background: linear-gradient(135deg, #f59e0b, #ea580c); padding: 20px; border-radius: 16px; color: white; max-width: 400px;">
                <h4 style="color: white; margin: 0 0 5px 0;"><?php echo esc_html(str_replace('{transfer_name}', 'JKIA → Nairobi CBD', $cta_title)); ?></h4>
                <p style="color: rgba(255,255,255,0.9); margin: 0 0 10px 0;"><?php echo esc_html($cta_description); ?></p>
                <div style="background: white; color: #f59e0b; display: inline-block; padding: 8px 16px; border-radius: 999px; font-weight: bold; font-size: 14px;">
                    <?php echo esc_html($cta_button_text); ?>
                </div>
                <p class="text-xs text-center mt-3 text-white/80" style="font-size: 10px; margin-top: 8px;"><?php echo esc_html($cta_footer_text); ?></p>
            </div>
        </div>
    </div>
    <?php
}
