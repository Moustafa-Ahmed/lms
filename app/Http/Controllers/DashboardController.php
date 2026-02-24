<?php

namespace App\Http\Controllers;

use App\Actions\Dashboard\GetDashboardDataAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard.
     */
    public function __invoke(GetDashboardDataAction $dashboardAction): View
    {
        $user = Auth::user();
        $data = $dashboardAction($user);

        return view('home.dashboard', [
            'user' => $user,
            ...$data,
        ]);
    }
}
