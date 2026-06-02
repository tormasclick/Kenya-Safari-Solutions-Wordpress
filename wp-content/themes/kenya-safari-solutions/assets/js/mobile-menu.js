// Mobile Menu Toggle - Fixed version
(function() {
    console.log('Mobile menu script loaded');
    
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeBtn = document.getElementById('mobile-menu-close');
    
    let isMenuOpen = false;
    
    function openMenu() {
        mobileMenu.style.display = 'block';
        isMenuOpen = true;
        document.body.style.overflow = 'hidden';
        console.log('Menu opened');
    }
    
    function closeMenu() {
        mobileMenu.style.display = 'none';
        isMenuOpen = false;
        document.body.style.overflow = '';
        console.log('Menu closed');
    }
    
    function toggleMenu() {
        if (isMenuOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    }
    
    if (menuBtn && mobileMenu) {
        // Initially hide
        mobileMenu.style.display = 'none';
        
        // Toggle on button click
        menuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMenu();
        });
        
        // Close with close button
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                closeMenu();
            });
        }
        
        // Close when clicking outside
        document.addEventListener('click', function(event) {
            if (isMenuOpen) {
                if (!mobileMenu.contains(event.target) && !menuBtn.contains(event.target)) {
                    closeMenu();
                }
            }
        });
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isMenuOpen) {
                closeMenu();
            }
        });
        
        // Close when a link is clicked
        const links = mobileMenu.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                closeMenu();
            });
        });
    }
})();
