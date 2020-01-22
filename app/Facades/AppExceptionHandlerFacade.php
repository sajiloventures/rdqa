<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class AppExceptionHandlerFacade extends Facade{
    protected static function getFacadeAccessor() { return 'appExceptionHandler'; }
}