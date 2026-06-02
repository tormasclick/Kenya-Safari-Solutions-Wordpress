</main>

<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">Kenya Safari Solutions</h3>
                <p class="text-gray-400">Your trusted partner for unforgettable safari experiences in Kenya.</p>
            </div>
            
            <div>
                <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                <?php wp_nav_menu([
                    'theme_location' => 'footer',
                    'menu_class' => 'space-y-2 text-gray-400',
                    'container' => false,
                    'fallback_cb' => false,
                ]); ?>
            </div>
            
            <div>
                <h3 class="text-xl font-bold mb-4">Contact</h3>
                <p class="text-gray-400"><i class="fas fa-envelope mr-2"></i> info@kenyasafarisolutions.com</p>
                <p class="text-gray-400"><i class="fas fa-phone mr-2"></i> +254 700 000 000</p>
            </div>
            
            <div>
                <h3 class="text-xl font-bold mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-amber-500 transition"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="text-gray-400 hover:text-amber-500 transition"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#" class="text-gray-400 hover:text-amber-500 transition"><i class="fab fa-twitter fa-2x"></i></a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; <?php echo date('Y'); ?> Kenya Safari Solutions. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
