<header class="mobile-header">
    <!-- Logo (Left) -->
    <div class="mobile-logo">
        <span>E-Invoice</span>
    </div>
    
    <!-- Menu Toggle Button (Right) -->
    <button type="button" class="mobile-menu-toggle" id="mobileMenuToggle">
        <span class="material-symbols-outlined">menu</span>
    </button>
</header>

<!-- Mobile Overlay -->
<div class="mobile-overlay" id="sidebarOverlay"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    // Mobile menu toggle
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('show');
            document.body.classList.toggle('overflow-hidden');
        });
    }
    
    // Close sidebar when clicking overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
            document.body.classList.remove('overflow-hidden');
        });
    }
});
</script> 