
@extends('layouts.hotel')

@section('title', __('Hotels - Search Results'))

@section('content')

    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ __('Hotels') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ __('Hotels') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    @include('partials._booking_bar', ['old_input' => $old_input ?? []])

    <div class="container-xxl pt-5" style="padding-bottom: 10rem;">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">{{ __('Our Hotels') }}</h6>
                @if ($isApiSearch)
                    <h1 class="mb-5">{{ __('Search Results for') }} <span class="text-primary text-uppercase">"{{ $old_input['location'] }}"</span></h1>
                @else
                    <h1 class="mb-5">{{ __('Explore Our') }} <span class="text-primary text-uppercase">{{ __('Partner Hotels') }}</span></h1>
                @endif
            </div>

            <div class="row g-4 mb-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-lg-8 offset-lg-2">
                    <div class="bg-light p-3 shadow-sm rounded">
                        <form action="{{ url()->current() }}" method="GET">
                            @if (isset($old_input['location']))
                                <input type="hidden" name="location" value="{{ $old_input['location'] }}">
                            @endif
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="sort_by" name="sort_by">
                                            <option value="">{{ __('Default (Recommended)') }}</option>
                                            <option value="rating_desc" {{ ($old_input['sort_by'] ?? '') == 'rating_desc' ? 'selected' : '' }}>{{ __('Rating (Highest First)') }}</option>
                                            <option value="popularity_desc" {{ ($old_input['sort_by'] ?? '') == 'popularity_desc' ? 'selected' : '' }}>{{ __('Popularity (Most Reviews)') }}</option>
                                            @if (!$isApiSearch)
                                                <option value="price_asc" {{ ($old_input['sort_by'] ?? '') == 'price_asc' ? 'selected' : '' }}>{{ __('Price (Lowest First)') }}</option>
                                            @endif
                                        </select>
                                        <label for="sort_by">{{ __('Sort By:') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @if (!$isApiSearch)
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="max_price" name="max_price"
                                                   placeholder="{{ __('Max Price') }}"
                                                   value="{{ $old_input['max_price'] ?? '' }}">
                                            <label for="max_price">{{ __('Max Price ($)') }}</label>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-secondary w-100 h-100" type="submit">{{ __('Filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row g-4">

                {{-- ************ 1. DURUM: API ARAMASI (Google Verisi) ************ --}}
                @if ($isApiSearch)

                    @forelse ($hotels as $hotel)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="room-item shadow rounded overflow-hidden d-flex flex-column h-100">
                                <div class="position-relative">
                                    {{--
                                        !!! GÜVENLİK DÜZELTMESİ !!!
                                        API Anahtarı kaldırıldı, 'hotel.image' rotası kullanıldı.
                                    --}}
                                    @if (isset($hotel['photos']) && !empty($hotel['photos']))
                                        <img class="card-hotel-image"
                                             src="{{ route('hotel.image', ['reference' => $hotel['photos'][0]['photo_reference']]) }}"
                                             alt="{{ $hotel['name'] }}">
                                    @else
                                        <img class="card-hotel-image" src="{{ asset('img/room-1.jpg') }}" alt="Default hotel image">
                                    @endif
                                    <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4">
                                        {{ $hotel['business_status'] ?? 'UNKNOWN' }}
                                    </small>
                                </div>
                                <div class="p-4 mt-2 flex-grow-1">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">{{ $hotel['name'] }}</h5>
                                        <div class="ps-2">
                                            @for ($i = 0; $i < round($hotel['rating'] ?? 0); $i++)
                                                <small class="fa fa-star text-primary"></small>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <small class="border-end me-3 pe-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ Str::limit($hotel['formatted_address'], 30) }}</small>
                                        <small><i class="fa fa-star text-primary me-2"></i>{{ $hotel['rating'] ?? 'N/A' }} ({{ $hotel['user_ratings_total'] ?? 0 }})</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between p-4 pt-0">
                                    <a class="btn btn-sm btn-primary rounded py-2 px-4"
                                       href="{{ route('hotel.detail', $hotel['place_id']) }}">
                                        {{ __('View Detail') }}
                                    </a>
                                    <a class="btn btn-sm btn-dark rounded py-2 px-4"
                                       href="{{ route('hotel.detail', $hotel['place_id']) }}">
                                        {{ __('Check Availability') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div class="alert alert-warning">
                                <h4 class="alert-heading">{{ __('No Hotels Found!') }}</h4>
                                <p>{{ __('No hotels matching your search query were found on Google.') }}</p>
                            </div>
                        </div>
                    @endforelse

                    {{-- ************ 2. DURUM: VERİTABANI ARAMASI (Partner Oteller) ************ --}}
                @else

                    @forelse ($hotels as $hotel)
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
                                    <a class="btn btn-sm btn-primary rounded py-2 px-4"
                                       href="{{ route('hotel.detail', $hotel->google_place_id) }}">
                                        {{ __('View Detail') }}
                                    </a>
                                    <a class="btn btn-sm btn-dark rounded py-2 px-4"
                                       href="{{ route('hotel.detail', $hotel->google_place_id) }}">
                                        {{ __('Book Now') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div class="alert alert-info">
                                <h4 class="alert-heading">{{ __('No Partner Hotels Found!') }}</h4>
                                <p>{{ __('There are currently no partner hotels listed on our platform.') }}</p>
                            </div>
                        </div>
                    @endforelse

                @endif
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
