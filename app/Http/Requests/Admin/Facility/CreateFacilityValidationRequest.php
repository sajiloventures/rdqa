<?php

namespace App\Http\Requests\Admin\Facility;

use App\Http\Requests\Request;

class CreateFacilityValidationRequest extends Request
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
            'province_name' => 'required',
            'district_name' => 'required',
            'palika_name' => 'required',
            'hf_name' => 'required',
        ];

    }
}
