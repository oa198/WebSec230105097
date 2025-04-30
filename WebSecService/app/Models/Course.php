<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [ // ✅ تمت إضافته
        'code',
        'name',
        'credit_hours',
    ];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
