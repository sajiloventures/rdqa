<?php namespace App\Http\Controllers\Admin\Acl;

//use App\Models\Route;
use App\Http\Controllers\AdminBaseController;
use App\Repositories\RouteRepository as Route;
use App\Repositories\PermissionRepository as Permission;
use App\Repositories\Criteria\Route\RoutesWithPermissions;
use App\Repositories\Criteria\Route\RoutesByPathAscending;
use App\Repositories\Criteria\Route\RoutesByMethodAscending;

use Illuminate\Http\Request;
use App\Http\Requests;
use Flash;
use DB;
use AppHelper,Auth;
use App\Models\Permission as AppPermission;

class RoutesController extends AdminBaseController
{

    /**
     * @var Route
     */
    private $route;

    /**
     * @var Permission
     */
    private $permission;

    /**
     * @var view location path
     */
    protected $view_path = 'admin.acl.routes';

    /**
     * @var translation array path
     */
    protected $trans_path;

    /**
     * @param Route $route
     * @param Permission $permission
     */
    public function __construct(Route $route, Permission $permission)
    {
        parent::__construct();

        $this->route = $route;
        $this->permission = $permission;

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
       // TODO: Warn of any routes in our DB that is not used in the app.

        $page_title = trans($this->trans_path.'general.page.index.title');
        $page_description = trans($this->trans_path.'general.page.index.description');

        $routes = $this->route->pushCriteria(new RoutesWithPermissions())
            ->pushCriteria(new RoutesByPathAscending())
            ->pushCriteria(new RoutesByMethodAscending())
            ->paginate(AppHelper::getConfigValue('ADMIN-PAGINATION-LIMIT'));

        $perms = $this->permission->all()->pluck('display_name', 'id');
        $perms = $perms->toArray(0);
        //  AppHelper::debug($perms);
        //  array_unshift($perms, '');

        return view($this->loadDefaultVars($this->view_path.'.index'), compact('routes', 'perms', 'page_title', 'page_description'));


    }

    /**
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $page_title = trans($this->trans_path.'general.page.show.title'); // "Admin | Route | Show";
        $page_description = trans($this->trans_path.'general.page.show.description'); // "Displaying route";

        $route = $this->route->find($id);

        return view($this->loadDefaultVars($this->view_path.'.show'), compact('route', 'page_title', 'page_description'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans($this->trans_path.'general.page.create.title'); // "Admin | Route | Create";
        $page_description = trans($this->trans_path.'general.page.create.description'); // "Creating a new route";

        return view($this->loadDefaultVars($this->view_path.'.create'), compact('page_title', 'page_description'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, array('method' => 'required', 'path' => 'required', 'action_name' => 'required|unique:routes'));

        $this->route->create($request->all());

        Flash::success(trans($this->trans_path.'general.status.created'));

        return redirect('/admin/routes');
    }

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $page_title = trans($this->trans_path.'general.page.edit.title');
        $page_description = trans($this->trans_path.'general.page.edit.description');

        $route = $this->route->find($id);

        return view($this->loadDefaultVars($this->view_path.'.edit'), compact('route', 'page_title', 'page_description'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array('method' => 'required', 'path' => 'required', 'action_name' => 'required|unique:routes'));

        $route = $this->route->find($id);

        $route->update($request->all());

        Flash::success(trans($this->trans_path.'general.status.updated'));

        return redirect('/admin/routes');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $route = $this->route->find($id);

        $this->route->delete($id);

        Flash::success(trans($this->trans_path.'general.status.deleted'));

        return redirect('/admin/routes');
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

        $route = $this->route->find($id);

        $modal_title = trans($this->trans_path.'dialog.delete-confirm.title');
        $modal_cancel = trans('admin/general.button.cancel');
        $modal_ok = trans('admin/general.button.ok');

        $modal_route = route('admin.routes.delete', array('id' => $route->id));

        $modal_body = trans($this->trans_path.'dialog.delete-confirm.body', ['id' => $route->id, 'name' => $route->name]);

        return view('admin.partials.modal_confirmation', compact('error', 'modal_route',
            'modal_title', 'modal_body', 'modal_cancel', 'modal_ok'));

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function enable($id)
    {
        $route = $this->route->find($id);
        $route->enabled = true;
        $route->save();

        Flash::success(trans($this->trans_path.'general.status.enabled'));

        return redirect('/admin/routes');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function disable($id)
    {
        $route = $this->route->find($id);
        $route->enabled = false;
        $route->save();

        Flash::success(trans($this->trans_path.'general.status.disabled'));

        return redirect('/admin/routes');
    }
    /**
     * @return \Illuminate\View\View
     */
    public function load()
    {
        $AppRoutes = \Route::getRoutes();
        $cnt = 0;

        $deleteRoutesIds = $deletePermissionIds = [];

        foreach ($AppRoutes as $appRoute) {


            $name = $appRoute->getName(); // Route
            $methods = $appRoute->methods(); // Http Methods
            $path = $appRoute->uri(); // URL
            $actionName = $appRoute->getActionName(); // Controller Action Path
            //dd($appRoute->getAction());

            if (!str_contains($actionName, 'AuthController') &&
                !str_contains($actionName, 'PasswordController')
            ) {
                foreach ($methods as $method) {

                    $route = null;

                    if ('HEAD' !== $method                     // Skip method 'HEAD' looks to be duplicated of 'GET'
                        && !starts_with($path, '_debugbar')
                    )   // Skip all DebugBar routes.
                    {
                        $newRoute = null;

                        // TODO: Use Repository 'findWhere' when its fixed!!
                        //                    $route = $this->route->findWhere([
                        //                        'method'      => $method,
                        //                        'action_name' => $actionName,
                        //                    ])->first();

//                        $routeActions = $appRoute->getAction();

//                        if(array_key_exists('req_update',$routeActions)) {
//                            $prevRoute = $routeActions['req_update'] . ':' . $method;
//                            $route = \App\Models\Route::ofName($prevRoute)->first();
//                        } else {
//                            $route = \App\Models\Route::ofMethod($method)->ofPath($path)->ofActionName($actionName)->first();
//                        }
                        $routeName = $name . ':' . $method;
                        if ($name == "" || $name == null)
                            $route = \App\Models\Route::ofMethod($method)->ofPath($path)->ofActionName($actionName)->first();
                        else
                            $route = \App\Models\Route::ofMethod($method)->ofName($routeName)->first();

                        if (!isset($route)) {
                            $cnt++;
                            $newRoute = $this->route->create([
                                'name' => $routeName,
                                'method' => $method,
                                'path' => $path,
                                'action_name' => $actionName,
                                'permission_id' => 0,
                                'enabled' => 1
                            ]);
                        }
                        else {
                            $this->route->update([
                                'name' => $routeName,
                                'method' => $method,
                                'path' => $path,
                                'action_name' => $actionName,
                            ], $route->id);

                            // Assigning new data in route
                            $route->name = $routeName;
                            $route->method = $method;
                            $route->path = $path;
                            $route->action_name = $actionName;

                            $newRoute = $route;
                            // change name and display name of permission table if exists
                            $associatedPermission = AppPermission::find($route->permission_id);
                            if ($associatedPermission) {
                                $associatedPermission->display_name = $associatedPermission->name = $route->path . '!' . $route->method;
                                $associatedPermission->description = 'Auto-generated from route: ' . $actionName;
                                $associatedPermission->enabled = 1;
                                $associatedPermission->save();
                            }
                        }

                        if ($newRoute) {
                            array_push($deleteRoutesIds, $newRoute->id);
                            array_push($deletePermissionIds, $newRoute->permission_id);
                        }
                    }
                }
            }
        }

        // delete removed routes and associated permissions
        \App\Models\Route::whereNotIn('id', $deleteRoutesIds)->delete();
        \App\Models\Permission::whereNotIn('name', ['guest-only', 'open-to-all', 'basic-authenticated'])
            ->whereNotIn('id', $deletePermissionIds)
            ->delete();

        Flash::success(trans($this->trans_path.'general.status.loaded', ['number' => $cnt]));
        return redirect('/admin/routes');

    }

