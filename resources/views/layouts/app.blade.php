@if(auth()->user()->hasRole('admin'))
    <x-layouts::app.navbar_administrador :title="$title ?? null">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts::app.navbar_administrador>
@else
    <x-layouts::app.navbar_lector :title="$title ?? null">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts::app.navbar_lector>
@endif


