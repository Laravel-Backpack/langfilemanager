<?php

namespace Backpack\LangFileManager\app\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use CrudTrait;

    protected $table = 'languages';

    protected $fillable = ['name', 'flag', 'abbr', 'active', 'default'];

    public $timestamps = false;

    public static function getActiveLanguagesArray()
    {
        $active_languages = self::where('active', 1)->get()->toArray();
        $localizable_languages_array = [];

        if (count($active_languages)) {
            foreach ($active_languages as $key => $lang) {
                $localizable_languages_array[$lang['abbr']] = $lang;
            }

            return $localizable_languages_array;
        }

        return config('laravellocalization.supportedLocales');
    }

    public static function findByAbbr($abbr = false)
    {
        return self::where('abbr', $abbr)->first();
    }
}
