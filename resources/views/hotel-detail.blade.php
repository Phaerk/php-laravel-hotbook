
@extends('layouts.hotel')

@section('title', $hotel->name)

{{-- @push('styles') bloğu kaldırıldı, stiller ana layout'a (layouts/hotel.blade.php) taşındı --}}

@php
    $photosArray = [];
    if (is_array($hotel->google_photos)) { $photosArray = $hotel->google_photos; }
    elseif (is_string($hotel->google_photos) && !empty($hotel->google_photos)) { $photosArray = json_decode($hotel->google_photos, true); }
    $reviewsArray = [];
    if (is_array($hotel->google_reviews)) { $reviewsArray = $hotel->google_reviews; }
    elseif (is_string($hotel->google_reviews) && !empty($hotel->google_reviews)) { $reviewsArray = json_decode($hotel->google_reviews, true); }
@endphp


@section('content')

    {{-- Sayfa başlığı (GÜVENLİ LİNK) --}}
    <div class="container-fluid page-header mb-5 p-0"
         style="background-image: url({{
             !empty($photosArray)
             ? route('hotel.image', ['reference' => $photosArray[0]['photo_reference']])
             : asset('img/carousel-2.jpg')
         }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ $hotel->name }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/hotels') }}">{{ __('Hotels') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ $hotel->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    @include('partials._booking_bar', ['old_input' => []])

    {{-- Ana içerik --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">

                {{-- BÖLÜM 1: OTEL BİLGİLERİ --}}
                <div class="col-lg-8">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <h6 class="section-title text-start text-primary text-uppercase">{{ __('About This Hotel') }}</h6>
                        <h1 class="mb-4">{{ __('Welcome to') }} <span class="text-primary text-uppercase">{{ $hotel->name }}</span></h1>

                        {{-- FOTOĞRAF GALERİSİ (GÜVENLİ LİNKLER) --}}
                        <div id="hotelPhotoCarousel" class="carousel slide mb-4 wow zoomIn" data-wow-delay="0.1s" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @if(!empty($photosArray))
                                    @foreach ($photosArray as $photo)
                                        <button type="button" data-bs-target="#hotelPhotoCarousel"
                                                data-bs-slide-to="{{ $loop->index }}"
                                                class="{{ $loop->first ? 'active' : '' }}"
                                                aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                                aria-label="{{ __('Slide') }} {{ $loop->iteration }}">
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                            <div class="carousel-inner rounded">
                                @forelse ($photosArray as $photo)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ route('hotel.image', ['reference' => $photo['photo_reference']]) }}"
                                             class="hotel-carousel-image"
                                             alt="{{ $hotel->name }} - {{ __('Photo') }} {{ $loop->iteration }}">
                                    </div>
                                @empty
                                    <div class="carousel-item active">
                                        <img src="{{ asset('img/about-1.jpg') }}"
                                             class="hotel-carousel-image"
                                             alt="{{ __('Default hotel image') }}">
                                    </div>
                                @endforelse
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#hotelPhotoCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">{{ __('Previous') }}</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#hotelPhotoCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">{{ __('Next') }}</span>
                            </button>
                        </div>
                        {{-- FOTOĞRAF GALERİSİ BİTİŞ --}}

                        {{-- Google Özeti --}}
                        @if ($hotel->editorial_summary && isset($hotel->editorial_summary['overview']))
                            <div class="alert alert-info bg-light border-info" style="font-style: italic;">
                                <p class="mb-0">"{{ $hotel->editorial_summary['overview'] }}"</p>
                                <footer class="blockquote-footer mb-0">{{ __('Google\'s Overview') }}</footer>
                            </div>
                        @endif

                        <h5 class="mt-4 mb-3">{{ __('About this Property') }}</h5>
                        <p class="mb-4">{{ $hotel->description }}</p>

                        {{-- İstatistik Kartları --}}
                        <div class="row g-3 pb-4">
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-star fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1">{{ $hotel->rating ?? 'N/A' }}</h2>
                                        <p class="mb-0">{{ __('Google Rating') }} ({{ $hotel->user_ratings_total ?? 0 }} {{ __('votes') }})</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-map-marker-alt fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" style="font-size: 1.4rem;">{{ Str::limit(explode(',', $hotel->address)[0], 20) }}</h2>
                                        <p class="mb-0">{{ __('Location') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                                <div class="border rounded p-1">
                                    <div class="border rounded text-center p-4">
                                        <i class="fa fa-building fa-2x text-primary mb-2"></i>
                                        <h2 class="mb-1" style="font-size: 1.4rem;">{{ $hotel->business_status }}</h2>
                                        <p class="mb-0">{{ __('Status') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Telefon ve Websitesi Linkleri --}}
                        <div class="row g-2 mb-4 wow fadeIn" data-wow-delay="0.5s">
                            @if ($hotel->formatted_phone_number)
                                <div class="col-6">
                                    <a class="btn btn-dark w-100 py-3" href="tel:{{ $hotel->formatted_phone_number }}">
                                        <i class="fa fa-phone-alt me-2"></i> {{ __('Call Hotel') }}
                                    </a>
                                </div>
                            @endif
                            @if ($hotel->website)
                                <div class="col-6">
                                    <a class="btn btn-outline-dark w-100 py-3" href="{{ $hotel->website }}" target="_blank">
                                        <i class="fa fa-globe me-2"></i> {{ __('Visit Website') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- BÖLÜM 2: REZERVASYON FORMU (Sağ Sütun) --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-lg wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body p-4">
                            <h4 class="text-primary text-uppercase mb-4">{{ __('Book This Hotel') }}</h4>

                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0">{{ __('Starts From') }}</h5>
                                <div class="ps-2">
                                    <h4 class="mb-0 text-dark">${{ $hotel->price_per_night }}<span class="fs-6 text-muted">/{{ __('Night') }}</span></h4>
                                </div>
                            </div>
                            <hr>

                            @auth
                                {{-- Hata Mesajları --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <h6 class="alert-heading">{{ __('Booking Failed!') }}</h6>
                                        <ul class="mb-0 small">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('booking.store', $hotel->id) }}" method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="form-floating date" id="date-checkin" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" id="check_in_date" name="check_in_date" placeholder="{{ __('Check In') }}" data-target="#date-checkin" data-toggle="datetimepicker" required />
                                                <label for="check_in_date">{{ __('Check In') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating date" id="date-checkout" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" id="check_out_date" name="check_out_date" placeholder="{{ __('Check Out') }}" data-target="#date-checkout" data-toggle="datetimepicker" required />
                                                <label for="check_out_date">{{ __('Check Out') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <select class="form-select" id="adults" name="adults">
                                                    <option value="1">1 {{ __('Adult') }}</option>
                                                    <option value="2" selected>2 {{ __('Adults') }}</option>
                                                    <option value="3">3 {{ __('Adults') }}</option>
                                                    <option value="4">4 {{ __('Adults') }}</option>
                                                </select>
                                                <label for="adults">{{ __('Select Adult') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <select class="form-select" id="children" name="children">
                                                    <option value="0" selected>0 {{ __('Children') }}</option>
                                                    <option value="1">1 {{ __('Child') }}</option>
                                                    <option value="2">2 {{ __('Children') }}</option>
                                                    <option value="3">3 {{ __('Children') }}</option>
                                                </select>
                                                <label for="children">{{ __('Select Child') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                            <textarea class="form-control" placeholder="{{ __('Special Request') }}"
                                                      id="special_request" name="special_request"
                                                      style="height: 100px"></textarea>
                                                <label for="special_request">{{ __('Special Request (Optional)') }}</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100 py-3" type="submit">{{ __('Book Now') }}</button>
                                        </div>
                                    </div>
                                </form>
                            @endauth

                            @guest
                                <div class="alert alert-warning text-center">
                                    <h5 class="alert-heading">{{ __('Login Required') }}</h5>
                                    <p>{{ __('You must be logged in to make a reservation.') }}</p>
                                    <hr>
                                    <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Login Now') }}</a>
                                </div>
                            @endguest

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Yorumlar bölümü (GÜVENLİ VE DÜZELTİLMİŞ) --}}
    <div class="container-xxl testimonial my-5 py-5 bg-dark wow zoomIn" data-wow-delay="0.1s" style="margin-bottom: 150px !important;">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 3rem;">
                <h6 class="section-title text-center text-white text-uppercase">{{ __('Reviews') }}</h6>
                <h1 class="mb-5 text-white">{{ __('What Our') }} <span class="text-primary text-uppercase">{{ __('Guests Say') }}</span></h1>
            </div>

            <div class="owl-carousel testimonial-carousel py-5">
                @forelse ($reviewsArray as $review)
                    <div class="testimonial-item position-relative bg-white rounded overflow-hidden">

                        <p class="review-text-clamp">{{ $review['text'] ?? __('No comment text available.') }}</p>

                        <div class="d-flex align-items-center mt-3">
                            <img class="img-fluid flex-shrink-0 rounded" src="{{ $review['profile_photo_url'] ?? asset('img/testimonial-1.jpg') }}" style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">{{ $review['author_name'] ?? __('Anonymous') }}</h6>
                                <small>
                                    @for ($i = 0; $i < round($review['rating'] ?? 0); $i++)
                                        <i class="fa fa-star text-primary"></i>
                                    @endfor
                                    ({{ $review['relative_time_description'] ?? __('sometime ago') }})
                                </small>
                            </div>
                        </div>
                        <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                    </div>
                @empty
                    <div class="testimonial-item position-relative bg-white rounded overflow-hidden">
                        <p>{{ __('This hotel currently has no reviews listed on our platform.') }}</p>
                        <div class="d-flex align-items-center mt-3">
                            <img class="img-fluid flex-shrink-0 rounded" src="{{ asset('img/testimonial-1.jpg') }}" style="width: 45px; height: 45px;">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">{{ __('System') }}</h6>
                                <small>{{ __('No reviews found') }}</small>
                            </div>
                        </div>
                        <i class="fa fa-quote-right fa-3x text-primary position-absolute end-0 bottom-0 me-4 mb-n1"></i>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function ($) {
            "use strict";
            var currentLocale = '{{ app()->getLocale() }}'; // Dili al

            $('#date-checkin').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: currentLocale, // Dili ayarla
                minDate: new Date()
            });
            $('#date-checkout').datetimepicker({
                format: 'YYYY-MM-DD',
                locale: currentLocale, // Dili ayarla
                useCurrent: false,
                minDate: new Date()
            });
            $("#date-checkin").on("change.datetimepicker", function (e) {
                $('#date-checkout').datetimepicker('minDate', e.date);
            });
            $("#date-checkout").on("change.datetimedatetimepicker", function (e) {
                $('#date-checkin').datetimepicker('maxDate', e.date);
            });
        })(jQuery);
    </script>
@endpush
