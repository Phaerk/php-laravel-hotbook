<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Hotelier - Hotel Booking Platform')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{--
        !!! TÜM ÖZEL CSS DÜZELTMELERİ BURADA !!!
        @push('styles') komutunu ve <style> bloklarını
        diğer sayfalardan kaldırdık, hepsini buraya topladık.
    --}}
    <style>
        /* 1. Otel Detay Sayfası - Fotoğraf Galerisi Zıplama Sorunu */
        .hotel-carousel-image {
            height: 500px;
            object-fit: cover;
            width: 100%;
        }

        /* 2. Ana Sayfa / Oteller Sayfası - Kart Fotoğraf Yüksekliği Sorunu */
        .card-hotel-image {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }

        /* 3. YORUM KARTLARI - EŞİT YÜKSEKLİK VE KIRPMA SORUNU */
        .testimonial-carousel .owl-stage {
            display: flex;
        }
        .testimonial-carousel .owl-item {
            display: flex;
            flex: 1 0 auto;
        }
        .testimonial-item {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            width: 100%;
        }
        .review-text-clamp {
            display: -webkit-box;
            -webkit-line-clamp: 5; /* Yorumları 5 satırla sınırla */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-grow: 1; /* Esneyerek kısa yorumların da kartı doldurmasını sağlar */
        }
    </style>
</head>

<body id="page-top"> {{-- Burası 'page-top' değil, normal 'body' olmalı ama temanızdan böyle geldi --}}

<div class="bg-white p-0">
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    @include('partials._header')
    @yield('content')


    @include('partials._footer')
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>
<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
{{-- Moment.js dil desteği için 'with-locales' sürümünü kullanıyoruz --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
<script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<script src="{{ asset('js/main.js') }}"></script>

{{-- Google Maps/Places API (Autocomplete için) --}}
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    function initAutocomplete() {
        var input = document.getElementById('location');
        if (input) {
            var autocomplete = new google.maps.places.Autocomplete(input, {
                // types: ['geocode'], // Kısıtlamayı kaldırmıştık
            });
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
            });
        }
    }
</script>

@stack('scripts')
</body>

</html>
