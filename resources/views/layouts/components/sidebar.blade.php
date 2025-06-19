@php
    // Define menu items
    $menuItems = [
        [
            'icon' => 'dashboard',
            'text' => 'Dashboard',
            'route' => 'dashboard.index',
            'active' => request()->routeIs('dashboard.*'),
        ],
        [
            'icon' => 'article',
            'text' => 'Sales',
            'hasSubmenu' => true,
            'submenu' => [
                ['text' => 'Invoices', 'route' => 'invoices.index'],
                ['text' => 'Credit Notes', 'route' => 'credit_notes.index'],
                ['text' => 'Debit Notes', 'route' => 'debit_notes.index'],
                ['text' => 'Refund Notes', 'route' => 'refund_notes.index'],
                ['text' => 'Receipts', 'route' => 'receipts.index'],
            ],
        ],
        [
            'icon' => 'shopping_cart',
            'text' => 'Purchases',
            'hasSubmenu' => true,
            'submenu' => [
                ['text' => 'Self-Billed Invoices', 'route' => 'self_billed_invoices.index'],
                ['text' => 'Self-Billed Credit Notes'],
                ['text' => 'Self-Billed Debit Notes'],
                ['text' => 'Self-Billed Refund Notes'],
            ],
        ],
        [
            'icon' => 'contacts',
            'text' => 'Contacts',
            'route' => 'contacts.index',
            'active' => request()->routeIs('contacts.*'),
        ],
        [
            'icon' => 'settings',
            'text' => 'Settings',
            'hasSubmenu' => true,
            'submenu' => [
                ['text' => 'Taxes', 'route' => 'taxes.index'],
                ['text' => 'Classifications', 'route' => 'classifications.index'],
                ['text' => 'MSICs', 'route' => 'msics.index'],
            ],
        ],
    ];
@endphp

