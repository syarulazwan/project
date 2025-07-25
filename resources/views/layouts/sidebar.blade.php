
@php

    $path = Request::path(); 
    use Illuminate\Support\Str;

    function renderSidebarMenu($items, $path, $level = 1)
    {
        $currentPath = trim($path, '/');

        foreach ($items as $item) {
            $menu = $item['menu'];
            $children = $item['children'] ?? [];
            $hasChildren = count($children) > 0;

            $menuPath = trim($menu->url, '/');
            $isActive = $menuPath !== '' && Str::startsWith($currentPath, $menuPath) ? 'active' : '';

            $liClass = 'slide' . ($hasChildren ? ' has-sub' : '');

            // If this is a label section (i.e. just a label, not clickable, maybe use `route` or `type` to differentiate)
            if ($menu->route === 'label') {
                echo '<li class="slide side-menu__label1">';
                echo '<a href="javascript:void(0)">' . $menu->name . '</a>';
                echo '</li>';
                continue;
            }

            echo '<li class="' . $liClass . '">';

            $url = $hasChildren ? 'javascript:void(0);' : url('/' . ltrim($menu->url, '/'));
            echo '<a href="' . $url . '" class="side-menu__item ' . $isActive . '">';

            if ($level === 1) {
                // Show icon and label only for top-level menu
                echo '<i class="' . ($menu->icon ?? 'ri-folder-line') . ' side-menu__icon"></i>';
                echo '<span class="side-menu__label">' . $menu->name . '</span>';
            } else {
                // For children, label only
                echo $menu->name;
            }

            if ($hasChildren) {
                echo '<i class="ri-arrow-right-s-line side-menu__angle"></i>';
            }

            echo '</a>';

            if ($hasChildren) {
                echo '<ul class="slide-menu child' . $level . '">';

                foreach ($children as $child) {
                    renderSidebarMenu([$child], $path, $level + 1);
                }

                echo '</ul>';
            }

            echo '</li>';
        }
    }

@endphp

<aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header">
        <a href="index.html" class="header-logo">
            <img src="../assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
            <img src="../assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
            <img src="../assets/images/brand-logos/desktop-white.png" alt="logo" class="desktop-white">
            <img src="../assets/images/brand-logos/toggle-white.png" alt="logo" class="toggle-white">
        </a>
    </div>
    <div class="main-sidebar" id="sidebar-scroll">
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
            </div>
            <ul class="main-menu">
                @php
                    $menuTree = buildMenuTree($menuTree);
                    $allowedMenuIds = session('allowed_menu_ids', []);
                    $filteredMenuTree = filterMenuTree($menuTree, $allowedMenuIds);
                    renderSidebarMenu($filteredMenuTree, $path); 
                @endphp

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
        </nav>
    </div>
</aside>