    public function reset()
    {
        DB::table('routes')->truncate();
        DB::table('permission_role')->truncate();
        \Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        \Schema::enableForeignKeyConstraints();


        \Artisan::call('db:seed',['--class'=>'PermissionTableSeeder']);

      return $this->load();
    }


    /**
     * @return \Illuminate\View\View
     */
    public function savePerms(Request $request)
    {
        $chkRoute = $request->input('chkRoute');
        $globalPerm_id = $request->input('globalPerm');
        $perms = $request->input('perms');

        if (isset($chkRoute) && isset($globalPerm_id)) {
            foreach ($chkRoute as $route_id) {
                $route = $this->route->find($route_id);
                $route->permission_id = $globalPerm_id;
                $route->save();
            }
            Flash::success(trans($this->trans_path.'general.status.global-perms-assigned'));
        } elseif (isset($perms)) {
            foreach ($perms as $route_id => $perm_id) {
                $route = $this->route->find($route_id);
                $route->permission_id = $perm_id;
                $route->save();
            }
            Flash::success(trans($this->trans_path.'general.status.indiv-perms-assigned'));
        } else {
            Flash::warning(trans($this->trans_path.'general.status.no-permission-changed-detected'));
        }
        return redirect('/admin/routes');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function enableSelected(Request $request)
    {
        $chkRoute = $request->input('chkRoute');

        if (isset($chkRoute)) {
            foreach ($chkRoute as $route_id) {
                $route = $this->route->find($route_id);
                $route->enabled = true;
                $route->save();
            }
            Flash::success(trans($this->trans_path.'general.status.global-enabled'));
        } else {
            Flash::warning(trans($this->trans_path.'general.status.no-route-selected'));
        }
        return redirect('/admin/routes');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function disableSelected(Request $request)
    {
        $chkRoute = $request->input('chkRoute');

        if (isset($chkRoute)) {
            foreach ($chkRoute as $route_id) {
                $route = $this->route->find($route_id);
                $route->enabled = false;
                $route->save();
            }
            Flash::success(trans($this->trans_path.'general.status.global-disabled'));
        } else {
            Flash::warning(trans($this->trans_path.'general.status.no-route-selected'));
        }
        return redirect('/admin/routes');
    }

    /**
     * @param Request $request
     * @return array|static[]
     */
    public function searchByName(Request $request)
    {
        $name = $request->input('query');
        $roles = DB::table('routes')
            ->select(DB::raw('id, name as text'))
            ->where('name', 'like', "%$name%")
            ->orWhere('path', 'like', "%$name%")
            ->orWhere('action_name', 'like', "%$name%")
            ->get();
        return $roles;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getInfo(Request $request)
    {
        $id = $request->input('id');
        $route = $this->route->find($id);

        return $route;
    }

    /**
     * Return list of permission as Array
     * with permission name as key
     * and permission id as value
     *
     * @return array
     */
    protected function getPermissionIds()
    {
        $permissions = AppPermission::all();
        $data = [];
        foreach ($permissions as $permission) {
            $data[$permission->name] = $permission->id;
        }
        return $data;
    }



}