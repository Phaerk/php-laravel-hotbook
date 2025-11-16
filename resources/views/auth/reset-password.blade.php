@extends('layouts.hotel')

@section('title', __('Reset Password'))

@section('content')

    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ __('Reset Password') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ __('Reset Password') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Alt boşluğu manuel olarak artırmak için style ekliyoruz --}}
    <div class="container-xxl pt-5" style="padding-bottom: 10rem;">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 offset-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="section-title text-center text-primary text-uppercase">{{ __('New Password') }}</h6>
                        <h1 class="mb-5">{{ __('Create Your') }} <span class="text-primary text-uppercase">{{ __('New Password') }}</span></h1>
                    </div>

                    {{-- Hata mesajları (örn: "Şifreler uyuşmuyor") --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="row g-3">
                            <div class="col-12">
                                {{-- E-posta Alanı (ZORUNLU, kilitli) --}}
                                <div class="form-floating">
                                    {{--
                                        E-posta alanı URL'den gelir ($request->email)
                                        ve 'readonly' (değiştirilemez) olmalıdır.
                                    --}}
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ old('email', $request->email) }}"
                                           placeholder="{{ __('Your Email') }}" required autofocus readonly
                                           style="background-color: #f8f9fa;"> {{-- Kilitli olduğunu göstermek için gri arkaplan --}}
                                    <label for="email">{{ __('Your Email (Locked)') }}</label>
                                </div>
                            </div>

                            <div class="col-12">
                                {{-- Yeni Şifre Alanı --}}
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('New Password') }}" required autocomplete="new-password">
                                    <label for="password">{{ __('New Password') }}</label>
                                </div>
                            </div>

                            <div class="col-12">
                                {{-- Yeni Şifre Tekrar Alanı --}}
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Confirm New Password') }}" required autocomplete="new-password">
                                    <label for="password_confirmation">{{ __('Confirm New Password') }}</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">{{ __('Reset Password') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
