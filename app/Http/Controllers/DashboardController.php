<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentTime = Carbon::now()->toDateTimeString();
        $totalAccounts = User::count();
        $todos = Todo::where('user_id', $user->id)->get();
        return view('dashboard', compact('user', 'currentTime', 'totalAccounts', 'todos'));
    }
}
