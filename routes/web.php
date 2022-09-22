<?php

use App\Http\Controllers\ReceivedSMSController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\UserReceivedSMSController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserTokenController;
use App\Http\Controllers\UserWebhookController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth']], function() {
    Route::delete('/users/{user}/sms', [UserReceivedSMSController::class, 'destroy'])->name('users.sms.delete');

    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}', [UsersController::class, 'update'])->name('users.update');

    Route::post('/users/{user}/webhook', [UserWebhookController::class, 'store'])->name('users.webhook.store');
    Route::delete('/users/{user}/webhook', [UserWebhookController::class, 'destroy'])->name('users.webhook.delete');

    Route::post('/users/{user}/api', [UserTokenController::class, 'store'])->name('users.sms-token.store');
    Route::delete('/users/{user}/api/{token}', [UserTokenController::class, 'destroy'])->name('users.sms-token.delete');


    Route::get('/sms/received', [ReceivedSMSController::class, 'index'])->name('sms.received.index');

    Route::get('sms/{sms}', [SMSController::class, 'show'])->name('sms.show');
    Route::post('sms', [SMSController::class, 'store'])->name('sms.store');
});
require __DIR__.'/auth.php';

