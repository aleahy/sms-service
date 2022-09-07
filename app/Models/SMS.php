<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    use HasFactory;

    protected $table = 'sms';
    protected $casts = [
        'sent' => 'boolean',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function scopeReceived(Builder $query)
    {
        return $query->where('sent', false);
    }

    public function scopeSent(Build $query)
    {
        return $query->where('sent', true);
    }
}
