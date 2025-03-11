<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke() {
        $user = Auth::user();

        if (!$user) {
            return redirect()->to('login');
        };

        return view('dashboard.' . $user->role);
    }
}
