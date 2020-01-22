<?php namespace App\Http\Controllers\Admin\Acl;

use App\Http\Controllers\AdminBaseController;
use App\Repositories\Criteria\Permission\PermissionsByNamesAscending;
use App\Repositories\PermissionRepository as Permission;
use App\Repositories\RoleRepository as Role;
use App\Repositories\RouteRepository as Route;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Artisan;
use AppHelper,DB,Schema;

class PermissionsController extends AdminBaseController
{

    private $role;
    private $permission;
    private $route;
    private $appRoutes;

    /**
     * @var view location path
     */
    protected $view_path = 'admin.acl.permissions';

    /**
     * @var translation array path
     */
    protected $trans_path;


    /**
     * @param Permission $permission
     * @param Role $role
     * @param Route $route
     */
    public function __construct(Permission $permission, Role $role, Route $route)
    {
        parent::__construct();

        $this->permission = $permission;
        $this->role = $role;
        $this->route = $route;

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //TODO: Warn of any permission in our DB that is not used (assigned to a route) in the app.

        $page_title = trans($this->trans_path . 'general.page.index.title');
        $page_description = trans($this->trans_path . 'general.page.index.description');

        $perms = $this->permission->pushCriteria(new PermissionsByNamesAscending())->paginate(AppHelper::getConfigValue('ADMIN-PAGINATION-LIMIT'));
        return view($this->loadDefaultVars($this->view_path . '.index'), compact('perms', 'page_title', 'page_description'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $perm = $this->permission->find($id);

        $page_title = trans($this->trans_path . 'general.page.show.title');
        $page_description = trans($this->trans_path . 'general.page.show.description', ['name' => $perm->name]); // "Displaying permission";

        return view($this->loadDefaultVars($this->view_path . '.show'), compact('perm', 'page_title', 'page_description'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans($this->trans_path . 'general.page.create.title');
        $page_description = trans($this->trans_path . 'general.page.create.description');

        $perm = new \App\Models\Permission();

        return view($this->loadDefaultVars($this->view_path . '.create'), compact('perm', 'page_title', 'page_description'));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, array('name' => 'required|unique:permissions', 'display_name' => 'required'));

        $attributes = $request->all();

        if (array_key_exists('selected_routes', $attributes) && !empty($attributes['selected_routes'])) {
            $attributes['routes'] = explode(",", $attributes['selected_routes']);
        }
        if (array_key_exists('selected_roles', $attributes) && !empty($attributes['selected_roles'])) {
            $attributes['roles'] = explode(",", $attributes['selected_roles']);
        }

        $perm = $this->permission->create($attributes);
        $perm->assignRoutes($attributes);
        $perm->assignRoles($attributes);

        Flash::success(trans($this->trans_path . 'general.status.created'));

        return redirect('/admin/permissions');
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        //TODO: Protect 'basic-authenticated', 'guest-only', 'open-to-all'

        $perm = $this->permission->find($id);

        $page_title = trans($this->trans_path . 'general.page.edit.title');
        $page_description = trans($this->trans_path . 'general.page.edit.description', ['name' => $perm->name]); // "Editing permission";

        if (!$perm->isEditable()) {
            abort(403);
        }

        return view($this->loadDefaultVars($this->view_path . '.edit'), compact('perm', 'page_title', 'page_description'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        //TODO: Protect 'basic-authenticated', 'guest-only', 'open-to-all'

        $this->validate($request, array('name' => 'required', 'display_name' => 'required'));

        $perm = $this->permission->find($id);

        if (!$perm->isEditable()) {
            abort(403);
        }

        $attributes = $request->all();
        if (array_key_exists('selected_routes', $attributes) && !empty($attributes['selected_routes'])) {
            $attributes['routes'] = explode(",", $attributes['selected_routes']);
        }
        if (array_key_exists('selected_roles', $attributes) && !empty($attributes['selected_roles'])) {
            $attributes['roles'] = explode(",", $attributes['selected_roles']);
        }

        $perm->update($request->all());
        if($request->input('selected_routes'))
        $perm->assignRoutes($attributes);

        $perm->assignRoles($attributes);

        Flash::success(trans($this->trans_path . 'general.status.updated'));

        return redirect('/admin/permissions');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        //TODO: Protect 'basic-authenticated', 'guest-only', 'open-to-all'

        $permission = $this->permission->find($id);

        if (!$permission->isDeletable()) {
            abort(403);
        }

        $this->permission->delete($id);

        Flash::success(trans($this->trans_path . 'general.status.deleted'));

        return redirect('/admin/permissions');
    }

    /**
     * Delete Confirm
     *
     * @param   int $id
     * @return  View
     */
    public function getModalDelete($id)
    {
        //TODO: Protect 'basic-authenticated', 'guest-only', 'open-to-all'

        $error = null;

        $permission = $this->permission->find($id);

        if (!$permission->isDeletable()) {
            abort(403);
        }

        $modal_title = trans($this->trans_path . 'dialog.delete-confirm.title');
        $modal_cancel = trans('admin/general.button.cancel');
        $modal_ok = trans('admin/general.button.ok');

        $modal_route = route('admin.permissions.delete', array('id' => $permission->id));

        $modal_body = trans($this->trans_path . 'dialog.delete-confirm.body', ['id' => $permission->id, 'name' => $permission->name]);

        return view('admin.partials.modal_confirmation', compact('error', 'modal_route',
            'modal_title', 'modal_body', 'modal_cancel', 'modal_ok'));

    }

    /**
     * @return \Illuminate\View\View
     */
    public function generate()
    {
        //abort(403);
        $routes = $this->route->all();

        /*
        |--------------------------------------------------------------------------
        | Permission For Authorized Routes
        |--------------------------------------------------------------------------
        |
        | Generate Permission for routes having "authorize" middleware
        | and assign the permission to the route
        |
        */

        $cnt = 0;
        foreach ($routes as $route) {

            $name = $route->path . '!' . $route->method;
            if (null == $this->permission->findBy('name', $name) && $this->isAuthorizedRoute($route)) {

                $permissionIns = $this->permission->create([
                        'name' => $name,
                        'display_name' => $name,
                        'description' => 'Auto-generated from route: ' . $route->action_name,
                        'enabled' => 1
                    ]
                );

                $route->permission_id = $permissionIns->id;
                $route->save();

                $cnt = $cnt + 1;

            }
        }

        Flash::success(trans($this->trans_path . 'general.status.generated', ['number' => $cnt]));
        return redirect('/admin/permissions');
    }
 /**
     * @return \Illuminate\View\View
     */
    public function reset()
    {


        DB::table('permission_role')->truncate();
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();
//        \App\Models\Permission::query()->truncate();


        Artisan::call('db:seed',['--class'=>'PermissionTableSeeder']);

        //abort(403);
        $routes = $this->route->all();

        /*
        |--------------------------------------------------------------------------
        | Permission For Authorized Routes
        |--------------------------------------------------------------------------
        |
        | Generate Permission for routes having "authorize" middleware
        | and assign the permission to the route
        |
        */
        $cnt = 0;
        foreach ($routes as $route) {
                $name = $route->path . '!' . $route->method;
//                $displayname = $route->name . '-' . $route->id;

            if (null == $this->permission->findBy('name', $name) && $this->isAuthorizedRoute($route)) {
                $permissionIns = $this->permission->create([
                        'name' => $name,
                        'display_name' => $name,
                        'description' => 'Auto-generated from route: ' . $route->action_name,
                        'enabled' => 1
                    ]
                );

                $route->permission_id = $permissionIns->id;
                $route->save();

                $cnt = $cnt + 1;

            }
        }

        Flash::success(trans($this->trans_path . 'general.status.generated', ['number' => $cnt]));
        return redirect('/admin/permissions');
    }
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function enable($id)
    {
        $permission = $this->permission->find($id);
        $permission->enabled = true;
        $permission->save();

        Flash::success(trans($this->trans_path . 'general.status.enabled'));

        return redirect('/admin/permissions');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function disable($id)
    {
        //TODO: Should we protect 'basic-authenticated', 'guest-only', 'open-to-all'??

        $permission = $this->permission->find($id);
        $permission->enabled = false;
        $permission->save();

        Flash::success(trans($this->trans_path . 'general.status.disabled'));

        return redirect('/admin/permissions');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function enableSelected(Request $request)
    {
        $chkPerms = $request->input('chkPerm');

        if (isset($chkPerms)) {
            foreach ($chkPerms as $perm_id) {
                $permission = $this->permission->find($perm_id);
                $permission->enabled = true;
                $permission->save();
            }
            Flash::success(trans($this->trans_path . 'general.status.global-enabled'));
        } else {
            Flash::warning(trans($this->trans_path . 'general.status.no-perm-selected'));
        }
        return redirect('/admin/permissions');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function disableSelected(Request $request)
    {
        //TODO: Should we protect 'basic-authenticated', 'guest-only', 'open-to-all'??

        $chkPerms = $request->input('chkPerm');

        if (isset($chkPerms)) {
            foreach ($chkPerms as $perm_id) {
                $permission = $this->permission->find($perm_id);
                $permission->enabled = false;
                $permission->save();
            }
            Flash::success(trans($this->trans_path . 'general.status.global-disabled'));
        } else {
            Flash::warning(trans($this->trans_path . 'general.status.no-perm-selected'));
        }
        return redirect('/admin/permissions');
    }

    /**
     * Verify if the given route is having
     * " authorize " middleware
     *
     * @param \App\Models\Route $route
     * @return bool
     */
    public function isAuthorizedRoute(\App\Models\Route $route)
    {
        return true;

        if (!$this->appRoutes)
            $this->appRoutes = \Route::getRoutes();

        $app_route = $this->appRoutes->getByAction($route->action_name);

        if ($app_route) {
            $middleware = $app_route->middleware();

            if (in_array('authorize', $middleware))
                return true;
        }

        return false;
    }

}