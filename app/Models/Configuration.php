<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use AppHelper;
use Auth;

class Configuration extends Model
{


    protected $table = 'settings';
    /**
     * @var array
     */
    protected $fillable = ['option_name', 'option_value', 'remarks', 'status'];

    protected $username;

    // Constructor
    public function __construct(array $attributes = [])
    {
        // pass construct params to Parent Model
        parent::__construct($attributes);

        if(auth()->check()){
            $this->username = Auth::user()->username;
        }
    }


    /**
     * @return bool
     */
    public function isAddableBy()
    {
        // Protect the root user from editing
        if ('root' == $this->username) {
            return true;
        }

        // Otherwise
        return false;
    }


    /**
     * @return bool
     */
    public function isEditableBy()
    {
        // Protect the root user from editing
        if ('root' == $this->username) {
            return true;
        }

        // Otherwise
        return false;
    }

    /**
     * @return bool
     */
    public function isDeletableBy()
    {
        // Protect the root user from deletion.
        if ('root' == $this->username) {
            return true;
        }

        // Otherwise
        return false;
    }



    /**
     * @return array
     */
    public function getAllSettings()
    {
        $settings = Configuration::get(['option_name', 'option_value']);

        return $settings->pluck('option_value', 'option_name')->toArray();
    }
    /**
     * @param $settingKey
     * @return mixed
     */
    public function getSetting($settingKey)
    {
        $setting = Configuration::where(['option_name' => $settingKey])
            ->select(['id', 'option_name', 'option_value'])
            ->first();
        if ($setting) {
            return $setting->option_value;
        }
        return null;
    }



}
