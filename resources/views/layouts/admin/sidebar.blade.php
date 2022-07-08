<div class="admin-sidebar">
    <ul class="admin-sidebar-menu">
        <li><a class="admin-sidebar-link admin-sidebar-home" href="{{ route('admin-home') }}"><i class="bi bi-house-fill"></i></a></li>
        <li><a class="admin-sidebar-link" href="{{ route('currency.index') }}"><i class="fa-solid fa-bitcoin-sign"></i><br>{{ __('Currency') }}</a></li>
        <li><a class="admin-sidebar-link" href="{{ route('currency-rate.index') }}"><i class="fa-solid fa-right-left"></i><br>{{ __('Rates') }}</a></li>
        <li><a class="admin-sidebar-link" href="{{ route('order.index') }}"><i class="fa-solid fa-wallet"></i><br>{{ __('Orders') }}</a></li>
        <li><a class="admin-sidebar-link" href="{{ route('review.index') }}"><i class="fa-solid fa-comment"></i><br>{{ __('Reviews') }}</a></li>
        <li><a class="admin-sidebar-link" href="{{ route('user.index') }}"><i class="fa-solid fa-user"></i><br>{{ __('Users') }}</a></li>
    </ul>
</div>
