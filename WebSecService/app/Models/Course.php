<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'code',
        'name',
        'credit_hours',
        'description' // تمت إضافته
    ];

    // علاقة مع الدرجات
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    // إذا كنت تريد علاقة مباشرة مع المستخدمين
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->using(Grade::class)
                    ->withPivot('grade', 'term', 'year', 'quality_points')
                    ->withTimestamps();
    }
}
