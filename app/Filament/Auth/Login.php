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
                ->autocomplete()
                ->autofocus()
                ->extraAttributes(['class' =>'cp-login-email-input']),
            TextInput::make('password')
                ->label("")
                ->placeholder(__("filament::login.fields.password.placeholder"))
                ->password()
                ->required()
                ->autofocus()
                ->extraAttributes(['class' =>'cp-login-password-input']),
            Checkbox::make('remember')
                ->label(__('filament::login.fields.remember.label'))
                ->extraAttributes([
                    'class'=>'remember',
        ]),
        ];
    }
}
