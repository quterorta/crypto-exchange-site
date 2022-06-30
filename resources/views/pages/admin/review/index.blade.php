@extends('layouts.main-layout')

@section('page-title')AdminPanel | {{ $titleMany }} @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">All {{ $titleMany }}</li>
                    <li class="admin-navbar-link"><a href="{{ route('review.create') }}">Add</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-items-container g5">
                @foreach($reviews as $review)
                    <div class="admin-item">
                        <a class="admin-item-header-link" href="{{ route('review.edit', $review->id) }}">
                            User: #{{ $review->user->id }} {{ $review->user->email }}
                        </a>
                        <a class="admin-item-review-link" href="{{ route('review.edit', $review->id) }}">
                            {{ $review->text }}
                        </a>
                        <a class="admin-item-link" href="{{ route('review.edit', $review->id) }}">
                            Created: {{ $review->created_at }}
                            <br>
                            Updated: {{ $review->updated_at }}
                        </a>
                        <div class="admin-item-control">
                            <ul>
                                <li><a class="admin-item-control-edit" href="{{ route('review.edit', $review->id) }}"><i class="bi bi-pencil-fill"></i></a></li>
                                <li><form action="{{ route('review.destroy', $review->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn admin-item-control-delete" data-title="#{{ $review->id }} {{ $review->email }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </section>
@endsection
