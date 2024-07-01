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

class CustomProfileComponentP extends MyProfileComponent
{
    protected string $view = "livewire.custom-profile-componentp";
    public array $only = ['birthday', 'age', 'sex', 'phone_no', 'address'];
    public array $data;
    public $user;
    public $userClass;
    public static $sort = 11;
    // this example shows an additional field we want to capture and save on the user
    public function mount()
    {

        $this->user = Filament::getCurrentPanel()->auth()->user();
        if ($this->user->userBio == null) {
            $this->user->userBio = $this->user->userBio()->firstOrCreate([]);
            $this->data = $this->user->userBio->only($this->only);
        } else {
            $this->data = $this->user->userBio->only($this->only);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sex')
                    ->label('Sex')
                    ->prefixIcon('bi-gender-ambiguous')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ]),
                Fieldset::make('Age')
                    ->schema([
                        DatePicker::make('birthday')
                            ->label('Birthday')
                            ->prefixIcon('iconpark-birthdaycake-o')
                            ->after('1900-01-01')
                            ->before('today')
                            ->maxDate(now()->subYear(2))
                            ->default(now()->subYear(2))
                            ->native(false)
                            ->live(onBlur: true)
                            ->hint('This field is automatically calculated based on the age field.')
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $birthday = $get('birthday');
                                $age = Carbon::parse($birthday)->age;
                                $set('age', $age);
                            }),
                        TextInput::make('age')
                            ->label('Age')
                            ->live(onBlur: true)
                            ->suffix('years')
                            ->default(2)
                            ->numeric()
                            ->prefixIcon('iconpark-birthdaycake-o')
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $age = $get('age');
                                $birthday = Carbon::now()->subYears($age)->toDateString();
                                $set('birthday', $birthday);
                            })
                            ->hint('This field is automatically calculated based on the birthday field.'),
                    ]),
                Fieldset::make('Contact Information')
                    ->schema([
                        Textarea::make('address')
                            ->label('Address')
                            ->rows(1)
                            ->autosize(),
                        PhoneNumber::make('phone_no')
                            ->label('Phone number')
                            ->prefix('(+95 / 0)')
                            ->suffix('Myanmar')
                            ->region('MM'),
                    ]),
            ])
            ->statePath('data');
    }

    // only capture the custome component field
    public function submit(): void
    {
        $data = collect($this->form->getState())->only($this->only)->all();
        // dd($data);
        $this->user->userBio->update($data);
        Notification::make()
            ->success()
            ->title(__('User Bio updated successfully'))
            ->send();
    }
}
