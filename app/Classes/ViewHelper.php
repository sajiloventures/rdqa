<?php
namespace App\Classes;

use App\Models\Configuration;
use App\User;

class ViewHelper
{

    /**
     * Used to store instance of Validation Error
     * @var
     */
    private $errors;


    /**
     * Check if passed form validation error exist
     *
     * @param $errors
     * @param $field_name
     * @return bool
     */
    public function hasValidationError($errors, $field_name)
    {
        if ($errors->first($field_name))
            return true;
        return false;
    }

    /**
     * Finds the validation error if exist and returns the message
     *
     * @param $errors Validation Error Instance
     * @param $field_name Field Name to be checked for error
     */
    public function showValidationError($errors, $field_name)
    {
        if (ViewHelper::hasValidationError($errors, $field_name))
            echo "<em id='$field_name-error' class='help-block'>" . $errors->first($field_name) . "</em>";
        echo '';
    }


    /**
     * @param $select_name Select Drop Down Name
     * @param $option_value_to_match Value in Drop Down loop to be checked
     * @param $old_value Value to be matched if request is from edit form
     * @return string
     */
    public function checkSelectOption($select_name, $option_value_to_match, $old_value = null)
    {
        if (old($select_name))
            return old($select_name) == $option_value_to_match ? 'selected="selected"' : '';

        elseif (!is_null($old_value))
            return $old_value == $option_value_to_match ? 'selected="selected"' : '';

        else
            return '';
    }

    /**
     * @param $name Form element name
     * @param string $old_value Value to be showed
     * @return mixed
     */
    public function getFormValue($name, $old_value = '')
    {
        if (old($name))
            return old($name);
        else
            return $old_value;
    }

    public function getImageUrl($path)
    {
        return asset(config('rdqa.asset_path.frontend.images').$path);
    }

    public function getDefaultImageUrl($type)
    {
        return asset(config('rdqa.asset_path.default_'.$type.'_image'));
    }

    public function userHaveRole(User $user, $role_name)
    {
        foreach ($user->roles as $item) {
            if ($item->name == 'users')
                continue;

            if ($item->name == $role_name)
                return true;

            return false;
        }
    }

    public function getRolesExceptUserRole($data)
    {
        $tmp = '';
        foreach ($data as $item) {
            if ($item->name == 'users')
                continue;
            if ($tmp == '')
                $tmp = $item->name;
            else
                $tmp .= ' | ' . $item->name;
        }

        return $tmp;
    }

    //function that gets embedded id of youtube video url
    // this id is used to get video thumbnail image from image.
    //used in event detail page video slider
    public function toEmbedYouTubeVideo($url)
    {
        // check whether the given link is valid youtube link or not
        if (strpos($url, 'youtu') || strpos($url, 'ytimg')) {
            if (stristr($url, 'youtu.be/')) {
                preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID);
                return $final_ID[4];
            } else {
                @preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD);
                return $IDD[5];
            }
        } else {
            return false;
        }
    }

}