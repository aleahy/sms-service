<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const TOKEN_SEND_SMS = 'Send SMS Token';
    const TOKEN_ABILITY_SEND_SMS = 'sms:send';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function showLink()
    {
        return route('users.show', $this);
    }

    public function webhook(): HasOne
    {
        return $this->hasOne(Webhook::class);
    }

    /**
     * The SMSs this user has sent to this system
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receivedSMSs()
    {
        return $this->hasMany(SMS::class, 'sender_id');
    }

    /**
     * The SMSs this system has sent to this user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentSMSs()
    {
        return $this->hasMany(SMS::class, 'recipient_id');
    }
}
