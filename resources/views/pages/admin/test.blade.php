@extends('layouts.main-layout')

@section('page-title')AdminPanel | Main @endsection

@section('header') @include('layouts.admin.header') @endsection

@section('main-content')
    @include('layouts.admin.sidebar')
@endsection

@section('footer') @include('layouts.admin.footer') @endsection
