@extends('layouts.hotel')

@section('title', __('Verify Email'))

@section('content')

    {{-- Header --}}
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ __('Verify Email') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ __('Verify Email') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- İçerik --}}
    <div class="container-xxl pt-5" style="padding-bottom: 10rem;">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8 offset-lg-2 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="section-title text-center text-primary text-uppercase">{{ __('Verify Your Email') }}</h6>
                        <h1 class="mb-5">{{ __('Verify') }} <span class="text-primary text-uppercase">{{ __('Your Account') }}</span></h1>
                    </div>

                    {{-- Bilgilendirme Metni --}}
                    <div class="alert alert-light mb-4 border text-center">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </div>

                    {{-- Başarı Mesajı --}}
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success mb-4 text-center" role="alert">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        {{-- Tekrar Gönder Butonu --}}
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary py-3 px-4">
                                {{ __('Resend Verification Email') }}
                            </button>
                        </form>

                        {{-- Çıkış Yap Butonu --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary py-3 px-4">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
