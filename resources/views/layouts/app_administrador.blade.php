<x-layouts::app.navbar_administrador :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts::app.navbar_administrador>