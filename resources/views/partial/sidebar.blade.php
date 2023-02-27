<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    @if(isset($site_setting->logo))
                        <a href="index.html"><img
                                src="{{ asset('/' . $site_setting->logo) }}" alt="Logo"></a>
                    @else
                        <a href="index.html"><img src="assets/images/logo/logo.svg" alt="Logo" srcset=""></a>
                    @endif
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>{{ __('lang.dashboard') }}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('categories') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}" class='sidebar-link'>
                        <i class="bi bi-list"></i>
                        <span>{{ __('lang.categories') }}</span>
                    </a>
                </li>
                @if(isset($site_setting->allow_brands) && $site_setting->allow_brands)
                    <li class="sidebar-item {{ request()->is('brands') ? 'active' : '' }}">
                        <a href="{{ route('brands.index') }}" class='sidebar-link'>
                            <i class="bi bi-list"></i>
                            <span>{{ __('lang.brands') }}</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-item {{ request()->is('units') ? 'active' : '' }}">
                    <a href="{{ route('units.index') }}" class='sidebar-link'>
                        <i class="bi bi-list"></i>
                        <span>{{ __('lang.units') }}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('attributes') ? 'active' : '' }}">
                    <a href="{{ route('attributes.index') }}" class='sidebar-link'>
                        <i class="bi bi-list"></i>
                        <span>{{ __('lang.product_attributes') }}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('products') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}" class='sidebar-link'>
                        <i class="bi bi-boxes"></i>
                        <span>{{ __('lang.products') }}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('promo-codes') ? 'active' : '' }}">
                    <a href="{{ route('promo-codes.index') }}" class='sidebar-link'>
                        <i class="bi bi-currency-dollar"></i>
                        <span>{{ __('lang.promo_codes') }}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('faqs') ? 'active' : '' }}">
                    <a href="{{ route('faqs.index') }}" class='sidebar-link'>
                        <i class="bi bi-list"></i>
                        <span>{{ __('lang.faqs') }}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('orders') ? 'active' : '' }}">
                    <a href="{{ route('orders.index') }}" class='sidebar-link'>
                        <i class="bi bi-graph-up-arrow"></i>
                        <span>{{ __('lang.orders') }}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->is('setting') ? 'active' : '' }}">
                    <a href="{{ route('setting.index') }}" class='sidebar-link'>
                        <i class="bi bi-gear-fill"></i>
                        <span>{{ __('lang.settings') }}</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('logout') }}" class='sidebar-link'>
                        <i class="bi bi-box-arrow-right"></i>
                        <span>{{ __('lang.logout') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
