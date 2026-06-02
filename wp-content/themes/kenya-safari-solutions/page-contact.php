<?php
/**
 * Template Name: Contact Page
 * Fully dynamic - all content editable from page editor
 */

get_header(); 

global $post;

// Get all dynamic settings from page meta
$hero_eyebrow = get_post_meta($post->ID, '_contact_hero_eyebrow', true);
$hero_title = get_post_meta($post->ID, '_contact_hero_title', true);
$hero_description = get_post_meta($post->ID, '_contact_hero_description', true);
$phone = get_post_meta($post->ID, '_contact_phone_number', true);
$email = get_post_meta($post->ID, '_contact_email_address', true);
$office_location = get_post_meta($post->ID, '_contact_office_location', true);
$office_hours = get_post_meta($post->ID, '_contact_office_hours', true);
$form_shortcode = get_post_meta($post->ID, '_contact_form_shortcode', true);
$form_title = get_post_meta($post->ID, '_contact_form_title', true);
$form_description = get_post_meta($post->ID, '_contact_form_description', true);

// Set defaults if empty
if (!$hero_eyebrow) $hero_eyebrow = 'Get in Touch';
if (!$hero_title) $hero_title = "Let's Start a {gradient}Conversation{/gradient}";
if (!$hero_description) $hero_description = "Whether you're planning your dream safari or have questions about our services, our team is here to help.";
if (!$phone) $phone = '+254 700 563 754';
if (!$email) $email = 'info@kenyasafarisolutions.com';
if (!$office_location) $office_location = 'Nairobi & Watamu, Kenya';
if (!$office_hours) $office_hours = 'Monday - Friday: 9am - 6pm';
if (!$form_shortcode) $form_shortcode = '[contact-form-7 id="229" title="Contact form"]';
if (!$form_title) $form_title = 'Send Us a Message';
if (!$form_description) $form_description = "Fill out the form and we'll get back to you shortly";

// Process hero title for gradient
$hero_title_processed = preg_replace('/\{gradient\}(.*?)\{\/gradient\}/', '<span class="text-gradient-gold">$1</span>', $hero_title);
?>

