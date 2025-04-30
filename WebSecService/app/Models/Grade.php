<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'grade', // Only the grade itself needs to be filled directly
        'term',
        'year',
        'user_id',
        'course_id', // ✅ Course relationship key
    ];

    // Grade points mapping
    public static $gradePoints = [
        'A+' => 4.0, 'A' => 4.0, 'A-' => 3.7,
        'B+' => 3.3, 'B' => 3.0, 'B-' => 2.7,
        'C+' => 2.3, 'C' => 2.0, 'C-' => 1.7,
        'D+' => 1.3, 'D' => 1.0, 'F' => 0.0
    ];

    // Retrieve grade point based on the grade value
    public function getGradePointAttribute()
    {
        return self::$gradePoints[$this->grade] ?? 0;
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // Calculate Quality Points (Grade Point * Credit Hours)
    public function getQualityPointsAttribute()
    {
        return $this->grade_point * $this->credit_hours;
    }

    // Accessor for credit_hours from the related Course model
    public function getCreditHoursAttribute()
    {
        return $this->course ? $this->course->credit_hours : 0;
    }

    // Accessor for course_code from the related Course model
    public function getCourseCodeAttribute()
    {
        return $this->course ? $this->course->course_code : 'N/A';
    }

    // Accessor for course_name from the related Course model
    public function getCourseNameAttribute()
    {
        return $this->course ? $this->course->course_name : 'N/A';
    }
}
