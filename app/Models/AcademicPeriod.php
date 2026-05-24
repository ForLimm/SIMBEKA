<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicPeriod extends Model
{
    protected $fillable = [
        'name',
        'academic_year',
        'semester',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the currently active period.
     */
    public static function active()
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Scope for active period.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function teacherClassAssignments()
    {
        return $this->hasMany(TeacherClassAssignment::class);
    }

    public function counselingSessions()
    {
        return $this->hasMany(CounselingSession::class);
    }

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }

    public function letters()
    {
        return $this->hasMany(Letter::class);
    }

    /**
     * Get assigned classes for a specific teacher in this period.
     */
    public function classesForTeacher($teacherId)
    {
        return $this->teacherClassAssignments()
            ->where('teacher_id', $teacherId)
            ->pluck('class');
    }

    /**
     * Get the label for display.
     */
    public function getLabelAttribute()
    {
        $semLabel = $this->semester == '1' ? 'Ganjil' : 'Genap';
        return "TA {$this->academic_year} — Semester {$this->semester} ({$semLabel})";
    }
}
