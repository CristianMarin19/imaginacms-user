<?php

namespace Modules\Iuser\Http\Requests;

use Imagina\Icore\Http\Request\CoreFormRequest;
use Illuminate\Contracts\Validation\Validator;

class LoginUserRequest extends CoreFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
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
