@extends('layouts.admin')

@section('title', __('Edit Hotel') . ': ' . $hotel->name)

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Edit Hotel') }}</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $hotel->name }}</h6>
        </div>

        {{-- Bu form, HotelController@update fonksiyonuna gidecek ve oteli GÜNCELLEYECEK --}}
        <form action="{{ route('admin.hotels.update', $hotel->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- BÖLÜM 1 --}}
                <h5 class="text-primary">{{ __('Information from Google (Read-only)') }}</h5>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label font-weight-bold">{{ __('Hotel Name') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $hotel->name }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label font-weight-bold">{{ __('Hotel Address') }}</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" disabled rows="3">{{ $hotel->address }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label font-weight-bold">{{ __('Google Rating') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $hotel->rating ?? 'N/A' }} ({{ __('Total') }} {{ $hotel->user_ratings_total ?? 0 }} {{ __('votes') }})" disabled>
                    </div>
                </div>
                <hr>

                {{-- BÖLÜM 2 --}}
                <h5 class="text-success mt-4">{{ __('Platform Information (Editable)') }}</h5>

                <div class="form-group row">
                    <label for="description" class="col-sm-3 col-form-label font-weight-bold">{{ __('Hotel Description') }} <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $hotel->description) }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price_per_night" class="col-sm-3 col-form-label font-weight-bold">{{ __('Starting Price per Night ($)') }} <span class="text-danger">*</span></label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="price_per_night" name="price_per_night"
                               placeholder="{{ __('e.g. 99') }}" value="{{ old('price_per_night', $hotel->price_per_night) }}" required>
                    </div>
                </div>

                <hr>
                <div class="form-group row mb-0">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> {{ __('Save Changes') }}
                        </button>
                        <a href="{{ route('admin.hotels.index') }}" class="btn btn-secondary btn-lg">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>

@endsection