<main class="pt-32 pb-16 px-4 min-h-screen" style="background: linear-gradient(135deg, var(--background, #ffffff) 0%, #faf8f5 100%); transition: background 0.3s ease;">
    <div class="mx-auto max-w-6xl">
        <!-- Hero Section -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 text-[11px] uppercase tracking-[0.22em] text-amber-600 dark:text-amber-400 font-bold mb-4">
                <span class="h-px w-8 bg-amber-500"></span> <?php echo esc_html($hero_eyebrow); ?>
            </div>
            <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-bold" style="color: var(--foreground, #1a1a1a);">
                <?php echo $hero_title_processed; ?>
            </h1>
            <p class="mt-4 text-lg max-w-2xl mx-auto" style="color: var(--muted-foreground, #6b7280);">
                <?php echo esc_html($hero_description); ?>
            </p>
        </div>

        <div class="grid lg:grid-cols-5 gap-8">
            <!-- Contact Info Cards (2 columns) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Phone Card -->
                <div class="group rounded-2xl p-6 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl" style="background: var(--card, #ffffff); border: 1px solid var(--border, #e5e7eb);">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-500 flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas fa-phone-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="font-display text-xl font-bold mb-2" style="color: var(--foreground, #1a1a1a);">Phone & WhatsApp</h3>
                    <p class="text-2xl font-semibold mt-2">
                        <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>" class="hover:text-amber-600 transition" style="color: var(--foreground, #1a1a1a);"><?php echo esc_html($phone); ?></a>
                    </p>
                    <p class="text-sm mt-2" style="color: var(--muted-foreground, #6b7280);">Available 24/7 for urgent inquiries</p>
                </div>

                <!-- Email Card -->
                <div class="group rounded-2xl p-6 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl" style="background: var(--card, #ffffff); border: 1px solid var(--border, #e5e7eb);">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas fa-envelope text-white text-2xl"></i>
                    </div>
                    <h3 class="font-display text-xl font-bold mb-2" style="color: var(--foreground, #1a1a1a);">Email Us</h3>
                    <p class="text-lg mt-2">
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="hover:text-amber-600 transition" style="color: var(--foreground, #1a1a1a);"><?php echo esc_html($email); ?></a>
                    </p>
                    <p class="text-sm mt-2" style="color: var(--muted-foreground, #6b7280);">We'll respond within 24 hours</p>
                </div>

                <!-- Office Card -->
                <div class="group rounded-2xl p-6 transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl" style="background: var(--card, #ffffff); border: 1px solid var(--border, #e5e7eb);">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="font-display text-xl font-bold mb-2" style="color: var(--foreground, #1a1a1a);">Visit Our Office</h3>
                    <p class="text-lg" style="color: var(--foreground, #1a1a1a);"><?php echo esc_html($office_location); ?></p>
                    <p class="text-sm mt-2" style="color: var(--muted-foreground, #6b7280);"><?php echo esc_html($office_hours); ?></p>
                </div>
            </div>

            <!-- Contact Form (3 columns) -->
            <div class="lg:col-span-3">
                <div class="rounded-2xl p-8 shadow-2xl" style="background: var(--card, #ffffff); border: 1px solid var(--border, #e5e7eb);">
                    <div class="text-center mb-6">
                        <h2 class="font-display text-2xl font-bold" style="color: var(--foreground, #1a1a1a);"><?php echo esc_html($form_title); ?></h2>
                        <p class="text-sm mt-1" style="color: var(--muted-foreground, #6b7280);"><?php echo esc_html($form_description); ?></p>
                    </div>
                    
                    <?php if (function_exists('wpcf7_contact_form') && !empty($form_shortcode)): ?>
                        <div class="contact-form-beautiful">
                            <?php echo do_shortcode($form_shortcode); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center p-8 bg-amber-50 dark:bg-amber-900/20 rounded-xl">
                            <p class="text-amber-600 dark:text-amber-400">Please install and activate Contact Form 7 plugin.</p>
                            <p class="text-sm mt-2 text-gray-500">Go to <strong>Plugins → Add New</strong> to install Contact Form 7.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- CTA Section -->
<?php get_template_part('template-parts/cta-section'); ?>

<style>
/* Beautiful Contact Form 7 Styling */
.contact-form-beautiful .wpcf7-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.contact-form-beautiful .wpcf7-form p {
    margin: 0;
}

.contact-form-beautiful .wpcf7-form input,
.contact-form-beautiful .wpcf7-form textarea,
.contact-form-beautiful .wpcf7-form select {
    width: 100%;
    padding: 14px 18px;
    border-radius: 16px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: var(--background, #ffffff);
    border: 2px solid var(--border, #e5e7eb);
    color: var(--foreground, #1a1a1a);
}

.contact-form-beautiful .wpcf7-form input:focus,
.contact-form-beautiful .wpcf7-form textarea:focus,
.contact-form-beautiful .wpcf7-form select:focus {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
    transform: translateY(-2px);
}

.contact-form-beautiful .wpcf7-form textarea {
    min-height: 120px;
    resize: vertical;
}

/* Submit Button */
.contact-form-beautiful .wpcf7-form input[type="submit"] {
    background: linear-gradient(135deg, #f59e0b, #ea580c);
    color: white;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 0.5rem;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
}

.contact-form-beautiful .wpcf7-form input[type="submit"]:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
}

/* Dark mode styles */
.dark .contact-form-beautiful .wpcf7-form input,
.dark .contact-form-beautiful .wpcf7-form textarea,
.dark .contact-form-beautiful .wpcf7-form select {
    background-color: #1a120c;
    border-color: #3f2c21;
    color: #f5f0eb;
}

.dark .contact-form-beautiful .wpcf7-form input:focus,
.dark .contact-form-beautiful .wpcf7-form textarea:focus {
    border-color: #d4784a;
    box-shadow: 0 0 0 4px rgba(212, 120, 74, 0.15);
}

/* Placeholder styles */
.contact-form-beautiful .wpcf7-form input::placeholder,
.contact-form-beautiful .wpcf7-form textarea::placeholder {
    color: #9ca3af;
}

.dark .contact-form-beautiful .wpcf7-form input::placeholder,
.dark .contact-form-beautiful .wpcf7-form textarea::placeholder {
    color: #6b7280;
}

/* Response messages */
.wpcf7-response-output {
    margin-top: 1rem !important;
    padding: 1rem !important;
    border-radius: 12px !important;
    text-align: center;
}

.wpcf7-mail-sent-ok {
    background-color: #10b981 !important;
    color: white !important;
    border: none !important;
}

.wpcf7-mail-sent-ng,
.wpcf7-validation-errors {
    background-color: #ef4444 !important;
    color: white !important;
    border: none !important;
}

.wpcf7-not-valid-tip {
    color: #ef4444 !important;
    font-size: 12px !important;
    margin-top: 5px !important;
}
</style>

<?php get_footer(); ?>
