<x-layouts::app.navbar_lector :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts::app.navbar_lector>
