<?php
namespace App\Classes;

use App\Models\Menu;
use App\Models\Menu_Page;
use DateTime;
use Request;

class AdminMenuHelper
{
    private $menu_config    = [];
    private $is_menu_active = false;

    /**
     * Render Admin Panel Menu HTML based on Menu Config Array
     * Menu Core Config may be standalone config located at config dir
     * or packages / plugins may merge their config with Core Config
     * at app boot time
     *
     */
    public function getMenu()
    {
        $menu_config = self::mergeCoreAndExternalMenus(config('rdqa-adminpanel-menu'));
        $menu_config = self::sortMenu($menu_config);
        return view('admin.partials._adminpanel_menu', compact('menu_config'))->render();
    }

    /**
     * Merge any external menu configurations with core menu configuration
     *
     * @param $menu_config
     * @return array
     */
    public function mergeCoreAndExternalMenus($menu_config)
    {
        if (!self::menusExists($menu_config, 1)) {
            return [];
        }

        $menu_config_tmp = $menu_config;
        // External Menu Config will be appended to Core Menu Configs
        $external_menus     = array_except($menu_config, 'ul');
        $external_menus_tmp = $external_menus;

        foreach ($menu_config_tmp['ul']['li'] as $lvl_one_key => $lvl_one_menu) {

            foreach ($external_menus_tmp as $ext_menu_key_lvl_one => $menu_lvl_one) {
                if (self::isExternalMenuValid($menu_lvl_one)) {

                    if ($menu_lvl_one['level'] === 1) {

                        $menu_config['ul']['li'] = array_merge_recursive($menu_config['ul']['li'], $menu_lvl_one['menu']);

                        array_forget($external_menus, $ext_menu_key_lvl_one);
                        $external_menus_tmp = $external_menus;

                    }

                }
            }

            if (self::menusExists($lvl_one_menu, 2)) {

                foreach ($lvl_one_menu['sub_menu']['ul']['li'] as $lvl_two_key => $lvl_two_menu) {

                    foreach ($external_menus_tmp as $ext_menu_key_lvl_two => $menu_lvl_two) {
                        if (self::isExternalMenuValid($menu_lvl_two)) {

                            if ($menu_lvl_two['level'] === 2 && $menu_lvl_two['parent'] == $lvl_one_key) {

                                $menu_config['ul']['li'][$lvl_one_key]['sub_menu']['ul']['li'] = array_merge_recursive(
                                    $menu_config['ul']['li'][$lvl_one_key]['sub_menu']['ul']['li'],
                                    $menu_lvl_two['menu']
                                );

                                array_forget($external_menus, $ext_menu_key_lvl_two);
                                $external_menus_tmp = $external_menus;

                            }

                        }
                    }

                    if (self::menusExists($lvl_two_menu, 3)) {

                        foreach ($lvl_two_menu['sub_menu']['ul']['li'] as $lvl_three_key => $lvl_three_menu) {

                            foreach ($external_menus_tmp as $ext_menu_key_lvl_three => $menu_lvl_three) {
                                if (self::isExternalMenuValid($menu_lvl_three)) {

                                    if ($menu_lvl_three['level'] == 3 && $menu_lvl_three['parent'] == $lvl_two_key) {

                                        $menu_config['ul']['li'][$lvl_one_key]['sub_menu']['ul']['li'][$lvl_two_key]['sub_menu']['ul']['li'] = array_merge_recursive(
                                            $menu_config['ul']['li'][$lvl_one_key]['sub_menu']['ul']['li'][$lvl_two_key]['sub_menu']['ul']['li'],
                                            $menu_lvl_three['menu']
                                        );

                                        array_forget($external_menus, $ext_menu_key_lvl_three);
                                        $external_menus_tmp = $external_menus;

                                    }

                                }
                            }

                        }
                    }

                }

            }

        }

        return array_only($menu_config, 'ul');

    }

    public function isExternalMenuValid($menu_config)
    {
        if (array_key_exists('level', $menu_config)
            && is_integer($menu_config['level'])
            && array_key_exists('parent', $menu_config)
            && !is_array($menu_config['parent'])
            && !is_object($menu_config['parent'])
            && array_key_exists('menu', $menu_config)
            && is_array($menu_config['menu'])) {
            return 'true';
        }

        return false;

    }

