<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'class_room_subject');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
