<?php
/**
 * Template Name: Contact Page with CF7
 */

get_header(); ?>

<main class="pt-32 pb-16 px-4 bg-white dark:bg-[#0f0a08] transition-colors duration-300 min-h-screen">
    <div class="mx-auto max-w-6xl">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent mb-4">
                Contact Us
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Get in touch with our travel experts. We're here to help you plan your perfect Kenyan adventure.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6">
                    <h2 class="font-display text-2xl font-bold mb-6 text-gray-900 dark:text-white">Get in Touch</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-phone-alt text-amber-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Phone / WhatsApp</h3>
                                <p class="text-gray-600 dark:text-gray-400"><?php echo esc_html(get_option('kenya_footer_phone', '+254 700 000 000')); ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-envelope text-amber-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Email</h3>
                                <p class="text-gray-600 dark:text-gray-400"><?php echo esc_html(get_option('kenya_footer_email', 'info@kenyasafarisolutions.com')); ?></p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-amber-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Office</h3>
                                <p class="text-gray-600 dark:text-gray-400">Nairobi & Watamu, Kenya</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6">
                    <h2 class="font-display text-2xl font-bold mb-4 text-gray-900 dark:text-white">Office Hours</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Monday - Friday</span>
                            <span class="text-gray-900 dark:text-white font-semibold">9:00 AM - 6:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Saturday</span>
                            <span class="text-gray-900 dark:text-white font-semibold">10:00 AM - 4:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Sunday</span>
                            <span class="text-gray-900 dark:text-white font-semibold">Closed</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form 7 -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-2xl p-8 text-white">
                <h2 class="font-display text-2xl font-bold mb-4">Send Us a Message</h2>
                <p class="text-white/90 mb-6">Fill out the form below and we'll get back to you</p>
                
                <?php echo do_shortcode('[contact-form-7 id="YOUR_FORM_ID" title="Contact form"]'); ?>
                
                <p class="text-xs text-center mt-4 text-white/80">We'll respond within 24 hours</p>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="mt-12">
            <div class="rounded-2xl overflow-hidden shadow-xl h-[400px]">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255282.35887743724!2d36.68297542891105!3d-1.303207979074577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1172d84d49a7%3A0xf7cf0254b297924c!2sNairobi%2C%20Kenya!5e0!3m2!1sen!2s!4v1700000000000!5m2!1sen!2s" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
