<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html" data-bs-theme="{{ isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light' }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

        {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@600&display=swap" rel="stylesheet"> --}}

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css" />
        
        <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
        @yield('css')

        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> --}}

        @livewireStyles
    </head>
    <body class="font-sans antialiased">

        <div class="wrapper">
            <nav id="sidebar" class="sidebar js-sidebar" style="overflow-y: auto; height: 100vh;">
                @include('admin/layouts.navigation')
            </nav>
        
            <div class="main" style="overflow: auto; height: 100vh;">
                <nav class="navbar navbar-expand navbar-bg bg-body-tertiary border-bottom position-sticky top-0 bg-body-tertiary bg-opacity-75" style="
                    z-index: 1050;
                    border-bottom: 1px solid rgb(255,255,255, .5);
                    backdrop-filter: saturate(180%) blur(10px);">
                    <a class="sidebar-toggle js-sidebar-toggle d-block d-lg-none">
                        <i class="bi bi-list hamburger align-self-center"></i>
                    </a>
        
                    <div class="navbar-collapse justify-content-end collapse">
                        <ul class="navbar-nav navbar-align">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                    {{-- <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1"
                                        alt="Avatar" /> --}}
                                    {!! Auth::user()->name !!}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1"
                                            data-feather="user"></i> Profile</a>
                                    <a class="dropdown-item" href="#">
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input" type="checkbox" role="switch" id="dark-mode" {{ isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'checked' : '' }}>
                                            <i class="bi bi-{{ isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'sun' : 'moon-stars-fill' }} change-icon"></i>
                                        </div>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Log out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
        
                <main class="content bg-body-tertiary">
                    @yield('content')
                </main>
        
                <footer class="footer bg-body-tertiary py-2">
                    <div class="container-fluid">
                        <div class="row text-muted">
                            <div class="col-12 text-right">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- MODAL WINDOW -->
        <div class="modal fade" id="modal-window" tabindex="-1" aria-labelledby="modalWindowLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content"></div>
            </div>
        </div>
        <!-- end MODAL WINDOW -->

        <!-- MINI MODAL WINDOW -->
        <div class="modal modal-mini fade" id="mini-modal-window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-small">
                <div class="modal-content"></div>
            </div>
        </div>
        <!-- end MINI MODAL WINDOW -->
        
            
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>

        <script src="{{ asset('admin/ckeditor/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('admin/js/bootstrap-treefy.min.js?v=2') }}"></script>
        <script src="https://unpkg.com/simplebar@latest/dist/simplebar.min.js"></script>
        
        <script src="{{ asset('admin/js/script.js') }}"></script>
        
        @include('flash::message')

        @livewireScripts
        @yield('ckeditor')
        @yield('scripts')

        <script>
            $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
        </script>

    </body>
</html>
