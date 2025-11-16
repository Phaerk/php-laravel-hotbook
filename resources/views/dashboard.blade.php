@extends('layouts.hotel')

@section('title', 'My Dashboard')

@section('content')

    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">My Dashboard</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Alt boşluğu manuel olarak artırmak için style ekliyoruz --}}
    <div class="container-xxl pt-5" style="padding-bottom: 10rem;">
        <div class="container">
            <div class="row g-5">
                {{-- Sayfayı ortalamak için col-lg-8 ve offset-lg-2 kullanıyoruz --}}
                <div class="col-lg-8 offset-lg-2 wow fadeInUp" data-wow-delay="0.2s">

                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="section-title text-center text-primary text-uppercase">Welcome Back</h6>
                        {{-- Giriş yapan kullanıcının adını Auth::user()->name ile alıyoruz --}}
                        <h1 class="mb-4">Welcome, <span class="text-primary text-uppercase">{{ Auth::user()->name }}</span>!</h1>
                    </div>

                    {{--
                        Breeze'in orijinal dashboard'undaki hoşgeldin kutusu.
                        Bunu Bootstrap stilleriyle yeniden yaptık (.p-4, .bg-light vb.)
                    --}}
                    <div class="p-4 bg-light rounded mb-4">
                        <p class="mb-0">
                            You are logged in! From this dashboard, you can view your bookings or manage your account profile.
                        </p>
                    </div>

                    {{-- Hızlı Linkler --}}
                    <div class="row g-3 text-center">
                        <div class="col-md-6">
                            <a href="{{ url('/my-bookings') }}" class="btn btn-primary w-100 py-3">View My Bookings</a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('profile.edit') }}" class="btn btn-secondary w-100 py-3">Manage My Profile</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
