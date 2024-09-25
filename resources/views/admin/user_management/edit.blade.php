@extends('admin.layouts.master', ['page_slug' => 'user'])
@section('title', 'Edit User')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="cart-title">{{ __('Edit User') }}</h4>
                    @include('admin.includes.button', [
                            'routeName' => 'user.index',
                            'label' => 'Back',
                        ])
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                placeholder="Enter name">
                            @include('alerts.feedback', ['field' => 'name'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Image') }}</label>
                            <input type="file" accept="image/*" name="image" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}">
                            @include('alerts.feedback', ['field' => 'image'])
                        </div>
                        @if ($user->image)
                            <img src="{{ auth_storage_url($user->image, $user->gender) }}" alt="" width="100" height="100">
                        @endif
                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input type="text" name="email" value="{{ $user->email }}" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                placeholder="Enter email">
                            @include('alerts.feedback', ['field' => 'email'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Password') }}</label>
                            <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter password">
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                placeholder="Enter confirm password">
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