<aside class="sidebar" id="sidebar">
    <!-- Toggle Button -->
    <div class="toggle-button d-none d-md-flex" id="collapseToggle">
        <span class="material-symbols-outlined text-secondary" id="toggleIcon">chevron_left</span>
    </div>

    <!-- Logo -->
    <div class="logo">
        {{-- <img src="{{ asset('images/logo.png') }}" alt="Future Tech Resources" class="logo-img"> --}}
        <span class="logo-text" id="logoText">E-Invoice</span>
        <span class="logo-icon" id="logoIcon">E</span>
    </div>

    <!-- Menu -->
    <div class="menu">
        <nav class="nav-menu">
            <!-- Menu Items -->
            @foreach ($menuItems as $index => $item)
                @if (isset($item['hasSubmenu']) && $item['hasSubmenu'])
                    <div class="menu-container" id="menu-container-{{ $index }}">
                        <button class="menu-toggle" id="menuToggle-{{ $index }}">
                            <span class="material-symbols-outlined menu-icon">{{ $item['icon'] }}</span>
                            <span class="menu-text">{{ $item['text'] }}</span>
                            <span class="material-symbols-outlined arrow-icon me-3"
                                id="menuArrow-{{ $index }}">expand_more</span>
                        </button>
                        <div class="submenu" id="submenu-{{ $index }}">
                            @foreach ($item['submenu'] as $subIndex => $subItem)
                                <a class="submenu-item" style="--index: {{ $subIndex + 1 }};"
                                    @if (isset($subItem['route'])) href="{{ route($subItem['route']) }}" @endif>
                                    <span>{{ $subItem['text'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a class="menu-item {{ isset($item['active']) && $item['active'] ? 'active' : '' }}"
                        @if (isset($item['route'])) href="{{ route($item['route']) }}" @endif>
                        <span class="material-symbols-outlined menu-icon">{{ $item['icon'] }}</span>
                        <span class="menu-text">{{ $item['text'] }}</span>
                    </a>
                @endif
            @endforeach
        </nav>
    </div>

    <!-- User Profile -->
    <div class="user-profile">
        <div class="position-relative dropup">
            <div class="profile-toggle" id="userProfileToggle" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-img">
                    <img src="https://ui-avatars.com/api/?name=Jane+Doeson&background=2563EB&color=fff" alt="User"
                        class="rounded-circle">
                </div>
                <div class="profile-info" id="userInfo">
                    <div class="profile-name">Jane Doeson</div>
                    <div class="profile-email">janedoeson@gmail.com</div>
                </div>
                <span class="material-symbols-outlined arrow-icon" id="userDropdownArrow">expand_more</span>
            </div>
            <!-- User Dropdown -->
            <div class="dropdown-menu" id="userDropdown">
                <a class="dropdown-item" style="--index: 1;" href="{{ route('company_profile.index') }}">
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-outlined me-2">settings</span>
                        Company Profile
                    </div>
                </a>
                <a class="dropdown-item text-danger" style="--index: 2;">
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-outlined me-2">logout</span>
                        Logout
                    </div>
                </a>
            </div>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const collapseToggle = document.getElementById('collapseToggle');
        const toggleIcon = document.getElementById('toggleIcon');
        const userProfileToggle = document.getElementById('userProfileToggle');
        const userDropdown = document.getElementById('userDropdown');
        const logoText = document.getElementById('logoText');
        const logoIcon = document.getElementById('logoIcon');
        const userInfo = document.getElementById('userInfo');
        const userDropdownArrow = document.getElementById('userDropdownArrow');
        const menuIcons = document.querySelectorAll('.menu-icon');

        // Default state (wide on desktop, hidden on mobile)
        if (window.innerWidth >= 768) {
            sidebar.classList.add('expanded');
        } else {
            sidebar.classList.add('expanded');
        }

        // Toggle sidebar collapse (desktop)
        collapseToggle.addEventListener('click', function() {
            if (sidebar.classList.contains('expanded')) {
                // Collapse
                sidebar.classList.remove('expanded');
                sidebar.classList.add('collapsed');
                toggleIcon.innerHTML = 'chevron_right';

                // Close any open submenus
                document.querySelectorAll('.submenu.open').forEach(submenu => {
                    submenu.classList.remove('open');
                });

                // Reset any rotated arrows
                document.querySelectorAll('.rotate').forEach(arrow => {
                    arrow.classList.remove('rotate');
                });

                // Handle specific elements
                logoText.classList.add('hidden');
                logoIcon.classList.remove('hidden');

                userInfo.classList.add('hidden');
                userDropdownArrow.classList.add('hidden');

                // Hide all arrow icons
                document.querySelectorAll('.arrow-icon').forEach(el => {
                    el.classList.add('hidden');
                });

                // Hide menu text
                document.querySelectorAll('.menu-text').forEach(el => {
                    el.classList.add('hidden');
                });

                menuIcons.forEach(icon => {
                    icon.classList.remove('me-3');
                    icon.classList.add('me-0');
                });

            } else {
                // Expand
                sidebar.classList.remove('collapsed');
                sidebar.classList.add('expanded');
                toggleIcon.innerHTML = 'chevron_left';

                // Handle specific elements
                logoText.classList.remove('hidden');
                logoIcon.classList.add('hidden');

                userInfo.classList.remove('hidden');
                userDropdownArrow.classList.remove('hidden');

                // Show all arrow icons
                document.querySelectorAll('.arrow-icon').forEach(el => {
                    el.classList.remove('hidden');
                });

                // Show menu text
                document.querySelectorAll('.menu-text').forEach(el => {
                    el.classList.remove('hidden');
                });

                menuIcons.forEach(icon => {
                    icon.classList.remove('me-0');
                    icon.classList.add('me-3');
                });
            }
        });

        // Set up menu toggles for all dropdown menus
        @foreach ($menuItems as $index => $item)
            @if (isset($item['hasSubmenu']) && $item['hasSubmenu'])
                const menuToggle{{ $index }} = document.getElementById(
                    'menuToggle-{{ $index }}');
                const submenu{{ $index }} = document.getElementById('submenu-{{ $index }}');
                const menuArrow{{ $index }} = document.getElementById('menuArrow-{{ $index }}');

                if (menuToggle{{ $index }} && submenu{{ $index }} &&
                    menuArrow{{ $index }}) {
                    menuToggle{{ $index }}.addEventListener('click', function(e) {
                        // Don't open submenu if sidebar is collapsed
                        if (sidebar.classList.contains('collapsed')) {
                            // If sidebar is collapsed, first expand it
                            if (collapseToggle) {
                                collapseToggle.click();
                                // After sidebar expands, we need a small delay before opening the submenu
                                setTimeout(() => {
                                    submenu{{ $index }}.classList.add('open');
                                    menuArrow{{ $index }}.classList.add('rotate');
                                }, 300); // Matches transition duration
                            }
                        } else {
                            // Normal toggle behavior when sidebar is expanded
                            submenu{{ $index }}.classList.toggle('open');
                            menuArrow{{ $index }}.classList.toggle('rotate');
                        }
                        e.stopPropagation(); // Prevent event bubbling
                    });
                }
            @endif
        @endforeach

        // The dropdown is now handled by Bootstrap's dropdown component
        // We just need to add the rotation effect to the arrow
        if (userProfileToggle) {
            userProfileToggle.addEventListener('shown.bs.dropdown', function() {
                userDropdownArrow.classList.add('rotate');
            });

            userProfileToggle.addEventListener('hidden.bs.dropdown', function() {
                userDropdownArrow.classList.remove('rotate');
            });
        }
    });
</script>
