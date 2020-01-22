<?php
namespace App\Classes;

use App\Models\Route as AppRoute;
use App\User;
use Auth;
use Illuminate\Database\Eloquent\Collection;

class AclHelper {

    /**
     * @var User Instance
     */
    private $user;

    /**
     * @var Route Instance
     */
    private $route;

    /**
     * @var List of Roles
     */
    private $user_roles = null;


    /**
     * Check if the route name pattern is matching
     *
     * @param $pattern url pattern
     * @return bool
     */
    public function isPathPatternAccessable($pattern)
    {
        // list all the routes matching the route name pattern
        $this->route = $this->getRouteByPathPattern($pattern);

        // Check for a valid route pattern
        if ($this->route !== false) {
            foreach ($this->route as $route) {
                // if any one of Route is accessable then return "true"
                if ( $this->isRouteAccessable($route->name) )
                    return true;
            }
        }

        // Managed to reach here means
        // this path pattern is un-accessable
        return false;
    }

    /**
     * Check if this route is accessible by the user
     *
     * @param $route Route to be checked
     * @param bool|true $authenticate
     * @return bool
     */
    public function isRouteAccessable($route, $authenticate = true)
    {
        if (!$authenticate)
            return true;

        $this->route = $this->getRouteByName($route);

        if (Auth::check()) {

            // check if User model already exist
            if(!$this->user)
                $this->user = User::find(Auth::user()->id);

            // "root" user can access every route
            if ('root' == $this->user->username)
                return true;

            // User having "admins" role can access any route
            if ($this->user->hasRole('super-admin'))
                return true;

            // Check for a valid route
            if ($this->route !== false) {

                // Check if Permission set for route.
                if (isset($this->route->permission) && !empty($this->route->permission)) {

                    // Route is accessable by all logged in user
                    if ( 'basic-authenticated' == $this->route->permission->name)
                        return true;

                    if ( $this->user->can($this->route->permission->name) )
                        return true;

                    // route permission can not access the route
                    return false;

                }
            }

            // User is not "root" user
            // neither have "admins" role
            // nor passed route have any permissions
            return false;

        } else {

            // Check for a valid route
            if ($this->route !== false && $this->route->permission !== null) {

                // Guest User
                // This route can be accessed without login
                if ( 'guest-only' == $this->route->permission->name )
                    return true;

                // Route is accessable by any ie. logged in or guest user
                if ( 'open-to-all' == $this->route->permission->name )
                    return true;
            }

        }

        // Managed to reach here means
        // this route is un-accessable
        return false;
    }

    /**
     * Let ROOT user and User having Admins role access ACL menu
     *
     * @return bool
     */
    public function hasAdministrativeAccess()
    {
        if (Auth::check()) {

            // check if User model already exist
            if(!$this->user)
                $this->user = User::find(Auth::user()->id);

            // "root" user can access every route
            if ('root' == $this->user->username)
                return true;

            // User having "admins" role can access any route
            if ($this->user->hasRole('super-admin'))
                return true;

            // User is not "root" user
            // neither have "admins" role
            // nor passed route have any permissions
            return false;

        }

        // Managed to reach here means
        // this route is un-accessable
        return false;
    }

    public function getRouteByPathPattern($pathPattern)
    {
        // Get application route based on info from Laravel route.
        $route = AppRoute::where('path', 'like', $pathPattern.'%')
            ->enabled()
            ->with('permission')
            ->get();

        if (!$route)
            return false;

        return $route;
    }

    /**
     * Returns Route Model if passed route exist
     * else returns false
     *
     * @param $name name of route
     * @return bool
     */
    public function getRouteByName($name)
    {
        // Get application route based on info from Laravel route.
        $route = AppRoute::ofName($name)
            ->enabled()
            ->with('permission')
            ->first();

        if (!$route)
            return false;

        return $route;

    }

    /**
     * Group Permissions By first two section of permission name
     *
     * @return array
     */
    public function groupPermissionsInTreeFormat()
    {
        return $this->getPermissionGroups();
    }

    /**
     * Return Permission Info Part filtering routes from Permission Config
     *
     * @return array
     */
    private function getPermissionGroups()
    {
        $permission_groups = [];

        try {

            $permission_config = config('rdqa-permission.route-groups');
            if (!$permission_config)
                throw new \Exception('Configuration file for permission not found.');

            if ($this->isValidPermissionConfigStructure($permission_config)) {

                foreach ($permission_config as $route_section_key => $group_section_config) {

                    foreach ($group_section_config['groups'] as $route_group_key => $route_group_config) {

                        $permission_groups[$route_section_key]['section'] = $group_section_config['section'];
                        $permission_groups[$route_section_key]['groups'][$route_group_key]['section'] = $route_group_config['section'];

                    }

                }

            }

            return $permission_groups;

        } catch (\Exception $e) {
            
            \AppExceptionHandler::logMessage('error', $e->getMessage());
            abort(500);
            
        }

    }

