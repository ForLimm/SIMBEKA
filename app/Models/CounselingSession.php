<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CounselingSession extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'academic_period_id',
        'student_id',
        'teacher_id',
        'teacher_name',
        'teacher_nip',
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

    public function academicPeriod()
    {
        return $this->belongsTo(\App\Models\AcademicPeriod::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
