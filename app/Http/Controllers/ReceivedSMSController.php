<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReceiveSMSRequest;
use App\Http\Resources\SMSResource;
use App\Models\SMS;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReceivedSMSController extends Controller
{
    public function index()
    {
        $receivedSMSs = SMSResource::collection(
            SMS::with('sender')
                ->received()
                ->orderBy('created_at', 'desc')
                ->paginate()
        );

        return Inertia::render('ReceivedSMS/Index', ['smss' => $receivedSMSs]);
    }

    public function store(ReceiveSMSRequest $request)
    {
        SMS::create([
            'sender_id' => auth()->user()->id,
            'from_phone_number' => $request->from,
            'to_phone_number' => $request->to,
            'message' => $request->message,
            'sent' => false
        ]);

        return response()->json(['success' => true]);
    }
}
