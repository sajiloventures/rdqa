<?php

namespace App\Http\Controllers\Admin\Question;


use App\Models\Question;
use App\Models\QuestionList;
use Illuminate\Http\Request;
use Auth, Flash, AppHelper, AclHelper, DB;

class QuestionController extends QuestionBaseController
{

    /**
     * @var view location path
     */
    protected $view_path = 'admin.question';
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

        $this->base_route = 'admin.question';

        // Generate Translation Dir path
        $this->trans_path = AppHelper::getTransPathFromViewPath($this->view_path);

    }

    public function index()
    {
        $data = [];
        $data['page_title'] = trans($this->trans_path . 'general.page.index.page-title');
        $data['trans_path'] = $this->trans_path;
        $data['question'] = parent::createQuestionArray(Question::ByStatus()->get());

        return view($this->loadDefaultVars($this->view_path . '.index'), compact('data'));
    }

    public function getTitleEditModal(Request $request)
    {
        $question = Question::where(trim($request->get('type')), trim($request->get('key')))
            ->where('part', trim($request->get('part')))->first()->toArray();
        if (count($question) > 0) {
            $question = [
                'type' => trim($request->get('type')),
                'key' => trim($request->get('key')),
                'part' => trim($request->get('part')),
                'name' => $question[($request->get('type') . '_name')],
                'description' => $question[($request->get('type') . '_description')]
            ];
            $html = view($this->loadDefaultVars($this->view_path . '.partials.modal.editTitle'), compact('question'))->render();
            return response()->json($html);
        }
        return response()->json('Requested data does not exist.', 401);
    }

    public function updateTitle(Request $request)
    {
        $question = Question::where(trim($request->get('type')), trim($request->get('key')))
            ->where('part', trim($request->get('part')))->update([
                ($request->get('type') . '_name') => $request->get('name'),
                ($request->get('type') . '_description') => $request->get('description'),
            ]);

        if ($question) {
            return response()->json([
                'title' => $request->get('name'),
                'message' => trans($this->trans_path . 'general.status.updated')
            ], 200);
//            Flash::success(trans($this->trans_path . 'general.status.updated'));
        } else
            return response()->json(trans($this->trans_path . 'general.status.updated'), 401);
//            Flash::success(trans($this->trans_path . 'general.status.updated'));

//        return redirect()->route($this->base_route);

    }

    public function getAddQuestionModal(Request $request)
    {
        $question = Question::find($request->get('id'));
            if ($question) {
                $data = [
                    'id' => $question->id,
                    'type' => trim($request->get('type')),
                    'key' => trim($request->get('key')),
                    'part' => trim($request->get('part')),
                    'name' => $question[($request->get('type') . '_name')],
                    'description' => $question[($request->get('type') . '_description')],
                    'questionList' => $question->questionList()->orderBy('sort_order')->get()
                ];
                $page = null;
                switch ($data['part']) {
                    case 'part-1':

                        if ($question->type == 'a')
                            $page = 'part-1-a-addQuestion';
                        else if ($question->type == 'b')
                            $page = 'part-1-b-addQuestion';
                        else if ($question->type == 'c' && $question->sub_type == 'cross-check-3') {
                            $page = 'question-only';
                            $data += ['show_message' => 'Last question will be compare with sum of former questions'];
                        } else
                            $page = 'part-1-c-addQuestion';
                        break;
                    default:
                        $page = 'question-only';
                        break;
                }
                $html = view($this->loadDefaultVars($this->view_path .'.partials.modal.' . $page), compact('data', 'question'))->render();
                return response()->json($html);
        }
        return response()->json('Requested data does not exist.', 401);
    }

    public function addUpdateQuestions(Request $request)
    {
        $question = Question::find($request->get('id'));
        $questionList = null;
        if ($question) {
            $data = [
                'id' => $question->id,
                'type' => trim($request->get('type')),
                'key' => trim($request->get('key')),
                'part' => trim($request->get('part'))
            ];
            $page = null;
            switch ($data['part']) {
                case 'part-1':
                    if ($question->type == 'a') {
                        $questionListIds = [];
                        $count = 0;
                        if ($request->get('question')) {
                            foreach ($request->get('question') as $key => $ques) {
                                $data = [
                                    'question' => $ques,
                                    'question_note' => $request->get('question_note')[$count],
                                    'if_not_question' => $request->get('if_not_question')[$count],
                                    'question_type' => 'yes-no',
                                    'sort_order' => $count + 1,
                                ];
                                if ($request->get('questionListId')[$count] && $request->get('questionListId')[$count] > 0) {
                                    $questionList = QuestionList::find($request->get('questionListId')[$count]);
                                    $questionList->update($data);
                                } else {
                                    $data += [
                                        'question_id' => $question->id,
                                        'user_id' => auth()->user()->id,
                                    ];
                                    $questionList = QuestionList::create($data);
                                }
                                if ($questionList)
                                    array_push($questionListIds, $questionList->id);

                                $count++;

                            }
                        }
                        $questionList = true;
                        QuestionList::where('question_id', $question->id)->whereNotIn('id', $questionListIds)->delete();
                    }
                    else if ($question->type == 'b') {
                        $data = [
                            'question' => $request->get('question_a'),
                            'question_note' => $request->get('question_b'),
                            'if_not_question' => $request->get('compare'),
                            'compare_result' => $request->get('compare_result'),
                            'compare_type' => 'A/B',
                            'question_type' => 'compare',
                            'sort_order' => 1,
                        ];
                        if ($request->get('questionListId') && $request->get('questionListId') > 0) {
                            $questionList = QuestionList::find($request->get('questionListId'));
                            $questionList->update($data);
                        } else {
                            $data += [
                                'question_id' => $question->id,
                                'user_id' => auth()->user()->id,
                            ];
                            $questionList = QuestionList::create($data);
                        }


                    } else if ($question->type == 'c' && $question->sub_type == 'cross-check-3') {
                        $questionListIds = [];
                        $count = 0;
                        if ($request->get('question')) {
                            foreach ($request->get('question') as $key => $ques) {
                                $data = [
                                    'question' => $ques,
                                    'question_note' => $request->get('question_note'),
                                    'question_type' => 'compare',
                                    'sort_order' => $count + 1,
                                ];
                                if ($request->get('questionListId')[$count] && $request->get('questionListId')[$count] > 0) {
                                    $questionList = QuestionList::find($request->get('questionListId')[$count]);
                                    $questionList->update($data);
                                } else {
                                    $data += [
                                        'question_id' => $question->id,
                                        'user_id' => auth()->user()->id,
                                    ];
                                    $questionList = QuestionList::create($data);
                                }
                                if ($questionList)
                                    array_push($questionListIds, $questionList->id);

                                $count++;

                            }
                        }

                        $questionList = true;
                        QuestionList::where('question_id', $question->id)->whereNotIn('id', $questionListIds)->delete();

                    } else {
                        $data = [
                            'question' => $request->get('question_a'),
                            'question_note' => $request->get('question_b'),
                            'if_not_question' => $request->get('compare'),
                            'compare_type' => 'A/B',
                            'question_type' => 'compare',
                            'sort_order' => 1,
                        ];
                        if ($request->get('questionListId') && $request->get('questionListId') > 0) {
                            $questionList = QuestionList::find($request->get('questionListId'));
                            $questionList->update($data);
                        } else {
                            $data += [
                                'question_id' => $question->id,
                                'user_id' => auth()->user()->id,
                            ];
                            $questionList = QuestionList::create($data);
                        }
                    }
                    break;
                default:
                    $questionListIds = [];
                    $count = 0;
                    if ($request->get('question')) {
                        foreach ($request->get('question') as $key => $ques) {
                            $data = [
                                'question' => $ques,
                                'question_type' => 'yes-no-partly',
                                'sort_order' => $count + 1,
                            ];
                            if ($request->get('questionListId')[$count] && $request->get('questionListId')[$count] > 0) {
                                $questionList = QuestionList::find($request->get('questionListId')[$count]);
                                $questionList->update($data);
                            } else {
                                $data += [
                                    'question_id' => $question->id,
                                    'user_id' => auth()->user()->id,
                                ];
                                $questionList = QuestionList::create($data);
                            }
                            if ($questionList)
                                array_push($questionListIds, $questionList->id);

                            $count++;

                        }
                    }

                    $questionList = true;
                    QuestionList::where('question_id', $question->id)->whereNotIn('id', $questionListIds)->delete();

                    break;
            }

        }

        if ($questionList)
            return response()->json('Successfully data updated.', 200);

        return response()->json('Error while updating data.', 401);
    }


}
