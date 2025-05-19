<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language_Translation extends Model
{
    use HasFactory;

    protected $table = 'language_translations';
    
    protected $fillable = [
        'key',
        'en_translation',
        'id_translation',
        'group',
    ];

    public function getTranslation($locale)
    {
        return $locale == 'en' ? $this->en_translation : $this->id_translation;
    }

    public function updateTranslation($locale, $value)
    {
        if ($locale == 'en') {
            $this->en_translation = $value;
        } else {
            $this->id_translation = $value;
        }
        
        $this->save();
    }
}