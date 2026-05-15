<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['title', 'content', 'type', 'priority', 'status', 'handled_by', 'is_anonymous'];

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}
