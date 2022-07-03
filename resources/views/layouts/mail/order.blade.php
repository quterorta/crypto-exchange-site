<h1>{{ __('New apply for exchange') }}</h1>

<p><strong>{{__('Name:')}}</strong> {{ $data->name }}</p>
<p><strong>{{ __('Email:') }}</strong> {{ $data->email }}</p>
<p><strong>{{ __('Phone:') }}</strong> {{ $data->phone }}</p>
<p><strong>{{ __('Telegram:') }}</strong> {{ $data->phone }}</p>
<p><strong>{{ __('Order') }}</strong> #{{ $data->order }}</p>
<p><a href="{{ $data->link }}"><strong>{{ __('View in admin') }}</strong></a></p>
