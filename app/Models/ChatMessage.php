<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['report_id', 'sender_id', 'message', 'read_at', 'is_destroyed'];

    protected $casts = [
        'read_at' => 'datetime',
        'is_destroyed' => 'boolean',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Scope to get only visible (non-destroyed) messages.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_destroyed', false);
    }
}
