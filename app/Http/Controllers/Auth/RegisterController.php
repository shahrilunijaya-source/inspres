<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|unique:users,email',
            'nric' => 'required|string|max:14|unique:users,nric',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'nric' => $data['nric'],
            'phone' => $data['phone'] ?? null,
            'password' => bcrypt($data['password']),
            'role' => 'public',
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Akaun berjaya didaftarkan.');
    }
}
