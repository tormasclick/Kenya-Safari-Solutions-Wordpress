/**
 * Dark Mode Title Highlighter
 * Targets specific card titles in dark mode
 */
document.addEventListener('DOMContentLoaded', function() {
    const specificTitles = {
        accommodations: ['Angama Mara', 'Mahali Mzuri', 'Tortilis Camp', 'Salt Lick Safari Lodge', 'Lake Nakuru Lodge', 'Kibo Safari Camp'],
        transfers: ['JKiA - Nairobi CBD', 'Moi Airport - Diani Beach', 'Malindi Airport - Watamu', 'SGR Terminus - Nairobi'],
        rentals: ['Toyota Land Cruiser', 'Toyota Prado TX', 'Tourist Safari Van', 'Mercedes V-Class']
    };
    
    function applyDarkModeTitleColors() {
        const isDark = document.documentElement.classList.contains('dark');
        
        if (!isDark) return;
        
        // Process all card titles
        document.querySelectorAll('.grid a h3, .grid a .font-display.text-xl, .grid a .font-display.text-2xl').forEach(title => {
            const titleText = title.textContent.trim();
            const isSpecial = [...specificTitles.accommodations, ...specificTitles.transfers, ...specificTitles.rentals].includes(titleText);
            
            if (isSpecial) {
                title.style.color = '#d97706';
            }
        });
    }
    
    // Run on load and when theme changes
    applyDarkModeTitleColors();
    
    // Watch for theme toggle
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                applyDarkModeTitleColors();
            }
        });
    });
    
    observer.observe(document.documentElement, { attributes: true });
});
