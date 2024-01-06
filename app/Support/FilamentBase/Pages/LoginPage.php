<?php

namespace App\Support\FilamentBase\Pages;

use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseComponent;

class LoginPage extends BaseComponent
{
    public function authenticate(): ?LoginResponse
    {
        $state = $this->form->getState();

        $response = parent::authenticate();

        $user = filament_user();

        $user->disableLogging()->update(['last_login_at' => now()]);

        activity('Authentication')
            ->event('Login')
            ->causedBy($user)
            ->withProperties($this->getLogProperties())
            ->log(__('admin.successfully_login_with_email', ['email' => $state['email']]));

        return $response;
    }

    protected function throwFailureValidationException(): never
    {
        $state = $this->form->getState();

        activity('Authentication')
            ->event('Login')
            ->withProperties($this->getLogProperties())
            ->log(__('admin.failed_to_login_with_email', ['email' => $state['email']]));

        parent::throwFailureValidationException();
    }

    private function getLogProperties(): array
    {
        $state = $this->form->getState();

        $data = [
            'email' => $state['email'],
            'from_ip_address' => request()->ip(),
            'from_user_agent' => request()->userAgent(),
        ];

        if (function_exists('geoip_record_by_name')) {
            foreach (\geoip_record_by_name(request()->ip()) as $k => $v) {
                $data["geoip_{$k}"] = $v;
            }
        }

        return ['attributes' => $data];
    }
}
