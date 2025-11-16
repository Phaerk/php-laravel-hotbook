@extends('layouts.hotel')

@section('title', __('Register'))

@section('content')

    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ __('Register') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ __('Register') }}</li>
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
                        <h6 class="section-title text-center text-primary text-uppercase">{{ __('Register') }}</h6>
                        <h1 class="mb-5">{{ __('Create Your') }} <span class="text-primary text-uppercase">{{ __('Account') }}</span></h1>
                    </div>

                    {{-- Hata mesajları için --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                {{-- İsim Alanı --}}
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Your Name') }}" value="{{ old('name') }}" required autofocus autocomplete="name">
                                    <label for="name">{{ __('Your Name') }}</label>
                                </div>
                            </div>

                            <div class="col-12">
                                {{-- E-posta Alanı --}}
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('Your Email') }}" value="{{ old('email') }}" required autocomplete="username">
                                    <label for="email">{{ __('Your Email') }}</label>
                                </div>
                            </div>

                            {{-- --- YENİ EKLENEN TELEFON ALANI --- --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="{{ __('Your Phone (Optional)') }}" value="{{ old('phone') }}" autocomplete="tel">
                                    <label for="phone">{{ __('Your Phone (Optional)') }}</label>
                                </div>
                            </div>
                            {{-- --- BİTİŞ --- --}}

                            <div class="col-12">
                                {{-- Şifre Alanı --}}
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('Password') }}" required autocomplete="new-password">
                                    <label for="password">{{ __('Password') }}</label>
                                </div>
                            </div>

                            <div class="col-12">
                                {{-- Şifre Tekrar Alanı --}}
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
                                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                </div>
                            </div>



                            {{-- --- YENİ EKLENEN BLOK --- --}}
                            <div class="col-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_hotel_owner" id="is_hotel_owner" value="1">
                                    <label class="form-check-label" for="is_hotel_owner">
                                        {{ __('Are you a hotel owner? (Register to add your property)') }}
                                    </label>
                                </div>
                            </div>
                            {{-- --- BİTİŞ --- --}}

                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">{{ __('Register') }}</button>
                            </div>

                            <div class="col-12 text-center mt-3">
                                <p>{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Login Now') }}</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
