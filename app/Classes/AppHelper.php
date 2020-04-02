<?php
namespace App\Classes;

use App\Models\Configuration;
use App\Models\WeightClass;
use Carbon\Carbon;
use Config, Lang, Log, App, AclHelper;
use Route as LaravelRoute;

class AppHelper
{

    protected $site_configs = null;
    /**
     * @var array
     */
    protected $settings;

    /**
     * Holds instance of AdminBaseController
     * @var
     */
    protected $adminBaseController;


    /**
     * Used to store instance of Validation Error
     * @var
     */
    private $error = null;

    public function getAppEnvironment()
    {
        return App::environment();
    }

    public function isProductionEnvironment()
    {
        if ($this->getAppEnvironment() == 'production')
            return true;

        return false;
    }

    /**
     * Process the exception caused by application
     *
     * @param $e
     */
    public function exceptionHandler($e, $message_title = 'Error Message')
    {
        if (self::getAppEnvironment() !== 'production')
            $this->debug($e->getMessage(), 1);
        else {
            Log::error('--------------------------------------------------------------------');
            Log::error($message_title);
            Log::error('--------------------------------------------------------------------');
            Log::error($e->getMessage());
            Log::error('--------------------------------------------------------------------');
            abort(404);
        }
    }

    // TODO: Load Route Not Found Page
    public function routeNotFound()
    {
        dd('Invalid route request made.');
    }

    // TODO: Load Un Authorized Page
    public function unAuthorizedAccess()
    {
        dd('Un Authorized access.');
    }

    // TODO: Load system error Page
    public function systemError($error_code = null, $message = null, $terminate_request = true)
    {
        $error_no = \AppExceptionHandler::generateUniqueErrorNo();

        // Log error for developer
        Log::error(\AppExceptionHandler::prepareMessage(
            $error_no,
            $error_code,
            $message
        ));
    }


    /**
     * Print the passed array
     *
     * @param $array
     * @param bool $die End Script after print
     * @param bool $var_dump
     */
    public function debug($array, $die = false, $var_dump = false)
    {
        echo '<pre>';
        if ($var_dump)
            var_dump($array);
        else
            print_r($array);
        echo '</pre>';
        if ($die)
            die;
    }

    /**
     * Fetch Site Configurations and return changing to Key Value pair
     * @return array
     */
    public function getSiteConfigs()
    {

        $data = Configuration::all();
        $infos = [];
        foreach ($data as $value) {
            $infos[$value->option_name] = $value->option_value;
        }

        return $infos;
    }

    /**
     * @return array
     */
    public function getSettingFromDB()
    {

        /**
         * @var SettingRepository $setting
         */
        $setting = new Configuration();

        $this->settings = $setting->getAllSettings();
        return $this->settings;
    }


    /**
     * Retrieve Strings stored in config folder
     *
     * @param string Array Key
     * @param string Array Key
     * @return string value associated to the passed string
     */
    public function returnRoute($scope, $action)
    {
        return Config::get("rdqa.route." . $scope . "." . $action);
    }

    /**
     * Return current route name
     * @return string
     */
    public function getCurrentRouteName()
    {
        $laravelRoute = LaravelRoute::current();
        return $laravelRoute->getName();
    }

    /**
     * Find Route Prefix
     *
     * @param $prefix
     * @return string
     */
    public function getRoutePrefixName($prefix)
    {
        if ($prefix == null || $prefix == NULL)
            return $prefix;

        if (str_contains($prefix, 'admin'))
            return 'admin';


    }

    /**
     * Make Translation Path from passed View Path
     *
     * @param $view_path View to which value is to be assigned
     * @param bool $with_file_name Must be true if View Path is sent with file name
     * @return string Translation path
     */
    public function getTransPathFromViewPath($view_path, $with_file_name = false)
    {
        return $this->getBasePathFromViewPath($view_path, $with_file_name);
    }

    /**
     * Generates View base path from view file path
     *
     * @param $view_path View to which value is to be assigned
     * @param bool $with_file_name Must be true if View Path is sent with file name
     * @return string View base path
     */
    public function getBasePathFromViewPath($view_path, $with_file_name = false)
    {
        $path_arr = explode('.', $view_path);

        // Remove Last value which MUST be view file name
        if ($with_file_name)
            array_pop($path_arr);

        // Map the Translation directory
        return implode('/', $path_arr) . '/';
    }

    /**
     * Returns file name form View path passed
     *
     * @param $view_path String View Path
     * @return mixed
     */
    public function getFileNameFormViewPath($view_path)
    {
        $path_arr = explode('.', $view_path);
        return last($path_arr);
    }

    /**
     * Handle If required config setting are missing
     *
     * @param array $config_data
     * @param $key
     * @param string $app_section
     * @return mixed
     */
    public function getConfigValueOrDie($config_data = [], $key = '', $app_section = 'admin')
    {
        if (!$config_data || empty($config_data))
            $this->error = 'APP_CONFIG_EMPTY';

        if (!array_key_exists($key, $config_data))
            $this->error = 'APP_CONFIG_KEY_NOT_EXIST';

        if ($this->error !== null) {
            $message = Lang::get($app_section . '/errors.general.' . $this->error, ['key' => $key], 'en');
            Log::notice($message);
            abort(404, $message);
        }

        return $config_data[$key];
    }

