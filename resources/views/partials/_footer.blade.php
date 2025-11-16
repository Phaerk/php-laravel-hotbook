{{-- Bu dosya /resources/views/partials/_footer.blade.php --}}
<div class="container-fluid bg-dark text-light footer wow fadeIn" data-wow-delay="0.1s">
    <div class="container pb-5">
        <div class="row g-5">
            {{-- 1. KOLON: MARKA VE AÇIKLAMA --}}
            <div class="col-md-6 col-lg-4">
                <div class="bg-primary rounded p-4">
                    <a href="{{ url('/') }}"><h1 class="text-white text-uppercase mb-3">Hotbook</h1></a>
                    <p class="text-white mb-0">
                        {{ __('Your ultimate destination for finding the perfect stay. We connect travelers with the best hotels worldwide, offering verified reviews and seamless booking experiences.') }}
                    </p>
                </div>
            </div>

            {{-- 2. KOLON: İLETİŞİM BİLGİLERİ --}}
            <div class="col-md-6 col-lg-3">
                <h6 class="section-title text-start text-primary text-uppercase mb-4">{{ __('Contact') }}</h6>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Alcorcon, Madrid</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+34 675 264 929</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>atakan.ibis@gmail.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    {{-- LinkedIn Linki --}}
                    <a class="btn btn-outline-light btn-social" href="https://www.linkedin.com/in/taner-atakan" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            {{-- 3. ve 4. KOLONLAR: LİNKLER --}}
            <div class="col-lg-5 col-md-12">
                <div class="row gy-5 g-4">
                    <div class="col-md-6">
                        <h6 class="section-title text-start text-primary text-uppercase mb-4">{{ __('Company') }}</h6>
                        <a class="btn btn-link" href="{{ url('/about') }}">{{ __('About Us') }}</a>
                        <a class="btn btn-link" href="{{ url('/contact') }}">{{ __('Contact Us') }}</a>
                        <a class="btn btn-link" href="">{{ __('Privacy Policy') }}</a>
                        <a class="btn btn-link" href="">{{ __('Terms & Condition') }}</a>
                        <a class="btn btn-link" href="">{{ __('Support') }}</a>
                    </div>
                    <div class="col-md-6">
                        {{-- 'Services' yerine daha işlevsel linkler --}}
                        <h6 class="section-title text-start text-primary text-uppercase mb-4">{{ __('Explore') }}</h6>
                        <a class="btn btn-link" href="{{ url('/hotels') }}">{{ __('Find Hotels') }}</a>
                        <a class="btn btn-link" href="{{ url('/for-hotel-owners') }}">{{ __('For Hotel Owners') }}</a>

                        @guest
                            <a class="btn btn-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            <a class="btn btn-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endguest

                        @auth
                            <a class="btn btn-link" href="{{ url('/my-bookings') }}">{{ __('My Bookings') }}</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- COPYRIGHT KISMI --}}
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">HOTBOOK</a>, {{ __('All Right Reserved.') }}

                    {{-- Tema lisansı gereği bu linkler kalmalı --}}
                    {{ __('Designed By') }} <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="{{ url('/') }}">{{ __('Home') }}</a>
                        <a href="">{{ __('Cookies') }}</a>
                        <a href="">{{ __('Help') }}</a>
                        <a href="">{{ __('FAQs') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
