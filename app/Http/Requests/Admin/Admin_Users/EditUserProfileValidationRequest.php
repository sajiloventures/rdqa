<?php

namespace App\Http\Requests\Admin\Admin_Users;

use App\Http\Requests\Request;
use App\User;

class EditUserProfileValidationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
        ];
        if ($this->request->get('password'))
            $rules += ['password' => 'confirmed|min:6'];

        return $rules;
    }
}
