<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model {
    use HasFactory;

    protected $fillable = ['student_name', 'course', 'grade', 'credit_hours'];
  
}
