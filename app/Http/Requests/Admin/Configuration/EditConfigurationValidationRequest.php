<?php

namespace App\Http\Requests\Admin\Configuration;

use App\Http\Requests\Request;

class EditConfigurationValidationRequest extends Request
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
        return [
            'option_name'    => 'required|unique:site_info,option_name,'.$this->request->get('id').',id',
        ];
    }
}
