<style>
    /* Base sidebar styles */
    aside.sidebar {
        background-color: var(--background);
        height: 100vh;
        display: flex;
        flex-direction: column;
        position: static;
        z-index: 20;
        transform: translateX(0);
        transition: all 0.3s ease;
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
        border-right: 1px solid var(--border);
    }

    /* Sidebar states */
    aside.sidebar.expanded {
        width: 240px;
    }

    aside.sidebar.collapsed {
        width: 64px;
    }

    /* Toggle button */
    .toggle-button {
        position: absolute;
        top: 16px;
        right: -12px;
        background-color: white;
        border-radius: 50%;
        border: 1px solid var(--border);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        padding: 0;
        margin: 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .toggle-button .material-symbols-outlined {
        transition: transform 0.3s ease;
    }

    /* ------------------------------------------------------------ */

    /* Logo area */
    .logo {
        padding: 16px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-text {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--primary);
        transition: all 0.3s ease;
        white-space: nowrap;
        overflow: hidden;
    }

    .logo-icon {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--primary);
        width: 0;
        opacity: 0;
        transition: all 0.3s ease;
    }

    /* ------------------------------------------------------------ */

    /* Menu area */
    .menu {
        display: flex;
        flex-grow: 1;
        overflow-y: auto;
        padding: 0 8px;
    }

    .nav-menu {
        padding: 12px 0;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    /* ------------------------------------------------------------ */

    /* Menu items */
    .menu-item, .menu-toggle {
        display: flex;
        align-items: center;
        padding: 8px 0px 8px 11px;
        text-decoration: none;
        color: var(--primary);
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.2s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .menu-item:hover, .menu-toggle:hover {
        background-color: var(--primary);
        color: white !important;
        text-decoration: none;
    }

    .menu-item.active {
        background-color: var(--primary);
        color: white !important;
    }

    .menu-item.active .menu-icon {
        color: white !important;
    }

    .menu-icon {
        color: var(--sub-text);
        margin-right: 12px;
    }

    .menu-item:hover .menu-icon, .menu-toggle:hover .menu-icon {
        color: white;
    }

    .menu-text {
        white-space: nowrap;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .arrow-icon {
        margin-left: auto;
        font-size: 0.875rem;
        color: #6b7280;
        transition: transform 0.3s ease, opacity 0.2s ease;
    }

    .arrow-icon.rotate {
        transform: rotate(180deg);
    }

    /* ------------------------------------------------------------ */

    /* Submenu styles */
    .submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out, opacity 0.2s ease-in-out, transform 0.2s ease;
        opacity: 0;
        transform: translateY(-10px);
        border-left: 2px solid transparent;
        margin-left: 22px;
        padding-left: 16px;
    }

    .submenu.open {
        max-height: 500px;
        opacity: 1;
        transform: translateY(0);
        border-left: 2px solid #e5e7eb;
    }

    .submenu-item {
        display: flex;
        align-items: center;
        padding: 8px;
        margin-bottom: 4px;
        text-decoration: none;
        color: var(--primary);
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 6px;
        transform: translateX(-10px);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease, background-color 0.2s ease, color 0.2s ease;
        transition-delay: calc(var(--index) * 0.05s);
    }

    .submenu-item:hover {
        background-color: var(--primary);
        color: white !important;
        text-decoration: none;
    }

    .submenu.open .submenu-item {
        transform: translateX(0);
        opacity: 1;
    }

    /* ------------------------------------------------------------ */
    /* User profile */
    .user-profile {
        border-top: 1px solid var(--border);
    }

    .profile-toggle {
        display: flex;
        align-items: center;
        padding: 16px;
        cursor: pointer;
    }

    .profile-toggle:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .profile-img img {
        height: 32px;
        width: 32px;
    }

    .profile-info {
        margin-left: 12px;
        white-space: nowrap;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .profile-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--primary);
    }

    .profile-email {
        font-size: 0.75rem;
        color: var(--sub-text);
        text-overflow: ellipsis;
        overflow: hidden;
    }

    /* ------------------------------------------------------------ */

    /* Bootstrap dropdown customization */
    .dropdown-menu {
        padding: 0.5rem 0;
        border: 1px solid var(--border);
        border-radius: 0.375rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        width: 100%;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        color: var(--primary);
        transition: background-color 0.15s ease-in-out;
    }

    .dropdown-item:hover {
        background-color: var(--primary) !important;
        color: white !important;
    }

    .dropdown-item:hover .material-symbols-outlined {
        color: white;
    }

    /* Animation for dropdown items */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(0.5rem);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-item {
        animation: fadeInUp 0.2s ease-out forwards;
        animation-delay: calc(var(--index) * 0.05s);
        opacity: 0;
    }

    /* ------------------------------------------------------------ */

    /* Utility classes */
    .hidden {
        width: 0 !important;
        opacity: 0 !important;
        margin: 0 !important;
    }

    /* Mobile styles */
    @media only screen and (max-width: 767px) {
        .logo {
            display: none;
        }
        
        aside.sidebar.open {
            transform: translateX(0);
        }

        .toggle-button {
            display: none;
        }
    }

    /* Tablet styles */
    @media (min-width: 768px) and (max-width: 1024px) {

        .logo {
            display: none;
        }
        
        aside.sidebar.open {
            transform: translateX(0);
        }

        .toggle-button {
            display: none;
        }
    }
</style>
