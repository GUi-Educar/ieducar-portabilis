<?php

namespace App\Http\Requests\Api\Resource\School;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResourceSchoolRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'institution' => ['required','integer','min:1']
        ];
    }

    public function attributes()
    {
        return [
            'institution' => 'Instituição'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['data'=>[]]));
    }
}
