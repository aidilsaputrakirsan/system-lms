<?php

namespace App\Services;

use App\Models\Language_Translation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LanguageService
{
    protected $availableLocales = ['id', 'en'];

    public function getAvailableLocales()
    {
        return $this->availableLocales;
    }

    public function getCurrentLocale()
    {
        return App::getLocale();
    }

    public function setLocale($locale)
    {
        if (in_array($locale, $this->availableLocales)) {
            App::setLocale($locale);
            
            if (Auth::check()) {
                Auth::user()->setLanguagePreference($locale);
            }
            
            return true;
        }
        
        return false;
    }

    public function translate($key, $params = [], $locale = null)
    {
        if (!$locale) {
            $locale = $this->getCurrentLocale();
        }
        
        $translation = Language_Translation::where('key', $key)->first();
        
        if ($translation) {
            $text = $locale == 'en' ? $translation->en_translation : $translation->id_translation;
            
            // If translation doesn't exist in requested locale, fall back to the other locale
            if (empty($text)) {
                $text = $locale == 'en' ? $translation->id_translation : $translation->en_translation;
            }
            
            // Replace parameters
            foreach ($params as $paramKey => $paramValue) {
                $text = str_replace(':'.$paramKey, $paramValue, $text);
            }
            
            return $text;
        }
        
        return $key;
    }

    public function exportTranslations($locale)
    {
        $translations = Language_Translation::all()->map(function ($translation) use ($locale) {
            return [
                'key' => $translation->key,
                'translation' => $translation->getTranslation($locale),
                'group' => $translation->group,
            ];
        });
        
        return $translations;
    }

    public function importTranslations($locale, $data)
    {
        $count = 0;
        
        foreach ($data as $item) {
            $translation = Language_Translation::where('key', $item['key'])->first();
            
            if (!$translation) {
                $translation = new Language_Translation();
                $translation->key = $item['key'];
                $translation->group = $item['group'] ?? null;
            }
            
            $translation->updateTranslation($locale, $item['translation']);
            $count++;
        }
        
        return $count;
    }
}