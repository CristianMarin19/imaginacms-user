<?php

namespace Modules\Iuser\Http\Requests;

use Imagina\Icore\Http\Request\CoreFormRequest;
use Illuminate\Contracts\Validation\Validator;

class ResetPasswordCompleteUserRequest extends CoreFormRequest
{
    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8'
        ];
    }

    public function translationRules(): array
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages(): array
    {
        return [];
    }

    public function getValidator(): Validator
    {
        return $this->getValidatorInstance();
    }
}
