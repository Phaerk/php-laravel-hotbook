{{-- /resources/views/partials/_header.blade.php --}}
<style>
    /* --- Genel Boşluk --- */
    body {
        padding-top: 90px; /* Header altında içerik kaybolmasın diye */
    }

    /* --- MODERN NAVBAR --- */
    .navbar-modern {
        backdrop-filter: blur(12px);
        background: rgba(18, 18, 18, 0.8);
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .navbar-modern.shrink {
        padding-top: 4px !important;
        padding-bottom: 4px !important;
        background: rgba(10, 10, 10, 0.92);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
    }

    /* --- Nav Linkler --- */
    .navbar-modern .nav-link {
        font-weight: 500;
        letter-spacing: 0.4px;
        transition: color 0.3s ease, transform 0.2s ease;
    }

    .navbar-modern .nav-link:hover {
        color: #C0392B !important; /* Ana Kırmızı Rengimiz */
        transform: translateY(-1px);
    }

    .navbar-modern .nav-link.active {
        color: #C0392B !important;
    }

    /* --- Dropdown (Profil Kutusu) --- */
    .custom-dropdown {
        background: rgba(30, 30, 30, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        min-width: 190px;
    }

    .custom-dropdown .dropdown-item {
        color: grey;
        transition: all 0.2s ease;
    }

    /* ! (ÖNERİ): Buradaki 'darkblue' rengini de ana renginizle (#C0392B)
       ! veya beyaz (#FFFFFF) ile değiştirmeniz daha iyi görünebilir.
    */
    .custom-dropdown .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #C0392B; /* 'darkblue' -> Kırmızı olarak güncelledim */
        transform: translateX(3px);
    }

    .navbar-brand h1 {
        font-weight: 700;
        letter-spacing: 1px;
        font-size: 26px;
    }

    .navbar-toggler {
        border: none;
        outline: none;
    }
    .navbar-toggler:focus {
        box-shadow: none;
    }

    /* Menü ortalama */
    .navbar-collapse {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .navbar-nav.center-menu {
        flex: 1;
        justify-content: center;
        gap: 1rem;
    }

    @media (max-width: 991.98px) {
        body {
            padding-top: 75px; /* Mobil için 75px (daha az) boşluk */
        }
        .navbar-modern {
            background: rgba(18, 18, 18, 0.95);
        }
        .navbar-nav.center-menu {
            flex-direction: column;
            align-items: flex-start;
            gap: 0;
        }
        .navbar-nav .nav-link {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    }
</style>

<div class="container-fluid px-0 fixed-top">
    <div class="row gx-0 align-items-center">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-dark navbar-modern px-3 py-3">
                {{-- LOGO --}}
                <a href="{{ url('/') }}" class="navbar-brand">
                    <h1 class="m-0 text-primary text-uppercase">HOTBOOK</h1>
                </a>

                {{-- TOGGLE (MOBİL) --}}
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- ANA KISIM --}}
                <div class="collapse navbar-collapse" id="navbarCollapse">

                    {{-- ORTADAKİ LİNKLER --}}
                    <div class="navbar-nav center-menu py-2">
                        <a href="{{ url('/') }}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('Home') }}</a>
                        <a href="{{ url('/about') }}" class="nav-item nav-link {{ request()->is('about') ? 'active' : '' }}">{{ __('About') }}</a>
                        <a href="{{ url('/for-hotel-owners') }}" class="nav-item nav-link {{ request()->is('for-hotel-owners') ? 'active' : '' }}">{{ __('For Hotel Owners') }}</a>
                        <a href="{{ url('/hotels') }}" class="nav-item nav-link {{ request()->is('hotels') ? 'active' : '' }}">{{ __('Hotels') }}</a>
                        <a href="{{ url('/contact') }}" class="nav-item nav-link {{ request()->is('contact') ? 'active' : '' }}">{{ __('Contact') }}</a>
                    </div>
                    {{-- DİL DEĞİŞTİRİCİ --}}
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-globe me-1"></i> {{ strtoupper(app()->getLocale()) }}
                        </a>
                        {{-- _header.blade.php içindeki Dil Dropdown'ı --}}
                        <div class="dropdown-menu dropdown-menu-end rounded-0 m-0 custom-dropdown">
                            <a href="{{ route('switch.language', 'en') }}" class="dropdown-item">English</a>
                            <a href="{{ route('switch.language', 'tr') }}" class="dropdown-item">Türkçe</a>

                            {{-- YENİ EKLENEN --}}
                            <a href="{{ route('switch.language', 'es') }}" class="dropdown-item">Español</a>
                        </div>
                    </div>
                    {{-- SAĞ TARAF (KULLANICI) --}}
                    <div class="navbar-nav ms-auto py-2">
                        @guest
                            <a href="{{ route('login') }}" class="nav-item nav-link {{ request()->is('login') ? 'active' : '' }}">{{ __('Login') }}</a>
                            <a href="{{ route('register') }}" class="nav-item nav-link {{ request()->is('register') ? 'active' : '' }}">{{ __('Register') }}</a>
                        @else
                            @php
                                $isAccountActive = request()->is('my-bookings') || request()->routeIs('profile.edit');
                            @endphp
                            <div class="nav-item dropdown">
                                {{--
                                    !!! DEĞİŞİKLİK BURADA !!!
                                    Profil linkini, admin panelindekine benzer
                                    bir ikon + metin formatına çevirdim.
                                --}}
                                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center {{ $isAccountActive ? 'active' : '' }}" data-bs-toggle="dropdown">
                                    {{-- Font Awesome ikonu (daha küçük) --}}
                                    <i class="fas fa-user-circle me-2"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>
                                {{-- !!! DEĞİŞİKLİK BİTTİ !!! --}}

                                <div class="dropdown-menu custom-dropdown rounded-3 shadow-lg border-0 p-2 m-0">
                                    @if (Auth::user()->role === 'hotel_owner')
                                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item rounded-2 py-2">{{ __('Admin Panel') }}</a>
                                    @else
                                        <a href="{{ route('dashboard') }}" class="dropdown-item rounded-2 py-2">{{ __('Dashboard') }}</a>
                                    @endif
                                    <a href="{{ url('/my-bookings') }}" class="dropdown-item rounded-2 py-2 {{ request()->is('my-bookings') ? 'active' : '' }}">{{ __('My Bookings') }}</a>
                                    <a href="{{ route('profile.edit') }}" class="dropdown-item rounded-2 py-2 {{ request()->routeIs('profile.edit') ? 'active' : '' }}">{{ __('My Profile') }}</a>

                                    <hr class="dropdown-divider">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="{{ route('logout') }}" class="dropdown-item rounded-2 py-2 text-danger"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </a>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

{{-- STICKY SHRINK SCRIPT --}}
<script>
    window.addEventListener("scroll", function() {
        const navbar = document.querySelector(".navbar-modern");
        if (window.scrollY > 40) {
            navbar.classList.add("shrink");
        } else {
            navbar.classList.remove("shrink");
        }
    });
</script>
