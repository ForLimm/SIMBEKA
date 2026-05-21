<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'type', 'priority', 'status', 'handled_by', 'is_anonymous', 'reported_by', 'is_hidden_for_reporter'];

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class)->visible()->orderBy('created_at', 'asc');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'reported_by', 'user_id');
    }
}
