<?php
/**
 * Marine CTA Settings Page
 */

// Add submenu page under Marine
function kenya_safari_marine_cta_menu() {
    add_submenu_page(
        'edit.php?post_type=marine',
        'Marine CTA Settings',
        'CTA Settings',
        'manage_options',
        'marine-cta-settings',
        'kenya_safari_marine_cta_page'
    );
}
add_action('admin_menu', 'kenya_safari_marine_cta_menu');

// Register settings
function kenya_safari_register_marine_cta_settings() {
    register_setting('kenya_marine_cta_settings', 'kenya_marine_cta_title');
    register_setting('kenya_marine_cta_settings', 'kenya_marine_cta_description');
    register_setting('kenya_marine_cta_settings', 'kenya_marine_cta_button_text');
}
add_action('admin_init', 'kenya_safari_register_marine_cta_settings');

// Settings Page
function kenya_safari_marine_cta_page() {
    $cta_title = get_option('kenya_marine_cta_title', 'Book Your {marine_name} Experience Today');
    $cta_description = get_option('kenya_marine_cta_description', 'Let our marine experts create an unforgettable ocean adventure for you');
    $cta_button_text = get_option('kenya_marine_cta_button_text', 'Reserve via WhatsApp');
    ?>
    <div class="wrap">
        <h1>Marine CTA Settings</h1>
        <p>Customize the Call-to-Action section that appears on all marine activity pages.</p>
        
        <form method="post" action="options.php">
            <?php settings_fields('kenya_marine_cta_settings'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row">CTA Title</th>
                    <td>
                        <input type="text" name="kenya_marine_cta_title" 
                               value="<?php echo esc_attr($cta_title); ?>" 
                               class="regular-text" />
                        <p class="description">Use <code>{marine_name}</code> as a placeholder for the marine activity name.</p>
                    </th>
                </tr>
                <tr>
                    <th scope="row">CTA Description</th>
                    <td>
                        <textarea name="kenya_marine_cta_description" rows="3" class="large-text"><?php echo esc_textarea($cta_description); ?></textarea>
                    </th>
                </tr>
                <tr>
                    <th scope="row">Button Text</th>
                    <td>
                        <input type="text" name="kenya_marine_cta_button_text" 
                               value="<?php echo esc_attr($cta_button_text); ?>" 
                               class="regular-text" />
                    </th>
                </tr>
            </table>
            
            <?php submit_button('Save Settings'); ?>
        </form>
        
        <div class="notice notice-info" style="margin-top: 20px;">
            <h3>Preview:</h3>
            <div style="background: linear-gradient(135deg, #f59e0b, #ea580c); padding: 20px; border-radius: 16px; color: white; max-width: 500px;">
                <h4 style="color: white; margin: 0 0 5px 0;"><?php echo esc_html(str_replace('{marine_name}', 'Dolphin Tours', $cta_title)); ?></h4>
                <p style="color: rgba(255,255,255,0.9); margin: 0 0 10px 0;"><?php echo esc_html($cta_description); ?></p>
                <div style="background: white; color: #f59e0b; display: inline-block; padding: 10px 20px; border-radius: 999px; font-weight: bold;">
                    <?php echo esc_html($cta_button_text); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
