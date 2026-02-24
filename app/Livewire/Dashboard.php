<?php

namespace App\Livewire;

use App\Actions\Dashboard\GetDashboardDataAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public function render(GetDashboardDataAction $action): View
    {
        $data = $action(Auth::user());

        return view('livewire.dashboard', $data);
    }
}
