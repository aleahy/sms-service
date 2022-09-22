<?php

namespace App\Http\Controllers;

use App\Models\SMS;
use App\Models\User;
use Illuminate\Http\Request;

class UserReceivedSMSController extends Controller
{
    public function destroy(User $user)
    {
        SMS::where('sender_id', $user->id)->delete();

        return back();
    }
}
