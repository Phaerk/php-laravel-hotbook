@extends('layouts.admin')

@section('title', __('My Hotels'))

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('My Hotels') }}</h1>
        <a href="{{ route('admin.hotels.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> {{ __('Add New Hotel') }}
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow">
            {{ session('success') }}
        </div>
    @endif


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Your Registered Hotels') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ __('Hotel Name') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Price (Nightly)') }}</th>
                        <th>{{ __('Google Rating') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($hotels as $hotel)
                        <tr>
                            <td>{{ $hotel->name }}</td>
                            <td>{{ $hotel->address }}</td>
                            <td>${{ $hotel->price_per_night }}</td>
                            <td>{{ $hotel->rating }} ({{ $hotel->user_ratings_total }} {{ __('votes') }})</td>
                            <td>
                                <a href="{{ route('admin.hotels.edit', $hotel->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>

                                {{-- Silme Formu --}}
                                <form action="{{ route('admin.hotels.destroy', $hotel->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('{{ __('Are you sure you want to delete this hotel? This action cannot be undone.') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> {{ __('Delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Hiç otel bulunamazsa --}}
                        <tr>
                            <td colspan="5" class="text-center">{{ __('You have no registered hotels yet.') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link href="{{ asset('admin-theme/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('admin-theme/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-theme/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
