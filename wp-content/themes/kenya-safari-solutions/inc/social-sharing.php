<?php
/**
 * Social Sharing with Icons
 */

function kenya_safari_social_share_buttons() {
    if (!is_singular()) {
        return;
    }
    
    $url = get_permalink();
    $title = get_the_title();
    ?>
    <div class="social-share-icons">
        <div class="social-share-icons-inner">
            <span class="share-label">Share:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" target="_blank" rel="noopener" class="share-icon share-fb">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($title); ?>&url=<?php echo urlencode($url); ?>" target="_blank" rel="noopener" class="share-icon share-tw">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://wa.me/?text=<?php echo urlencode($title . ' - ' . $url); ?>" target="_blank" rel="noopener" class="share-icon share-wa">
                <i class="fab fa-whatsapp"></i>
            </a>
            <button onclick="copyPageLink('<?php echo esc_js($url); ?>')" class="share-icon share-cp">
                <i class="fas fa-link"></i>
            </button>
        </div>
    </div>
    
    <style>
    .social-share-icons {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: white;
        padding: 10px 18px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 999;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0,0,0,0.05);
    }
    .dark .social-share-icons {
        background: #1f2937;
        border-color: #374151;
    }
    .social-share-icons-inner {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .share-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }
    .dark .share-label {
        color: #9ca3af;
    }
    .share-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 16px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
        background: none;
    }
    .share-fb {
        background: #1877f2;
        color: white;
    }
    .share-tw {
        background: #1da1f2;
        color: white;
    }
    .share-wa {
        background: #25d366;
        color: white;
    }
    .share-cp {
        background: #6b7280;
        color: white;
    }
    .share-icon:hover {
        transform: scale(1.1);
    }
    .share-fb:hover { background: #166fe5; }
    .share-tw:hover { background: #1a91da; }
    .share-wa:hover { background: #20bd5a; }
    .share-cp:hover { background: #4b5563; }
    
    @media (max-width: 768px) {
        .social-share-icons {
            bottom: 10px;
            right: 10px;
            padding: 6px 12px;
        }
        .share-icon {
            width: 30px;
            height: 30px;
            font-size: 14px;
        }
        .share-label {
            font-size: 11px;
        }
    }
    </style>
    
    <script>
    function copyPageLink(url) {
        navigator.clipboard.writeText(url).then(() => {
            const btn = document.querySelector('.share-cp');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            setTimeout(() => { btn.innerHTML = originalHTML; }, 1500);
        });
    }
    </script>
    <?php
}
add_action('wp_footer', 'kenya_safari_social_share_buttons');
