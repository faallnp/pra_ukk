@props([
    'active' => false
])

<button class="category-btn {{ $active ? 'active' : '' }}">
    {{ $slot }}
</button>