    /**
     * validate permission basic configuration structure
     *
     * @param $permission_config
     * @return bool
     */
    public function isValidPermissionConfigStructure($permission_config)
    {
        $valid = true;

        foreach ($permission_config as $route_section_key => $group_section_config) {

            if (array_key_exists('section', $group_section_config) && array_key_exists('groups', $group_section_config)) {

                if (!isset($group_section_config['section']['name']) || empty($group_section_config['section']['name'])) {

                    $valid = false;
                    break;

                }

                foreach ($group_section_config['groups'] as $route_group_key => $route_group_config) {

                    if (array_key_exists('section', $route_group_config) && array_key_exists('routes', $route_group_config)) {

                        if (!isset($route_group_config['section']['name']) || empty($route_group_config['section']['name'])) {

                            $valid = false;
                            break;

                        }

                    } else {

                        $valid = false;
                        break;

                    }

                }

            } else {
                $valid = false;
                break;
            }

        }

        if (!$valid)
            \AppExceptionHandler::logMessage('error', 'Permission Configuration structure is not matching application need.');
        
        return $valid;
    }

    /**
     * Check if passed route has permission for accessing routes
     * under passed RouteGroupSection
     *
     * @param $route_group_section_name
     * @param $role
     * @return bool
     */
    public function hasPermission($route_group_section_name, $role)
    {
        try {

            if ($role->id !== null) {

                $routes = config($this->getRouteGroupChain($route_group_section_name));

                $permissions_collection = AppRoute::select('permission_id')
                    ->where('enabled', 1)
                    ->whereIn('name', $routes)
                    ->get();

                $permission_ids = $permissions_collection->pluck('permission_id')->toArray();

                $permission_count = $role->perms()->whereIn('permission_id', $permission_ids)->count();


                if ($permission_count > 0 && count($permission_ids) == $permission_count)
                    return true;

                return false;
            }

            return false;

        } catch (\Exception $ex) {

            \AppExceptionHandler::logMessage('error', $ex->getMessage());
            return false;

        }
    }

    /**
     * Accepts route group section name and
     * generate array key chin for accessing the
     * routes under the given route group section
     *
     * @param array $route_group_section_name
     * @return string
     */
    public function getRouteGroupChain($route_group_section_name = [])
    {
        $tmp = explode('.', $route_group_section_name);
        $route_group_chain = [];
        $route_group_chain[] = 'rdqa-permission.route-groups';
        $route_group_chain[] = $tmp[0];
        $route_group_chain[] = 'groups';
        $route_group_chain[] = $tmp[1];
        $route_group_chain[] = 'routes';
        $route_group_chain[] = $tmp[2];

        return implode('.', $route_group_chain);
    }

    /**
     * Returns logged in users roles
     *
     * @return array
     */
    public function getUserRoles()
    {
        if ($this->user_roles)
            return $this->user_roles;
        else  {

            $roles = [];

            if (auth()->check()) {


                // TODO: If user have multiple role then logic can be changed here
                // App should support single role
                // If a user have multiple role then, user must select a single role before accessing
                // admin section

                foreach (auth()->user()->roles()->exclude()->select('name')->where('enabled', 1)->get() as $role) {
                    $roles[] = $role->name;
                }

            }

            $this->user_roles = $roles;

            return $roles;

        }
    }

    /**
     * Get User Role
     *
     * @return mixed
     */
    public function getUserRole()
    {
        $roles = $this->getUserRoles();
        if (count($roles) !== 1)
            AppHelper::systemError();

        return $roles[0];
    }

    /**
     * Finds the User Type of currently logged in user
     *
     * @param $to_check Role to check
     * @return bool
     */
    public function checkUserType($to_check)
    {
        if (in_array($to_check, $this->getUserRoles()))
            return true;

        return false;

        // TODO: OLD CODE : REMOVE !!
        if (auth()->check()) {

            if (auth()->user()->user_type == $to_check)
                return true;

        }

        return false;
    }

    public function getUsersTypeKey($user_type)
    {
        return config('rdqa.admin-users-roles.'.$user_type.'.key');
    }

    public function getUsersTypeTitle($user_type)
    {
        return config('rdqa.admin-users-roles.'.$user_type.'.title');
    }

    public function isRoleHierarchyBelowPromoter($user_role = null)
    {
        if (!$user_role) 
            AppHelper::systemError();

        if (
            $user_role == self::getUsersTypeKey('super-admin') ||
            $user_role == self::getUsersTypeKey('support-admin') ||
            $user_role == self::getUsersTypeKey('promoter-admin')
        )
            return false;

        return true;

    }

    public function isRoleHierarchyAbovePromoter($user_role = null)
    {
        if (!$user_role)
            AppHelper::systemError();

        if (
            $user_role == self::getUsersTypeKey('super-admin') ||
            $user_role == self::getUsersTypeKey('support-admin')
        )
            return true;

        return false;
    }


}