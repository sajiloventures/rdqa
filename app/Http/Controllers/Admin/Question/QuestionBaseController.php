<?php

namespace App\Http\Controllers\Admin\Question;

use App\Http\Controllers\AdminBaseController;
use App\Models\AdminUser;
use App\Models\CompareSheet;
use App\Models\Instance;
use View;
use AppHelper;

class QuestionBaseController extends AdminBaseController
{

    /**
     * External packages must set to false
     *
     * @var bool
     */
    protected $app_model = true;

    public function __construct()
    {
        /*
         * !! Not to remove !!
         */
        parent::__construct();
    }


    /**
     * create nested array of question format
     * TODO:: write recursive function to create this array
     * @param $questions
     * @return array
     */

    public function createQuestionArray($questions)
    {
        $array = [];
        foreach ($questions as $question)
        {
            if (isset($array[$question->part])) {

                if (isset($array[$question->part]['type'][$question->type])) {

                    if (!isset($array[$question->part]['type'][$question->type]['type'][$question->sub_type])) {
                        if ($question->sub_type) {
                            $array[$question->part]['type'][$question->type]['type'] += [
                                $question->sub_type => [
                                    'key'       => $question->sub_type,
                                    'id'       => $question->id,
                                    'question'       => $question,
                                    'name'      => $question->sub_type_name,
                                    'description'      => $question->sub_type_description,
                                ]
                            ];
                        }
                    }

                } else {
                    $array[$question->part]['type'] += [
                        $question->type => [
                            'key'   => $question->type,
                            'id'   => $question->id,
                            'question'       => $question,
                            'name'  =>  $question->type_name,
                            'description'  =>  $question->type_description,
                            'type'     =>  []
                        ]
                    ];
                    if ($question->sub_type) {
                        $array[$question->part]['type'][$question->type]['type'] = [
                            $question->sub_type => [
                                'key'       => $question->sub_type,
                                'id'       => $question->id,
                                'question'       => $question,
                                'name'      => $question->sub_type_name,
                                'description'      => $question->sub_type_description,
                            ]
                        ];
                    }
                }
            } else {
                $array += [
                    $question->part => [
                        'id'=> $question->id,
                        'key'=>  $question->part,
                        'question'       => $question,
                        'name'=> $question->part_name,
                        'description'=> $question->part_description,
                        'type'  => []
                    ]
                ];

                if ($question->type) {
                    $array[$question->part]['type'] = [
                        $question->type => [
                            'key'   => $question->type,
                            'id'  =>  $question->id,
                            'question'       => $question,
                            'name'  =>  $question->type_name,
                            'description'  =>  $question->type_description,
                            'type'     =>  []
                        ]
                    ];

                    if ($question->sub_type) {
                        $array[$question->part]['type'][$question->type]['type'] = [
                            $question->sub_type => [
                                'id'       => $question->id,
                                'key'       => $question->sub_type,
                                'question'       => $question,
                                'name'      => $question->sub_type_name,
                                'description'      => $question->sub_type_description,
                            ]
                        ];
                    }
                }
            }
        }
        return $array;
    }

    public function getCompareSheetArray($selectedIds = [])
    {
        $array = [];
        $compareSheets = CompareSheet::ByStatus()->whereIn('id', $selectedIds)->get();
        foreach ($compareSheets as $cs)
            $array += [
                $cs->id => $cs->name . ' vs ' . $cs->name_2
            ];

        return $array;

    }

    public function getInstancesIdsByRole()
    {
        $instanceIds = [];
        $instances = Instance::select('instance.id')
            ->leftJoin('instance_site_delivery as isd', 'instance.id', '=', 'isd.instance_id')
            ->whereIn('isd.facility_user_id', $this->getFacilityUsersIdsByRole())
            ->get();

        foreach ($instances as $instance)
            array_push($instanceIds, $instance->id);

        return $instanceIds;
    }

    public function getFacilityUsersIdsByRole()
    {
        if (auth()->check()) {
            $role = \AclHelper::getUserRole();
            if ($role == 'rdqa-admin' || $role == 'super-admin') {
                $users = AdminUser::select('id')->where('palika_user_id', '>', 0)->get();
                return $this->getFacilityUserIds($users);
            }
            if ($role == 'province-user') {
                $users = AdminUser::select('id')->where('palika_user_id', auth()->user()->id)->get();
                return $this->getFacilityUserIds($users);
            }
            if ($role == 'district-user') {
                $users = AdminUser::select('id')->where('palika_user_id', auth()->user()->id)->get();
                return $this->getFacilityUserIds($users);
            }
            if ($role == 'palika-user') {
                $users = AdminUser::select('id')->where('palika_user_id', auth()->user()->id)->get();
                return $this->getFacilityUserIds($users);
            }
            if ($role == 'facility-user') {
                $users = AdminUser::select('id')->where('id', auth()->user()->id)->get();
                return $this->getFacilityUserIds($users);
            }
            return [];
        } else {
            $users = AdminUser::select('id')->where('palika_user_id', '>', 0)->get();
            return $this->getFacilityUserIds($users);
        }
    }

    public function getFacilityUserIds($users)
    {
        $userIds = [];
        foreach ($users as $user)
            array_push($userIds, $user->id);

        return $userIds;
    }

}
