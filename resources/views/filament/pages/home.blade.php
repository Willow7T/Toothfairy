{{-- <x-filament-panels::page> --}}
<div 
    x-data="{}"
    x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('customapp'))]"

class="mt-6">
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <div>
        <livewire:CardHome />
    </div>


    <div>
        <livewire:LoadTreatments />
    </div>
</div>
{{-- </x-filament-panels::page> --}}
