@extends('layouts.hotel')

@section('title', __('My Bookings'))

@section('content')

    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ __('My Bookings') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ __('My Bookings') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: -2rem; position: relative; z-index: 1;">
        @if (session('success'))
            <div class="alert alert-success shadow">
                {{ session('success') }}
            </div>
        @endif
    </div>

    {{--
        !!! DİKKAT: Aşağıdaki statik 'Booking Start' formu artık kullanılmıyor.
        Burası sadece 'session success' mesajı için tutulabilir veya
        'my-bookings.blade.php' ile tamamen değiştirilebilir.
        Ben yine de metinleri çevirdim.
    --}}
    <div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="bg-white shadow" style="padding: 35px;">
                <div class="row g-2">
                    {{-- ... (Statik form içeriği - Çevrildi) ... --}}
                    <div class="col-md-3">
                        <div class="date" id="date1" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input"
                                   placeholder="{{ __('Check in') }}" data-target="#date1" data-toggle="datetimepicker" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="date" id="date2" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" placeholder="{{ __('Check out') }}" data-target="#date2" data-toggle="datetimepicker"/>
                        </div>
                    </div>
                    {{-- ... --}}
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">{{ __('Submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
