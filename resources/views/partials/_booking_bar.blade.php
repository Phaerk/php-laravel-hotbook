{{-- Bu dosya /resources/views/partials/_booking_bar.blade.php --}}
<div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="bg-white shadow" style="padding: 35px;">
            <form action="{{ route('hotels.index') }}" method="GET">
                <div class="row g-2">
                    <div class="col-md-10">
                        <div class="form-floating">
                            {{--
                                Metinler __('...') formatına çevrildi
                            --}}
                            <input type="text" class="form-control" id="location" name="location"
                                   placeholder="{{ __('Search Location or Hotel') }}"
                                   value="{{ $old_input['location'] ?? '' }}">
                            <label for="location">{{ __('Search Location or Hotel') }}</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100 h-100">{{ __('Search') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
