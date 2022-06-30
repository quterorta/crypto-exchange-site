@extends('layouts.main-layout')

@section('page-title')
    Despre Noi
@endsection

@section('header')@include('layouts.frontend.header')@endsection

@section('main-content')

    <section id="despre-noi" class="about-us-section block-plr-5 block-ptb-5">
        <p class="about-us-section-header block_header">Despre Noi</p>
        <div class="about-us-section-content">
            <div class="about-us-section-content-image">
                <img src="/img/content/1.jpg" alt="">
            </div>
            <div class="about-us-section-content-text">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    <br>
                    <b>Ut enim ad minim veniam</b>, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    <a href="#">Duis aute irure dolor in reprehenderit in voluptate velit esse</a> cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt <i>mollit anim id est laborum</i>
                </p>
            </div>
        </div>
        <div class="about-us-section-content">
            <div class="about-us-section-content-text">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    <br>
                    <b>Ut enim ad minim veniam</b>, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    <a href="#">Duis aute irure dolor in reprehenderit in voluptate velit esse</a> cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt <i>mollit anim id est laborum</i>
                </p>
            </div>
            <div class="about-us-section-content-image">
                <img src="/img/content/2.jpg" alt="">
            </div>
        </div>
    </section>

    <section id="partenerii" class="partners-section block-ptb-5 block-plr-5">
        <p class="partners-section-header block_header">Partenerii noștri</p>
        <div class="partners-section-items gb-4">
            @foreach($partners as $partner)
                <div class="partners-section-item">
                    <a href="{{ $partner->url }}" target="_blank"><img src="{{ Storage::url($partner->image) }}" alt=""></a>
                </div>
            @endforeach
        </div>
    </section>

    <section id="contacte" class="contacts-section block-ptb-5 block-plr-5">
        <p class="contacts-section-header block_header">Contacte</p>
        <ul>
            <li><a href="tel:+380993080701">+380993080701</a></li>
            <li><a href="tel:+380976690368">+380976690368</a></li>
            <li><a href="tel:+380916216271">+380916216271</a></li>
        </ul>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d174147.87650780866!2d28.718093435435854!3d46.99978363574422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c97c3628b769a1%3A0x37d1d6305749dd3c!2z0JrQuNGI0LjQvdGR0LIsINCc0L7Qu9C00LDQstC40Y8!5e0!3m2!1sru!2sua!4v1648755074967!5m2!1sru!2sua" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

@endsection

@section('footer')@include('layouts.frontend.footer')@endsection
