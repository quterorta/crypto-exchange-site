@extends('layouts.main-layout')

@section('page-title')AdminPanel | {{ $titleMany }} @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">All {{ $titleMany }}</li>
                    <li class="admin-navbar-link">
                        <a href="{{ route('user.create') }}">Add</a>
                    </li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-items-list_container">
                @foreach($users as $user)
                    <div class="admin-list_item">
                        <div class="admin-list_item-id_container">
                            <p>#{{ $user->id }}</p>
                        </div>
                        <div class="admin-list_item-currency_container">
                            <a href="{{ route('user.edit', $user->id) }}">
                                {{ $user->name }}
                            </a>
                        </div>
                        <div class="admin-list_item-currency_container">
                            <a href="{{ route('user.edit', $user->id) }}">
                                {{ $user->email }}
                            </a>
                        </div>
                        <div class="admin-list_item-currency_container">
                            <a href="{{ route('user.edit', $user->id) }}">
                                {{ $user->created_at }}
                            </a>
                        </div>
                        <div class="admin-item-control">
                            <ul>
                                <li><a class="admin-item-control-edit" href="{{ route('user.edit', $user->id) }}"><i class="bi bi-pencil-fill"></i></a></li>
                                <li><form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn admin-item-control-delete" data-title="#{{ $user->id }} {{ $user->email }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($users)
                {{ $users->links('blocks.pagination.admin-pagination') }}
            @endif
        </section>
    </section>
@endsection
