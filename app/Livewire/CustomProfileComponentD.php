<?php

namespace App\Livewire;

use App\Models\UserBio;
use Filament\Facades\Filament;
use Livewire\Component;
use Jeffgreco13\FilamentBreezy\Livewire\MyProfileComponent;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Carbon\Carbon;
use Cheesegrits\FilamentPhoneNumbers\Forms\Components\PhoneNumber;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;

class CustomProfileComponentD extends MyProfileComponent
{
    protected string $view = "livewire.custom-profile-componentd";
    public array $only = ['age', 'qualification', 'experience', 'phone_no'];
    public array $data;
    public $user;
    public $userClass;
    public static $sort = 11;
    // this example shows an additional field we want to capture and save on the user
    public function mount()
    {

        $this->user = Filament::getCurrentPanel()->auth()->user();
        if ($this->user->dentistBio == null) {
            $this->user->dentistBio = $this->user->dentistBio()->firstOrCreate([]);
            $this->data = $this->user->dentistBio->only($this->only);
        } else {
            $this->data = $this->user->dentistBio->only($this->only);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('age')
                    ->label('Age')
                    ->suffix('years')
                    ->numeric()
                    ->prefixIcon('iconpark-birthdaycake-o'),
                TextInput::make('qualification')
                    ->label('Qualification')
                    ->prefixIcon('fas-graduation-cap'),
                TextInput::make('experience')
                    ->label('Experience')
                    ->numeric()
                    ->suffix('years')
                    ->prefixIcon('iconpark-briefcase-o')
                    ->hint('In years'),
                PhoneNumber::make('phone_no')
                    ->label('Phone number')
                    ->prefix('(+95 / 0)')
                    ->suffix('Myanmar')
                    ->region('MM'),
            ])
            ->statePath('data');
    }

    // only capture the custome component field
    public function submit(): void
    {
        $data = collect($this->form->getState())->only($this->only)->all();
        $this->user->dentistBio->update($data);
        Notification::make()
            ->success()
            ->title(__('Dentist Bio updated successfully'))
            ->send();
    }
}
