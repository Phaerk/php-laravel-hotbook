@extends('layouts.hotel')

@section('title', __('My Profile'))

@section('content')

    <div class="container-fluid page-header mb-5 p-0" style="background-image: url({{ asset('img/carousel-1.jpg') }});">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">{{ __('My Profile') }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ __('My Profile') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- Alt boşluğu manuel olarak artırmak için style ekliyoruz --}}
    <div class="container-xxl pt-5" style="padding-bottom: 10rem;">
        <div class="container">
            <div class="row g-5">
                {{-- Sayfayı ortalamak için col-lg-8 ve offset-lg-2 kullanıyoruz --}}
                <div class="col-lg-8 offset-lg-2 wow fadeInUp" data-wow-delay="0.2s">

                    {{-- 1. BÖLÜM: Profil Bilgileri Güncelleme --}}
                    <div class="card shadow border-0 mb-5">
                        <div class="card-header bg-dark text-white p-4">
                            <h4 class="mb-0 text-primary text-uppercase">{{ __('Profile Information') }}</h4>
                            <p class="mb-0 text-light">{{ __('Update your account\'s profile information and email address.') }}</p>
                        </div>
                        <div class="card-body p-4">

                            {{-- Başarı Mesajı --}}
                            @if (session('status') === 'profile-updated')
                                <div class="alert alert-success">
                                    {{ __('Profile information updated successfully.') }}
                                </div>
                            @endif

                            <form method="post" action="{{ route('profile.update') }}">
                                @csrf
                                @method('patch')

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Your Name') }}" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                    <label for="name">{{ __('Your Name') }}</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('Your Email') }}" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                    <label for="email">{{ __('Your Email') }}</label>
                                </div>

                                <button class="btn btn-primary py-3" type="submit">{{ __('Save Changes') }}</button>
                            </form>
                        </div>
                    </div>

                    {{-- 2. BÖLÜM: Şifre Güncelleme --}}
                    <div class="card shadow border-0 mb-5">
                        <div class="card-header bg-dark text-white p-4">
                            <h4 class="mb-0 text-primary text-uppercase">{{ __('Update Password') }}</h4>
                            <p class="mb-0 text-light">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
                        </div>
                        <div class="card-body p-4">

                            {{-- Başarı Mesajı --}}
                            @if (session('status') === 'password-updated')
                                <div class="alert alert-success">
                                    {{ __('Password updated successfully.') }}
                                </div>
                            @endif

                            {{-- Hata Mesajları --}}
                            @if ($errors->updatePassword->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->updatePassword->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="post" action="{{ route('password.update') }}">
                                @csrf
                                @method('put')

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="{{ __('Current Password') }}" required autocomplete="current-password">
                                    <label for="current_password">{{ __('Current Password') }}</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('New Password') }}" required autocomplete="new-password">
                                    <label for="password">{{ __('New Password') }}</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Confirm New Password') }}" required autocomplete="new-password">
                                    <label for="password_confirmation">{{ __('Confirm New Password') }}</label>
                                </div>

                                <button class="btn btn-primary py-3" type="submit">{{ __('Save Changes') }}</button>
                            </form>
                        </div>
                    </div>


                    {{-- 3. BÖLÜM: Hesap Silme (Modal/Popup ile) --}}
                    <div class="card shadow border-0">
                        <div class="card-header bg-danger text-white p-4">
                            <h4 class="mb-0 text-white text-uppercase">{{ __('Delete Account') }}</h4>
                            <p class="mb-0 text-white-50">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title text-danger">{{ __('Are you sure you want to delete your account?') }}</h5>
                            <p>{{ __('Before deleting your account, please download any data or information that you wish to retain. This action cannot be undone.') }}</p>

                            {{--
                                Bootstrap'in Modal (popup) özelliğini kullanıyoruz.
                                data-bs-toggle="modal" ve data-bs-target="#confirmUserDeletionModal"
                                ile butona tıklayınca popup açılır.
                            --}}
                            <button type="button" class="btn btn-danger py-3" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                                {{ __('Delete Account') }}
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">{{ __('Confirm Account Deletion') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('Are you sure you want to delete your account? This action cannot be undone.') }}</p>
                        <p>{{ __('To confirm, please enter your password:') }}</p>

                        {{-- Hata Mesajı (Şifre yanlışsa) --}}
                        @if ($errors->userDeletion->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->userDeletion->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        <div class="form-floating">
                            <input type="password" class="form-control" id="password_delete" name="password" placeholder="{{ __('Password') }}" required autocomplete="current-password">
                            <label for="password_delete">{{ __('Password') }}</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
