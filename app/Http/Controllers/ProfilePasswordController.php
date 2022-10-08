<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfilePasswordController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => [
                'required',
                'string',
                'max:255',
                'current_password:web',
            ],
            'password' => [
                'required',
                'string',
                'max:255',
                'confirmed',
                new Password(8),
            ]
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('password_status', 'Your password has been updated');
    }
}
