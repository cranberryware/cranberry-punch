<?php

namespace App\Filament\Auth;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Http\Livewire\Auth\Login as BasePage;

class Login extends BasePage
{
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->label("")
                ->placeholder(__('filament::login.fields.email.placeholder'))
                ->email()
                ->required()
                ->autocomplete(),
            TextInput::make('password')
                ->label("")
                ->placeholder(__("filament::login.fields.password.placeholder"))
                ->password()
                ->required(),
            Checkbox::make('remember')
                ->label(__('filament::login.fields.remember.label'))
                ->extraAttributes([
                    'class'=>'remember',
        ]),
        ];
    }
}
