<?php namespace App\Http\Controllers\Admin\Acl;

use AppHelper;
use App\Classes\AclHelper;
use App\Http\Controllers\AdminBaseController;
use App\Models\Route;
use App\Repositories\Criteria\Role\RolesByPositionAscending;
use App\Repositories\Criteria\Role\RolesWithPermissions;
use App\Repositories\PermissionRepository as Permission;
use App\Repositories\RoleRepository as Role;
use App\Repositories\UserRepository as User;
use DB;
use Flash;
use Illuminate\Http\Request;

class RolesController extends AdminBaseController
{

    /**
     * @var Role
     */
    private $role;

    /**
     * @var Permission
     */
    private $permission;

    /**
     * @var User
     */
    private $user;

    /**
     * @var view location path
     */
    protected $view_path = 'admin.acl.roles';

    /**
     * @var translation array path
     */
    protected $trans_path;

    /**
     * @param Role $role
     * @param Permission $permission
     * @param User $user
     */
    public function __construct(Role $role, Permission $permission, User $user)
    {
        parent::__construct();

        $this->role       = $role;
        $this->permission = $permission;
        $this->user       = $user;

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $page_title       = trans($this->trans_path . 'general.page.index.title'); // "Admin | Roles";
        $page_description = trans($this->trans_path . 'general.page.index.description'); // "List of roles";

        $roles = $this->role->pushCriteria(new RolesWithPermissions())
            ->pushCriteria(new RolesByPositionAscending())
            ->paginate($this->admin_pagination_limit);

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('roles', 'page_title', 'page_description'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $role = $this->role->find($id);

        $page_title       = trans($this->trans_path . 'general.page.show.title'); // "Admin | Role | Show";
        $page_description = trans($this->trans_path . 'general.page.show.description', ['name' => $role->name]); // "Displaying role";

        $perms = $this->permission->all();
//        $userCollection = \App\User::take(10)->get(['id', 'first_name', 'last_name', 'username'])->lists('full_name_and_username', 'id');
        //        $userList = [''=>''] + $userCollection->all();

        return view($this->loadDefaultVars($this->view_path . '.show'), compact('role', 'perms', 'page_title', 'page_description'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $page_title       = trans($this->trans_path . 'general.page.create.title'); // "Admin | Role | Create";
        $page_description = trans($this->trans_path . 'general.page.create.description'); // "Creating a new role";

        $role              = new \App\Models\Role();
        $permission_groups = \AclHelper::groupPermissionsInTreeFormat();

        return view($this->loadDefaultVars($this->view_path . '.create'), compact('role', 'permission_groups', 'page_title', 'page_description'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, array('name' => 'required|unique:roles', 'display_name' => 'required'));

        $attributes = $request->all();

        try {

            $permission_ids = $this->getSelectedPermissionIds($request);

            if (array_key_exists('selected_users', $attributes) && !empty($attributes['selected_users'])) {
                $attributes['users'] = explode(",", $attributes['selected_users']);
            }

            $role = $this->role->create($attributes);

            $role->savePermissions($permission_ids);
            $role->forcePermission('basic-authenticated');

            if (isset($attributes['users'])) {
                $role->saveUsers($attributes['users']);
            }

            Flash::success(trans($this->trans_path . 'general.status.created')); // 'Role successfully created');

            return redirect('/admin/roles');

        } catch (\Exception $ex) {

            \AppExceptionHandler::logMessage('error', $ex->getMessage());
            abort(500);

        }

    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $role = $this->role->find($id);

        $page_title       = trans($this->trans_path . 'general.page.edit.title'); // "Admin | Role | Edit";
        $page_description = trans($this->trans_path . 'general.page.edit.description', ['name' => $role->name]); // "Editing role";

        if (!$role->isEditable() && !$role->canChangePermissions()) {
            abort(403);
        }

        // $perms = $this->permission->all();
        $permission_groups = \AclHelper::groupPermissionsInTreeFormat($this->permission->all());

//        $rolePerms = $role->perms();
        //        $userCollection = \App\User::take(10)->get(['id', 'first_name', 'last_name', 'username'])->lists('full_name_and_username', 'id');
        //        $userList = [''=>''] + $userCollection->all();

        return view($this->loadDefaultVars($this->view_path . '.edit'), compact('role', 'permission_groups', 'page_title', 'page_description'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array('name' => 'required', 'display_name' => 'required'));

        try {

            $role           = $this->role->find($id);
            $attributes     = $request->all();
            $permission_ids = $this->getSelectedPermissionIds($request);

   
            if (array_key_exists('selected_users', $attributes) && !empty($attributes['selected_users'])) {
                $attributes['users'] = explode(",", $attributes['selected_users']);
            } else {
                $attributes['users'] = [];
            }

            if ($role->isEditable()) {
                $role->update($attributes);
            }

            if ($role->canChangePermissions()) {
                $role->savePermissions($permission_ids);
            }

            $role->forcePermission('basic-authenticated');

            if ($role->canChangeMembership()) {
                $role->saveUsers($attributes['users']);
            }

            Flash::success(trans($this->trans_path . 'general.status.updated')); // 'Role successfully updated');

            return redirect('/admin/roles');

        } catch (\Exception $ex) {

            \AppExceptionHandler::logMessage('error', $ex->getMessage());
            abort(500);

        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $role = $this->role->find($id);

        if (!$role->isdeletable()) {
            abort(403);
        }

        $this->role->delete($id);

        Flash::success(trans($this->trans_path . 'general.status.deleted')); // 'Role successfully deleted');

        return redirect('/admin/roles');
    }

    /**
     * Delete Confirm
     *
     * @param   int $id
     * @return  View
     */
    public function getModalDelete($id)
    {
        $error = null;

        $role = $this->role->find($id);

        if (!$role->isdeletable()) {
            abort(403);
        }

        $modal_title  = trans($this->trans_path . 'dialog.delete-confirm.title');
        $modal_cancel = trans('admin/general.button.cancel');
        $modal_ok     = trans('admin/general.button.ok');

        $role        = $this->role->find($id);
        $modal_route = route('admin.roles.delete', array('id' => $role->id));

        $modal_body = trans($this->trans_path . 'dialog.delete-confirm.body', ['id' => $role->id, 'name' => $role->name]);

        return view('admin.partials.modal_confirmation', compact('error', 'modal_route',
            'modal_title', 'modal_body', 'modal_cancel', 'modal_ok'));

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function enable($id)
    {
        $role          = $this->role->find($id);
        $role->enabled = true;
        $role->save();

        Flash::success(trans($this->trans_path . 'general.status.enabled'));

        return redirect('/admin/roles');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function disable($id)
    {
        //TODO: Should we protect 'admins', 'users'??

        $role          = $this->role->find($id);
        $role->enabled = false;
        $role->save();

        Flash::success(trans($this->trans_path . 'general.status.disabled'));

        return redirect('/admin/roles');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function enableSelected(Request $request)
    {
        $chkRoles = $request->input('chkRole');

        if (isset($chkRoles)) {
            foreach ($chkRoles as $role_id) {
                $role          = $this->role->find($role_id);
                $role->enabled = true;
                $role->save();
            }
            Flash::success(trans($this->trans_path . 'general.status.global-enabled'));
        } else {
            Flash::warning(trans($this->trans_path . 'general.status.no-role-selected'));
        }
        return redirect('/admin/roles');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function disableSelected(Request $request)
    {
        //TODO: Should we protect 'admins', 'users'??

        $chkRoles = $request->input('chkRole');

        if (isset($chkRoles)) {
            foreach ($chkRoles as $role_id) {
                $role          = $this->role->find($role_id);
                $role->enabled = false;
                $role->save();
            }
            Flash::success(trans($this->trans_path . 'general.status.global-disabled'));
        } else {
            Flash::warning(trans($this->trans_path . 'general.status.no-role-selected'));
        }
        return redirect('/admin/roles');
    }

    /**
     * @param Request $request
     * @return array|static[]
     */
    public function searchByName(Request $request)
    {

        $name  = $request->input('query');
        $roles = DB::table('roles')
        /*->select(DB::raw('id, display_name || " (" || description || ")" as text'))*/
            ->select(DB::raw('id, display_name as text'))
            ->where('name', 'like', "%$name%")
            ->orWhere('display_name', 'like', "%$name%")
            ->orWhere('description', 'like', "%$name%")
            ->get();
        return $roles;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getInfo(Request $request)
    {
        $id   = $request->input('id');
        $role = $this->role->find($id);

        return $role;
    }

    /**
     * Returns an array with permission ids based on selectd
     * permission group in Role Add/Edit form
     *
     * @param $request
     * @return array
     */
    private function getSelectedPermissionIds($request)
    {
        $permission_ids    = [];
        $permission_config = config('rdqa-permission.route-groups');
   
        foreach ($permission_config as $level_one_key => $level_one) {

            foreach ($level_one['groups'] as $level_two_key => $level_two) {

                foreach ($level_two['routes'] as $routes_key => $routes) {

                    $route_section = $level_one_key . '.' . $level_two_key . '.' . $routes_key;

                    if (!is_null($request->get('perms')) && in_array($route_section, $request->get('perms'))) {
                        foreach ($routes as $route) {

                            $route_detail = Route::select('routes.id as route_id', 'p.id as permission_id')
                                ->join('permissions as p', 'p.id', '=', 'routes.permission_id')
                                ->where('routes.name', $route)
                                ->where('routes.enabled', 1)
                                ->first();

                            if ($route_detail) {
                                $permission_ids[] = $route_detail->permission_id;
                            }

                        }

                    }

                }

            }

        }

        return $permission_ids;
    }

}
