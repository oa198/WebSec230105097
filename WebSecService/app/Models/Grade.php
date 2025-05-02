<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'grade',
        'term',
        'year',
        'user_id',
        'course_id',
    ];

    public static $gradePoints = [
        'A+' => 4.0, 'A' => 4.0, 'A-' => 3.7,
        'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7,
        'C+' => 2.3, 'C' => 2.0, 'C-' => 1.7,
        'D+' => 1.3, 'D' => 1.0, 'F' => 0.0
    ];

    public function getGradePointAttribute()
    {
        return self::$gradePoints[$this->grade] ?? 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getCreditHoursAttribute()
    {
        return $this->course->credit_hours ?? 0;
    }

    public function getQualityPointsAttribute()
    {
        return $this->grade_point * $this->course->credit_hours;
    }


    public function getCourseCodeAttribute()
    {
        return $this->course ? $this->course->code : 'N/A';
    }

    public function getCourseNameAttribute()
    {
        return $this->course ? $this->course->name : 'N/A';
    }
}
