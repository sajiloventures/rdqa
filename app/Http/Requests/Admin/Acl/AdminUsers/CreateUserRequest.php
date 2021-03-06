<?php namespace App\Http\Requests\Admin\Acl\AdminUsers;

use App\Http\Requests\Request;

class CreateUserRequest extends Request {

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
            'email'    => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
            'selected_roles' => 'required',
        ];
    }

}
