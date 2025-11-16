@extends('layouts.admin')

@section('title', __('Reservation Management'))

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Reservation Management') }}</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger shadow">
            @foreach ($errors->all() as $error)
                <p class="mb-0">{{ $error }}</p>
            @endforeach
        </div>
    @endif


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('All Reservations') }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Customer Info') }}</th>
                        <th>{{ __('Hotel') }}</th>
                        <th>{{ __('Reservation Details') }}</th>
                        <th>{{ __('Customer Note') }}</th>
                        <th style="min-width: 210px;">{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td>
                                {{-- Durum --}}
                                @if ($booking->status === 'pending')
                                    <span class="badge badge-warning">{{ __('Pending') }}</span>
                                @elseif ($booking->status === 'approved')
                                    <span class="badge badge-success">{{ __('Approved') }}</span>
                                @elseif ($booking->status === 'rejected')
                                    <span class="badge badge-danger">{{ __('Rejected') }}</span>
                                @endif
                            </td>
                            <td>
                                {{-- Müşteri Bilgileri --}}
                                <strong>{{ $booking->customer->name }}</strong><br>
                                <small>
                                    {{ $booking->customer->email }}<br>
                                    {{ $booking->customer->phone ?? __('No Phone') }}
                                </small>
                            </td>
                            <td>{{ $booking->hotel->name }}</td>

                            <td>
                                <strong>{{ __('Dates:') }}</strong> {{ $booking->check_in_date }} -> {{ $booking->check_out_date }}<br>
                                <small>
                                    <strong>{{ __('Guests:') }}</strong> {{ $booking->adults }} {{ __('Adults') }}, {{ $booking->children }} {{ __('Children') }}
                                </small>
                            </td>

                            <td>
                                {{-- Müşteri Notu --}}
                                {{ $booking->special_request ?? '---' }}
                            </td>
                            <td>
                                {{-- İşlemler (Onay/Reddet) --}}
                                @if ($booking->status === 'pending')
                                    <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> {{ __('Approve') }}
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-danger btn-sm reject-button"
                                            data-toggle="modal"
                                            data-target="#rejectBookingModal"
                                            data-booking-id="{{ $booking->id }}">
                                        <i class="fas fa-times"></i> {{ __('Reject') }}
                                    </button>
                                @else
                                    <span class="text-muted">{{ __('Action taken') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ __('No reservations found.') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

{{-- Modal ve Script'ler --}}
@push('footer-modals')
    <div class="modal fade" id="rejectBookingModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">{{ __('Reject Reservation') }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('Please enter a reason for rejecting this reservation to notify the customer.') }}</p>
                        <div class="form-group">
                            <label for="rejection_reason">{{ __('Rejection Reason:') }}</label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button class="btn btn-danger" type="submit">{{ __('Reject Reservation') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('styles')
    <link href="{{ asset('admin-theme/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('admin-theme/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-theme/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            $('#rejectBookingModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var bookingId = button.data('booking-id');
                var form = $(this).find('form#rejectForm');

                var actionUrlTemplate = '{{ route("admin.bookings.reject", ["booking" => ":id"]) }}';
                var actionUrl = actionUrlTemplate.replace(':id', bookingId);

                form.attr('action', actionUrl);
            });
        });
    </script>
@endpush
