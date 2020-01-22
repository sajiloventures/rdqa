<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteDeliveryData extends Model
{
    protected $table = 'site_delivery_data';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_delivery_questions_id',
        'instance_id',
        'indicator_id',
        'question_id',
        'question_list_id',
        'value',
        'value_2',
        'value_3',
        'value_4',
        'compare_result',
        'answer_remark',
        'overall_remark',
    ];

    public $timestamps = true;


    public function siteQuestion()
    {
        return $this->belongsTo('App\Models\SiteDeliveryQuestions', 'site_delivery_questions_id');
    }
}
