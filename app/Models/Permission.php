<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{


    /**
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description', 'resync_on_login', 'enabled'];



    public function routes()
    {
        return $this->hasMany('App\Models\Route');
    }
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

    }

    /**
     * Scope a query to exclude some roles
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExclude($query)
    {
        return $query->whereNotIn('roles.name', config('rdqa.excluded-roles'));
    }

    /**
     * @return bool
     */
    public function isEditable()
    {
        // Protect the admins and users roles from editing changes
        if ( ('super-admin' == $this->name)
            || ('users' == $this->name)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isDeletable()
    {
        // Protect the admins and users roles from deletion
        if ( ('super-admin' == $this->name)
            || ('users' == $this->name)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function canChangePermissions()
    {
        // Protect the admins role from permissions changes
        if ('super-admin' == $this->name) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function canChangeMembership()
    {
        // Protect the users role from membership changes
        if ('users' == $this->name) {
            return false;
        }

        return true;
    }


    /**
     * @param $role
     * @return bool
     */
    public static function isForced($role)
    {
        if ('users' == $role->name) {
            return true;
        }

        return false;
    }

    public function hasPerm(Permission $perm)
    {
        // perm 'basic-authenticated' is always checked.
        if ('basic-authenticated' == $perm->name) {
            return true;
        }

        // Return true if the role has is assigned the given permission.
        if ( $this->perms()->where('id' , $perm->id)->first() ) {
            return true;
        }
        // Otherwise
        return false;
    }

    /**
     *
     * Force the role to have the given permission.
     *
     * @param $permissionName
     */
    public function forcePermission($permissionName)
    {
        // If the role has not been given a the said permission
        if (null == $this->perms()->where('name', $permissionName)->first()) {
            // Load the given permission and attach it to the role.
            $permToForce = Permission::where('name', $permissionName)->first();
            $this->perms()->attach($permToForce->id);
        }
    }

    /**
     * Save the inputted users.
     *
     * @param mixed $inputUsers
     *
     * @return void
     */
    public function saveUsers($inputUsers)
    {
        if (!empty($inputUsers)) {
            $this->users()->sync($inputUsers);
        } else {
            $this->users()->detach();
        }
    }
 /**
     *
     *
     * @param array $attributes
     * @param $user
     */
    public function assignRoutes(array $attributes = [])
    {
        if (array_key_exists('routes', $attributes) && ($attributes['routes'])) {
            $this->clearRouteAssociation();

            foreach ($attributes['routes'] as $id) {
                $route = \App\Models\Route::find($id);
                if (!empty($route))
                    $this->routes()->save($route);
            }
        } else {
            $this->clearRouteAssociation();
        }
    }

    /**
     *
     *
     * @param array $attributes
     * @param $user
     */
    public function assignRoles(array $attributes = [])
    {
        if (array_key_exists('roles', $attributes) && ($attributes['roles'])) {
            if (!empty($attributes['roles']))
                $this->roles()->sync($attributes['roles']);
        } else {
            $this->roles()->sync([]);
        }
    }

    /**
     *
     */
    public function clearRouteAssociation()
    {
        foreach ($this->routes as $route) {
            $route->permission()->dissociate();
//            $route->dissociate();
            $route->save();
        }
        $this->save();
    }
}
