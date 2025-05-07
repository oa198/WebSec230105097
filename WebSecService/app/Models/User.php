<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'facebook_id',
        'google_id',
        'provider_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // علاقة واحدة مع الدرجات
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    // إذا كنت تريد علاقة مباشرة مع الكورسات بدون درجات
    public function courses()
    {
        return $this->belongsToMany(Course::class)
                    ->using(Grade::class)
                    ->withPivot('grade', 'term', 'year', 'quality_points')
                    ->withTimestamps();
    }
}
