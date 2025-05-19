<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'code',
        'description',
        'thumbnail',
        'user_id',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function getInstructor()
    {
        return $this->user;
    }

    public function getStudents()
    {
        return User::whereHas('enrollments', function ($query) {
            $query->where('course_id', $this->id)
                  ->where('status', 'approved');
        })->get();
    }
    
    // Placeholder methods for future implementation
    public function getLessons()
    {
        // To be implemented when Lesson model is created
        return collect();
    }
    
    public function getAssignments()
    {
        // To be implemented when Assignment model is created
        return collect();
    }
    
    public function getPracticalModules()
    {
        // To be implemented when PracticalModule model is created
        return collect();
    }
}