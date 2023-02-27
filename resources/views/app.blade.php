<!DOCTYPE html>
<html lang="en">

@include('partial.head')
<body class="{{ isset($site_setting) && $site_setting->dark_mode ? 'theme-dark' : 'theme-light' }}">
<div id="app">
    @include('partial.sidebar')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none show-sidebar">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>{{ $title }}</h3>
        </div>
        <div class="page-content">
           @yield('content')
        </div>

        @include('partial.footer')
    </div>
</div>

@include('partial.scripts')

</body>

</html>
