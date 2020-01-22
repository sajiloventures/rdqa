<?php

namespace App\Http\Controllers\Admin\FAQ;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\FAQ\CreateFAQValidationRequest;
use App\Models\FAQ;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth, Flash, AppHelper, AclHelper, DB, File;

class FAQController extends AdminBaseController
{

    /**
     * @var view location path
     */
    protected $view_path = 'admin.faq';
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

        $this->base_route = 'admin.faq';

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);

    }

    public function index()
    {
        $data = [];
        $data['page_title'] = trans($this->trans_path . 'general.page.index.page-title');
        $data['trans_path'] = $this->trans_path;
        $data['faq'] = FAQ::orderBy('sort_order')->get();

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('data'));
    }

    public function create()
    {
        $data = [];
        $data['page_title'] =
            trans($this->trans_path . 'general.page.create.page-title');

        return view($this->loadDefaultVars($this->view_path . '.create'), compact('data'));
    }

    public function store(CreateFAQValidationRequest $request)
    {
        DB::beginTransaction();

        try {
            $faq_detail = [
                'created_by' => auth()->user()->id,
                'question' => $request->get('question'),
                'answer' => $request->get('answer'),
                'sort_order' => 999,
                'status'        => $request->has('status') ? 1 : 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            FAQ::create($faq_detail);

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t create faq.';
            $message .= PHP_EOL.'Error: '.$e->getMessage();
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('faq-add-failed', $message);

            Flash::error(trans($this->trans_path . 'general.error.create'))->important();
            return redirect()->back();
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.created'))->important();
        return redirect()->route($this->base_route);

    }

    public function edit($id)
    {
        $faq = FAQ::find($id);

        if(!$faq) {
            Flash::error(trans($this->trans_path . 'general.error.edit'))->important();
            return redirect()->route($this->base_route);
        }

        return view($this->loadDefaultVars($this->view_path . '.edit'),
            compact('faq'));
    }

    public function update(CreateFAQValidationRequest $request, $id)
    {
        $faq = FAQ::find($id);

        if(!$faq){
            Flash::error(trans($this->trans_path . 'general.error.edit'))->important();
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $faq->question          = $request->get('question');
            $faq->answer            = $request->get('answer');
            $faq->updated_at       = Carbon::now();

            if ($request->has('status'))
                $faq->status = 1;
            else
                $faq->status = 0;


            $faq->save();

        } catch (\Exception $e) {

            DB::rollback();
            $message = 'Couldn\'t update faq';
            $message .= PHP_EOL.'Error: '.$e->getMessage();;
            $message .= PHP_EOL.'Path: '.get_class($this).'@'.__FUNCTION__;
            $message .= PHP_EOL.'URl: '. request()->fullUrl();
            \AppHelper::systemError('faq-update-failed', $message);
            Flash::error(trans($this->trans_path . 'general.error.edit'))->important();
            return redirect()->back();
        }

        DB::commit();

        Flash::success(trans($this->trans_path . 'general.status.updated'))->important();
        return redirect()->route($this->base_route);
    }

    public function sortData(Request $request)
    {
        $count = 0;
        foreach ($request->get('sort_data') as $sort_id)
        {
            if (isset($sort_id['id'])){
                $faq = FAQ::find($sort_id['id']);
                if ($faq) {
                    $faq->sort_order = ++$count;
                    $faq->save();
                }
            }
        }
        return response()->json('Success', 200);
    }

    public function enable($id)
    {
        $faq = FAQ::find($id);

        if (!$faq) {
            Flash::error(trans($this->trans_path . 'general.error.enabled'))->important();
            return redirect()->route($this->base_route);
        }
        $faq->status = 1;
        $faq->save();

        Flash::success(trans($this->trans_path . 'general.status.enabled'))->important();

        return redirect(route($this->base_route));
    }

    public function disable($id)
    {
        $faq = FAQ::find($id);

        if (!$faq) {
            Flash::error(trans($this->trans_path . 'general.error.disabled'))->important();
            return redirect()->route($this->base_route);
        }
        $faq->status = 0;
        $faq->save();

        Flash::success(trans($this->trans_path . 'general.status.disabled'))->important();

        return redirect(route($this->base_route));
    }

    public function destroy($id)
    {

        $faq = FAQ::find($id);

        if(!$faq->delete())
            Flash::error(trans($this->trans_path . 'general.error.delete'))->important();
        else
            Flash::success(trans($this->trans_path . 'general.status.deleted'))->important();

        return redirect()->route($this->base_route);

    }

    public function userManual()
    {
        $File = public_path('user-manual/user-manual.txt');
        $data = null;
        if (File::exists($File)) {
            $handle = file($File);
            $data = join(' ', $handle);
        }
        return view($this->loadDefaultVars($this->view_path . '.user-manual'),
            compact('data'));
    }

    public function userManualStore(Request $request)
    {
        $this->createFolderIfNotExits('user-manual/');
        try {
            $File = public_path('user-manual/user-manual.txt');
            $File = fopen($File, "w");
            fwrite($File, $request->get('user_manual'));
            fclose($File);
            Flash::success('User manual successfully updated.')->important();
        } catch (\Exception $e) {
            AppHelper::exceptionHandler($e, "Error while updating user manual");
            Flash::error('Error while updating user manual.')->important();
        }
        return redirect()->back();
    }


    public function createFolderIfNotExits($path = null)
    {
        if (!$path) {
            return false;
        }

        try {
            if(!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
        } catch (\Exception $e) {
            AppHelper::exceptionHandler($e, "Error while creating folder");
        }

    }

}
