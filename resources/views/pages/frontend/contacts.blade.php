@extends('layouts.main-layout')

@section('page-title')
    Contacte
@endsection

@section('header')@include('layouts.frontend.header')@endsection

@section('main-content')

    <section>
        <div class="product-detail-contact-form">
            <p class="product-detail-contact-form-header">Pune o intrebare</p>
            <form action="{{ route('product-contact-form') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nume</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Nume" value="{{ old('name') ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="tel" name="phone" id="phone" class="form-control" required placeholder="Telefon" value="{{ old('phone') ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="comment">Un comentariu</label>
                    <textarea name="comment" id="comment" rows="3" class="form-control">{{ old('comment') ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <button class="submit-button" type="submit">Trimite</button>
                </div>
            </form>
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
        <p class="contacts-section-header block_header">Cum altfel ne poți contacta</p>
        <ul>
            <li><a href="tel:+380993080701">+380993080701</a></li>
            <li><a href="tel:+380976690368">+380976690368</a></li>
            <li><a href="tel:+380916216271">+380916216271</a></li>
        </ul>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d174147.87650780866!2d28.718093435435854!3d46.99978363574422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40c97c3628b769a1%3A0x37d1d6305749dd3c!2z0JrQuNGI0LjQvdGR0LIsINCc0L7Qu9C00LDQstC40Y8!5e0!3m2!1sru!2sua!4v1648755074967!5m2!1sru!2sua" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

@endsection

@section('footer')@include('layouts.frontend.footer')@endsection
