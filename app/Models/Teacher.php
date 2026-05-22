<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['user_id', 'nip', 'max_quota'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function counselingSessions()
    {
        return $this->hasMany(CounselingSession::class);
    }

    public function classAssignments()
    {
        return $this->hasMany(TeacherClassAssignment::class);
    }

    /**
     * Get class assignments for a specific period.
     */
    public function classAssignmentsForPeriod($periodId)
    {
        return $this->classAssignments()->where('academic_period_id', $periodId)->get();
    }

    /**
     * Get class assignments for the active period.
     */
    public function activeClassAssignments()
    {
        $activePeriod = AcademicPeriod::active();
        if (!$activePeriod) return collect();
        return $this->classAssignments()->where('academic_period_id', $activePeriod->id)->get();
    }

    /**
     * Get assigned class names for the active period.
     */
    public function getActiveClassNamesAttribute()
    {
        return $this->activeClassAssignments()->pluck('class')->toArray();
    }
}
