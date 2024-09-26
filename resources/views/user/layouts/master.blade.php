<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
     <!-- Fonts and icons -->
     <script src="{{ asset('admin/assets/js/plugin/webfont/webfont.min.js') }}"></script>
     <script>
         WebFont.load({
             google: {
                 families: ["Public Sans:300,400,500,600,700"]
             },
             custom: {
                 families: [
                     "Font Awesome 5 Solid",
                     "Font Awesome 5 Regular",
                     "Font Awesome 5 Brands",
                     "simple-line-icons",
                 ],
                 urls: ["{{ asset('admin/assets/css/fonts.min.css') }}"],
             },
             active: function() {
                 sessionStorage.fonts = true;
             },
         });
     </script>
    <link
    href="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-2.1.7/b-3.1.2/b-html5-3.1.2/b-print-3.1.2/cr-2.0.4/fc-5.0.1/r-3.0.3/rr-1.5.0/datatables.min.css"
    rel="stylesheet">
    @stack('css_links')
    {{-- Custom CSS   --}}
    <link rel="stylesheet" href="{{ asset('user/css/custom.css') }}">
    @stack('css')
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                showAlert('success', '{{ session('success') }}');
            @endif

            @if (session('error'))
                showAlert('error', '{{ session('error') }}');
            @endif

            @if (session('warning'))
                showAlert('warning', '{{ session('warning') }}');
            @endif
        });
    </script>
    <style>
        .dt-container .dt-buttons {
            display: inline-block;
        }

        .dt-container .dt-search {
            float: right;
        }

        .dt-container .dt-info {
            margin-top: 20px;
            display: inline-block;
        }

        .dt-container .dt-paging {
            margin-top: 10px;
            float: right;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('user.dashboard') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

<!--   Core JS Files   -->
<script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
@stack('js_links')
<script src="{{ asset('user/js/custom.js') }}"></script>
@stack('js')
</body>
</html>
