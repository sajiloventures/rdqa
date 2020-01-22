<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\AdminBaseController;
use Image, File, Log, AppHelper as AppHelper1;

class AdminUsersBaseController extends AdminBaseController
{

    public function redirectPath()
    {
        if(auth()->check()) {
            return redirect(\AppHelper::getRedirectPathByRole());
        } else
            return redirect('/login');
    }
}
