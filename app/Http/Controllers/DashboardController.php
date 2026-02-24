<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user's dashboard.
     */
    public function __invoke(): View
    {
        return view('home.dashboard', [
            'user' => Auth::user(),
        ]);
    }
}
