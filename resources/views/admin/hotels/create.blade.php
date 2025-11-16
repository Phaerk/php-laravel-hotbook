@extends('layouts.admin')

@section('title', __('Add New Hotel'))

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Add New Hotel') }}</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (!isset($selectedHotel))

        {{-- ADIM 1: OTEL ARAMA (AUTOCOMPLETE) FORMU --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('Step 1: Find Your Hotel on Google') }}</h6>
            </div>
            <div class="card-body">
                <p>{{ __('Start typing the name of your hotel as it appears on Google. When you select one from the suggestions, you will be redirected to the details form.') }}</p>

                <div class="form-group row">
                    <label for="searchQuery" class="col-sm-3 col-form-label font-weight-bold">{{ __('Search Hotel Name:') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="searchQuery"
                               placeholder="{{ __('e.g. Hotel Madrid Río...') }}">
                    </div>
                </div>
            </div>
        </div>

    @else

        {{-- ADIM 3: DETAY DOLDURMA FORMU --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('Step 2: Confirm Details and Fill Missing Info') }}</h6>
            </div>

            <form action="{{ route('admin.hotels.store') }}" method="POST">
                @csrf

                {{-- Gizli Inputlar (Aynı) --}}
                <input type="hidden" name="name" value="{{ $selectedHotel['name'] }}">
                <input type="hidden" name="address" value="{{ $selectedHotel['formatted_address'] }}">
                <input type="hidden" name="google_place_id" value="{{ $selectedHotel['place_id'] }}">
                <input type="hidden" name="rating" value="{{ $selectedHotel['rating'] ?? null }}">
                <input type="hidden" name="user_ratings_total" value="{{ $selectedHotel['user_ratings_total'] ?? 0 }}">
                <input type="hidden" name="latitude" value="{{ $selectedHotel['geometry']['location']['lat'] }}">
                <input type="hidden" name="longitude" value="{{ $selectedHotel['geometry']['location']['lng'] }}">
                <input type="hidden" name="business_status" value="{{ $selectedHotel['business_status'] ?? 'OPERATIONAL' }}">
                <input type="hidden" name="open_now" value="{{ $selectedHotel['opening_hours']['open_now'] ?? false }}">
                <input type="hidden" name="google_photos" value="{{ json_encode($selectedHotel['photos'] ?? []) }}">
                <input type="hidden" name="google_reviews" value="{{ json_encode($selectedHotel['reviews'] ?? []) }}">
                <input type="hidden" name="formatted_phone_number" value="{{ $selectedHotel['formatted_phone_number'] ?? null }}">
                <input type="hidden" name="website" value="{{ $selectedHotel['website'] ?? null }}">
                {{-- 'editorial_summary' için gizli input'a GEREK YOK --}}


                <div class="card-body">

                    {{-- BÖLÜM 1 --}}
                    <h5 class="text-primary">{{ __('Information from Google (Read-only)') }}</h5>
                    <p class="mb-4">{{ __('These details are automatically fetched from Google API.') }}</p>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">{{ __('Hotel Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $selectedHotel['name'] }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">{{ __('Hotel Address') }}</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" disabled rows="3">{{ $selectedHotel['formatted_address'] }}</textarea>
                        </div>
                    </div>

                    <hr>

                    {{-- BÖLÜM 2 --}}
                    <h5 class="text-success mt-4">{{ __('Platform Information (Required)') }}</h5>
                    <p class="mb-4">{{ __('Please fill in the missing information to be displayed on our platform.') }}</p>

                    {{-- !!! DÜZELTME BURADA !!! --}}
                    <div class="form-group row">
                        <label for="description" class="col-sm-3 col-form-label font-weight-bold">{{ __('Hotel Description') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            {{--
                                Textarea'nın İÇİNE $summaryText değişkenini basıyoruz.
                                'old()' -> Validasyon hatası olursa, kullanıcının yazdığı son metni korur.
                                '$summaryText' -> İlk yüklemede Google'ın özetini basar.
                            --}}
                            <textarea class="form-control" id="description" name="description" rows="5"
                                      placeholder="{{ __('Enter a detailed description of your hotel for customers...') }}"
                                      required>{{ old('description', $summaryText) }}</textarea>

                            @if(!empty($summaryText))
                                <small class="form-text text-muted">{{ __('Google\'s summary was automatically added. You can edit it.') }}</small>
                            @else
                                <small class="form-text text-muted">{{ __('This description will be shown on the hotel details page.') }}</small>
                            @endif
                        </div>
                    </div>
                    {{-- !!! DÜZELTME BİTTİ !!! --}}

                    <div class="form-group row">
                        <label for="price_per_night" class="col-sm-3 col-form-label font-weight-bold">{{ __('Starting Price per Night ($)') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" id="price_per_night" name="price_per_night"
                                   placeholder="{{ __('e.g. 99') }}" value="{{ old('price_per_night') }}" required>
                        </div>
                    </div>

                    <hr>
                    <div class="form-group row mb-0">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> {{ __('Save and List My Hotel') }}
                            </button>
                            <a href="{{ route('admin.hotels.create') }}" class="btn btn-secondary btn-lg">
                                {{ __('Cancel (Search Again)') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    @endif

@endsection

{{-- JavaScript (Değişiklik yok) --}}@push('scripts')
    <script>
        // Bu 'initMap' fonksiyonu, layouts/admin.blade.php'deki
        // Google script'i yüklendiğinde ('callback=initMap') otomatik olarak çağrılır.
        function initMap() {

            // Sadece 'searchQuery' input'u sayfada varsa bu kodu çalıştır
            var input = document.getElementById('searchQuery');
            if (input) {

                // Autocomplete'i başlat
                var autocomplete = new google.maps.places.Autocomplete(input, {

                    // !!! DÜZELTME BURADA !!!
                    // Arama önerilerini SADECE 'konaklama' (oteller vb.) ile kısıtla
                    types: ['lodging']
                });

                // Kullanıcı bir öneriye tıkladığında...
                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();

                    if (!place.place_id) {
                        alert("{{ __('Please select a valid place from the suggestions.') }}");
                        return;
                    }

                    // Kullanıcıyı, o 'place_id' ile 'Adım 3' formuna yönlendir
                    window.location.href = "{{ route('admin.hotels.create') }}?place_id=" + place.place_id;
                });
            }
        }
    </script>
@endpush
