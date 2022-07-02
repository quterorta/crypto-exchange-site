@extends('layouts.main-layout')

@section('page-title')
    {{ $appName }} | {{ __('FAQ') }}
@endsection

@section('header')@include('layouts.frontend.header')@endsection

@section('main-content')

    <div class="main-container">
        <section class="about_us-container ptb5 plr5">
            <p style="color:white; font-size: 2rem; font-weight: 400; text-align: center;">Тут будет какой-то текст</p>
        </section>
    </div>

@endsection

@section('footer')@include('layouts.frontend.footer')@endsection
