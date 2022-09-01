<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::query()->orderBy('id')
            ->paginate(20)
            ->through(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name
                ];
            });

        return Inertia::render('Users/Index', ['users' => $users]);
    }
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(10)),
        ]);
        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }
}
