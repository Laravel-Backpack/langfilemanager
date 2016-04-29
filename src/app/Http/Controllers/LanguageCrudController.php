<?php

namespace Backpack\LangFileManager\app\Http\Controllers;

use App\Http\Requests;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\LangFileManager\app\Http\Requests\LanguageRequest as StoreRequest;
use Backpack\LangFileManager\app\Http\Requests\LanguageRequest as UpdateRequest;
use Backpack\LangFileManager\app\Models\Language;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\LangFileManager\app\Services\LangFiles;
use Illuminate\Http\Request;

class LanguageCrudController extends CrudController
{
    public $crud = [
                        'model'              => "Backpack\LangFileManager\app\Models\Language",
                        'entity_name'        => 'language',
                        'entity_name_plural' => 'languages',
                        'route'              => 'admin/language',

                        // *****
                        // COLUMNS
                        // *****
                        //
                        // Define the columns for the table view as an array:
                        //
                        'columns' => [
                                            [
                                                'name'  => 'name',
                                                'label' => 'Language name',
                                            ],
                                            [
                                                'name'  => 'active',
                                                'label' => 'Active',
                                                'type'  => 'boolean',
                                            ],
                                            [
                                                'name'  => 'default',
                                                'label' => 'Default',
                                                'type'  => 'boolean',
                                            ],
                                    ],
                        'fields' => [
                                        [
                                            'name'  => 'name',
                                            'label' => 'Language Name',
                                            'type'  => 'text',
                                        ],
                                        [
                                            'name'  => 'abbr',
                                            'label' => 'Code (ISO 639-1)',
                                            'type'  => 'text',
                                        ],
                                        [
                                            'name'  => 'flag',
                                            'label' => 'Flag image',
                                            'type'  => 'browse',
                                        ],
                                        [
                                            'name'  => 'active',
                                            'label' => 'Active',
                                            'type'  => 'checkbox',
                                        ],
                                        [
                                            'name'  => 'default',
                                            'label' => 'Default',
                                            'type'  => 'checkbox',
                                        ],
                                    ],

                        ];

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }

    public function showTexts(LangFiles $langfile, Language $languages, $lang = '', $file = 'site')
    {
        // SECURITY
        // check if that file isn't forbidden in the config file
        if (in_array($file, config('langfilemanager.language_ignore'))) {
            abort('403', 'This language file cannot be edited online.');
        }

        if ($lang) {
            $langfile->setLanguage($lang);
        }

        $langfile->setFile($file);

        $this->data['currentFile'] = $file;
        $this->data['currentLang'] = $lang ?: config('app.locale');
        $this->data['currentLangObj'] = Language::where('abbr', '=', $this->data['currentLang'])->first();
        $this->data['browsingLangObj'] = Language::where('abbr', '=', config('app.locale'))->first();
        $this->data['languages'] = $languages->orderBy('name')->get();
        $this->data['langFiles'] = $langfile->getlangFiles();
        $this->data['fileArray'] = $langfile->getFileContent();
        $this->data['langfile'] = $langfile;
        $this->data['title'] = 'Translations';

        return view('langfilemanager::translations', $this->data);
    }

    public function updateTexts(LangFiles $langfile, Request $request, $lang = '', $file = 'site')
    {
        // SECURITY
        // check if that file isn't forbidden in the config file
        if (in_array($file, config('langfilemanager.language_ignore'))) {
            abort('403', 'This language file cannot be edited online.');
        }

        $message = trans('error.error_general');
        $status = false;

        if ($lang) {
            $langfile->setLanguage($lang);
        }

        $langfile->setFile($file);

        $fields = $langfile->testFields($request->all());
        if (empty($fields)) {
            if ($langfile->setFileContent($request->all())) {
                \Alert::success('Saved')->flash();
                $status = true;
            }
        } else {
            $message = trans('admin.language.fields_required');
            \Alert::error('Please fill all fields')->flash();
        }

        return redirect()->back();
    }
}
