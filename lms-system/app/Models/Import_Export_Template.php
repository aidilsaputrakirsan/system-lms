<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import_Export_Template extends Model
{
    use HasFactory;

    protected $table = 'import_export_templates';
    
    protected $fillable = [
        'name',
        'file_path',
        'type',
        'description',
    ];
}