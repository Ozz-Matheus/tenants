<?php

namespace App\Livewire\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Pages\SimplePage;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRules;

class ResetPassword extends SimplePage
{
    protected string $view = 'livewire.auth.reset-password';

    public ?string $email = null;

    public ?string $token = null;

    public ?array $data = [];

    public function getHeading(): string
    {
        return __('Reset Password');
    }

    public function getSubheading(): ?string
    {
        return __('Enter your new password to regain access.');
    }

    public function mount(): void
    {
        $this->token = request()->route('token');
        $this->email = request()->query('email');

        $this->form->fill([
            'email' => $this->email,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('email')
                    ->label(__('Email'))
                    ->disabled()
                    ->required(),

                TextInput::make('password')
                    ->label(__('New Password'))
                    ->password()
                    ->revealable()
                    ->required()
                    ->rule(PasswordRules::defaults())
                    ->same('password_confirmation'),

                TextInput::make('password_confirmation')
                    ->label(__('Confirm Password'))
                    ->password()
                    ->revealable()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function store()
    {
        $formData = $this->form->getState();

        $status = Password::broker()->reset(
            [
                'token' => $this->token,
                'email' => $this->email,
                'password' => $formData['password'],
                'password_confirmation' => $formData['password_confirmation'],
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('home')->with('status', __($status))
            : $this->addError('email', __($status));
    }
}
