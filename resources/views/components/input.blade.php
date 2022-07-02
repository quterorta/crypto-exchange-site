@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'custom-styles']) !!} >
<style>
    .custom-styles {
        background-color: transparent !important;
        border: 1px solid #54ADFF !important;
        border-radius: 0.5rem !important;
        color: #fff !important;
    }
</style>
