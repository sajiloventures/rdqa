<?php

namespace App\Http\Controllers\Admin\Admin_Users;

use App\Http\Requests\Admin\Admin_Users\EditUserProfileValidationRequest;
use App\Models\AdminUser;
use App\Models\Facility;
use App\Models\ProvinceDistrict;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminUsersBaseController;
use App\Http\Requests\Admin\Admin_Users\CreateAdminUserValidationRequest;
use App\Http\Requests\Admin\Admin_Users\EditAdminUserValidationRequest;
use Auth, Carbon\Carbon, Flash, AppHelper, AclHelper, DB;
use Yajra\Datatables\Datatables;
Use App\Models\Role;

class AdminUsersController extends AdminUsersBaseController
{

    /**
     * @var view location path
     */
    protected $view_path = 'admin.admin_users';
    protected $user_code = '';

    /**
     * @var translation array path
     */
    protected $trans_path;

    protected $user;
    protected $admin_user;

    public function __construct()
    {
        parent:: __construct();

        $this->base_route = 'admin.admin_users';

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);

    }

    public function index()
    {
        $data = [];
        $data['page_title'] = trans($this->trans_path . 'general.page.index.page-title');
        $data['show_modal'] = false;
        $data['trans_path'] = $this->trans_path;

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('data'));
    }

    public function search(Request $request)
    {
        $columns = ['users.*', 'r.name', 'r.display_name', 'r.name as user_type'];
        $data = User::select($columns)
            ->selectRaw('CONCAT_WS(" ", users.first_name, users.last_name) as name')
            ->selectRaw('CONCAT_WS(" ", nu.first_name, nu.last_name) as palika_name')
            ->leftJoin('users as nu', 'nu.id', '=', 'users.palika_user_id')
            ->leftJoin('role_user as ru', 'users.id', '=', 'ru.user_id')
            ->leftJoin('roles as r', 'r.id', '=', 'ru.role_id')
            ->FilterByRole()
            ->whereNotIn('r.name', AppHelper::getExcludedRoles())
            ->whereNotIn('users.id', [1])
            ->groupBy('users.id')
            ->get();

        $usedFacilityUsers = parent::getSelectedFacilityUserIds();

        return Datatables::of($data)
            ->editColumn('user_type', function ($users) {
                return config('rdqa.admin-users-roles.' . $users->user_type . '.title');
            })
            ->editColumn('status', function ($users) use ($usedFacilityUsers) {
                 return view($this->loadDefaultVars($this->view_path . '.partials._action_fields'), compact('users', 'usedFacilityUsers'))->render();

            })
            ->editColumn('palika_name', function ($users) {
              
                  if($users->user_type == 'super-admin'){
                    return null;
                  }
                elseif($users->user_type == 'rdqa-admin'){
                    return null;
                }
                elseif($users->user_type == 'province-user'){
                    return null;
                }
                elseif($users->user_type == 'district-user'){
                    return $users->district;
                }
                elseif($users->user_type = 'palika-user'){
                    return $users->municipality;
                }
                elseif($users->user_type = 'facility-user'){
                    return $users->health_post_name;
                } 
                // return $users->id != $users->palika_user_id ? $users->palika_name : null;

            })
            ->rawColumns(['id', 'user_type', 'status'])
            ->make(true);
    }

    public function create()
    {
        $data = [];
        $data['page_title'] =
            trans($this->trans_path . 'general.page.create.page-title');

        $province = $this->nepalDetail(request());
        $data['province_users'] = $this->userDetails(request());

        $data['users_list'] = $this->getPalikaUsersArray();

        $data += $this->getUserSelectedRoleIds();
        $data['palika_user_display'] = AclHelper::getUserRole() == 'palika-user' ? 'none' : 'block';

        return view($this->loadDefaultVars($this->view_path . '.create'), compact('data', 'province'));
    }

    protected function getUserSelectedRoleIds()
    {
        $required_data = [
            'province_user_id' => null,
            'district_user_id' => null,
            'palika_user_id' => null
        ];
        $user = auth()->user();
        switch (AclHelper::getUserRole()) {
            case 'province-user':
                $required_data['province_user_id'] = $user->id;
                break;
            case 'district-user':
                $required_data['province_user_id'] = $user->province_user_id;
                $required_data['district_user_id'] = $user->id;
                break;
            case 'palika-user':
                $required_data['province_user_id'] = $user->province_user_id;
                $required_data['district_user_id'] = $user->district_user_id;
                $required_data['palika_user_id'] = $user->id;
                break;
        }
        return $required_data;

    }

    public function store(CreateAdminUserValidationRequest $request)
    {
        DB::beginTransaction();

        try {

            $username = $request->username;
            if (!$username || $username == "") {
                do {
                    $username = AppHelper::generateRandomString();

                } while(User::where('username', $username)->count() > 0);
            }

            $users_detail = [
                'first_name'        => $request->get('first_name'),
                'last_name'         => $request->get('last_name'),
                'username'          => $username,
                'email'             => $request->get('email'),
                'province'          => $request->get('province'),
                'district'          => $request->get('district'),
                'municipality'      => $request->get('municipality'),
                'health_post_name'  => $request->get('health_post_name'),
                'password'          => bcrypt($request->get('password')),
                'enabled'           => $request->has('enabled') ? 1 : 0,
                'created_by'        => auth()->user()->id,
            ];

            $selectedRole = config('rdqa.admin-users-roles.' . $request->get('user_role') . '.key');

            if (!$this->checkValidUserRole($selectedRole))  {
                Flash::error('Role you have selected for this user is invalid');
                return redirect()->back();
            }

            $adminUser = AdminUser::create($users_detail);

            $otherUserDetail = $this->defineSelectedRolesArray($request, $selectedRole, $adminUser);

            $adminUser->update($otherUserDetail);

            $user = User::find($adminUser->id);

            $user_role_sync_id = Role::where('name', '=', $selectedRole)->first()->id;
            $user->roles()->sync([$user_role_sync_id]);

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t add admin user details.';
            $message .= PHP_EOL.'Error: '.$e->getMessage();
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('user-add-failed', $message);

        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.created'));
        return redirect()->route($this->base_route);

    }

    private function checkValidUserRole($role)
    {
        return ($role == 'facility-user' || $role == 'rdqa-admin' || $role == 'province-user'
            || $role == 'district-user' || $role == 'palika-user');
    }

    public function edit($user_code)
    {
        $user = $this->getUserQuery($user_code);

        $data['users_list'] = [];

        $data['province_users'] = $this->userDetails(request());
        $data += $this->getUserSelectedRoleIds();

        $data['palika_user_display'] = AclHelper::getUserRole() == 'palika-user' ? 'none' : 'block';

        if(!$user) {
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-User'));
            return redirect()->route($this->base_route);
        }

        $province = $this->nepalDetail(request());
        return view($this->loadDefaultVars($this->view_path . '.edit'),
            compact('user', 'province', 'data'));
    }

    public function update(EditAdminUserValidationRequest $request, $user_code)
    {
        $user = $this->getUserQuery($user_code);

        if(!$user){
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-User'));
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $user_detail = [
                'first_name'        => $request->get('first_name'),
                'last_name'         => $request->get('last_name'),
                'province'          => $request->get('province'),
                'district'          => $request->get('district'),
                'municipality'      => $request->get('municipality'),
                'health_post_name'  => $request->get('health_post_name'),
            ];

            if ($request->has('email') && auth()->user()->id != $user_code)
                $user_detail += ['email' => $request->get('email')];

            $user_detail += ['enabled' => $request->has('enabled') && auth()->user()->id != $user_code ? 1 : 0];

            if ($request->has('password') && $request->get('password'))
                $user_detail += ['password' => bcrypt($request->get('password'))];

            if ($request->has('username'))
                $user_detail += ['username' => $request->get('username')];

            $selectedRole = config('rdqa.admin-users-roles.' . $request->get('user_role') . '.key');

            if (!$this->checkValidUserRole($selectedRole))  {
                Flash::error('Role you have selected for this user is invalid');
                return redirect()->back();
            }

            $user_detail += $this->defineSelectedRolesArray($request, $selectedRole, $user);

            $adminUser = AdminUser::find($user->id);

            $adminUser->update($user_detail);

            if (auth()->user()->id != $user_code) {
                $user_role_sync_id = Role::where('name', '=', $selectedRole)->first()->id;
                $user->roles()->sync([$user_role_sync_id]);
            }

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t update admin user details .';
            $message .= PHP_EOL.'Error: '.$e->getMessage();;
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('user-update-failed', $message);
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-User'));
            return redirect()->back();
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.updated'));
        return redirect()->route($this->base_route);
    }

    protected function defineSelectedRolesArray($request, $selectedRole, $user)
    {
        $user_detail = $this->getUserSelectedRoleIds();

        $user_detail += [
            'hf_user' => 0,
        ];

        if ($selectedRole == 'province-user') {
            $user_detail['province_user_id'] = $user->id;
        }
        if ($selectedRole == 'district-user') {
            $user_detail['province_user_id'] = $user_detail['province_user_id'] ? $user_detail['province_user_id'] : $request->get('province_user_id');
            $user_detail['district_user_id'] = $user->id;
        }
        if ($selectedRole == 'palika-user') {
            $user_detail['province_user_id'] = $user_detail['province_user_id'] ? $user_detail['province_user_id'] : $request->get('province_user_id');
            $user_detail['district_user_id'] = $user_detail['district_user_id'] ? $user_detail['district_user_id'] :  $request->get('district_user_id');
            $user_detail['palika_user_id'] = $user->id;
        }
        if ($selectedRole == 'facility-user') {
            $user_detail['province_user_id'] = $user_detail['province_user_id'] ? $user_detail['province_user_id'] : $request->get('province_user_id');
            $user_detail['district_user_id'] = $user_detail['district_user_id'] ? $user_detail['district_user_id'] :  $request->get('district_user_id');
            $user_detail['palika_user_id']   = $user_detail['palika_user_id'] ? $user_detail['palika_user_id'] : $request->get('palika_user_id');
            $user_detail['hf_user']   = 1;
        }
        return $user_detail;
    }

    public function enable($user_code, $req_type = null)
    {
        $user = $this->getUserQuery($user_code, null, true);

        if (!$user) {
            Flash::error(trans($this->trans_path . 'general.error.enabled'));
            return redirect()->route($this->base_route);
        }
        $user->enabled = true;
        $user->save();

        if ($req_type == 'bulk') {
            return 'ok';
        }

        Flash::success(trans($this->trans_path . 'general.status.enabled'));

        return redirect(route($this->base_route));
    }

    public function disable($user_code, $req_type = null)
    {

        $user = $this->getUserQuery($user_code, null, true);

        if (!$user) {
            Flash::error(trans($this->trans_path . 'general.error.disabled'));
            return redirect()->route($this->base_route);
        }
        $user->enabled = false;
        $user->save();

        if ($req_type == 'bulk') {
            return 'ok';
        }

        Flash::success(trans($this->trans_path . 'general.status.disabled'));

        return redirect(route($this->base_route));
    }

    public function destroy($user_code)
    {
        DB::beginTransaction();

        try {
            $user = $this->getUserQuery($user_code, null, true);
            if (!$user || in_array($user->id, parent::getSelectedFacilityUserIds())) {
                Flash::success(trans($this->trans_path . 'general.status.deleted'));
                return redirect()->route($this->base_route);
            }

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t remove admin user details.';
            $message .= PHP_EOL.'Error: '.$e->getMessage();;
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('user-delete-failed', $message);

        }


        if(!$user->delete())
            Flash::error(trans($this->trans_path . 'general.error.cant-delete-this-User'));
        else
            Flash::success(trans($this->trans_path . 'general.status.deleted'));

        DB::commit();
        return redirect()->route($this->base_route);

    }

    protected function getUserQuery($user_code, $columns = null, $delete =false)
    {
        if (!$columns)
            $columns = ['users.*', 'r.name', 'r.display_name', 'r.name as user_role'];

        $user =  User::select($columns)->join('role_user as ru', 'users.id', '=', 'ru.user_id')
            ->join('roles as r', 'r.id', '=', 'ru.role_id')
            ->FilterByRole()
            ->whereNotIn('r.name', AppHelper::getExcludedRoles())
            ->where('users.id', $user_code);

        if ($delete && $delete)
            $user->whereNotIn('users.id', [1, auth()->user()->id]);
        else
            $user->whereNotIn('users.id', [1]);

        return $user->first();
    }


    public function userDetails(Request $request)
    {
        $type = $id = null;
        if ($request->has('type'))
            $type = $request->get('type');

        if ($request->has('id'))
            $id = $request->get('id');

        switch ($type) {

            case 'district':
                $district_users = User::select('users.id')
                    ->selectRaw('CONCAT_WS(" ", users.first_name, users.last_name) as name')
                    ->leftJoin('role_user as ru', 'users.id', '=', 'ru.user_id')
                    ->leftJoin('roles as r', 'r.id', '=', 'ru.role_id')
                    ->where('r.name', 'district-user')
                    ->where('users.province_user_id', '=', $id)
                    ->pluck('name', 'id')
                    ->toArray();

                $data = response()->json($district_users);

                break;
            case 'palika':
                $palika_users = User::select('users.id')
                    ->selectRaw('CONCAT_WS(" ", users.first_name, users.last_name) as name')
                    ->leftJoin('role_user as ru', 'users.id', '=', 'ru.user_id')
                    ->leftJoin('roles as r', 'r.id', '=', 'ru.role_id')
                    ->where('r.name', 'palika-user')
                    ->where('users.district_user_id', '=', $id)
                    ->pluck('name', 'id')
                    ->toArray();

                $data = response()->json($palika_users);
                break;
            case 'health_post_name':
                $hf_users = User::select('users.id')
                    ->selectRaw('CONCAT_WS(" ", users.first_name, users.last_name) as name')
                    ->leftJoin('role_user as ru', 'users.id', '=', 'ru.user_id')
                    ->leftJoin('roles as r', 'r.id', '=', 'ru.role_id')
                    ->where('r.name', 'facility-user')
                    ->where('users.palika_user_id', '=', $id)
                    ->pluck('name', 'id')
                    ->toArray();

                $data = response()->json($hf_users);
                break;
            default:
                $province_users = User::select('users.id')
                    ->selectRaw('CONCAT_WS(" ", users.first_name, users.last_name) as name')
                    ->leftJoin('role_user as ru', 'users.id', '=', 'ru.user_id')
                    ->leftJoin('roles as r', 'r.id', '=', 'ru.role_id')
                    ->where('r.name', 'province-user')
                    ->pluck('name', 'id')
                    ->toArray();

                $data = $province_users;
                break;
        }

        return $data;

    }

    public function nepalDetail(Request $request)
    {
        $data = [];
        $type = $id = null;
        if ($request->has('type'))
            $type = $request->get('type');

        if ($request->has('id'))
            $id = $request->get('id');

        switch ($type) {

            case 'district':
                $district = Facility::select('district_name')
                    ->ByStatus()
                    ->where('province_name', $id)
                    ->groupBy('district_name')
                    ->orderBy('district_name')
                    ->pluck('district_name')
                    ->toArray();

                $data = $district;

//                foreach ($district as $row)
//                    array_push($data, $row->district_name);

                $data = response()->json($data);

                break;
            case 'municipality':
                $palika_name = Facility::select('palika_name')
                    ->ByStatus()
                    ->where('district_name', $id)
                    ->groupBy('palika_name')
                    ->orderBy('palika_name')
                    ->pluck('palika_name')
                    ->toArray();

                $data = $palika_name;

//                foreach ($palika_name as $row)
//                    array_push($data, $row->palika_name);

                $data = response()->json($data);
                break;
            case 'health_post_name':
                $hf_name = Facility::select('id', 'hf_name')
                    ->ByStatus()
                    ->where('palika_name', $id)
                    ->groupBy('hf_name')
                    ->orderBy('hf_name')
                    ->pluck('hf_name', 'id')
                    ->toArray();

                $data = $hf_name;

//                foreach ($hf_name as $row)
//                    $data += [$row->id => $row->hf_name];

                $data = response()->json($data);
                break;
            default:
                $province = Facility::select('province_name')
                    ->groupBy('province_name')
                    ->orderBy('province_name')
                    ->pluck('province_name', 'province_name')
                    ->toArray();

                $data = $province;
//                foreach ($province as $prov)
//                    $data += [$prov->province_name => $prov->province_name];
                break;
        }

        return $data;

    }


    public function nepalDetailOld(Request $request)
    {
        $data = [];
        $type = $id = null;
        if ($request->has('type'))
            $type = $request->get('type');

        if ($request->has('id'))
            $id = $request->get('id');

        switch ($type) {

            case 'district':
                $getStateID = explode('province ', strtolower($id));
                if (count($getStateID) > 1)
                    $id = $getStateID[1];
                $district = ProvinceDistrict::select('district')->where('state', $id)->groupBy('district')->orderBy('district')->get();

                foreach ($district as $row)
                    array_push($data, $row->district);

                $data = response()->json($data);

                break;
            case 'municipality':
                $municipality = ProvinceDistrict::select('municipality')->where('district', $id)->groupBy('municipality')->orderBy('municipality')->get();

                foreach ($municipality as $row)
                    $data += [$row->municipality => $row->municipality];

                $data = response()->json($data);
                break;
            default:
                $province = ProvinceDistrict::select('state')->groupBy('state')->orderBy('state')->get();
                foreach ($province as $prov)
                    $data += ['Province ' . $prov->state => 'Province ' . $prov->state];
                break;
        }

        return $data;

    }

    private function getPalikaUsersArray($user_id = null)
    {
        $getUserList = User::select('users.id')
            ->selectRaw('CONCAT_WS(" ", users.first_name, users.last_name) as name')
            ->leftJoin('role_user as ru', 'users.id', '=', 'ru.user_id')
            ->leftJoin('roles as r', 'r.id', '=', 'ru.role_id')
            ->where('r.name', 'palika-user')
            ->where('users.id', '!=', $user_id)
            ->pluck('name', 'id')
            ->toArray();

        return $getUserList;
    }
    public function editProfile()
    {
        $user = auth()->user();

        if(!$user) {
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-User'));
            return redirect()->route($this->base_route);
        }

        return view($this->loadDefaultVars($this->view_path . '.edit_profile'),
            compact('user'));
    }
    public function updateProfile(EditUserProfileValidationRequest $request)
    {
        $user = AdminUser::find(auth()->user()->id);

        if(!$user) {
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-User'));
            return redirect()->back();
        }

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');

        if ($request->has('password') && $request->get('password'))
            $user->password = bcrypt($request->get('password'));

        $user->save();

        Flash::success(trans($this->trans_path . 'general.status.updated'));
        return redirect()->back();
    }


}
