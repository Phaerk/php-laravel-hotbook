@extends('layouts.hotel')

@section('title', __('Forgot Password'))

@section('content')

    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ __('Forgot Password') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ __('Forgot Password') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container-xxl pt-5" style="padding-bottom: 10rem;">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 offset-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="section-title text-center text-primary text-uppercase">{{ __('Reset Password') }}</h6>
                        {{-- Başlığı ikiye böldük: "Forgot Your" ve "Password?" --}}
                        <h1 class="mb-4">{{ __('Forgot Your') }} <span class="text-primary text-uppercase">{{ __('Password?') }}</span></h1>
                        <p class="mb-4">{{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('Your Email') }}" value="{{ old('email') }}" required autofocus>
                                    <label for="email">{{ __('Your Email') }}</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">{{ __('Email Password Reset Link') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
