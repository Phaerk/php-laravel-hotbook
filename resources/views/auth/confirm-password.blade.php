@extends('layouts.hotel')

@section('title', __('Confirm Password'))

@section('content')

    {{-- Header --}}
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ __('Confirm Password') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ __('Confirm Password') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- İçerik --}}
    <div class="container-xxl pt-5" style="padding-bottom: 10rem;">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 offset-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="section-title text-center text-primary text-uppercase">{{ __('Secure Area') }}</h6>
                        <h1 class="mb-4">{{ __('Confirm') }} <span class="text-primary text-uppercase">{{ __('Password') }}</span></h1>
                        <p class="mb-4">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
                    </div>

                    {{-- Hata Mesajları --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('Password') }}" required autocomplete="current-password" autofocus>
                                    <label for="password">{{ __('Password') }}</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">{{ __('Confirm') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
