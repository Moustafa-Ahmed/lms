<?php

namespace App\Livewire;

use App\Support\UserTimezone;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class TimezoneSync extends Component
{
    #[On('updateUserTimezone')]
    public function updateUserTimezone(string $timezone): void
    {
        $normalizedTimezone = UserTimezone::normalize($timezone);

        session(['userTimezone' => $normalizedTimezone]);

        if (Auth::check() && Auth::user()->timezone !== $normalizedTimezone) {
            Auth::user()->forceFill(['timezone' => $normalizedTimezone])->saveQuietly();
        }
    }

    public function render()
    {
        return view('livewire.timezone-sync');
    }
}
