@extends('layouts.main-layout')

@section('page-title')AdminPanel | {{ $titleMany }} @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <div class="admin-navbar">
                <ul>
                    <li class="admin-navbar-header">All {{ $titleMany }}</li>
                    <li class="admin-navbar-link"><a href="{{ route('order.create') }}">Add</a></li>
                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="admin-items-container g5">
                @foreach($orders as $order)
                    <div class="admin-item">
                        <a class="admin-item-order-link" href="{{ route('order.edit', $order->id) }}">
                            <img src="{{ Storage::url($order->fromImage) }}" alt="">{{ $order->fromCode }} -
                            <img src="{{ Storage::url($order->toImage) }}" alt="">{{ $order->toCode }}
                        </a>
                        <a class="admin-item-status-link" href="{{ route('order.edit', $order->id) }}">
                            Status: <br>
                            @if($order->status === 0)
                                <b>{{ __('Canceled') }}</b>
                            @elseif($order->status === 1)
                                <b>{{ __('Completed') }}</b>
                            @elseif($order->status === 2)
                                <b>{{ __('New') }}</b>
                            @elseif($order->status === 3)
                                <b>{{ __('Awaiting payment') }}</b>
                            @elseif($order->status === 4)
                                <b>{{ __('Paid, awaiting confirmation') }}</b>
                            @endif
                        </a>
                        <a class="admin-item-header-link" href="{{ route('order.edit', $order->id) }}">
                            Total: {{ $order->sum }}
                        </a>
                        <a class="admin-item-header-link" href="{{ route('user.show', $order->user->id) }}">
                            User: #{{ $order->user->id }} | {{ $order->user->name }}
                        </a>
                        <a class="admin-item-link" href="{{ route('order.edit', $order->id) }}">
                            Created: {{ $order->created_at }}
                            <br>
                            Updated: {{ $order->updated_at }}
                        </a>
                        <div class="admin-item-control">
                            <ul>
                                <li><a class="admin-item-control-edit" href="{{ route('order.edit', $order->id) }}"><i class="bi bi-pencil-fill"></i></a></li>
                                <li><form action="{{ route('order.destroy', $order->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn admin-item-control-delete" data-title="#{{ $order->id }} | {{ $order->fromCode }}-{{ $order->toCode }}">
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
