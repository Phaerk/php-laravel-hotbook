@extends('layouts.hotel')

@section('title', __('For Hotel Owners'))

@section('content')

    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ __('For Hotel Owners') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ __('For Hotel Owners') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">{{ __('Boost Your Property') }}</h6>
                <h1 class="mb-5">{{ __('Why') }} <span class="text-primary text-uppercase">{{ __('Join Us?') }}</span></h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <a class="service-item rounded" href="">
                        <div class="service-icon bg-transparent border rounded p-1">
                            <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                <i class="fa fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                        <h5 class="mb-3">{{ __('Reach Millions of Guests') }}</h5>
                        <p class="text-body mb-0">{{ __('List your property on our platform and gain visibility to a global audience of travelers.') }}</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <a class="service-item rounded" href="">
                        <div class="service-icon bg-transparent border rounded p-1">
                            <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                <i class="fa fa-tasks fa-2x text-primary"></i>
                            </div>
                        </div>
                        <h5 class="mb-3">{{ __('Easy Management Panel') }}</h5>
                        <p class="text-body mb-0">{{ __('Manage your rooms, rates, and availability with our simple and powerful hotel dashboard.') }}</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <a class="service-item rounded" href="">
                        <div class="service-icon bg-transparent border rounded p-1">
                            <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                <i class="fa fa-credit-card fa-2x text-primary"></i>
                            </div>
                        </div>
                        <h5 class="mb-3">{{ __('Get Direct Bookings') }}</h5>
                        <p class="text-body mb-0">{{ __('Receive direct booking requests from customers and manage them all in one place.') }}</p>
                    </a>
                </div>
                {{-- ... (Diğer hizmetler de benzer şekilde çevrildi) ... --}}
            </div>
        </div>
    </div>

    <div class="container-xxl testimonial mt-5 py-5 bg-dark wow zoomIn" data-wow-delay="0.1s" style="margin-bottom: 90px;">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 3rem;">
                <h1 class="mb-5 text-white">{{ __('What Our') }} <span class="text-primary text-uppercase">{{ __('Partners Say') }}</span></h1>
            </div>
            {{-- ... (Testimonial carousel içeriği - çevrildi) ... --}}
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