    /**
     * Search for config value in database
     * if not exists search in config value
     * else returns false
     *
     * @param string $key
     * @return bool
     */
    public function getConfigValue($key = null)
    {
        if (!$key || $key == '')
            return false;

        if (!$this->site_configs)
            $this->setSiteConfigValues();

        if (!is_null($this->site_configs) && array_key_exists($key, $this->site_configs))
            return $this->site_configs[$key];

        if (array_key_exists($key, config('rdqa.site-configuration-keys')))
            return config('rdqa.site-configuration-keys')[$key];

        return false;
    }

    /**
     * Set site configuration value as array to
     * class property
     */
    private function setSiteConfigValues()
    {
        $site_info = Configuration::select('option_name', 'option_value')->where('status', 1)->get()->toArray();
        foreach ($site_info as $value) {
            $this->site_configs[$value['option_name']] = $value['option_value'];
        }
    }

    /*
     * Return current timestamp based on server timezone
     */
    public function getCurrentTimestamp()
    {
        return strtotime(Carbon::now());
    }

    public function getUserCode()
    {
        if (auth()->check()) {
            return substr(auth()->user()->first_name, 0, 1).substr(auth()->user()->middle_name, 0, 1).substr(auth()->user()->last_name, 0, 1);
        }

        return '';
    }


    public function getValueOrNa($data)
    {
        return $data ? $data : 'N/A';
    }

