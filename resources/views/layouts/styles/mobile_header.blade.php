<style>
    /* Mobile header styles */
    .mobile-header {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 64px;
        background-color: white;
        border-bottom: 1px solid var(--border);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        z-index: 30;
        padding: 0 16px;
    }

    .mobile-logo {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--primary);
    }

    .mobile-menu-toggle {
        background: none;
        border: none;
        padding: 8px;
        border-radius: 6px;
        cursor: pointer;
        color: var(--primary);
    }

    .mobile-menu-toggle:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .mobile-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 20;
        display: none;
    }

    /* Mobile sidebar adjustments */
    @media only screen and (max-width: 767px) {
        .mobile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        aside.sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 25;
            padding-top: 64px; /* Add padding to accommodate the header */
        }
        
        aside.sidebar.open {
            transform: translateX(0);
        }
        
        .mobile-overlay.show {
            display: block;
        }
        
        .main-content {
            margin-top: 64px !important; /* Add top margin for the mobile header */
        }
    }

    /* Tablet adjustments */
    @media (min-width: 768px) and (max-width: 1024px) {
        .mobile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        aside.sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 25;
            padding-top: 64px; /* Add padding to accommodate the header */
        }
        
        aside.sidebar.open {
            transform: translateX(0);
        }
        
        .mobile-overlay.show {
            display: block;
        }
        
        .main-content {
            margin-top: 64px !important; /* Add top margin for the mobile header */
        }
    }
</style>
