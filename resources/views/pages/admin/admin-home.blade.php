@extends('layouts.main-layout')

@section('page-title')AdminPanel | Main @endsection

@section('main-content')
    <section class="admin-layout">
        @include('layouts.admin.sidebar')
        <section class="admin-content">
            <h1 class="admin-header">AdminPage | Home</h1>
        </section>
    </section>
@endsection
