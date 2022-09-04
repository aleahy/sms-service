<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = UserResource::collection(User::paginate());

        return Inertia::render('Users/Index', ['users' => $users]);
    }

    public function show(User $user)
    {
        $user->load(['webhook', 'tokens']);
        return Inertia::render('Users/Show', ['user' => UserResource::make($user)]);
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->safe()['name'],
            'email' => $request->safe()['email'],
            'password' => Hash::make(Str::random(10)),
        ]);

        return back();
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }

    public function update(User $user, UserRequest $request)
    {
        $user->update([
            'name' => $request->safe()['name'],
            'email' => $request->safe()['email'],
        ]);

        return back();
    }
}
