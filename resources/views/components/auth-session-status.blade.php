@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'text-center']) }}>
        {{ $status }}
    </div>
@endif
