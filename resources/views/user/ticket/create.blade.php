@extends('user.layouts.master', ['page_slug' => 'user-ticket'])
@section('content')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Create Ticket') }}</h4>
                    @include('user.includes.button', [
                            'routeName' => 'user.ticket.index',
                            'label' => 'Back',
                        ])
                </div>
                <div class="card-body">
                    <form action="{{ route('user.ticket.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Title') }}</label>
                            <input type="text" value="{{ old('title') }}" name="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Enter title">
                            @include('alerts.feedback', ['field' => 'title'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description') }}</label>
                            <textarea name="description" value="{{ old('description') }}" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="Enter description"></textarea>
                            @include('alerts.feedback', ['field' => 'description'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Files') }}</label>
                            <input type="file" name="files[]" class="form-control {{ $errors->has('files') ? ' is-invalid' : '' }}" multiple>
                            @include('alerts.feedback', ['field' => 'files.*'])
                            @include('alerts.feedback', ['field' => 'files'])
                        </div>
                        <div class="form-group float-end mb-3">
                            <input type="submit" class="btn btn-primary" value="Create">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
