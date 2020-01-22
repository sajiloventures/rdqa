<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class AdminMenuHelperFacade extends Facade{
    protected static function getFacadeAccessor() { return 'adminMenuHelper'; }
}