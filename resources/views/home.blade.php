
@extends('layouts.hotel')

@section('title', __('Home - Find Your Perfect Hotel'))

@section('content')

    <div class="container-fluid p-0 mb-5">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('img/carousel-1.jpg') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 700px;">
                            <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">{{ __('Luxury Living') }}</h6>
                            <h1 class="display-3 text-white mb-4 animated slideInDown">{{ __('Find Your Perfect Hotel') }}</h1>
                            <a href="{{ url('/hotels') }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">{{ __('Explore Hotels') }}</a>
                            <a href="#booking-bar" class="btn btn-light py-md-3 px-md-5 animated slideInRight">{{ __('Book Now') }}</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('img/carousel-2.jpg') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 700px;">
                            <h6 class="section-title text-white text-uppercase mb-3 animated slideInDown">{{ __('Luxury Living') }}</h6>
                            <h1 class="display-3 text-white mb-4 animated slideInDown">{{ __('Book Instantly at the Best Rates') }}</h1>
                            <a href="{{ url('/hotels') }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">{{ __('Explore Hotels') }}</a>
                            <a href="#booking-bar" class="btn btn-light py-md-3 px-md-5 animated slideInRight">{{ __('Book Now') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">{{ __('Previous') }}</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">{{ __('Next') }}</span>
            </button>
        </div>
    </div>
    @include('partials._booking_bar', ['old_input' => ($old_input ?? [])])

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h6 class="section-title text-start text-primary text-uppercase">{{ __('About Us') }}</h6>
                    <h1 class="mb-4">{{ __('Welcome to') }} <span class="text-primary text-uppercase">HOTBOOK</span></h1>
                    <p class="mb-4">{{ __('Your ultimate portal for hotel bookings. We connect you with thousands of hotels worldwide, offering verified reviews and instant booking confirmations.') }}</p>
                    <div class="row g-3 pb-4">
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-hotel fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">1234</h2>
                                    <p class="mb-0">{{ __('Hotels') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-users fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">1234</h2>
                                    <p class="mb-0">{{ __('Clients') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                            <div class="border rounded p-1">
                                <div class="border rounded text-center p-4">
                                    <i class="fa fa-star fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">1234</h2>
                                    <p class="mb-0">{{ __('Reviews') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="{{ url('/about') }}">{{ __('Explore More') }}</a>
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
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">{{ __('Featured') }}</h6>
                <h1 class="mb-5">{{ __('Explore Our') }} <span class="text-primary text-uppercase">{{ __('Featured Hotels') }}</span></h1>
            </div>
            <div class="row g-4">

                @forelse ($featuredHotels as $hotel)
                    @php
                        $photosArray = [];
                        if (is_array($hotel->google_photos)) {
                            $photosArray = $hotel->google_photos;
                        } elseif (is_string($hotel->google_photos) && !empty($hotel->google_photos)) {
                            $photosArray = json_decode($hotel->google_photos, true);
                        }
                    @endphp

                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="room-item shadow rounded overflow-hidden d-flex flex-column h-100">
                            <div class="position-relative">
                                {{--
                                    !!! GÜVENLİK DÜZELTMESİ !!!
                                    API Anahtarı kaldırıldı, 'hotel.image' rotası kullanıldı.
                                --}}
                                @if (!empty($photosArray) && isset($photosArray[0]['photo_reference']))
                                    <img class="card-hotel-image"
                                         src="{{ route('hotel.image', ['reference' => $photosArray[0]['photo_reference']]) }}"
                                         alt="{{ $hotel->name }}">
                                @else
                                    <img class="card-hotel-image" src="{{ asset('img/room-1.jpg') }}" alt="Default hotel image">
                                @endif
                                <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
                                    ${{ $hotel->price_per_night }}/{{ __('Night') }}
                                </small>
                            </div>

                            <div class="p-4 mt-2 flex-grow-1">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0">{{ $hotel->name }}</h5>
                                    <div class="ps-2">
                                        @for ($i = 0; $i < round($hotel->rating ?? 0); $i++)
                                            <small class="fa fa-star text-primary"></small>
                                        @endfor
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <small class="border-end me-3 pe-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ Str::limit($hotel->address, 30) }}</small>
                                    <small><i class="fa fa-star text-primary me-2"></i>{{ $hotel->rating ?? 'N/A' }} ({{ $hotel->user_ratings_total ?? 0 }})</small>
                                </div>
                                <p class="text-body mb-3">{{ Str::limit($hotel->description, 100) }}</p>
                            </div>

                            <div class="d-flex justify-content-between p-4 pt-0">
                                {{-- Rota Düzeltmesi: $hotel->id yerine $hotel->google_place_id kullandık --}}
                                <a class="btn btn-sm btn-primary rounded py-2 px-4" href="{{ route('hotel.detail', $hotel->google_place_id) }}">{{ __('View Detail') }}</a>
                                <a class="btn btn-sm btn-dark rounded py-2 px-4" href="{{ route('hotel.detail', $hotel->google_place_id) }}">{{ __('Book Now') }}</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <p class="mb-0">{{ __('No featured hotels available at the moment. Please check back later.') }}</p>
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
    <div class="container-xxl py-5 px-0 wow zoomIn" data-wow-delay="0.1s">
        <div class="row g-0">
            <div class="col-md-6 bg-dark d-flex align-items-center">
                <div class="p-5">
                    <h6 class="section-title text-start text-white text-uppercase mb-3">{{ __('Why Choose Us?') }}</h6>
                    <h1 class="text-white mb-4">{{ __('Your Trusted Partner in Travel') }}</h1>
                    <p class="text-white mb-4">{{ __('We provide a seamless booking experience by aggregating thousands of properties and offering verified reviews through our smart API integration. Find the best hotels at the best prices, every time.') }}</p>
                    <a href="{{ url('/hotels') }}" class="btn btn-primary py-md-3 px-md-5 me-3">{{ __('Explore Hotels') }}</a>
                    <a href="{{ url('/contact') }}" class="btn btn-light py-md-3 px-md-5">{{ __('Contact Us') }}</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="video">
                    <button type="button" class="btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                                allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">{{ __('Our Platform') }}</h6>
                <h1 class="mb-5">{{ __('Explore Our') }} <span class="text-primary text-uppercase">{{ __('Advantages') }}</span></h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <a class="service-item rounded" href="{{ url('/hotels') }}">
                        <div class="service-icon bg-transparent border rounded p-1">
                            <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                <i class="fa fa-hotel fa-2x text-primary"></i>
                            </div>
                        </div>
                        <h5 class="mb-3">{{ __('Thousands of Hotels') }}</h5>
                        <p class="text-body mb-0">{{ __('Access a vast network of hotels worldwide, from luxury resorts to budget-friendly stays.') }}</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <a class="service-item rounded" href="">
                        <div class="service-icon bg-transparent border rounded p-1">
                            <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                <i class="fa fa-check-circle fa-2x text-primary"></i>
                            </div>
                        </div>
                        <h5 class="mb-3">{{ __('Instant Confirmation') }}</h5>
                        <p class="text-body mb-0">{{ __('Book with confidence. Receive instant confirmation for your reservations.') }}</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <a class="service-item rounded" href="">
                        <div class="service-icon bg-transparent border rounded p-1">
                            <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                <i class="fa fa-comments fa-2x text-primary"></i>
                            </div>
                        </div>
                        <h5 class="mb-3">{{ __('Verified Guest Reviews') }}</h5>
                        <p class="text-body mb-0">{{ __('Make informed decisions with real-time, verified reviews powered by our API.') }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
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
