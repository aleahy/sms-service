<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\WebhookStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserWebhookController extends Controller
{
    public function store(User $user, WebhookStoreRequest $request)
    {
        $user->load('webhook');
        if ($user->webhook) {
            $user->webhook->url = $request->safe()['webhook_url'];
            $user->webhook->save();

            return response()->noContent();
        }

        $secret = Str::random(40);
        $user->webhook()->create([
            'url' => $request->safe()['webhook_url'],
            'secret' => $secret,
        ]);

        return response()->json(['secret' => $secret]);
    }
}
