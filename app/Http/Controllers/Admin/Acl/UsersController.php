<?php namespace App\Http\Controllers\Admin\Acl;

use App\Http\Controllers\AclBaseController;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Acl\AdminUsers\CreateUserRequest;
use App\Http\Requests\Admin\Acl\AdminUsers\UpdateUserRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Repositories\Criteria\User\UsersWithRoles;
use App\Repositories\Criteria\User\UsersByUsernamesAscending;
use App\Repositories\UserRepository as User;
use App\Repositories\RoleRepository as Role;
use Flash;
use Auth;
use DB;
use View; 
use AppHelper;

class UsersController extends AdminBaseController
{

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Role
     */
    protected $role;

    /**
     * @var Permission
     */
    protected $perm;

    /**
     * @var view location path
     */
    protected $view_path = 'admin.acl.users';

    /**
     * @var translation array path
     */
    protected $trans_path;


    /**
     * @param User $user
     * @param Role $role
     */
    public function __construct(User $user, Role $role, Permission $perm)
    {
        parent::__construct();

        $this->user = $user;
        $this->role = $role;
        $this->perm = $perm;

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $page_title = trans($this->trans_path . 'general.page.index.title'); // "Admin | Users";
        $page_description = trans($this->trans_path . 'general.page.index.description'); // "List of users";

        $users = $this->user->pushCriteria(new UsersWithRoles())->pushCriteria(new UsersByUsernamesAscending())->paginate(AppHelper::getConfigValue('ADMIN-PAGINATION-LIMIT'));

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('users', 'page_title', 'page_description'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = $this->user->find($id);

        $page_title = trans($this->trans_path . 'general.page.show.title'); // "Admin | User | Show";
        $page_description = trans($this->trans_path . 'general.page.show.description', ['full_name' => $user->full_name]); // "Displaying user";

//        $roleCollection = \App\Models\Role::take(10)->get(['id', 'display_name'])->lists('display_name', 'id');
//        $roleList = [''=>''] + $roleCollection->all();
        $perms = $this->perm->all();

        return view($this->loadDefaultVars($this->view_path . '.show'), compact('user', 'perms', 'page_title', 'page_description'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $page_title = trans($this->trans_path . 'general.page.create.title'); // "Admin | User | Create";
        $page_description = trans($this->trans_path . 'general.page.create.description'); // "Creating a new user";

        $perms = $this->perm->all();
        $user = new \App\User();
//        $userRoles = $user->roles;
//        $roleCollection = \App\Models\Role::take(10)->get(['id', 'display_name'])->lists('display_name', 'id');
//        $roleList = [''=>''] + $roleCollection->all();

        return view($this->loadDefaultVars($this->view_path . '.create'), compact('user', 'perms', 'page_title', 'page_description'));
    }

    /**
     * @param CreateUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateUserRequest $request)
    {
        $attributes = $request->all();

        if (array_key_exists('selected_roles', $attributes) && !empty($attributes['selected_roles'])) {
            $attributes['role'] = explode(",", $attributes['selected_roles']);
        }

        // Create basic user.
        $user = $this->user->create($attributes);

        // Run the update method to set enabled status and roles membership.
        $user->update($attributes);

        Flash::success(trans($this->trans_path . 'general.status.created')); // 'User successfully created');

        return redirect('/admin/users');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->user->find($id);

        $page_title = trans($this->trans_path . 'general.page.edit.title'); // "Admin | User | Edit";
        $page_description = trans($this->trans_path . 'general.page.edit.description', ['full_name' => $user->full_name]); // "Editing user";

        if (!$user->isEditable()) {
            abort(403);
        }

        $roles = $this->role->all();
        $perms = $this->perm->all();
        // $roleCollection = \App\Models\Role::take(10)->get(['id', 'display_name'])->lists('display_name', 'id');
        // $roleList = [''=>''] + $roleCollection->all();

        return view($this->loadDefaultVars($this->view_path . '.edit'), compact('user', 'roles', 'perms', 'page_title', 'page_description'));
    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->user->find($id);

        if (!$user->isEditable()) {
            abort(403);
        }

        $attributes = $request->all();

        if (array_key_exists('selected_roles', $attributes)) {
            $attributes['role'] = explode(",", $attributes['selected_roles']);
        }

        $user->update($attributes);

        Flash::success(trans($this->trans_path . 'general.status.updated'));

        return redirect('/admin/users');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);

        if (!$user->isdeletable()) {
            abort(403);
        }

        $this->user->delete($id);

        Flash::success(trans($this->trans_path . 'general.status.deleted'));

        return redirect('/admin/users');
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

        $user = $this->user->find($id);

        if (!$user->isdeletable()) {
            abort(403);
        }

        $modal_title = trans($this->trans_path . 'dialog.delete-confirm.title');
        $modal_cancel = trans('admin/general.button.cancel');
        $modal_ok = trans('admin/general.button.ok');

        if (Auth::user()->id !== $id) {
            $user = $this->user->find($id);
            $modal_route = route('admin.users.delete', array('id' => $user->id));

            $modal_body = trans($this->trans_path . 'dialog.delete-confirm.body', ['id' => $user->id, 'full_name' => $user->full_name]);
        } else {
            $error = trans($this->trans_path . 'general.error.cant-delete-yourself');
        }
        return view('admin.partials.modal_confirmation', compact('error', 'modal_route',
            'modal_title', 'modal_body', 'modal_cancel', 'modal_ok'));

    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function enable($id)
    {
        $user = $this->user->find($id);
        $user->enabled = true;
        $user->save();

        Flash::success(trans($this->trans_path . 'general.status.enabled'));

        return redirect('/admin/users');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function disable($id)
    {
        $user = $this->user->find($id);

        if (!$user->canBeDisabled()) {
            Flash::error(trans($this->trans_path . 'general.error.cant-be-disabled'));
        } else {
            $user->enabled = false;
            $user->save();
            Flash::success(trans($this->trans_path . 'general.status.disabled'));
        }

        return redirect('/admin/users');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function enableSelected(Request $request)
    {
        $chkUsers = $request->input('chkUser');

        if (isset($chkUsers)) {
            foreach ($chkUsers as $user_id) {
                $user = $this->user->find($user_id);
                $user->enabled = true;
                $user->save();
            }
            Flash::success(trans($this->trans_path . 'general.status.global-enabled'));
        } else {
            Flash::warning(trans($this->trans_path . 'general.status.no-user-selected'));
        }
        return redirect('/admin/users');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function disableSelected(Request $request)
    {
        $chkUsers = $request->input('chkUser');

        if (isset($chkUsers)) {
            foreach ($chkUsers as $user_id) {
                $user = $this->user->find($user_id);
                if (!$user->canBeDisabled()) {
                    Flash::error(trans($this->trans_path . 'general.error.cant-be-disabled'));
                } else {
                    $user->enabled = false;
                    $user->save();
                }
            }
            Flash::success(trans($this->trans_path . 'general.status.global-disabled'));
        } else {
            Flash::warning(trans($this->trans_path . 'general.status.no-user-selected'));
        }
        return redirect('/admin/users');
    }

    public function searchByName(Request $request)
    {
        $name = $request->input('query');
        $users = DB::table('users')
            ->select(DB::raw('id, email as text'))
            ->where('first_name', 'like', "%$name%")
            ->orwhere('last_name', 'like', "%$name%")
            ->orwhere('email', 'like', "%$name%")
            ->orWhere('username', 'like', "%$name%")
            ->get();
        return $users;
    }

    public function listByPage(Request $request)
    {
        $skipNumb = $request->input('s');
        $takeNumb = $request->input('t');

        $userCollection = \App\User::skip($skipNumb)->take($takeNumb)
            ->get(['id', 'first_name','last_name', 'username'])
            ->lists('full_name_and_username', 'id');
        $userList = $userCollection->all();

        return $userList;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getInfo(Request $request)
    {
        $id = $request->input('id');
        $user = $this->user->find($id);

        return $user;
    }

}