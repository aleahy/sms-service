<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendSMSRequest;
use App\Http\Resources\SMSResource;
use App\Models\SMS;
use App\Models\User;
use Inertia\Inertia;
use Spatie\WebhookServer\WebhookCall;

class SMSController extends Controller
{
    public function show(SMS $sms)
    {
        $sms->load(['sender', 'recipient']);

        return Inertia::render('SMS/Show', ['sms' => SMSResource::make($sms)]);
    }

    public function store(SendSMSRequest $request)
    {
        $recipient = User::with('webhook')
            ->find($request->recipient_id);

        WebhookCall::create()
            ->url($recipient->webhook->url)
            ->payload([
                'from' => $request->from,
                'message' => $request->message
            ])
            ->useSecret($recipient->webhook->secret)
            ->dispatch();

        SMS::create([
            'recipient_id' => $request->recipient_id,
            'from_phone_number' => $request->from,
            'message' => $request->message,
            'sent' => true,
        ]);

        return back();
    }
}
