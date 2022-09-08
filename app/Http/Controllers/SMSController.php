<?php

namespace App\Http\Controllers;

use App\Http\Resources\SMSResource;
use App\Models\SMS;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SMSController extends Controller
{
    public function show(SMS $sms)
    {
        $sms->load(['sender', 'recipient']);

        return Inertia::render('SMS/Show', ['sms' => SMSResource::make($sms)]);
    }
}
