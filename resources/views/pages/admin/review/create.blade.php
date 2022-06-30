@extends('layouts.main-layout')

@section('page-title')AdminPanel | Add {{ $title }} @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">Add {{ $title }}</li>
                    <li class="admin-navbar-link"><a href="{{ route('review.index') }}">All {{ $titleMany }}</a></li>
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
                <form action="{{ route('review.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">{{ __('User') }}</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value=null disabled>--- {{ __('Select Currency') }} ---</option>
                            @foreach($users as $user)
                                <option @if($user->name === 'Guest') selected @endif value={{ $user->id }}>{{ $user->name }} | {{ $user->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="text">{{ __('Review Text') }}</label>
                        <textarea name="text" id="text" rows="5" placeholder="{{ __('Review Text') }}" class="form-control" minlength="1"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Create</button>
                    </div>
                </form>
            </div>
    </section>
    </section>
@endsection
