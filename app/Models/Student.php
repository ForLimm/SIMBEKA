<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 
        'teacher_id', 
        'name', 
        'nisn', 
        'photo',
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
        return $this->hasMany(Report::class, 'reported_by', 'user_id');
    }

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }

    public function letters()
    {
        return $this->hasMany(Letter::class)->latest();
    }

    public function counselingSessions()
    {
        return $this->hasMany(CounselingSession::class)->latest('counseling_date');
    }
}
