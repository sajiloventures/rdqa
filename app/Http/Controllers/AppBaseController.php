<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Route;
use App\User;
use Intervention\Image\ImageManager;
use Session;
use View;
use File;
use Config;
use AppHelper;

abstract class AppBaseController extends Controller
{
    /**
     * Route Prefix
     *
     * @var string
     */
    protected $base_route;

    /**
     * @var translation array path
     */
    protected $trans_path;

    /**
     * Used in pagination in index
     * @var int
     */
    protected $admin_pagination_limit = 10;

    /**
     * Holds language collection
     *
     * @var Collection
     */
    protected $language;

    /**
     * Application default language id
     *
     * @var int
     */
    protected $default_lan_id = 1;

    /**
     * Used to store data to InActive languages
     * taken from default language ie. en (id: 1)
     *
     * @var
     */
    protected $inactive_lang_data;

    /**
     * Used to store key for mapping data
     * stored in diff languages
     *
     * @var
     */
    protected $primary_key;

    /**
     * Used to store Model object
     *
     * @var
     */
    protected $model;

    /**
     * @var string image name
     */
    protected $image = '';

    /**
     *  Used while uploading image
     */
    protected $file_input_field = 'file';

    /**
     * Used by Update Action to store old image
     *
     * @var string
     */
    protected $existing_image = '';

    /**
     * Stores Thumbnail dimensions for uploaded image
     *
     * @var string
     */
    protected $thumbnail_dimensions = '';

    /**
     * @var string random string
     */
    protected $rand = '';

    /**
     * @var string file
     */
    protected $file = '';

    /**
     * @var string final image
     */
    protected $final_image = '';

    /**
     * @var string final image
     */
    protected $imagePath = '';

    /**
     * @var string language flag path
     */
    protected $lang_image_path = 'images/language/';

    /**
     * Stores hierarchy tree data
     *
     * @var array
     */
    protected $hierarchy = [];

    /**
     * Used to store the filed name
     * which is used as parent for hierarchical relations
     *
     * @var
     */
    protected  $parent_is;

    protected $to_replace;

    protected $separator = ' > ';

    public $default_lang_id;

    protected $site_infos;

    protected $is_super_admin_role = true;

    protected $user_type = 'super-admin';

    protected $cart_total_item;

    protected $cart_total_price;

    protected function __construct()
    {
        // Prepare Configurations as Key Value Array
        $this->site_infos = AppHelper::getSiteConfigs();

        if (app()->environment() !== 'production')
            \DB::enableQueryLog();

    }

    /**
     * Assign variables to passed view and
     * return passed view path
     *
     * @param $view_path View to which value is to be assigned
     * @param array $params
     * @return mixed
     */
    protected function loadDefaultVars($view_path, $params = [])
    {
        try {

            View::composer($view_path, function ($view) use ($view_path, $params) {

                //  Make Translation Path from passed View Path
                $view->with('trans_path', $this->trans_path);

                // Make View Path available to view
                $view->with('view_path', AppHelper::getBasePathFromViewPath($view_path, true));
                // Make route prefix available
                $view->with('base_route', $this->base_route);

            });

            return $view_path;

        } catch (\Exception $e) {
            AppHelper::exceptionHandler($e);
        }

    }

    /**
     * Assign passed Array data as variables to view
     *
     * @param $view_path
     * @param $data
     */
    protected function loadCustomVars($view_path, $data)
    {
        try {

            View::composer($view_path, function ($view) use ($data) {
                $view->with('custom_data', $data);
            });

        } catch (\Exception $e) {
            AppHelper::exceptionHandler($e);
        }
    }

    /**
     * Check if data exist on requested Model based on Primary Key field
     *
     * @param $model Model Name
     * @param $pk primary_key value
     * @return bool
     */
    protected function rowExist($model, $pk)
    {
        if ($model::pk($pk)->count() == 0)
            return false;

        return true;
    }

    /**
     * Check if data exist on requested Model based on Id field
     *
     * @param $model
     * @param $id
     * @return bool
     */
    protected function rowExistById($model, $id)
    {
        if ($model::Id($id)->count() == 0)
            return false;

        return true;
    }

    /**
     * Return value by index ($field)
     *
     * @param $data Object or Array
     * @param $field Index of Obect or Array Passed
     * @return mixed
     */
    protected function getValueByKey($data, $field)
    {
        if (is_object($data))
            return isset($data->$field)?$data->$field:'';

        return isset($data[$field])?$data[$field]:'';
    }


    /**
     * Redirects conditions
     *
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToRoute($id = null)
    {
        if (request('save-add')) {
            return redirect()->route($this->base_route . '.create')->send();
        }
        elseif (request('save-edit')) {
            return redirect()->route($this->base_route . '.edit', ['id' => $id])->send();
        }
        return redirect()->route($this->base_route)->send();
        exit;
    }


    /*
   *
   *
   * setting for sites
   *
   * */
    public static function users($type = null, $data = null)
    {
        if($type and $data) {
            return User::where($type, $data)->get();
        }
        return User::all();
    }

    public static function roles($type = null, $data = null)
    {
        if($type and $data) {
            return Role::where($type, $data)->get();
        }
        return Role::all();
    }

    public static function permissions($type = null, $data = null)
    {
        if($type and $data) {
            return Permission::where($type, $data)->get();
        }
        return Permission::all();
    }

    public static function routes($type = null, $data = null)
    {
        if($type and $data) {
            return Route::where($type, $data)->get();
        }
        return Route::all();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function environment()
    {
        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/'.PHP_VERSION],
            ['name' => 'Laravel version',   'value' => app()->version()],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => $_SERVER['SERVER_SOFTWARE']],

            ['name' => 'Cache driver',      'value' => config('cache.default')],
            ['name' => 'Session driver',    'value' => config('session.driver')],
            ['name' => 'Queue driver',      'value' => config('queue.default')],

            ['name' => 'Timezone',          'value' => config('app.timezone')],
            ['name' => 'Locale',            'value' => config('app.locale')],
            ['name' => 'Env',               'value' => config('app.env')],
            ['name' => 'URL',               'value' => config('app.url')],
        ];

        return $envs;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function dependencies()
    {
        $json = file_get_contents(base_path('composer.json'));
        $dependencies = json_decode($json, true)['require'];

        return $dependencies;
    }


}
