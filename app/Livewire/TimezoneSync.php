<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class TimezoneSync extends Component
{
    #[On('updateUserTimezone')]
    public function updateUserTimezone(string $timezone): void
    {
        session(['userTimezone' => $timezone]);

        if (Auth::check() && Auth::user()->timezone !== $timezone) {
            Auth::user()->forceFill(['timezone' => $timezone])->saveQuietly();
        }
    }

    public function render()
    {
        return view('livewire.timezone-sync');
    }
}
