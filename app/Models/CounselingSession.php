<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingSession extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'title',
        'counseling_date',
        'category',
        'summary',
        'follow_up',
        'status',
        'completed_at'
    ];

    protected $casts = [
        'counseling_date' => 'date',
        'completed_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
