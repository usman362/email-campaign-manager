<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = User::find(Auth::id());
        return view('settings.index', compact('user'));
    }

    public function create()
    {
        $user = User::find(Auth::id());
        return view('settings.create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = User::find(Auth::id());
        $user->gmail_username = $request->gmail_username;
        $user->gmail_email = $request->gmail_email;
        $user->gmail_password = $request->gmail_password;
        $user->save();
        return redirect(route('settings.index'))->with('success', 'Email Updated Successfully');
    }
}
