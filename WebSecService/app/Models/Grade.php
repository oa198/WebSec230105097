<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'course_code', 'course_name', 'credit_hours',
        'grade', 'term', 'year'
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getQualityPointsAttribute()
    {
        return $this->grade_point * $this->credit_hours;
    }
}
