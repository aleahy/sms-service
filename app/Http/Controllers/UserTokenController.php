<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserTokenController extends Controller
{
    public function store(User $user)
    {
        $user->load('tokens');
        $tokens = $user->tokens;

        foreach($tokens as $token) {
            if ($token->can(User::TOKEN_ABILITY_SEND_SMS)) {
                $token->delete();
            }
        }

        $token = $user->createToken(User::TOKEN_SEND_SMS, [User::TOKEN_ABILITY_SEND_SMS]);
        $plainTxt = Str::of($token->plainTextToken)->after('|');

        return response()->json([
            'token' => $plainTxt
        ]);
    }
}
