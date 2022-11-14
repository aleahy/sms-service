<?php

namespace App\Http\Controllers;

use App\Http\Resources\SMSResource;
use App\Models\SMS;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $mostRecentReceived = SMSResource::make(
            SMS::with('sender')
                ->received()
                ->orderBy('created_at', 'desc')
                ->limit(1)
                ->first()
        );

        return Inertia::render('Dashboard', [
            'most_recent_received' => $mostRecentReceived,
        ]);




    }
}
