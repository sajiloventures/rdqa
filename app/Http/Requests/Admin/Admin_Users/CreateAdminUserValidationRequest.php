<?php

namespace App\Http\Requests\Admin\Admin_Users;

use AclHelper;
use App\Http\Requests\Request;

class CreateAdminUserValidationRequest extends Request
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
            'email' => 'required|email|unique:users',
            'username' => 'unique:users',
            'user_role' => 'required',
            'password' => 'required|confirmed|min:6',
        ];


        if (!($this->request->get('user_role') == 'super-admin' || $this->request->get('user_role') == 'rdqa-admin')){

            $rules += [
                'province' => 'required',
              
            ];

            if($this->request->get('user_role') == 'district-user'){
               $rules += [
                'district' => 'required',
              
            ]; 
            
            }
            elseif($this->request->get('user_role') == 'palika-user'){
               $rules += [
                
                'district' => 'required',
                'municipality' => 'required',
              
            ]; 
            
            }
            elseif($this->request->get('user_role') == 'facility-user'){
               $rules += [
                'district' => 'required',
                'municipality' => 'required',
                'health_post_name' => 'required',
              
            ]; 
            
            }




        }


        return $rules;

    }
}
