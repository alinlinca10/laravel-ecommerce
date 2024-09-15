<div class="sidebar-content bg-dark js-simplebar">
    <a class="text-white text-center mt-3" href="/admin/dashboard">
        <h3>eShop</h3>
    </a>

    <ul class="sidebar-nav">
        <li class="sidebar-item mt-4">
            <a class="sidebar-link" href="/" target="_blank">
                <i class="bi bi-house"></i> See website
            </a>
        </li>

        <li class="sidebar-item @if(strpos(url()->current(),route('dashboard.index')) !== false) active @endif">
            <a class="sidebar-link" href="{{ route('dashboard.index') }}">
                <i class="bi bi-bar-chart-line"></i> Dashboard
            </a>
        </li>

        <li class="sidebar-header text-white mt-4">
            Shop
        </li>

        <li class="sidebar-item @if(strpos(url()->current(),route('elfinder.index')) !== false) active @endif">
            <a class="sidebar-link" href="{{ route('elfinder.index') }}">
                <i class="bi bi-folder"></i> Media
            </a>
        </li>
        <div>
            <li class="sidebar-item @if(strpos(url()->current(), route('products.index')) !== false || strpos(url()->current(), route('attributes.index')) !== false) active @endif" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="@if(strpos(url()->current(), route('products.index')) !== false || strpos(url()->current(), route('attributes.index')) !== false) active @else false @endif">
                <a class="sidebar-link" href="/admin/products">
                    <i class="bi bi-lightning"></i> Products
                </a>
            </li>
            <div class="collapse @if(strpos(url()->current(), route('products.index')) !== false || strpos(url()->current(), route('attributes.index')) !== false) show @endif" id="dashboard-collapse">
              <ul>
                <li class="sidebar-item">
                    <a class="sidebar-link @if(strpos(url()->current(),route('products.index')) !== false) text-white @endif" href="/admin/products">
                        Products
                    </a>
                </li>
        
                <li class="sidebar-item">
                    <a class="sidebar-link @if(strpos(url()->current(),route('attributes.index')) !== false) text-white @endif" href="/admin/attributes">
                        Attributes
                    </a>
                </li>
              </ul>
            </div>
        </div>

        <li class="sidebar-item @if(strpos(url()->current(),route('orders.index')) !== false) active @endif">
            <a class="sidebar-link" href="/admin/orders">
                <i class="bi bi-bag-check"></i> Orders
            </a>
        </li>

        <li class="sidebar-item @if(strpos(url()->current(),route('category.index')) !== false) active @endif">
            <a class="sidebar-link" href="/admin/category">
                <i class="bi bi-tag"></i> Categories
            </a>
        </li>

        <li class="sidebar-item @if(strpos(url()->current(),route('users.index')) !== false) active @endif">
            <a class="sidebar-link" href="/admin/users">
                <i class="bi bi-people"></i> Users
            </a>
        </li>

        <li class="sidebar-header text-white mt-4">
            Website
        </li>

        <li class="sidebar-item @if(strpos(url()->current(),route('menu.index')) !== false) active @endif">
            <a class="sidebar-link" href="/admin/menu">
                <i class="bi bi-list"></i> Menu
            </a>
        </li>

        <li class="sidebar-item @if(strpos(url()->current(),route('settings.index')) !== false) active @endif">
            <a class="sidebar-link" href="/admin/settings">
                <i class="bi bi-gear-wide-connected"></i> Settings
            </a>
        </li>

    </ul>

    {{-- <div class="sidebar-cta">
        <div class="sidebar-cta-content">
            <div class="d-grid">
                <a href="/" class="btn btn-primary" target="_blank">Vezi site</a>
            </div>
        </div>
    </div> --}}
</div>