<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', __('Hotel Owner Panel')) - {{ config('app.name') }}</title>

    <link href="{{ asset('admin-theme/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="{{ asset('admin-theme/css/sb-admin-2.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body id="page-top">

<div id="wrapper">

    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-hotel"></i>
            </div>
            <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{ __('Dashboard') }}</span></a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            {{ __('Hotel Management') }}
        </div>

        <li class="nav-item {{ request()->routeIs('admin.hotels.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.hotels.index') }}">
                <i class="fas fa-fw fa-building"></i>
                <span>{{ __('My Hotels') }}</span></a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.bookings.index') }}">
                <i class="fas fa-fw fa-calendar-check"></i>
                <span>{{ __('Reservations') }}</span></a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            <img class="img-profile rounded-circle"
                                 src="{{ asset('admin-theme/img/undraw_profile.svg') }}">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}" target="_blank">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('My Profile (Customer View)') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Log Out') }}
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; {{ config('app.name') }} {{ date('Y') }}</span>
                </div>
            </div>
        </footer>
    </div>
</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">{{ __('Select "Logout" below if you are ready to end your current session.') }}</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('admin-theme/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin-theme/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('admin-theme/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<script src="{{ asset('admin-theme/js/sb-admin-2.min.js') }}"></script>

{{-- Google Places API (Admin Autocomplete için) --}}
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places&callback=initMap" async defer></script>

@stack('scripts')

@stack('footer-modals')
</body>

</html>
