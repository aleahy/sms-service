<?php

namespace App\Http\Controllers;

use App\Http\Resources\SMSResource;
use App\Models\SMS;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReceivedSMSController extends Controller
{
    public function index()
    {
        $receivedSMSs = SMSResource::collection(SMS::received()->paginate());

        return Inertia::render('ReceivedSMS/Index', ['smss' => $receivedSMSs]);
    }
}
