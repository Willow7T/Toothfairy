{{-- <x-filament-panels::page> --}}
<div 
    x-data="{}"
    x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('final_2.0'))]"
class="mt-6">
    <div>
        <livewire:CardHome />
    </div>


    <div>
        <livewire:LoadTreatments />
    </div>

    <div>
        <div class="text-4xl text-center mt-4 text-primary-600 dark:text-primary-400 font-postserif">
            Frequently Asked Questions
        </div>
        <div class="h-40 mx-auto overflow-scroll">
            <livewire:FAQs />
        </div>
    </div>
</div>
{{-- </x-filament-panels::page> --}}
{{-- x-data="{}"
x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('customapp'))]" --}}
