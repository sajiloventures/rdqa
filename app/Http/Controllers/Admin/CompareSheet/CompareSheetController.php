<?php

namespace App\Http\Controllers\Admin\CompareSheet;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\CompareSheet\CreateCompareSheetValidationRequest;
use App\Models\CompareSheet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth, Flash, AppHelper, AclHelper, DB;
use Yajra\Datatables\Datatables;

class CompareSheetController extends AdminBaseController
{

    /**
     * @var view location path
     */
    protected $view_path = 'admin.compare_sheet';
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

        $this->base_route = 'admin.compare_sheet';

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);

    }

    public function index()
    {
        $data = [];
        $data['page_title'] = trans($this->trans_path . 'general.page.index.page-title');
        $data['trans_path'] = $this->trans_path;
        $data['compare_sheet'] = CompareSheet::ByStatus()->get();

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('data'));
    }


    public function search(Request $request)
    {
        $data = CompareSheet::select('*');

        return Datatables::of($data)
            ->editColumn('name', function ($compare_sheet) {
                return $compare_sheet->name . ($compare_sheet->name_2 ? ' vs ' . $compare_sheet->name_2 : null);
            })
            ->editColumn('status', function ($compare_sheet) {
                return view($this->loadDefaultVars($this->view_path . '.partials._action_fields'), compact('compare_sheet'))->render();

            })
            ->rawColumns(['status'])
            ->make(true);
    }


    public function create()
    {
        $data = [];
        $data['page_title'] =
            trans($this->trans_path . 'general.page.create.page-title');

        return view($this->loadDefaultVars($this->view_path . '.create'), compact('data', 'province'));
    }

    public function store(CreateCompareSheetValidationRequest $request)
    {
        DB::beginTransaction();

        try {
            $compare_sheet_detail = [
                'name'          => $request->get('compare_name_1'),
                'name_2'        => $request->get('compare_name_2'),
                'description'   => $request->get('description'),
                'user_id'       => auth()->user()->id,
                'status'        => $request->has('status') ? 1 : 0,
            ];

            CompareSheet::create($compare_sheet_detail);

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t create compare_sheet.';
            $message .= PHP_EOL.'Error: '.$e->getMessage();
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('compare_sheet-add-failed', $message);

            Flash::error(trans($this->trans_path . 'general.error.create'));
            return redirect()->back();
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.created'));
        return redirect()->route($this->base_route);

    }

    public function edit($id)
    {
        $compare_sheet = CompareSheet::find($id);

        if(!$compare_sheet) {
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-User'));
            return redirect()->route($this->base_route);
        }

        $compare_sheet->compare_name_1 = $compare_sheet->name;
        $compare_sheet->compare_name_2 = $compare_sheet->name_2;
        return view($this->loadDefaultVars($this->view_path . '.edit'),
            compact('compare_sheet'));
    }

    public function update(CreateCompareSheetValidationRequest $request, $id)
    {
        $compare_sheet = CompareSheet::find($id);


        if(!$compare_sheet){
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-compare_sheet'));
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $compare_sheet->name  = $request->get('compare_name_1');
            $compare_sheet->name_2  = $request->get('compare_name_2');
            $compare_sheet->description  = $request->get('description');
            if ($request->has('status'))
                $compare_sheet->status = 1;
            else
                $compare_sheet->status = 0;


            $compare_sheet->save();

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t update compare_sheet';
            $message .= PHP_EOL.'Error: '.$e->getMessage();;
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('compare_sheet-update-failed', $message);
            Flash::error(trans($this->trans_path . 'general.error.cant-edit-this-compare_sheet'));
            return redirect()->back();
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.updated'));
        return redirect()->route($this->base_route);
    }

    public function enable($id)
    {
        $compare_sheet = CompareSheet::find($id);

        if (!$compare_sheet) {
            Flash::error(trans($this->trans_path . 'general.error.enabled'));
            return redirect()->route($this->base_route);
        }
        $compare_sheet->status = 1;
        $compare_sheet->save();

        Flash::success(trans($this->trans_path . 'general.status.enabled'));

        return redirect(route($this->base_route));
    }

    public function disable($id)
    {
        $compare_sheet = CompareSheet::find($id);

        if (!$compare_sheet) {
            Flash::error(trans($this->trans_path . 'general.error.disabled'));
            return redirect()->route($this->base_route);
        }
        $compare_sheet->status = 0;
        $compare_sheet->save();

        Flash::success(trans($this->trans_path . 'general.status.disabled'));

        return redirect(route($this->base_route));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        $compare_sheet = CompareSheet::find($id);
        try {
            if (!$compare_sheet) {
                Flash::success(trans($this->trans_path . 'general.status.deleted'));
                return redirect()->route($this->base_route);
            }

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t remove compare_sheet -> ' . $compare_sheet ? $compare_sheet->id : null;
            $message .= PHP_EOL.'Error: '.$e->getMessage();;
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('compare_sheet-delete-failed', $message);

        }

        DB::commit();

        if(!$compare_sheet->delete())
            Flash::error(trans($this->trans_path . 'general.error.cant-delete-this-compare_sheet'));
        else
            Flash::success(trans($this->trans_path . 'general.status.deleted'));

        return redirect()->route($this->base_route);

    }

}
