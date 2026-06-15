<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherClassAssignment extends Model
{
    protected $fillable = [
        'academic_period_id',
        'teacher_id',
        'class',
    ];

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get students in this assigned class.
     */
    public function students()
    {
        return Student::where('class', $this->class)
            ->where('teacher_id', $this->teacher_id)
            ->get();
    }

    /**
     * Mutator to automatically normalize class name for assignments.
     */
    public function setClassAttribute($value)
    {
        $this->attributes['class'] = Student::normalizeClass($value);
    }
}
