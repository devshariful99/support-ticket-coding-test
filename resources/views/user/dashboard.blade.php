@extends('user.layouts.master', ['page_slug' => 'user-dashboard'])
@section('content')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('My Tickets') }}</h4>
                    @include('user.includes.button', [
                        'routeName' => 'user.ticket.create',
                        'label' => 'Create New Ticket',
                    ])
                </div>
                <div class="card-body">
                    <table class="table table-responsive nowrap table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Ticket Number') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created Date') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{-- Datatable Scripts --}}
    <script src="{{ asset('datatable/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let table_columns = [
                //name and data, orderable, searchable
                ['ticket_number', true, true],
                ['title', true, true],
                ['description', false, false],
                ['status', true, true],
                ['created_at', false, false],
                ['action', false, false],
            ];
            const details = {
                table_columns: table_columns,
                main_class: '.datatable',
                displayLength: 10,
                main_route: "{{ route('user.dashboard') }}",
                // order_route: "{{ route('user.update.sort.order') }}",
                export_columns: [0, 1, 2, 3, 4],
                model: 'Ticket',
                rowOrder: false,
            };
            initializeDataTable(details);
        })
    </script>
@endpush