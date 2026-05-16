<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingSession extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'counseling_date',
        'category',
        'summary',
        'follow_up',
        'status'
    ];

    protected $casts = [
        'counseling_date' => 'date'
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
