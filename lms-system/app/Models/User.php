<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'student_staff_number',
        'profile_photo',
        'language_preference',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['admin', 'instructor']) || $this->hasPermissionTo('access_admin_panel');
    }
    
    public function importExportLogs()
    {
        return $this->hasMany(Import_Export_Log::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withPivot('status', 'enrolled_at')
                    ->withTimestamps();
    }

    public function getSubmissions()
    {
        // To be implemented when Submission model is created
    }

    public function importFromExcel()
    {
        // Implementation will come later
    }

    public function exportToExcel()
    {
        // Implementation will come later
    }

    public function setLanguagePreference($locale)
    {
        $this->language_preference = $locale;
        $this->save();
    }
}