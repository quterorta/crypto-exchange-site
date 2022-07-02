<div class="footer-main_container">
    <div class="footer-logo_container">
        <a href="{{ route('home') }}"><img src="/img/assets/logo.png" alt=""></a>
    </div>
    <div class="footer-menu_container gb-2">
        <div class="footer-menu-nav_container">
            <ul class="footer-menu-nav">
                <li class="footer-menu-nav_item">
                    <a href="{{ route('exchange') }}">{{ __('Exchange') }}</a>
                </li>
                <li class="footer-menu-nav_item">
                    <a href="{{ route('about-us') }}">{{ __('About Us') }}</a>
                </li>
                <li class="footer-menu-nav_item">
                    <a href="{{ route('reviews') }}">{{ __('Reviews') }}</a>
                </li>
                <li class="footer-menu-nav_item">
                    <a href="{{ route('faq') }}">{{ __('FAQ') }}</a>
                </li>
            </ul>
        </div>
        <div class="footer-menu-contacts_container">
            <ul class="footer-menu-contacts">
                <li class="footer-menu-contacts_link">
                    <a href="#" class="disabled-link"><i class="fa-regular fa-clock"></i>{{ __('We working 27/7') }}</a>
                </li>
                <li class="footer-menu-contacts_link">
                    <a href="tel:+380993080701"><i class="fa-solid fa-phone"></i>+380993080701</a>
                </li>
                <li class="footer-menu-contacts_link">
                    <a href="mailto:{{ $supportEmail }}"><i class="fa-regular fa-envelope"></i>{{ $supportEmail }}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer-copyright_container">
        <p id="copyright" class="footer-copyright"></p>
    </div>
</div>
<script>
    $(document).ready(function () {
        let copyright = $('#copyright');
        let currentYear = new Date().getFullYear();
        let copyrightText = 'Copyright ©'+currentYear+' {{ $appName }} | All rights reserved.';
        copyright.html(copyrightText);
    });
</script>
