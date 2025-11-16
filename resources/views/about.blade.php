@extends('layouts.hotel')

@section('title', __('About Us'))

@section('content')

    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ __('About Us') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ __('About') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Arama Çubuğu (Tüm sayfalarda tutarlılık için) --}}
    @include('partials._booking_bar', ['old_input' => ($old_input ?? [])])

    {{-- GÜNCELLENMİŞ HAKKIMIZDA BÖLÜMÜ --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h6 class="section-title text-start text-primary text-uppercase">{{ __('About Us') }}</h6>
                    <h1 class="mb-4">{{ __('Welcome to') }} <span class="text-primary text-uppercase">HOTBOOK</span></h1>

                    {{-- YENİ PROFESYONEL AÇIKLAMA --}}
                    <p class="mb-4">{{ __('A full-stack hotel booking platform built with Laravel, Google Places API, and MySQL.') }}</p>
                    <p class="mb-4">{{ __('Our platform allows customers to search a global directory of hotels, view live ratings, and book partner hotels directly.') }} {{ __('Meanwhile, hotel owners have a dedicated admin panel to manage their properties, confirm bookings, and update pricing.') }}</p>

                    {{-- GÜNCELLENMİŞ İSTATİSTİKLER --}}
                    <div class="row g-3 pb-4">
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-hotel fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">123</h2> {{-- TODO: Dinamik --}}
                                    <p class="mb-0">{{ __('Partner Hotels') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-calendar-check fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">456</h2> {{-- TODO: Dinamik --}}
                                    <p class="mb-0">{{ __('Bookings Made') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-star fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">7890</h2> {{-- TODO: Dinamik --}}
                                    <p class="mb-0">{{ __('Google Reviews') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="{{ url('/hotels') }}">{{ __('Explore Hotels') }}</a>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6 text-end">
                            <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.1s" src="{{ asset('img/about-1.jpg') }}" style="margin-top: 25%;">
                        </div>
                        <div class="col-6 text-start">
                            <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s" src="{{ asset('img/about-2.jpg') }}">
                        </div>
                        <div class="col-6 text-end">
                            <img class="img-fluid rounded w-50 wow zoomIn" data-wow-delay="0.5s" src="{{ asset('img/about-3.jpg') }}">
                        </div>
                        <div class="col-6 text-start">
                            <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.7s" src="{{ asset('img/about-4.jpg') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- HAKKIMIZDA BÖLÜMÜ BİTİŞİ --}}

    {{-- !!! "OUR TEAM" BÖLÜMÜ TAMAMEN KALDIRILDI !!! --}}

    {{-- Newsletter --}}
    <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="row justify-content-center">
            <div class="col-lg-10 border rounded p-1">
                <div class="border rounded text-center p-1">
                    <div class="bg-white rounded text-center p-5">
                        <h4 class="mb-4">{{ __('Subscribe Our') }} <span class="text-primary text-uppercase">{{ __('Newsletter') }}</span></h4>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control w-100 py-3 ps-4 pe-5" type="text" placeholder="{{ __('Enter your email') }}">
                            <button type="button" class="btn btn-primary py-2 px-3 position-absolute top-0 end-0 mt-2 me-2">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
