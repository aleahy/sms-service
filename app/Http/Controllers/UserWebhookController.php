<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\WebhookStoreRequest;
use App\Models\User;
use App\Models\Webhook;
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

            return response()->json(['secret' => $user->webhook->secret]);
        }

        $secret = Str::random(40);
        $user->webhook()->create([
            'url' => $request->safe()['webhook_url'],
            'secret' => $secret,
        ]);

        return response()->json(['secret' => $secret]);
    }

    public function destroy(User $user)
    {
        $webhook = Webhook::where('user_id', $user->id)->first();
        $webhook->delete();

        return back();
    }
}
