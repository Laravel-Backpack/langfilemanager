<?php

namespace Backpack\LangFileManager\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageTextRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            '*' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            '*.required' => trans('backpack::langfilemanager.please_fill_all_fields'),
        ];
    }
}
