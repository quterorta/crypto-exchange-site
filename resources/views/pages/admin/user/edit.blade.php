@extends('layouts.main-layout')

@section('page-title')AdminPanel | Edit {{ $title }} @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Edit {{ $title }} #{{ $user->id }}</li>
                    <li class="admin-navbar-link"><a href="{{ route('user.index') }}">All {{ $titleMany }}</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-form-container">
                <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Change Password (not necessary)') }}</label>
                        <input type="text" name="password" id="password" class="form-control" placeholder="{{ __('Change Password') }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Edit</button>
                    </div>
                </form>
            </div>
        </section>
    </section>
@endsection
