<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id', 
        'teacher_id', 
        'name', 
        'nisn', 
        'class',
        'birth_place', 
        'birth_date', 
        'gender', 
        'religion', 
        'address', 
        'phone',
        'father_name', 
        'mother_name', 
        'parents_job', 
        'parents_phone', 
        'parents_address', 
        'living_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }

    public function counselingSessions()
    {
        return $this->hasMany(CounselingSession::class)->latest('counseling_date');
    }
}