    /**
     * Sorts Multi-dimensional admin panel menu array till nth level
     *
     * @param $menu_config Menu Config Array
     * @return mixed
     */
    public function sortMenu(&$menu_config)
    {
        if (!empty($menu_config) && array_key_exists('ul', $menu_config) && array_key_exists('li', $menu_config['ul'])) {

            foreach ($menu_config['ul']['li'] as $menu) {

                if (!empty($menu)
                    && array_key_exists('sub_menu', $menu)
                    && array_key_exists('ul', $menu['sub_menu'])
                    && array_key_exists('li', $menu['sub_menu']['ul'])
                    && !empty($menu['sub_menu']['ul']['li'])
                ) {

                    self::sortMenu($menu['sub_menu']);

                }

                uasort(/**
                 * @param $a
                 * @param $b
                 * @return int
                 */
                    $menu_config['ul']['li'], function ($a, $b) {

                    if ($a['display_order'] === $b['display_order']) {
                        return 0;
                    } else {
                        return ($a['display_order'] < $b['display_order']) ? -1 : 1;
                    }

                });

            }

        }

        return $menu_config;
    }

    /**
     * Check Admin Panel Menu Level
     *
     * @param $menu_config Admin Menu Config Array
     * @param $menu_level
     * @return bool
     */
    public function menusExists($menu_config, $menu_level)
    {
        switch ($menu_level) {
            case 1:
                if (!empty($menu_config) && array_key_exists('ul', $menu_config) && array_key_exists('li', $menu_config['ul'])) {
                    return true;
                }

                break;
            case 2:
            case 3:
                if (array_key_exists('sub_menu', $menu_config)
                    && !empty($menu_config['sub_menu'])
                    && array_key_exists('ul', $menu_config['sub_menu'])
                    && array_key_exists('li', $menu_config['sub_menu']['ul'])) {
                    return true;
                }

                break;
            default:
                return false;
        }

    }

    /**
     * Check if Menu must pass through diff verifications
     * Process ACL / Administrative Access operation for passed Menu
     * return "true" if menu is accessible by current user
     * else return "false" if menu is not accessible by current user
     *
     * @param $menu_config Admin Menu Config Array
     * @return bool
     */
    public function isMenuAccessible($menu_config)
    {
        if (!auth()->check()) {
            return false;
        }

        $can_access = true;

        if (isset($menu_config['sub_menu'])) {
            foreach ($menu_config['sub_menu']['ul']['li'] as $menu) {
                if (array_key_exists('acl_auth', $menu)) {
                    foreach ($menu['acl_auth'] as $route) {
                        if (!\AclHelper::isRouteAccessable($route)) {
                            $can_access = false;
                        }
                    }
                }
                return $can_access;


            }
        }
        if($menu_config['acl_auth'] == 'logout'|| $menu_config['acl_auth'] == 'dashboard'){
            return true;
        }
        // dd($menu_config);
        if($menu_config['acl_auth'] != 'none'){
            if (array_key_exists('acl_auth', $menu_config)) {

                $acl_access_routes = $menu_config['acl_auth'];
                foreach ($acl_access_routes as $route) {
                    // Access fails if any route is un-accessible
                    if (!$can_access) {
                        continue;
                    }

                    if (!\AclHelper::isRouteAccessable($route)) {
                        $can_access = false;
                    }

                }
            }

        }

        if ($can_access && array_key_exists('need_administrative_access', $menu_config) && $menu_config['need_administrative_access'] === true) {
            if (!\AclHelper::hasAdministrativeAccess()) {
                $can_access = false;
            }

        }

        if ($can_access && self::shouldHideMenu($menu_config)) {
            $can_access = false;
        }


        return $can_access;
    }

    public function shouldHideMenu($menu_config)
    {
        if (array_key_exists('acl_conditional_menu', $menu_config)) {
            if (!config('rdqa.show-acl')) {
                return true;
            }

        }

        return false;
    }

