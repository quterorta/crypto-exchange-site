<div class="header-top_section plr15">
    <div class="header-top_section-links_container">
        <p class="header-top_section-link"><i class="fa-regular fa-clock"></i>{{ __('We working 27/7') }}</p>
        <a class="header-top_section-link" href="tel:+380993080701"><i class="fa-solid fa-phone"></i>+380993080701</a>
        <a class="header-top_section-link" href="mailto:{{ $supportEmail }}"><i class="fa-regular fa-envelope"></i>{{ $supportEmail }}</a>
    </div>
    <div class="header-top_section-language_container">
        <a href="" class="header-top_section-language_link active">EN</a>
        <a href="" class="header-top_section-language_link">RO</a>
        <a href="" class="header-top_section-language_link">RU</a>
    </div>
</div>
<div class="header-bottom_section plr15">
    <div class="header-bottom_section-logo_container">
        <a class="header-bottom_section-logo" href="{{ route('home') }}"><img src="/img/assets/logo.png" alt=""></a>
    </div>
    <div class="header-bottom_section-links_container">
        <a href="{{ route('exchange') }}" class="header-bottom_section-link">{{ __('Exchange') }}</a>
        <a href="{{ route('about-us') }}" class="header-bottom_section-link">{{ __('About Us') }}</a>
        <a href="{{ route('reviews') }}" class="header-bottom_section-link">{{ __('Reviews') }}</a>
        <a href="{{ route('faq') }}" class="header-bottom_section-link">{{ __('FAQ') }}</a>
    </div>
    <div class="header-bottom_section-auth-container">
        @if(!Auth::user())
            <a href="{{ route('login') }}" class="header-bottom_section-auth_link">{{ __('Login') }}</a>
            <a href="{{ route('register') }}" class="header-bottom_section-auth_link">{{ __('Register') }}</a>
        @else
            <a href="{{ route('account') }}" class="header-bottom_section-auth_link">{{ __('Account') }}</a>
            <a href="{{ route('logout') }}" class="header-bottom_section-auth_link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endif
    </div>
</div>
