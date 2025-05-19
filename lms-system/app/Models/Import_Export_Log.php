<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import_Export_Log extends Model
{
    use HasFactory;

    protected $table = 'import_export_logs';
    
    protected $fillable = [
        'user_id',
        'file_path',
        'operation_type',
        'status',
        'result_message',
        'records_processed',
        'records_success',
        'records_failed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}