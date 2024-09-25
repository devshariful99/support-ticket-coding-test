@extends('admin.layouts.master', ['page_slug' => 'user'])
@section('title', 'User List')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('User List') }}</h4>
                    @include('admin.includes.button', [
                        'routeName' => 'user.create',
                        'label' => 'Add New',
                    ])
                </div>
                <div class="card-body">
                    <table class="table table-responsive nowrap table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created Date') }}</th>
                                <th>{{ __('Created By') }}</th>
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
    {{-- User Details Modal  --}}
    @include('admin.includes.details_modal', ['modal_title' => 'User Details'])
@endsection
@push('js')
    {{-- Datatable Scripts --}}
    <script src="{{ asset('datatable/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            let table_columns = [
                //name and data, orderable, searchable
                ['name', true, true],
                ['email', true, true],
                ['status', true, true],
                ['created_at', false, false],
                ['created_by', true, true],
                ['action', false, false],
            ];
            const details = {
                table_columns: table_columns,
                main_class: '.datatable',
                displayLength: 10,
                main_route: "{{ route('user.index') }}",
                order_route: "{{ route('update.sort.order') }}",
                export_columns: [0, 1, 2, 3, 4, 5],
                model: 'User',
            };
            initializeDataTable(details);
        })
    </script>
@endpush
@push('js')
    {{-- Show details scripts --}}
    <script src="{{ asset('modal/details_modal.js') }}"></script>
    <script>
        // Event listener for viewing details
        $(document).on("click", ".view", function() {
            let id = $(this).data("id");
            let route = "{{ route('user.show', ['id']) }}";
            const detailsUrl = route.replace("id", id);
            const headers = [{
                    label: "Name",
                    key: "name"
                },
                {
                    label: "Email",
                    key: "email"
                },
                {
                    label: "Status",
                    key: "statusBadgeTitle",
                    badge: true,
                    badgeClass: 'statusBadgeBg',
                },
            ];
            fetchAndShowModal(detailsUrl, headers, "modal_wrap_id", "modal_id");
        });
    </script>
@endpush
