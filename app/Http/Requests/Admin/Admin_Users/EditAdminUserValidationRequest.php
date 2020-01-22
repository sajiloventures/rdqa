<?php

namespace App\Http\Requests\Admin\Admin_Users;

use App\Http\Requests\Request;
use App\User;

class EditAdminUserValidationRequest extends Request
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
        $id = \Route::current()->parameters()['userId'];

        if($user = User::find($id))
            $id = $user->id;

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'user_role' => 'required',
            'username' => 'unique:users,username,' . $id,
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

        if ($this->request->get('password'))
            $rules += ['password' => 'confirmed|min:6'];

        return $rules;
    }
}
