<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Requests\Admin\Resource\CreateResourceValidationRequest;
use App\Http\Requests\Admin\Resource\EditResourceValidationRequest;
use App\Models\Resource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth, Flash, AppHelper, AclHelper, DB, File;
use Yajra\Datatables\Datatables;

class ResourceController extends UploadController
{

    /**
     * @var view location path
     */
    protected $view_path = 'admin.resource';
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

        $this->base_route = 'admin.resource';

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);

    }

    public function index()
    {
        $data = [];
        $data['page_title'] = trans($this->trans_path . 'general.page.index.page-title');

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('data'));
    }


    public function search(Request $request)
    {
        $data = Resource::select('*');

        return Datatables::of($data)
            ->editColumn('status', function ($resource) {
                return view($this->loadDefaultVars($this->view_path . '.partials._action_fields'), compact('resource'))->render();

            })
            ->addColumn('file', function ($resource) {
                $links = null;
                $files = explode('~,', $resource->files);
                if ($resource->files && count($files) > 0)
                    foreach ($files as $file) {
                        $path = asset(config('rdqa.asset_path.resource_file')) . '/' . $file;
                        if (File::exists(public_path(config('rdqa.asset_path.resource_file')) . '/' . $file))
                            $links .= '<a href="' . $path . '" class="btn btn-default btn-xs fileList" download>' . $file . '</a> &nbsp;';
                    }
                return $links;
            })
            ->rawColumns(['file', 'status'])
            ->make(true);
    }

    public function create()
    {
        \Storage::deleteDirectory('upload/' . auth()->user()->id . '/');
        $data = [];
        $data['page_title'] = trans($this->trans_path . 'general.page.create.page-title');

        return view($this->loadDefaultVars($this->view_path . '.create'), compact('data'));
    }

    public function store(CreateResourceValidationRequest $request)
    {
        DB::beginTransaction();

        try {
            $resource_detail = [
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'created_by' => auth()->user()->id,
                'status'        => $request->has('status') ? 1 : 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if ($request->get('fileName') && is_array($request->get('fileName'))) {
                $path = public_path(config('rdqa.asset_path.resource_file'));
                $this->createFolderIfNotExits($path);
                $files = [];
                foreach ($request->get('fileName') as $file) {
                    $filePath = "upload/";
                    $filePath = storage_path("app/" . $filePath . auth()->user()->id . '/' . $file);
                    if (File::exists($filePath)) {
                        File::move($filePath, public_path(config('rdqa.asset_path.resource_file') . '/'. $file));
                    }
                    array_push($files, $file);
                }

                $resource_detail += ['files' => join('~,', $files)];
            }

            Resource::create($resource_detail);

            \Storage::deleteDirectory('upload/' . auth()->user()->id . '/');
        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t create resource.';
            $message .= PHP_EOL.'Error: '.$e->getMessage();
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('resource-add-failed', $message);

            Flash::error(trans($this->trans_path . 'general.error.create'))->important();
            return redirect()->back();
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.created'))->important();
        return redirect()->route($this->base_route);

    }

    public function edit($id)
    {
        \Storage::deleteDirectory('upload/' . auth()->user()->id . '/');

        $resource = Resource::find($id);
        if(!$resource) {
            Flash::error(trans($this->trans_path . 'general.status.invalid'))->important();
            return redirect()->route($this->base_route);
        }

        return view($this->loadDefaultVars($this->view_path . '.edit'),
            compact('resource'));
    }

    public function update(EditResourceValidationRequest $request, $id)
    {
        $resource = Resource::find($id);


        if(!$resource){
            Flash::error(trans($this->trans_path . 'general.error.invalid'))->important();
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $resource->name    = $request->get('name');
            $resource->description    = $request->get('description');
            $resource->updated_at       = Carbon::now();

            if ($request->get('fileName') && is_array($request->get('fileName'))) {
                $path = public_path(config('rdqa.asset_path.resource_file'));
                $this->createFolderIfNotExits($path);
                $files = [];
                $oldFiles = explode('~,', $resource->files);
                foreach ($request->get('fileName') as $file) {
                    if (array_search($file, $oldFiles) > -1)
                        unset($oldFiles[array_search($file, $oldFiles)]);
                    $filePath = "upload/";
                    $filePath = storage_path("app/" . $filePath . auth()->user()->id . '/' . $file);
                    if (File::exists($filePath)) {
                        File::move($filePath, public_path(config('rdqa.asset_path.resource_file') . '/'. $file));
                    }
                    array_push($files, $file);
                }

                $resource->files = join('~,', $files);

                if (count($oldFiles) > 0) {
                    foreach ($oldFiles as $fl)
                        $this->deleteFileIfExists($fl);
                }
            }

            if ($request->has('status'))
                $resource->status = 1;
            else
                $resource->status = 0;


            $resource->save();
            \Storage::deleteDirectory('upload/' . auth()->user()->id . '/');

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t update resource';
            $message .= PHP_EOL.'Error: '.$e->getMessage();;
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('resource-update-failed', $message);
            Flash::error(trans($this->trans_path . 'general.error.update'))->important();
            return redirect()->back()->withInput();
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.updated'))->important();
        return redirect()->route($this->base_route);
    }

    public function enable($id)
    {
        $resource = Resource::find($id);

        if (!$resource) {
            Flash::error(trans($this->trans_path . 'general.error.enabled'))->important();
            return redirect()->route($this->base_route);
        }
        $resource->status = 1;
        $resource->save();

        Flash::success(trans($this->trans_path . 'general.status.enabled'))->important();

        return redirect(route($this->base_route));
    }

    public function disable($id)
    {
        $resource = Resource::find($id);

        if (!$resource) {
            Flash::error(trans($this->trans_path . 'general.error.disabled'))->important();
            return redirect()->route($this->base_route);
        }
        $resource->status = 0;
        $resource->save();

        Flash::success(trans($this->trans_path . 'general.status.disabled'))->important();

        return redirect(route($this->base_route));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        $resource = Resource::find($id);
        try {
            if (!$resource) {
                Flash::success(trans($this->trans_path . 'general.status.deleted'))->important();
                return redirect()->route($this->base_route);
            }

            $oldFiles = explode('~,', $resource->files);

            if (count($oldFiles) > 0) {
                foreach ($oldFiles as $fl)
                    $this->deleteFileIfExists($fl);
            }

            if(!$resource->delete())
                Flash::error(trans($this->trans_path . 'general.error.delete'))->important();
            else {
                DB::commit();
                Flash::success(trans($this->trans_path . 'general.status.deleted'))->important();
            }
        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t remove resource -> ' . $resource ? $resource->id : null;
            $message .= PHP_EOL.'Error: '.$e->getMessage();;
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('resource-delete-failed', $message);

        }

        return redirect()->route($this->base_route);

    }

    public function createFolderIfNotExits($path = null)
    {
        if (!$path)
            $path = public_path(config('rdqa.asset_path.resource_file'));

        try {
            if(!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
        } catch (\Exception $e) {
            AppHelper::exceptionHandler($e, "Resource Folder Creation failed");
        }

    }

    public function deleteFileIfExists($image){
        //get file path
        $file_original = public_path(config('rdqa.asset_path.resource_file') . $image);
        //checks file before delete it.
        if(File::isFile($file_original)){
            File::delete($file_original);
        }
    }

}
