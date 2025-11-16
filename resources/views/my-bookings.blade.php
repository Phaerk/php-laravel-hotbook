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
    <div class="container-xxl pt-5" style="padding-bottom: 10rem;">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title text-center text-primary text-uppercase">{{ __('My Bookings') }}</h6>
                <h1 class="mb-5">{{ __('Your') }} <span class="text-primary text-uppercase">{{ __('Reservation History') }}</span></h1>
            </div>

            @if (session('success'))
                <div class="alert alert-success shadow wow fadeInUp" data-wow-delay="0.1s">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow border-0 wow fadeInUp" data-wow-delay="0.3s">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">{{ __('Hotel') }}</th>
                                <th scope="col">{{ __('Check-in') }}</th>
                                <th scope="col">{{ __('Check-out') }}</th>
                                <th scope="col">{{ __('Total Price') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Hotel\'s Note') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td><strong>{{ $booking->hotel->name }}</strong></td>

                                    {{-- !!! DÜZELTME BURADA: 'translatedFormat' kullanıldı !!! --}}
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->translatedFormat('d M, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_out_date)->translatedFormat('d M, Y') }}</td>

                                    <td>${{ $booking->total_price }}</td>
                                    <td>
                                        @if ($booking->status === 'pending')
                                            <span class="badge bg-warning text-dark">{{ __('Pending') }}</span>
                                        @elseif ($booking->status === 'approved')
                                            <span class="badge bg-success">{{ __('Approved') }}</span>
                                        @elseif ($booking->status === 'rejected')
                                            <span class="badge bg-danger">{{ __('Rejected') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $booking->rejection_reason ?? '---' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4">
                                        {{ __('You have no bookings yet.') }}
                                        <a href="{{ route('hotels.index') }}" class="btn btn-primary btn-sm ms-3">{{ __('Book a Hotel') }}</a>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