    /**
     * Cast Array to Object
     */
    public function arrayToObject($array)
    {
        if (!is_array($array)) {
            return $array;
        }

        $object = new \stdClass();
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $name => $value) {
                $name = strtolower(trim($name));
                if (!empty($name)) {
                    $object->$name = self::arrayToObject($value);
                }
            }
            return $object;
        } else {
            return FALSE;
        }
    }

    /**
     * check and verify data and key for breakage.
     * @param null $data
     * @param null $key
     * @param null $returnType
     * @return null
     */
    public function getValueByKey($data = null, $key = null, $returnType = null)
    {
        if (is_array($data)) {
            return isset($data[$key]) && !empty($data[$key]) ? $data[$key] : $returnType;
        } elseif (is_object($data)) {
            return property_exists($data, $key) && !empty($data->$key) ? $data->$key : $returnType;
        }

        return $returnType;
    }

    /**
     * generate random string for testing in act tab
     *
     * @param int $length
     * @return string
     */
    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Make a folder if not exist
     * @param $path
     */
    public function makeFolderIfNotExist($path)
    {
        if (!file_exists($path)) {
            // create folder
            mkdir($path, 0775, true);
        }
    }

    public function getImageData($file, $find)
    {
        switch ($find) {
            case 'name':
                $image_name = $file->getClientOriginalName();
                $tmp = explode('.', $image_name);
                array_pop($tmp);
                return implode('.', $tmp);
                break;
        }
    }

    public function makeImageName($file)
    {
        return self::getImageData($file, 'name') . '_' . self::generateRandomString(5) . '.' . $file->getClientOriginalExtension();
    }

    public function validateDateFormat($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * create new filename for image
     * @param $prefix
     * return random file name
     */
    public function createImageRandomName($prefix = null)
    {
        return $prefix . self::generateRandomString(5);
    }



    public function getErrorCode($error_type)
    {
        return config('rdqa.error-codes.' . $error_type);
    }

    /**
     * @param null $key
     * @param null $default
     * @return array|string
     */
    public function getSetting($key = null, $default = null)
    {
        if ($this->settings === null) {
            $this->settings = $this->getSettingFromDB();
        }


        if ($key === null) {
            return $this->settings;
        }

        if (isset($this->settings[$key]) && $this->settings[$key]) {
            return $this->settings[$key];
        }

        return $default;
    }

    public function getUserRoles()
    {
        if (in_array(AclHelper::getUsersTypeKey('super-admin'), AclHelper::getUserRoles(), 1)
            || in_array(AclHelper::getUsersTypeKey('rdqa-admin'), AclHelper::getUserRoles(), 1)) {
            return [
                'rdqa-admin' => 'RDQA admin',
                'province-user' => 'Province user',
                'district-user' => 'District user',
                'palika-user' => 'Palika user',
                'facility-user' => 'Facility user'
            ];
        }

        if (in_array(AclHelper::getUsersTypeKey('province-user'), AclHelper::getUserRoles(), 1)) {
            return [
                'district-user' => 'District user',
                'palika-user' => 'Palika user',
                'facility-user' => 'Facility user'
            ];
        }

        if (in_array(AclHelper::getUsersTypeKey('district-user'), AclHelper::getUserRoles(), 1)) {
            return [
                'palika-user' => 'Palika user',
                'facility-user' => 'Facility user'
            ];
        }

        if (in_array(AclHelper::getUsersTypeKey('palika-user'), AclHelper::getUserRoles(), 1))
            return [
                'facility-user' => 'Facility user'
            ];

        return [];

    }


    public function getExcludedRoles()
    {
        $excluded = config('rdqa.excluded-roles');


        if (in_array(AclHelper::getUsersTypeKey('rdqa-admin'), AclHelper::getUserRoles(), 1)) {
            array_push($excluded, 'super-admin');
        }

        if (in_array(AclHelper::getUsersTypeKey('province-user'), AclHelper::getUserRoles(), 1)) {
            array_push($excluded, 'super-admin');
            array_push($excluded, 'rdqa-admin');
            array_push($excluded, 'province-user');
        }

        if (in_array(AclHelper::getUsersTypeKey('district-user'), AclHelper::getUserRoles(), 1)) {
            array_push($excluded, 'super-admin');
            array_push($excluded, 'rdqa-admin');
            array_push($excluded, 'province-user');
            array_push($excluded, 'district-user');
        }

        if (in_array(AclHelper::getUsersTypeKey('palika-user'), AclHelper::getUserRoles(), 1)) {
            array_push($excluded, 'super-admin');
            array_push($excluded, 'rdqa-admin');
            array_push($excluded, 'province-user');
            array_push($excluded, 'district-user');
            array_push($excluded, 'palika-user');
        }

        if (in_array(AclHelper::getUsersTypeKey('facility-user'), AclHelper::getUserRoles(), 1)) {
            array_push($excluded, 'super-admin');
            array_push($excluded, 'rdqa-admin');
            array_push($excluded, 'province-user');
            array_push($excluded, 'district-user');
            array_push($excluded, 'palika-user');
            array_push($excluded, 'facility-user');
        }

        return $excluded;

    }

    public function getInputs($fieldName, $type = 'yes-no', $placeHolder = '', $other_attributes = '', $value = null)
    {
        switch ($type)
        {
            case 'yes-no':
                $inputField = '<select name="' . $fieldName . '"' . $other_attributes . ' class="form-control yesNoCheck" required>' .
                    '<option value=""></option>' .
                    '<option value="yes" ' . (($value && $value == 1) ? 'selected' : null) . '>छ</option>' .
                    '<option value="no" ' . (($value !== null && $value == 0) ? 'selected' : null) . '>छैन</option>' .
                    '</select>';

                break;
            case 'yes-no-partly':
                $inputField = '<select name="' . $fieldName . '"' . $other_attributes . ' class="form-control yesNoPartlyCheck" required>' .
                    '<option value=""></option>' .
                    '<option value="3" ' . (($value && $value == 3) ? 'selected' : null) . '>Yes - completely</option>' .
                    '<option value="2" ' . (($value && $value == 2) ? 'selected' : null) . '>Partly</option>' .
                    '<option value="1" ' . (($value && $value == 1) ? 'selected' : null) . '>No - not at all</option>' .
                    '<option value="0" ' . (($value !== null && $value == 0) ? 'selected' : null) . '>N/A</option>' .
                    '</select>';
                break;
            case 'number':
                $inputField = '<input type="number" min="0" name="' . $fieldName . '" placeholder="' . $placeHolder . '"' . $other_attributes . ($value ? ' value="' . $value . '"' : null) . ' class="form-control" required>';
                break;
            default:
                $inputField = '<input type="text" name="' . $fieldName . '" placeholder="' . $placeHolder . '"' . $other_attributes . ($value ? ' value="' . $value . '"' : null) . ' class="form-control">';
                break;
        }
        return $inputField;
    }

    public function getPercentage($numerator = 0, $denominator = 0, $round = 2, $percentage = true)
    {
        if ($numerator == 0 || $denominator == 0)
            return 0;

        return $percentage ? (round($numerator / $denominator, ($round + 2)) * 100) : round($numerator / $denominator, $round);

    }

    public function getSystemAssessmentColor($value = 0)
    {
        if ($value >= 2.5)
            $color = '#24c524b3';
        else if ($value < 1.5)
            $color = '#f06c6c';
        else
            $color = 'yellow';

        return $color;

    }

    public function getBuildStage($stage = 'step-1')
    {
        if ($stage == 'step-4')
            return '<i class="fa fa-fw fa-check text-success"></i>';

        $stage = explode('-', $stage);
        if (count($stage) > 1)
            $stage[1] = (int) $stage[1] - 1;

        $stage = join(' ', $stage);

        return str_replace('step', 'Part', $stage);
    }

    public function replaceCodeInText($text, $replaceBy = null)
    {
        if ($replaceBy)
            $text = str_replace('[code]', $replaceBy, $text);

        return $text;
    }

    public function addNewLineInText($text, $length = 20)
    {
        $text = explode('-', $text);
        $text = join(' - ', $text);
        return wordwrap($text,$length,'\n');
    }
}