    /**
     * Check if Url Pattern Array values match current url
     *
     * @param $menu_config Admin Menu Config Array
     * @param $url_array_key Array index for Url patterns to check
     * @return bool
     */
    public function activateMenu($menu_config, $url_array_key)
    {
        $is_active = false;
        if (array_key_exists($url_array_key, $menu_config)) {
            $menu_activation_urls = $menu_config[$url_array_key];
            foreach ($menu_activation_urls as $url_pattern) {
                // Activate menu if any of the url pattern matches current URL
                if ($is_active) {
                    continue;
                }

                if (Request::is($url_pattern)) {
                    $is_active = true;
                }

            }
        }

        if ($is_active) {
            $this->is_menu_active = true;
        }

    }

    public function getLiClass($menu_config)
    {
        $class_attr = " class='";
        if ((array_key_exists('additional_attr', $menu_config) && array_key_exists('class', $menu_config['additional_attr']))) {

            $class_attr .= $menu_config['additional_attr']['class'];
        }

        $is_active = false;
        if (array_key_exists('active_if_request_is', $menu_config)) {
            $menu_activation_urls = $menu_config['active_if_request_is'];
            foreach ($menu_activation_urls as $url_pattern) {
                // Activate menu if any of the url pattern matches current URL
                if ($is_active) {
                    continue;
                }
                if (Request::is($url_pattern)) {
                    $is_active = true;
                }

            }
        }

        if ($is_active) {
            $class_attr .= " " . 'active ';
        }

        $class_attr .= "'";

        echo $class_attr;

    }

    public function getLiStyle($menu_config)
    {
        if ((array_key_exists('additional_attr', $menu_config) && array_key_exists('style', $menu_config['additional_attr']))) {
            echo " style='" . $menu_config['additional_attr']['style'] . "' ";
        }

    }

    public function getMenuClass($menu_config)
    {
        $classAttr = '';
        $is_active = false;
        if (array_key_exists('active_if_request_is', $menu_config)) {
            $menu_activation_urls = $menu_config['active_if_request_is'];
            foreach ($menu_activation_urls as $url_pattern) {
                // Activate menu if any of the url pattern matches current URL
                if ($is_active) {
                    continue;
                }
                if (Request::is($url_pattern)) {
                    $is_active = true;
                }

            }
        }

        $colorClass = ($is_active) ? 'txt-color-blue' : '';

        if (array_key_exists('additional_attr', $menu_config['a']) && isset($menu_config['a']['additional_attr']['class'])) {
            $classAttr = " class='" . $menu_config['a']['additional_attr']['class'] . " " . $colorClass . "' ";
        }

        // adding extra attributes in menu if exist
        if (array_key_exists('additional_attr', $menu_config['a'])) {
            foreach ($menu_config['a']['additional_attr'] as $key => $value) {
                if ($key != 'class' && $key != 'style')
                    $classAttr .= " " . $key . "='" . $value . "'";
            }
        }

        echo $classAttr;

    }

    public function getMenuUrl($menu_config)
    {
        $url = '#';
        if (array_key_exists('route', $menu_config['a']) && $menu_config['a']['route'] !== '#') {

            $routes = \Route::getRoutes();
            foreach ($routes as $route) {

                if ($route->getName() == $menu_config['a']['route']) {
                    $url = route($menu_config['a']['route']);
                    break;
                }

            }

            echo $url;

        } else {
            echo $url;
        }

    }

    public function getMenuContent($menu_config)
    {
        if (array_key_exists('content', $menu_config['a'])) {
            echo $menu_config['a']['content'];
        } else {
            '';
        }

    }

    public function getMenuIcon($menu_config)
    {
        if (array_key_exists('icon', $menu_config['a'])) {
            echo $menu_config['a']['icon'];
        } else {
            '';
        }

    }


    public function getParentPageMenu($id)
    {
        return Menu::find($id)->menupages;

    }

    public function getChildPageMenu($id, $pageID)
    {
        $chmenus = Menu_Page::where('menu_id',$id)->where('parent_id',$pageID)->get();
        return $chmenus;

    }

}
