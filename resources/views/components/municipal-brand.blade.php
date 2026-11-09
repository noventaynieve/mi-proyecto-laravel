<div>
    <!-- It always seems impossible until it is done. - Nelson Mandela -->
</div>
@props([
    'href',
    'logoClass' => 'h-16 w-16 shrink-0 object-contain',
])

<a href="{{ $href }}" {{ $attributes->class(['flex items-center gap-4']) }}>
    <img
        src="{{ asset('img/cropped-logo2025.webp') }}"
        alt="Escudo del Gobierno de Cocula"
        class="{{ $logoClass }}"
    >
    <span>{{ $slot }}</span>
</a>